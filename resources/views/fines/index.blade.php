@extends('layouts.app')

@section('content')
<div class="py-6 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 tracking-wide">
            {{ $isAdmin ? __('Manage Fines') : __('My Fines') }}
        </h2>
    </div>

    @if (session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl text-xs flex items-center justify-between">
        <span><i class="fa-solid fa-circle-check text-emerald-500 mr-2"></i> {{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove();" class="text-emerald-500 font-bold">&times;</button>
    </div>
    @endif

    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-xl border border-gray-200/80 dark:border-cyan-500/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-cyan-500/20 bg-gray-50/50 dark:bg-gray-800/50 text-xs font-bold text-gray-500 dark:text-cyan-400 uppercase tracking-wider">
                        @if($isAdmin)
                        <th class="p-4">{{ __('Member') }}</th>
                        @endif
                        <th class="p-4">{{ __('Book Title') }}</th>
                        <th class="p-4">{{ __('Amount') }}</th>
                        <th class="p-4">{{ __('Status') }}</th>
                        <th class="p-4">{{ $isAdmin ? __('Date Issued') : __('Date') }}</th>
                        <th class="p-4 text-right">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-cyan-500/10 text-sm">
                    @forelse($fines as $fine)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-cyan-950/10 transition-colors">
                        @if($isAdmin)
                        <td class="p-4 font-semibold text-gray-900 dark:text-gray-100">
                            {{ $fine->user->name ?? __('N/A') }}
                        </td>
                        @endif
                        <td class="p-4 font-semibold text-gray-900 dark:text-gray-100">
                            {{ $fine->bookIssue->book->title ?? __('N/A') }}
                        </td>
                        <td class="p-4 font-bold text-indigo-600 dark:text-cyan-400">
                            ${{ number_format($fine->amount, 2) }}
                        </td>
                        <td class="p-4">
                            @if($fine->status === 'paid')
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/30">{{ __('Paid') }}</span>
                            @elseif($fine->status === 'waived')
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-500/10 text-amber-500 border border-amber-500/30">{{ __('Waived') }}</span>
                            @else
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-500/10 text-rose-500 border border-rose-500/30">{{ __('Unpaid') }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 text-xs">
                            {{ $fine->created_at->format('M d, Y') }}
                        </td>
                        <td class="p-4 text-right">
                            @if($fine->status === 'unpaid')
                                @if($isAdmin)
                                <form action="{{ route('admin.fines.waive', $fine->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-amber-500 bg-amber-500/10 border border-amber-500/30 rounded-xl hover:bg-amber-500/20 transition-all">
                                        {{ __('Waive') }}
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('member.fines.pay', $fine->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-cyan-500 to-indigo-600 rounded-xl shadow hover:shadow-lg transition-all">
                                        {{ __('Pay Now') }}
                                    </button>
                                </form>
                                @endif
                            @else
                            <span class="text-xs text-gray-400 font-medium">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 6 : 5 }}" class="p-12 text-center text-gray-500 dark:text-cyan-300/60 font-medium">
                            {{ __('No fine records found.') }}
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
@endsection