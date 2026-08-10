<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $query = Publisher::withCount('books');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('website', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $publishers = $query->latest()->paginate(10)->withQueryString();

        return view('publishers.index', compact('publishers'));
    }

    public function show(Publisher $publisher)
    {
        $books = $publisher->books()->latest()->paginate(10);

        return view('publishers.show', compact('publisher', 'books'));
    }

    public function create()
    {
        return view('publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:publishers,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'status'  => 'required|in:active,inactive',
        ]);

        Publisher::create($validated);

        return redirect()->route('publishers.index')->with('success', 'Publisher created successfully.');
    }

    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:publishers,email,' . $publisher->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'status'  => 'required|in:active,inactive',
        ]);

        $publisher->update($validated);

        return redirect()->route('publishers.index')->with('success', 'Publisher updated successfully.');
    }

    public function toggleStatus(Publisher $publisher)
    {
        $publisher->status = $publisher->status === 'active' ? 'inactive' : 'active';
        $publisher->save();

        return redirect()->route('publishers.index')->with('success', 'Publisher status updated successfully.');
    }

    public function destroy(Publisher $publisher)
    {
        if ($publisher->books()->exists()) {
            return redirect()->route('publishers.index')->with('error', 'Cannot delete publisher because there are books associated with them.');
        }

        $publisher->delete();

        return redirect()->route('publishers.index')->with('success', 'Publisher deleted successfully.');
    }
}