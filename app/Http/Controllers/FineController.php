<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fine;

class FineController extends Controller
{
    public function adminIndex(Request $request)
    {
        $fines = Fine::with(['user', 'bookIssue.book'])->latest()->paginate(10);
        $isAdmin = true;
        return view('fines.index', compact('fines', 'isAdmin'));
    }
    public function memberIndex(Request $request)
    {
        $fines = Fine::with(['bookIssue.book'])->where('user_id', Auth::id())->latest()->paginate(10);
        $isAdmin = false;

        $isInMemberPortal = $request->is('member*') || $request->routeIs('member.*');
        if (!$isInMemberPortal && view()->exists('books.my-fines')) {
            return view('books.my-fines', compact('fines', 'isAdmin'));
        }

        return view('fines.index', compact('fines', 'isAdmin'));
    }
    public function pay(Request $request, Fine $fine)
    {
        if ($fine->user_id !== Auth::id()) {
            abort(403);
        }
        $fine->update(['status' => 'paid', 'paid_at' => now()]);
        return back()->with('success', __('Fine paid successfully.'));
    }
    public function waive(Request $request, Fine $fine)
    {
        $fine->update(['status' => 'waived']);
        return back()->with('success', __('Fine waived successfully.'));
    }
}
