@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-12 bg-gray-50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-coins text-indigo-600 dark:text-cyan-400"></i> {{ __('My Fines Ledger') }}
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('View and settle any pending library fines securely.') }}</p>
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
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800/80 text-gray-700 dark:text-cyan-300 border-b border-gray-200 dark:border-cyan-500/30 uppercase tracking-wider text-[11px]">
                            <th class="p-4 font-bold">{{ __('Book Title') }}</th>
                            <th class="p-4 font-bold">{{ __('Amount') }}</th>
                            <th class="p-4 font-bold">{{ __('Status') }}</th>
                            <th class="p-4 font-bold">{{ __('Paid At') }}</th>
                            <th class="p-4 font-bold text-right">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800 text-gray-800 dark:text-gray-200">
                        @forelse($fines as $fine)
                            <tr class="hover:bg-indigo-50/40 dark:hover:bg-cyan-950/20 transition-colors">
                                <td class="p-4 font-semibold text-gray-900 dark:text-white">
                                    {{ $fine->bookIssue->book->title ?? __('N/A (General Fine)') }}
                                </td>
                                <td class="p-4 font-bold text-rose-600 dark:text-rose-400">${{ number_format($fine->amount ?? 0, 2) }}</td>
                                <td class="p-4 whitespace-nowrap">
                                    @php
                                        $fineStatusColors = [
                                            'unpaid' => 'bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border-amber-300 dark:border-amber-500/30',
                                            'paid'   => 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border-emerald-300 dark:border-emerald-500/30',
                                            'waived' => 'bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 border-blue-300 dark:border-blue-500/30',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full border {{ $fineStatusColors[$fine->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($fine->status) }}
                                    </span>
                                </td>
                                <td class="p-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                    {{ $fine->paid_at ? \Carbon\Carbon::parse($fine->paid_at)->format('M d, Y H:i') : __('N/A') }}
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    @if($fine->status === 'unpaid')
                                        <form action="{{ route('fines.pay', $fine->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-indigo-600 dark:bg-gradient-to-r dark:from-cyan-500 dark:to-fuchsia-600 hover:opacity-90 rounded-xl transition-all shadow-md">
                                                <i class="fa-solid fa-credit-card mr-1"></i> {{ __('Pay Now') }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic">{{ __('Settled') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                    <i class="fa-solid fa-circle-check text-3xl mb-2 text-emerald-500/60"></i>
                                    <p>{{ __('No fines recorded on your account.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($fines->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-cyan-500/20">
                    {{ $fines->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection