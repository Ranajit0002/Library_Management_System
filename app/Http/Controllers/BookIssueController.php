<?php

namespace App\Http\Controllers;

use App\Models\BookIssue;
use App\Models\Book;
use App\Models\Member;
use App\Models\User;
use App\Models\BookReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Exception;

class BookIssueController extends Controller
{
    private function resolveMemberProfile(User $user): ?Member
    {
        if (method_exists($user, 'member') && $user->member) {
            return $user->member;
        }
        $member = Member::where('user_id', $user->id)->first();
        if ($member) {
            return $member;
        }
        return Member::create([
            'user_id'       => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'membership_no' => 'MEM-' . strtoupper(substr(md5($user->id . time()), 0, 6)),
            'joining_date'  => now()->toDateString(),
            'status'        => 'active',
            'address'       => 'N/A',
            'phone'         => 'N/A',
        ]);
    }
    private function checkIsAdmin(User $user): bool
    {
        return strtolower($user->role ?? '') === 'admin' || (method_exists($user, 'isAdmin') && $user->isAdmin()) || (bool) $user->is_admin;
    }
    private function calculateDynamicFine(BookIssue $issue): void
    {
        if ($issue->status === 'returned' || ($issue->fine_status ?? 'unpaid') === 'paid' || ($issue->fine_status ?? 'unpaid') === 'waived') {
            return;
        }
        $targetDueDate = $issue->return_date ?? $issue->due_date ?? null;
        if (!$targetDueDate) {
            $issue->fine = 0.00;
            return;
        }
        $dueDate = Carbon::parse($targetDueDate)->startOfDay();
        $today   = Carbon::now()->startOfDay();
        if ($today->greaterThan($dueDate)) {
            $daysLate    = $today->diffInDays($dueDate);
            $issue->fine = $daysLate * 10.00;
        } else {
            $issue->fine = 0.00;
        }
    }
    public function index(Request $request)
    {
        $query = BookIssue::with(['book', 'member.user']);
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->input('member_id'));
        }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', function ($b) use ($search) {
                    $b->where('title', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                })->orWhereHas('member', function ($m) use ($search) {
                    $m->where('membership_no', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($u) use ($search) {
                            $u->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        $bookIssues = $query->latest()->paginate(10)->withQueryString();
        foreach ($bookIssues as $issue) {
            $this->calculateDynamicFine($issue);
        }
        return view('book_issues.index', compact('bookIssues'));
    }
    public function myBorrowings(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $member = $this->resolveMemberProfile($user);
        if (!$member) {
            return redirect()->route('dashboard')->with('error', 'Unable to resolve member profile.');
        }
        $query = BookIssue::where('member_id', $member->id)->with('book');
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('book', function ($b) use ($search) {
                $b->where('title', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        $bookIssues = $query->latest()->paginate(10)->withQueryString();
        foreach ($bookIssues as $issue) {
            $this->calculateDynamicFine($issue);
        }

        $isInMemberPortal = $request->is('member*') || $request->routeIs('member.*');
        if (!$isInMemberPortal && view()->exists('books.my-borrowings')) {
            return view('books.my-borrowings', compact('bookIssues'))->with('isMemberView', true);
        }

        return view('book_issues.index', compact('bookIssues'))->with('isMemberView', true);
    }
    public function create()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$this->checkIsAdmin($user)) {
            abort(403, 'Only administrators can issue books directly to members.');
        }
        $books   = Book::where('available_quantity', '>', 0)->orderBy('title')->get();
        $members = Member::where('status', 'active')->with('user')->orderBy('membership_no')->get();
        return view('book_issues.create', compact('books', 'members'));
    }
    public function store(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $isAdmin = $this->checkIsAdmin($user);
        $rules = [
            'book_id'     => 'required|exists:books,id',
            'member_id'   => $isAdmin ? 'nullable|exists:members,id' : 'nullable',
            'issue_date'  => $isAdmin ? 'nullable|date' : 'nullable|date',
            'return_date' => $isAdmin ? 'nullable|date|after_or_equal:issue_date' : 'nullable|date',
        ];
        $validated = $request->validate($rules);
        if ($isAdmin && !empty($validated['member_id'])) {
            $memberId = $validated['member_id'];
        } else {
            $member = $this->resolveMemberProfile($user);
            if (!$member) {
                return back()->with('error', 'Could not resolve member account details.');
            }
            $memberId = $member->id;
        }
        $issueDate  = $validated['issue_date'] ?? now()->toDateString();
        $returnDate = $validated['return_date'] ?? now()->addDays(14)->toDateString();
        $alreadyIssued = BookIssue::where('book_id', $validated['book_id'])->where('member_id', $memberId)->whereIn('status', ['issued', 'borrowed', 'pending', 'active'])->exists();
        if ($alreadyIssued) {
            return back()->withInput()->with('error', 'You already have an active borrowing record for this book.');
        }
        try {
            DB::transaction(function () use ($validated, $memberId, $issueDate, $returnDate) {
                /** @var Book $book */
                $book = Book::lockForUpdate()->findOrFail($validated['book_id']);
                if ($book->available_quantity <= 0) {
                    throw new Exception('Selected book is currently out of stock.');
                }
                BookIssue::create([
                    'book_id'     => $validated['book_id'],
                    'member_id'   => $memberId,
                    'issue_date'  => $issueDate,
                    'return_date' => $returnDate,
                    'status'      => 'issued',
                    'fine'        => 0.00,
                    'fine_status' => 'unpaid',
                ]);
                $book->decrement('available_quantity');
                if ($book->available_quantity <= 0) {
                    $book->update(['status' => 'out_of_stock']);
                }
            });
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        if ($isAdmin && $request->filled('member_id')) {
            $redirectUrl = Route::has('admin.book_issues.index') ? route('admin.book_issues.index') : (Route::has('book_issues.index') ? route('book_issues.index') : url('/admin/book-issues'));
            return redirect()->to($redirectUrl)->with('success', 'Book issued successfully.');
        }
        return back()->with('success', 'Book borrowed successfully! Check your borrowings for return deadlines.');
    }
    public function show(BookIssue $bookIssue)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        if (!$this->checkIsAdmin($user)) {
            $member = $this->resolveMemberProfile($user);
            if (!$member || $bookIssue->member_id != $member->id) {
                abort(403, 'Unauthorized access.');
            }
        }
        $bookIssue->load(['book', 'member.user']);
        $this->calculateDynamicFine($bookIssue);
        return view('book_issues.show', compact('bookIssue'));
    }
    public function returnBook(Request $request, int|string $id)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        $isAdmin = $this->checkIsAdmin($user);
        $bookIssue = BookIssue::find($id);
        if (!$bookIssue) {
            $member = $this->resolveMemberProfile($user);
            $query = BookIssue::where('book_id', $id)->whereIn('status', ['issued', 'borrowed', 'active', 'pending']);
            if (!$isAdmin && $member) {
                $query->where('member_id', $member->id);
            }
            $bookIssue = $query->first();
        }
        if (!$bookIssue) {
            return back()->with('error', 'Active borrowing record not found for this book.');
        }
        if (!$isAdmin) {
            $member = $this->resolveMemberProfile($user);
            if (!$member || $bookIssue->member_id != $member->id) {
                abort(403, 'You cannot return another member\'s book.');
            }
        }
        if ($bookIssue->status === 'returned') {
            return back()->with('error', 'This book has already been returned.');
        }
        $queueNotified = false;
        try {
            DB::transaction(function () use ($bookIssue, &$queueNotified) {
                $actualReturnDate = Carbon::now()->startOfDay();
                $targetDueDate    = $bookIssue->return_date ?? $bookIssue->due_date;
                $dueDate          = Carbon::parse($targetDueDate)->startOfDay();
                $fine             = 0.00;
                if ($actualReturnDate->greaterThan($dueDate)) {
                    $daysLate = $actualReturnDate->diffInDays($dueDate);
                    $fine     = $daysLate * 10.00;
                }
                $updateData = ['fine'   => $fine, 'status' => 'returned'];
                if (Schema::hasColumn('book_issues', 'actual_return_date')) {
                    $updateData['actual_return_date'] = $actualReturnDate->toDateString();
                }
                $bookIssue->update($updateData);
                if ($bookIssue->book_id) {
                    $book = Book::lockForUpdate()->find($bookIssue->book_id);
                    if ($book) {
                        $book->increment('available_quantity');
                        if ($book->status === 'out_of_stock' && $book->available_quantity > 0) {
                            $book->update(['status' => 'available']);
                        }
                        $nextReservation = BookReservation::where('book_id', $book->id)->where('status', 'pending')->oldest('reserved_at')->first();
                        if ($nextReservation) {
                            $nextReservation->update(['status' => 'fulfilled']);
                            $queueNotified = true;
                            $notificationClass = '\\App\\Models\\Notification';
                            if (class_exists($notificationClass) && Schema::hasTable('notifications')) {
                                $targetUserId = data_get($nextReservation, 'member.user_id') ?? data_get($nextReservation, 'member.user.id');
                                if ($targetUserId) {
                                    $notificationClass::create([
                                        'user_id' => $targetUserId,
                                        'title'   => 'Reserved Book Available!',
                                        'message' => "A copy of '{$book->title}' has been returned and is now available for you.",
                                        'is_read' => false,
                                    ]);
                                }
                            }
                        }
                    }
                }
            });
        } catch (Exception $e) {
            return back()->with('error', 'Failed to process book return: ' . $e->getMessage());
        }
        $message = 'Book returned successfully.';
        if ($queueNotified) {
            $message .= ' Next member in reservation queue has been notified!';
        }
        return back()->with('success', $message);
    }
    public function payFine(Request $request, int|string $id)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$this->checkIsAdmin($user)) {
            abort(403, 'Unauthorized action.');
        }
        $bookIssue = BookIssue::findOrFail($id);
        if ($bookIssue->fine <= 0) {
            return back()->with('error', 'There is no active fine on this record.');
        }
        try {
            $bookIssue->update([
                'fine_status' => 'paid',
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Failed to mark fine as paid: ' . $e->getMessage());
        }
        return back()->with('success', 'Fine marked as successfully paid.');
    }
    public function waiveFine(Request $request, int|string $id)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$this->checkIsAdmin($user)) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'waiver_reason' => 'required|string|max:255',
        ]);
        $bookIssue = BookIssue::findOrFail($id);
        if ($bookIssue->fine <= 0) {
            return back()->with('error', 'There is no active fine to waive.');
        }
        try {
            $bookIssue->update([
                'fine'          => 0.00,
                'fine_status'   => 'waived',
                'waiver_reason' => $validated['waiver_reason'],
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Failed to waive fine: ' . $e->getMessage());
        }
        return back()->with('success', 'Fine has been successfully waived.');
    }
    public function destroy(BookIssue $bookIssue)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$this->checkIsAdmin($user)) {
            abort(403, 'Only administrators can delete issue records.');
        }
        try {
            DB::transaction(function () use ($bookIssue) {
                if (in_array($bookIssue->status, ['issued', 'borrowed', 'pending']) && $bookIssue->book_id) {
                    $book = Book::lockForUpdate()->find($bookIssue->book_id);
                    if ($book) {
                        $book->increment('available_quantity');
                        if ($book->status === 'out_of_stock' && $book->available_quantity > 0) {
                            $book->update(['status' => 'available']);
                        }
                    }
                }
                $bookIssue->delete();
            });
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete issue record: ' . $e->getMessage());
        }
        $redirectRoute = Route::has('admin.book_issues.index') ? route('admin.book_issues.index') : (Route::has('book_issues.index') ? route('book_issues.index') : url('/admin/book-issues'));
        return redirect()->to($redirectRoute)->with('success', 'Book issue record removed successfully.');
    }
}