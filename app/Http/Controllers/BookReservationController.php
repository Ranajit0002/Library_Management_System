<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookReservation;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Exception;

class BookReservationController extends Controller
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
    public function index(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user || !$this->checkIsAdmin($user)) {
            abort(403, 'Only administrators can view overall reservation queues.');
        }
        $query = BookReservation::with(['book', 'member.user']);
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', function ($b) use ($search) {
                    $b->where('title', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                })->orWhereHas('member', function ($m) use ($search) {
                    $m->where('membership_no', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($u) use ($search) {
                            $u->where('name', 'like', "%{$search}%");
                        });
                });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        $reservations = $query->latest('reserved_at')->paginate(15)->withQueryString();
        return view('reservations.index', compact('reservations'));
    }
    public function myReservations(Request $request)
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
        $query = BookReservation::where('member_id', $member->id)->with('book');
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
        $reservations = $query->latest('reserved_at')->paginate(10)->withQueryString();

        $isInMemberPortal = $request->is('member*') || $request->routeIs('member.*');
        if (!$isInMemberPortal && view()->exists('books.my-reservations')) {
            return view('books.my-reservations', compact('reservations'));
        }

        return view('reservations.index', compact('reservations'))->with('isMemberView', true);
    }
    public function store(Request $request, int|string|null $bookId = null)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $targetBookId = $bookId ?? $request->input('book_id');
        if (!$targetBookId) {
            return back()->with('error', 'Invalid book selection.');
        }
        $member = $this->resolveMemberProfile($user);
        if (!$member) {
            return back()->with('error', 'Unable to resolve member account details.');
        }
        try {
            DB::transaction(function () use ($targetBookId, $member) {
                /** @var Book $book */
                $book = Book::lockForUpdate()->findOrFail($targetBookId);
                if ($book->available_quantity > 0) {
                    throw new Exception('This book is currently in stock! You can borrow it directly.');
                }
                $alreadyReserved = BookReservation::where('book_id', $book->id)
                    ->where('member_id', $member->id)
                    ->where('status', 'pending')
                    ->exists();
                if ($alreadyReserved) {
                    throw new Exception('You already have an active reservation for this book.');
                }
                BookReservation::create([
                    'book_id'     => $book->id,
                    'member_id'   => $member->id,
                    'reserved_at' => now(),
                    'status'      => 'pending',
                ]);
            });
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Book reserved successfully! We will notify you as soon as a copy becomes available.');
    }
    public function destroy(int|string $id)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        $reservation = BookReservation::findOrFail($id);
        $isAdmin = $this->checkIsAdmin($user);
        if (!$isAdmin) {
            $member = $this->resolveMemberProfile($user);
            if (!$member || $reservation->member_id != $member->id) {
                abort(403, 'Unauthorized operation.');
            }
        }
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Only pending reservations can be cancelled.');
        }
        $reservation->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservation cancelled successfully.');
    }
}
