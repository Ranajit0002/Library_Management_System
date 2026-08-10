<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('membership_no', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $members = $query->latest()->paginate(10)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'membership_no' => 'required|string|unique:members,membership_no',
            'joining_date'  => 'required|date',
            'address'       => 'nullable|string',
            'phone'         => 'nullable|string|max:20',
            'status'        => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'member',
            ]);

            Member::create([
                'user_id'       => $user->id,
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'membership_no' => $validated['membership_no'],
                'joining_date'  => $validated['joining_date'],
                'address'       => $validated['address'] ?? null,
                'phone'         => $validated['phone'] ?? null,
                'status'        => $validated['status'],
            ]);
        });

        return redirect()->route('members.index')->with('success', 'Library member registered successfully.');
    }

    public function show(Member $member)
    {
        $member->load(['user', 'bookIssues.book']);

        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $member->load('user');

        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $member->user_id,
            'membership_no' => 'required|string|unique:members,membership_no,' . $member->id,
            'joining_date'  => 'required|date',
            'address'       => 'nullable|string',
            'phone'         => 'nullable|string|max:20',
            'status'        => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($validated, $member) {
            if ($member->user) {
                $member->user->update([
                    'name'  => $validated['name'],
                    'email' => $validated['email'],
                ]);
            }

            $member->update([
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'membership_no' => $validated['membership_no'],
                'joining_date'  => $validated['joining_date'],
                'address'       => $validated['address'] ?? null,
                'phone'         => $validated['phone'] ?? null,
                'status'        => $validated['status'],
            ]);
        });

        return redirect()->route('members.index')->with('success', 'Member details updated successfully.');
    }

    public function toggleStatus(Member $member)
    {
        $member->status = $member->status === 'active' ? 'inactive' : 'active';
        $member->save();

        return redirect()->route('members.index')->with('success', 'Member status updated successfully.');
    }

    public function history(Member $member)
    {
        $borrowings = $member->bookIssues()->with('book')->latest()->paginate(10);

        return view('members.history', compact('member', 'borrowings'));
    }

    public function destroy(Member $member)
    {
        $hasActiveBorrowings = $member->bookIssues()->whereIn('status', ['issued', 'borrowed'])->exists();

        if ($hasActiveBorrowings) {
            return redirect()->route('members.index')->with('error', 'Cannot remove member with active borrowed books.');
        }

        DB::transaction(function () use ($member) {
            $user = $member->user;
            $member->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('members.index')->with('success', 'Member profile removed successfully.');
    }
}