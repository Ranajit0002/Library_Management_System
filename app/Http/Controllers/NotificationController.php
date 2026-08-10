<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $filter = $request->input('filter', 'all');

        $query = match ($filter) {
            'unread' => $user->unreadNotifications(),
            'read'   => $user->readNotifications(),
            default  => $user->notifications(),
        };

        $notifications = $query->paginate(15)->withQueryString();

        return view('notifications.index', compact('notifications', 'filter'));
    }

    public function markAsRead(string $id, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $notification = $user->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }
        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Notification marked as read.']);
        }
        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'All notifications marked as read.']);
        }
        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(string $id, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $notification = $user->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->delete();
            }
        }
        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Notification deleted.']);
        }
        return back()->with('success', 'Notification removed successfully.');
    }
}
