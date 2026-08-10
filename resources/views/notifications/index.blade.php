@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-6">
        @php
            $unreadCount = (auth()->check() && auth()->user()?->unreadNotifications) ? auth()->user()->unreadNotifications->count() : 0;
            $readAllRoute = Route::has('notifications.read-all') ? route('notifications.read-all') : '#';
        @endphp
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)]">
                {{ __('Notifications') }}
            </h2>
            @if($unreadCount > 0)
            <form action="{{ $readAllRoute }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-white bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 px-4 py-2.5 rounded-xl shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    {{ __('Mark all as read') }}
                </button>
            </form>
            @endif
        </div>
        @if (session('success'))
        <div id="flash-success" class="bg-emerald-500/10 dark:bg-emerald-950/40 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl text-xs flex items-center justify-between backdrop-blur-md">
            <span><i class="fa-solid fa-circle-check text-emerald-500 mr-2"></i> {{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove();" class="text-emerald-500 font-bold">&times;</button>
        </div>
        @endif
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] border border-gray-200/80 dark:border-cyan-500/30 overflow-hidden transition-all duration-300">
            <div class="divide-y divide-gray-200/80 dark:divide-cyan-500/20">
                @forelse($notifications ?? [] as $notification)
                @php
                    $isUnread = is_null(data_get($notification, 'read_at'));
                    $notifId = data_get($notification, 'id');
                    $readRoute = Route::has('notifications.read') ? route('notifications.read', $notifId) : '#';
                    $deleteRoute = Route::has('notifications.destroy') ? route('notifications.destroy', $notifId) : '#';
                    $createdAt = data_get($notification, 'created_at');
                    $rawDate = data_get($notification, 'data');
                    $notifData = is_array($rawDate) ? $rawDate : json_decode($rawDate, true);
                    $message = is_array($notifData) ? ($notifData['message'] ?? __('New system notification received.')) : __('New system notification received.');
                @endphp
                <div class="p-4 sm:p-6 flex items-start justify-between gap-4 transition-all duration-200 relative overflow-hidden {{ $isUnread ? 'bg-indigo-50/50 dark:bg-cyan-950/20 border-l-4 border-cyan-400' : 'bg-transparent' }}">
                    <div class="flex-1">
                        <p class="text-sm text-gray-900 dark:text-gray-100 font-semibold mb-1 leading-relaxed">
                            {{ $message }}
                        </p>
                        <span class="text-xs text-gray-400 dark:text-cyan-300/60 font-medium">
                            {{ $createdAt ? \Carbon\Carbon::parse($createdAt)->diffForHumans() : '' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($isUnread)
                        <form action="{{ $readRoute }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 hover:text-fuchsia-500 dark:hover:text-fuchsia-400 whitespace-nowrap px-3 py-1.5 rounded-lg border border-cyan-500/30 dark:border-cyan-400/30 hover:border-fuchsia-400 bg-cyan-500/5 hover:bg-fuchsia-500/10 transition-all duration-300">
                                {{ __('Mark as read') }}
                            </button>
                        </form>
                        @endif
                        <form action="{{ $deleteRoute }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-700 p-1.5 rounded-lg border border-rose-500/30 bg-rose-500/5 hover:bg-rose-500/10 transition-all duration-300" title="{{ __('Delete') }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center text-sm text-gray-500 dark:text-cyan-300/60 font-medium">
                    {{ __('You have no notifications right now.') }}
                </div>
                @endforelse
            </div>
        </div>
        @if(isset($notifications) && method_exists($notifications, 'hasPages') && $notifications->hasPages())
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection