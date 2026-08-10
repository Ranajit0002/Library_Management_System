@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-12 bg-gray-50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-bookmark text-indigo-600 dark:text-cyan-400"></i> {{ __('My Book Reservations') }}
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Track status updates and manage your active book queue requests.') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-cyan-500/30 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-gray-200 dark:border-cyan-500/20 bg-gray-50/50 dark:bg-gray-900/50 flex flex-col sm:flex-row gap-3 justify-between items-center">
                <form method="GET" action="{{ route('books.my-reservations') }}" class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by title or ISBN...') }}" class="w-full sm:w-64 px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-gray-300 dark:border-cyan-500/40 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-cyan-400 focus:outline-none transition-all">
                    <select name="status" class="w-full sm:w-auto px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-gray-300 dark:border-cyan-500/40 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-cyan-400 focus:outline-none transition-all">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="fulfilled" {{ request('status') === 'fulfilled' ? 'selected' : '' }}>{{ __('Fulfilled') }}</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                    <button type="submit" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-indigo-600 dark:bg-cyan-500 hover:bg-indigo-700 dark:hover:bg-cyan-600 rounded-xl transition-all shadow-md">{{ __('Filter') }}</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800/80 text-gray-700 dark:text-cyan-300 border-b border-gray-200 dark:border-cyan-500/30 uppercase tracking-wider text-[11px]">
                            <th class="p-4 font-bold">{{ __('Book Details') }}</th>
                            <th class="p-4 font-bold">{{ __('Reserved Date') }}</th>
                            <th class="p-4 font-bold">{{ __('Status') }}</th>
                            <th class="p-4 font-bold text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800 text-gray-800 dark:text-gray-200">
                        @forelse($reservations as $reservation)
                            <tr class="hover:bg-indigo-50/40 dark:hover:bg-cyan-950/20 transition-colors">
                                <td class="p-4 flex items-center gap-3">
                                    @if($reservation->book->cover_image ?? false)
                                        <img src="{{ asset('storage/' . $reservation->book->cover_image) }}" class="w-10 h-12 object-cover rounded-lg border border-gray-200 dark:border-cyan-500/30">
                                    @else
                                        <div class="w-10 h-12 rounded-lg bg-indigo-100 dark:bg-cyan-950 flex items-center justify-center text-indigo-600 dark:text-cyan-400 font-bold text-xs">
                                            <i class="fa-solid fa-book"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $reservation->book->title ?? __('N/A') }}</div>
                                        <div class="text-[11px] text-gray-500 dark:text-gray-400">{{ __('ISBN: :isbn', ['isbn' => $reservation->book->isbn ?? 'N/A']) }}</div>
                                    </div>
                                </td>
                                <td class="p-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($reservation->reserved_at)->format('M d, Y H:i') }}</td>
                                <td class="p-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending'   => 'bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border-amber-300 dark:border-amber-500/30',
                                            'fulfilled' => 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border-emerald-300 dark:border-emerald-500/30',
                                            'cancelled' => 'bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 border-rose-300 dark:border-rose-500/30',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full border {{ $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    @if($reservation->status === 'pending')
                                        <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-rose-600 dark:text-fuchsia-400 bg-rose-50 dark:bg-fuchsia-950/30 border border-rose-200 dark:border-fuchsia-500/30 hover:bg-rose-100 dark:hover:bg-fuchsia-900/50 rounded-xl transition-all">
                                                <i class="fa-solid fa-xmark mr-1"></i> {{ __('Cancel') }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic">{{ __('No action available') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                    <i class="fa-solid fa-folder-open text-3xl mb-2 text-gray-400 dark:text-cyan-500/40"></i>
                                    <p>{{ __('No book reservations found.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reservations->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-cyan-500/20">
                    {{ $reservations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection