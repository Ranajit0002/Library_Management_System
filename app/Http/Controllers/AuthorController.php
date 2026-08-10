<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::withCount('books');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $authors = $query->latest()->paginate(10)->withQueryString();

        return view('authors.index', compact('authors'));
    }

    public function show(Author $author)
    {
        $books = $author->books()->latest()->paginate(10);

        return view('authors.show', compact('author', 'books'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|unique:authors,email',
            'phone'     => 'nullable|string|max:20',
            'biography' => 'nullable|string',
            'status'    => 'required|in:active,inactive',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('authors', 'public');
        }

        Author::create($validated);

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|unique:authors,email,' . $author->id,
            'phone'     => 'nullable|string|max:20',
            'biography' => 'nullable|string',
            'status'    => 'required|in:active,inactive',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($author->photo && Storage::disk('public')->exists($author->photo)) {
                Storage::disk('public')->delete($author->photo);
            }
            $validated['photo'] = $request->file('photo')->store('authors', 'public');
        }

        $author->update($validated);

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        if ($author->books()->exists()) {
            return redirect()->route('authors.index')->with('error', 'Cannot delete author because there are books associated with them.');
        }

        if ($author->photo && Storage::disk('public')->exists($author->photo)) {
            Storage::disk('public')->delete($author->photo);
        }

        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}