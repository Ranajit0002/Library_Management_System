@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)] leading-tight">
                {{ __('Admin Reports Dashboard') }}
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl border border-cyan-500/40 shadow-[0_0_20px_rgba(6,182,212,0.15)] dark:shadow-[0_0_20px_rgba(6,182,212,0.25)] flex flex-col justify-between transition-all duration-300">
                <span class="text-xs uppercase tracking-wider font-bold text-cyan-600 dark:text-cyan-400 drop-shadow-[0_0_5px_rgba(6,182,212,0.5)]">{{ __('Total Books') }}</span>
                <h3 class="text-3xl font-extrabold mt-2 text-gray-900 dark:text-white drop-shadow-[0_0_10px_rgba(6,182,212,0.3)]">{{ $totalBooks ?? 0 }}</h3>
            </div>
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl border border-emerald-500/40 shadow-[0_0_20px_rgba(16,185,129,0.15)] dark:shadow-[0_0_20px_rgba(16,185,129,0.25)] flex flex-col justify-between transition-all duration-300">
                <span class="text-xs uppercase tracking-wider font-bold text-emerald-600 dark:text-emerald-400 drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]">{{ __('Total Members') }}</span>
                <h3 class="text-3xl font-extrabold mt-2 text-gray-900 dark:text-white drop-shadow-[0_0_10px_rgba(16,185,129,0.3)]">{{ $totalMembers ?? 0 }}</h3>
            </div>
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl border border-amber-500/40 shadow-[0_0_20px_rgba(245,158,11,0.15)] dark:shadow-[0_0_20px_rgba(245,158,11,0.25)] flex flex-col justify-between transition-all duration-300">
                <span class="text-xs uppercase tracking-wider font-bold text-amber-600 dark:text-amber-400 drop-shadow-[0_0_5px_rgba(245,158,11,0.5)]">{{ __('Issues in Range') }}</span>
                <h3 class="text-3xl font-extrabold mt-2 text-gray-900 dark:text-white drop-shadow-[0_0_10px_rgba(245,158,11,0.3)]">{{ $totalIssuedInRange ?? 0 }}</h3>
            </div>
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl border border-fuchsia-500/40 shadow-[0_0_20px_rgba(217,70,239,0.15)] dark:shadow-[0_0_20px_rgba(217,70,239,0.25)] flex flex-col justify-between transition-all duration-300">
                <span class="text-xs uppercase tracking-wider font-bold text-fuchsia-600 dark:text-fuchsia-400 drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ __('Fine Collected') }}</span>
                <h3 class="text-3xl font-extrabold mt-2 text-gray-900 dark:text-white drop-shadow-[0_0_10px_rgba(217,70,239,0.3)]">₹{{ number_format($totalFineCollected ?? 0, 2) }}</h3>
            </div>
        </div>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl shadow-lg dark:shadow-[0_0_20px_rgba(6,182,212,0.1)] border border-gray-200/80 dark:border-cyan-500/30 mb-6 transition-all duration-300">
            <form method="GET" action="{{ Route::has('reports.index') ? route('reports.index') : '#' }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="type" class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('Report Type') }}</label>
                    <select name="type" id="type" class="w-full text-sm bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                        <option value="issues" {{ ($reportType ?? '') === 'issues' ? 'selected' : '' }} class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('All Issues') }}</option>
                        <option value="returned" {{ ($reportType ?? '') === 'returned' ? 'selected' : '' }} class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Returned Books') }}</option>
                        <option value="overdue" {{ ($reportType ?? '') === 'overdue' ? 'selected' : '' }} class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Overdue Books') }}</option>
                    </select>
                </div>
                <div>
                    <label for="start_date" class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}" class="w-full text-sm bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('End Date') }}</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}" class="w-full text-sm bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 text-white text-sm font-bold py-2.5 px-4 rounded-xl transition-all duration-300 shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        {{ __('Filter Report') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl overflow-hidden shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30">
            <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-cyan-500/20 text-left">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-950/50 text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">
                            <th class="px-6 py-3.5">#</th>
                            <th class="px-6 py-3.5">{{ __('Book Title') }}</th>
                            <th class="px-6 py-3.5">{{ __('Member Name') }}</th>
                            <th class="px-6 py-3.5">{{ __('Issue Date') }}</th>
                            <th class="px-6 py-3.5">{{ __('Due Date') }}</th>
                            <th class="px-6 py-3.5">{{ __('Status') }}</th>
                            <th class="px-6 py-3.5">{{ __('Fine (₹)') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-200 dark:divide-cyan-500/10 text-sm">
                        @forelse($records ?? [] as $record)
                        <tr class="hover:bg-cyan-500/5 dark:hover:bg-cyan-950/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400 font-medium">
                                {{ $loop->iteration + ((isset($records) && method_exists($records, 'currentPage')) ? ($records->currentPage() - 1) * $records->perPage() : 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-cyan-100">{{ data_get($record, 'book.title', 'N/A') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300/80">{{ data_get($record, 'member.user.name', data_get($record, 'member.name', 'N/A')) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300/80">{{ data_get($record, 'issue_date', data_get($record, 'created_at') ? \Carbon\Carbon::parse(data_get($record, 'created_at'))->toDateString() : 'N/A') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300/80">{{ data_get($record, 'due_date', 'N/A') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-extrabold rounded-full border {{ data_get($record, 'status') === 'returned' ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-600 dark:text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.3)]' : 'bg-amber-500/10 border-amber-500/30 text-amber-600 dark:text-amber-400 shadow-[0_0_10px_rgba(245,158,11,0.3)]' }}">
                                    {{ ucfirst(data_get($record, 'status', 'issued')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-fuchsia-300 font-bold drop-shadow-[0_0_5px_rgba(217,70,239,0.3)]">₹{{ number_format(data_get($record, 'fine', 0), 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-cyan-300/60 font-medium">
                                {{ __('No records found for the selected criteria.') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if(isset($records) && method_exists($records, 'hasPages') && $records->hasPages())
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-cyan-500/20">
                    {{ $records->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection