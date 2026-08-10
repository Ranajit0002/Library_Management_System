@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                    {{ isset($isMemberView) && $isMemberView ? __('My Book Reservations Queue') : __('Book Reservations Queue Management') }}
                </h2>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                    {{ __('Track and manage pending reservation waitlists for out-of-stock books.') }}
                </p>
            </div>
            <a href="{{ route('books.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                <i class="fa-solid fa-book mr-1"></i> {{ __('Browse Catalog') }}
            </a>
        </div>

        @if (session('success'))
        <div id="flash-success" class="bg-emerald-500/10 dark:bg-emerald-950/40 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.15)] text-xs flex items-center justify-between backdrop-blur-md" role="alert">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
            </span>
            <button type="button" onclick="document.getElementById('flash-success').remove();" class="text-emerald-500 hover:text-emerald-700 font-bold text-base leading-none">&times;</button>
        </div>
        @endif

        @if (session('error'))
        <div id="flash-error" class="bg-rose-500/10 dark:bg-rose-950/40 border border-rose-500/30 text-rose-700 dark:text-rose-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(244,63,94,0.15)] text-xs flex items-center justify-between backdrop-blur-md" role="alert">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark text-rose-500"></i> {{ session('error') }}
            </span>
            <button type="button" onclick="document.getElementById('flash-error').remove();" class="text-rose-500 hover:text-rose-700 font-bold text-base leading-none">&times;</button>
        </div>
        @endif

        {{-- Filters Section --}}
        <div class="relative w-full">
            <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-r from-violet-600/30 via-fuchsia-600/30 to-cyan-500/30 blur-md opacity-50 dark:opacity-75 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-sm p-4">
                @php
                $isMemberView = isset($isMemberView) ? $isMemberView : (!auth()->user()->is_admin && strtolower(auth()->user()->role ?? '') !== 'admin');
                $filterAction = $isMemberView
                ? (Route::has('member.reservations.my') ? route('member.reservations.my') : (Route::has('reservations.my') ? route('reservations.my') : url()->current()))
                : (Route::has('admin.reservations.index') ? route('admin.reservations.index') : (Route::has('reservations.index') ? route('reservations.index') : url()->current()));
                @endphp
                <form action="{{ $filterAction }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ $isMemberView ? __('Search reserved book by title or ISBN...') : __('Search by book title, ISBN, member name, or membership no...') }}"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300">
                    </div>
                    <div class="flex gap-2">
                        <select
                            name="status"
                            class="w-full px-3 py-2 text-xs rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300">
                            <option value="" class="dark:bg-gray-900">{{ __('All Statuses') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="dark:bg-gray-900">{{ __('Pending Waitlist') }}</option>
                            <option value="fulfilled" {{ request('status') == 'fulfilled' ? 'selected' : '' }} class="dark:bg-gray-900">{{ __('Fulfilled') }}</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }} class="dark:bg-gray-900">{{ __('Cancelled') }}</option>
                        </select>
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 flex items-center gap-1.5">
                            <i class="fa-solid fa-filter"></i> {{ __('Filter') }}
                        </button>
                        @if(request('search') || request('status'))
                        <a href="{{ $filterAction }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 border border-gray-300/50 dark:border-gray-700 rounded-xl transition-all duration-300 flex items-center justify-center">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Queue View --}}
        <div class="relative w-full">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-20 dark:opacity-30 blur-xl pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-100 dark:divide-cyan-950/60 text-left">
                        <thead>
                            <tr class="border-b border-violet-100 dark:border-cyan-900/40 text-[11px] font-bold text-gray-700 dark:text-cyan-400 uppercase tracking-wider bg-violet-50/50 dark:bg-gray-900/50">
                                <th class="px-6 py-3.5">{{ __('Reserved Book') }}</th>
                                @if(!$isMemberView)
                                <th class="px-6 py-3.5">{{ __('Member & Membership ID') }}</th>
                                @endif
                                <th class="px-6 py-3.5">{{ __('Reserved On') }}</th>
                                <th class="px-6 py-3.5">{{ __('Status') }}</th>
                                <th class="px-6 py-3.5 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-violet-100/60 dark:divide-cyan-950/40 text-xs">
                            @forelse ($reservations ?? [] as $reservation)
                            @php
                            $status = data_get($reservation, 'status', 'pending');
                            $user = auth()->user();
                            $isAdmin = $user && ($user->is_admin || strtolower($user->role ?? '') === 'admin');
                            $resId = data_get($reservation, 'id');
                            $bookId = data_get($reservation, 'book_id', data_get($reservation, 'book.id'));
                            $destroyRoute = Route::has('reservations.destroy') ? route('reservations.destroy', $resId) : url("/reservations/{$resId}");
                            @endphp
                            <tr class="hover:bg-violet-50/30 dark:hover:bg-cyan-950/20 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                                        {{ data_get($reservation, 'book.title', 'N/A') }}
                                    </div>
                                    <div class="text-[11px] text-gray-500 font-mono mt-0.5">
                                        ISBN: {{ data_get($reservation, 'book.isbn', 'N/A') }}
                                    </div>
                                </td>

                                @if(!$isMemberView)
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-gray-900 dark:text-gray-100">
                                        {{ data_get($reservation, 'member.user.name', data_get($reservation, 'member.name', 'N/A')) }}
                                    </div>
                                    <div class="text-[11px] text-violet-600 dark:text-cyan-400/80 font-mono tracking-tight mt-0.5">
                                        {{ data_get($reservation, 'member.membership_no', 'N/A') }}
                                    </div>
                                </td>
                                @endif

                                <td class="px-6 py-4 font-mono">
                                    @php
                                    $reservedAt = data_get($reservation, 'reserved_at');
                                    @endphp
                                    {{ $reservedAt ? \Carbon\Carbon::parse($reservedAt)->format('Y-m-d H:i') : 'N/A' }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($status === 'pending')
                                    <span class="px-2.5 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                                        <i class="fa-solid fa-hourglass-half mr-1"></i> {{ __('Queued') }}
                                    </span>
                                    @elseif($status === 'fulfilled')
                                    <span class="px-2.5 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                                        <i class="fa-solid fa-circle-check mr-1"></i> {{ __('Fulfilled') }}
                                    </span>
                                    @else
                                    <span class="px-2.5 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-gray-500/10 text-gray-600 dark:text-gray-400 border border-gray-500/30">
                                        {{ ucfirst($status) }}
                                    </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center font-medium">
                                    @if($status === 'pending')
                                    <form action="{{ $destroyRoute }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-2.5 py-1 text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-lg hover:bg-rose-500/20 transition-all hover:scale-105"
                                            onclick="return confirm('Cancel this reservation entry?');">
                                            <i class="fa-solid fa-xmark mr-1"></i> {{ __('Cancel Queue') }}
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-xs text-gray-400 font-semibold">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $isMemberView ? 4 : 5 }}" class="px-6 py-12 text-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fa-solid fa-bookmark text-3xl opacity-50"></i>
                                        <p>{{ __('No book reservation queue records found.') }}</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if(isset($reservations) && method_exists($reservations, 'hasPages') && $reservations->hasPages())
                    <div class="mt-6 pt-4 border-t border-violet-100/80 dark:border-cyan-950/60">
                        {{ $reservations->withQueryString()->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        ['flash-success', 'flash-error'].forEach(function(id) {
            let alertBox = document.getElementById(id);
            if (alertBox) {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }
        });
    }, 4000);
</script>
@endsection