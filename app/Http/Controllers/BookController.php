<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\User;
use App\Models\BookIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BookController extends Controller
{
    public function home()
    {
        $stats = [
            'total_books'   => Book::count(),
            'total_members' => class_exists(User::class) ? User::count() : 0,
            'issued_books'  => class_exists(BookIssue::class) ? BookIssue::whereIn('status', ['issued', 'borrowed', 'active', 'pending'])->count() : 0,
        ];
        $featuredBooks = Book::with(['category', 'author'])->where('available_quantity', '>', 0)->latest()->take(4)->get();
        $latestBooks   = Book::with(['category', 'author'])->latest()->take(6)->get();
        $categories    = Category::orderBy('name')->take(6)->get();

        return view('frontend.home', compact('stats', 'featuredBooks', 'latestBooks', 'categories'));
    }

    public function index(Request $request)
    {
        $search       = $request->input('search');
        $categoryId   = $request->input('category_id') ?? $request->input('category');
        $authorId     = $request->input('author_id');
        $publisherId  = $request->input('publisher_id');
        $language     = $request->input('language');
        $status       = $request->input('status');
        $minPrice     = $request->input('min_price');
        $maxPrice     = $request->input('max_price');
        $availability = $request->input('availability');

        $books = Book::with(['category', 'author', 'publisher'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhereHas('author', fn($a) => $a->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('publisher', fn($p) => $p->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                if (is_numeric($categoryId)) {
                    return $q->where('category_id', $categoryId);
                }
                return $q->whereHas('category', fn($catQuery) => $catQuery->where('name', 'like', "%{$categoryId}%"));
            })
            ->when($authorId, fn($q) => $q->where('author_id', $authorId))
            ->when($publisherId, fn($q) => $q->where('publisher_id', $publisherId))
            ->when($language, fn($q) => $q->where('language', $language))
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($minPrice, fn($q) => $q->where('price', '>=', $minPrice))
            ->when($maxPrice, fn($q) => $q->where('price', '<=', $maxPrice))
            ->when($availability === 'available', fn($q) => $q->where('available_quantity', '>', 0))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Evaluate Member Active Issues & Fine Status safely
        $user = Auth::user();
        $userActiveIssues = collect();
        $userHasUnpaidFine = false;

        if ($user && class_exists(BookIssue::class)) {
            $table = (new BookIssue())->getTable();
            $userColumn = Schema::hasColumn($table, 'member_id') ? 'member_id' : (Schema::hasColumn($table, 'student_id') ? 'student_id' : 'user_id');

            if (Schema::hasColumn($table, $userColumn)) {
                $userActiveIssues = BookIssue::where($userColumn, $user->id)
                    ->whereIn('status', ['borrowed', 'issued', 'pending', 'approved', 'active'])
                    ->get()
                    ->keyBy('book_id');

                $fineQuery = BookIssue::where($userColumn, $user->id);
                if (Schema::hasColumn($table, 'fine_amount')) {
                    $fineQuery->where('fine_amount', '>', 0);
                }
                if (Schema::hasColumn($table, 'fine_status')) {
                    $fineQuery->where('fine_status', 'unpaid');
                }
                $userHasUnpaidFine = $fineQuery->exists();
            }
        }

        // Attach dynamic attributes to each book item
        $books->getCollection()->transform(function ($book) use ($userActiveIssues, $userHasUnpaidFine) {
            $book->user_active_issue = $userActiveIssues->get($book->id);
            $book->user_has_unpaid_fine = $userHasUnpaidFine;
            $book->user_reserved = false;
            return $book;
        });

        $categories = Category::orderBy('name')->get();
        $authors    = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();
        $languages  = Book::select('language')->whereNotNull('language')->distinct()->pluck('language');

        $isInBackend = $request->is('admin*') || $request->routeIs('admin.*');
        $targetView  = ($isInBackend && view()->exists('admin.books.index')) ? 'admin.books.index' : 'books.index';

        return view($targetView, compact(
            'books',
            'categories',
            'authors',
            'publishers',
            'languages',
            'search',
            'categoryId',
            'authorId',
            'publisherId',
            'language',
            'status',
            'minPrice',
            'maxPrice',
            'availability'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $authors    = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();

        $viewName = view()->exists('admin.books.create') ? 'admin.books.create' : 'books.create';

        return view($viewName, compact('categories', 'authors', 'publishers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'author_id'    => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'title'        => 'required|string|max:255',
            'isbn'         => 'required|string|unique:books,isbn',
            'edition'      => 'nullable|string|max:50',
            'language'     => 'required|string|max:50',
            'price'        => 'required|numeric|min:0',
            'quantity'     => 'required|integer|min:1',
            'publish_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'description'  => 'nullable|string',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_path'    => 'nullable|file|mimes:pdf,epub|max:20480',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('ebooks', 'public');
        }

        $validated['available_quantity'] = $validated['quantity'];
        $validated['status']             = 'available';

        Book::create($validated);

        $redirectRoute = Route::has('admin.books.index') ? 'admin.books.index' : 'books.index';

        return redirect()->route($redirectRoute)->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        $book->load(['category', 'author', 'publisher']);

        $user = Auth::user();
        $userActiveIssue = null;
        $userHasUnpaidFine = false;

        if ($user && class_exists(BookIssue::class)) {
            $table = (new BookIssue())->getTable();
            $userColumn = Schema::hasColumn($table, 'member_id') ? 'member_id' : (Schema::hasColumn($table, 'student_id') ? 'student_id' : 'user_id');

            if (Schema::hasColumn($table, $userColumn)) {
                $userActiveIssue = BookIssue::where($userColumn, $user->id)
                    ->where('book_id', $book->id)
                    ->whereIn('status', ['borrowed', 'issued', 'pending', 'approved', 'active'])
                    ->first();

                $fineQuery = BookIssue::where($userColumn, $user->id);
                if (Schema::hasColumn($table, 'fine_amount')) {
                    $fineQuery->where('fine_amount', '>', 0);
                }
                if (Schema::hasColumn($table, 'fine_status')) {
                    $fineQuery->where('fine_status', 'unpaid');
                }
                $userHasUnpaidFine = $fineQuery->exists();
            }
        }

        $book->user_active_issue = $userActiveIssue;
        $book->user_has_unpaid_fine = $userHasUnpaidFine;
        $book->user_reserved = false;

        $viewName = (request()->is('admin*') && view()->exists('admin.books.show')) ? 'admin.books.show' : 'books.show';

        return view($viewName, compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        $authors    = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();

        $viewName = view()->exists('admin.books.edit') ? 'admin.books.edit' : 'books.edit';

        return view($viewName, compact('book', 'categories', 'authors', 'publishers'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'author_id'    => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'title'        => 'required|string|max:255',
            'isbn'         => 'required|string|unique:books,isbn,' . $book->id,
            'edition'      => 'nullable|string|max:50',
            'language'     => 'required|string|max:50',
            'price'        => 'required|numeric|min:0',
            'quantity'     => 'required|integer|min:1',
            'publish_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'description'  => 'nullable|string',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_path'    => 'nullable|file|mimes:pdf,epub|max:20480',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        if ($request->hasFile('file_path')) {
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('ebooks', 'public');
        }

        if (isset($validated['quantity']) && $validated['quantity'] != $book->quantity) {
            $difference = $validated['quantity'] - $book->quantity;
            $newAvailable = max(0, $book->available_quantity + $difference);
            $validated['available_quantity'] = $newAvailable;
            $validated['status'] = $newAvailable > 0 ? 'available' : 'out_of_stock';
        }

        $book->update($validated);

        $redirectRoute = Route::has('admin.books.index') ? 'admin.books.index' : 'books.index';

        return redirect()->route($redirectRoute)->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $redirectRoute = Route::has('admin.books.index') ? 'admin.books.index' : 'books.index';

        $hasActiveIssues = false;

        if (method_exists($book, 'bookIssues')) {
            $hasActiveIssues = $book->bookIssues()->whereIn('status', ['borrowed', 'issued', 'pending'])->exists();
        }

        if ($hasActiveIssues) {
            return redirect()->route($redirectRoute)
                ->with('error', 'Cannot delete this book because there are active borrowings associated with it.');
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }

        $book->delete();

        return redirect()->route($redirectRoute)->with('success', 'Book deleted successfully.');
    }

    public function read(Book $book)
    {
        if (!$book->file_path || !Storage::disk('public')->exists($book->file_path)) {
            return back()->with('error', 'No digital copy available for this book.');
        }

        $user = Auth::user();
        $isAdmin = $user && ($user->is_admin || strtolower($user->role ?? '') === 'admin');

        if (!$isAdmin) {
            $hasActiveBorrow = false;
            if (method_exists($user, 'bookIssues')) {
                $hasActiveBorrow = $user->bookIssues()
                    ->where('book_issues.book_id', $book->id)
                    ->whereIn('book_issues.status', ['borrowed', 'issued', 'approved', 'active', 'pending'])
                    ->exists();
            }

            if (!$hasActiveBorrow) {
                return back()->with('error', 'You must borrow this book before reading it digitally.');
            }
        }

        $viewName = view()->exists('member.books.reader')
            ? 'member.books.reader'
            : (view()->exists('books.read') ? 'books.read' : 'books.show');

        return view($viewName, compact('book'));
    }

    public function streamFile(Book $book)
    {
        if (!$book->file_path || !Storage::disk('public')->exists($book->file_path)) {
            abort(404, 'File not found.');
        }

        $user = Auth::user();
        $isAdmin = $user && ($user->is_admin || strtolower($user->role ?? '') === 'admin');

        if (!$isAdmin) {
            $hasActiveBorrow = false;
            if (method_exists($user, 'bookIssues')) {
                $hasActiveBorrow = $user->bookIssues()
                    ->where('book_issues.book_id', $book->id)
                    ->whereIn('book_issues.status', ['borrowed', 'issued', 'approved', 'active', 'pending'])
                    ->exists();
            }

            if (!$hasActiveBorrow) {
                abort(403, 'Unauthorized access to this e-book.');
            }
        }

        $path = Storage::disk('public')->path($book->file_path);

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
}