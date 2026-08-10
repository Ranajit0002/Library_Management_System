<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Display the support form page.
     */
    public function index(Request $request)
    {
        $user = $request->user() ?? Auth::user();

        if (view()->exists('pages.support')) {
            return view('pages.support', compact('user'));
        }

        if (view()->exists('support')) {
            return view('support', compact('user'));
        }

        return view('frontend.support', compact('user'));
    }

    /**
     * Handle support ticket submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Support::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status'  => 'pending',
        ]));

        return back()->with('success', __('Your support ticket has been submitted successfully. We will get back to you soon!'));
    }
}