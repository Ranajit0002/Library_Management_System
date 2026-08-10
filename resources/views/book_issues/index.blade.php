@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                    {{ __('Book Circulation (Issues)') }}
                </h2>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ __('Manage book loans, returns, tracking, and late fines.') }}</p>
            </div>
            @if(auth()->check() && (auth()->user()->is_admin || strtolower(auth()->user()->role ?? '') === 'admin'))
            @if(Route::has('admin.book_issues.create') || Route::has('book_issues.create'))
            <a href="{{ Route::has('admin.book_issues.create') ? route('admin.book_issues.create') : route('book_issues.create') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                <i class="fa-solid fa-plus mr-1"></i> {{ __('Issue Book') }}
            </a>
            @endif
            @endif
        </div>

        @if (session('success'))
        <div id="flash-success" class="bg-emerald-500/10 dark:bg-emerald-950/40 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.15)] text-xs flex items-center justify-between backdrop-blur-md" role="alert">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('success') }}
            </span>
            <button type="button" onclick="document.getElementById('flash-success').remove();" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300 font-bold text-base leading-none">&times;</button>
        </div>
        @endif

        @if (session('error'))
        <div id="flash-error" class="bg-rose-500/10 dark:bg-rose-950/40 border border-rose-500/30 text-rose-700 dark:text-rose-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(244,63,94,0.15)] text-xs flex items-center justify-between backdrop-blur-md" role="alert">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark text-rose-500"></i> {{ session('error') }}
            </span>
            <button type="button" onclick="document.getElementById('flash-error').remove();" class="text-rose-500 hover:text-rose-700 dark:hover:text-rose-300 font-bold text-base leading-none">&times;</button>
        </div>
        @endif

        <div class="relative w-full">
            <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-r from-violet-600/30 via-fuchsia-600/30 to-cyan-500/30 blur-md opacity-50 dark:opacity-75 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-sm p-4">
                @php
                $isMemberView = isset($isMemberView) ? $isMemberView : (!auth()->user()->is_admin && strtolower(auth()->user()->role ?? '') !== 'admin');
                $filterAction = $isMemberView
                    ? (Route::has('member.book_issues.my') ? route('member.book_issues.my') : (Route::has('book_issues.my') ? route('book_issues.my') : url()->current()))
                    : (Route::has('admin.book_issues.index') ? route('admin.book_issues.index') : (Route::has('book_issues.index') ? route('book_issues.index') : url()->current()));
                @endphp
                <form action="{{ $filterAction }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ $isMemberView ? __('Search by book title or ISBN...') : __('Search by book title, ISBN, member name, email, or membership no...') }}"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300">
                    </div>
                    <div class="flex gap-2">
                        <select
                            name="status"
                            class="w-full px-3 py-2 text-xs rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300">
                            <option value="" class="dark:bg-gray-900">{{ __('All Statuses') }}</option>
                            <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }} class="dark:bg-gray-900">{{ __('Issued / Borrowed') }}</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }} class="dark:bg-gray-900">{{ __('Returned') }}</option>
                        </select>
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_15px_rgba(139,92,246,0.3)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 flex items-center gap-1.5">
                            <i class="fa-solid fa-filter"></i> {{ __('Filter') }}
                        </button>
                        @if(request('search') || request('status'))
                        <a href="{{ $filterAction }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl transition-all duration-300 flex items-center justify-center">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="relative w-full">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-20 dark:opacity-30 blur-xl pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-100 dark:divide-cyan-950/60 text-left">
                        <thead>
                            <tr class="border-b border-violet-100 dark:border-cyan-900/40 text-[11px] font-bold text-gray-700 dark:text-cyan-400 uppercase tracking-wider bg-violet-50/50 dark:bg-gray-900/50">
                                <th class="px-6 py-3.5">{{ __('Book & Status') }}</th>
                                @if(!$isMemberView)
                                <th class="px-6 py-3.5">{{ __('Member & ID') }}</th>
                                @endif
                                <th class="px-6 py-3.5">{{ __('Dates') }}</th>
                                <th class="px-6 py-3.5">{{ __('Fine & Status (₹10/day)') }}</th>
                                <th class="px-6 py-3.5 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-violet-100/60 dark:divide-cyan-950/40 text-xs">
                            @forelse ($bookIssues ?? [] as $issue)
                            @php
                            $status = data_get($issue, 'status', 'issued');
                            $user = auth()->user();
                            $isAdmin = $user && ($user->is_admin || strtolower($user->role ?? '') === 'admin');
                            $issueId = data_get($issue, 'id');
                            $bookId = data_get($issue, 'book_id', data_get($issue, 'book.id'));
                            $bookFilePath = data_get($issue, 'book.file_path');
                            $dueDate = data_get($issue, 'return_date', data_get($issue, 'due_date'));
                            $isOverdue = in_array($status, ['issued', 'borrowed', 'active', 'pending']) && $dueDate && \Carbon\Carbon::parse($dueDate)->isPast();
                            $fineAmount = (float) data_get($issue, 'fine', data_get($issue, 'fine_amount', 0));
                            $fineStatus = data_get($issue, 'fine_status', 'unpaid');

                            // Route Resolvers
                            if ($isAdmin) {
                                $showRoute = Route::has('admin.book_issues.show') ? route('admin.book_issues.show', $issueId) : (Route::has('book_issues.show') ? route('book_issues.show', $issueId) : url("/book-issues/{$issueId}"));
                                $returnRoute = Route::has('admin.book_issues.return') ? route('admin.book_issues.return', $issueId) : (Route::has('book_issues.return') ? route('book_issues.return', $issueId) : url("/book-issues/{$issueId}/return"));
                                $payFineRoute = Route::has('admin.book_issues.pay_fine') ? route('admin.book_issues.pay_fine', $issueId) : url("/admin/book-issues/{$issueId}/pay-fine");
                                $waiveFineRoute = Route::has('admin.book_issues.waive_fine') ? route('admin.book_issues.waive_fine', $issueId) : url("/admin/book-issues/{$issueId}/waive-fine");
                            } else {
                                $showRoute = Route::has('member.book_issues.show') ? route('member.book_issues.show', $issueId) : (Route::has('book_issues.show') ? route('book_issues.show', $issueId) : url("/book-issues/{$issueId}"));
                                $returnRoute = Route::has('member.book_issues.return') ? route('member.book_issues.return', $issueId) : (Route::has('book_issues.return') ? route('book_issues.return', $issueId) : url("/book-issues/{$issueId}/return"));
                            }

                            $readRoute = Route::has('member.books.read') ? route('member.books.read', $bookId) : (Route::has('books.read') ? route('books.read', $bookId) : url("/books/{$bookId}/read"));
                            @endphp
                            <tr class="hover:bg-violet-50/30 dark:hover:bg-cyan-950/20 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 dark:text-gray-100 tracking-tight mb-1 flex items-center gap-2">
                                        <span>{{ data_get($issue, 'book.title', 'N/A') }}</span>
                                        @if(!empty($bookFilePath) && in_array($status, ['issued', 'borrowed', 'approved', 'active']))
                                        <a href="{{ $readRoute }}" class="px-2 py-0.5 text-[9px] font-extrabold uppercase tracking-wider bg-cyan-500/20 text-cyan-700 dark:text-cyan-300 border border-cyan-500/40 rounded-md hover:bg-cyan-500/30 transition-all">
                                            <i class="fa-solid fa-book-open text-[9px]"></i> {{ __('Read') }}
                                        </a>
                                        @endif
                                    </div>
                                    <div>
                                        @if($isOverdue)
                                        <span class="px-2.5 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/30 shadow-[0_0_10px_rgba(244,63,94,0.2)]">
                                            <i class="fa-solid fa-clock mr-1"></i> {{ __('Overdue') }}
                                        </span>
                                        @elseif(in_array($status, ['issued', 'borrowed', 'active', 'pending']))
                                        <span class="px-2.5 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                                            {{ ucfirst($status) }}
                                        </span>
                                        @else
                                        <span class="px-2.5 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                                            {{ ucfirst($status) }}
                                        </span>
                                        @endif
                                    </div>
                                </td>

                                @if(!$isMemberView)
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-gray-900 dark:text-gray-100">
                                        {{ data_get($issue, 'member.user.name', data_get($issue, 'member.name', data_get($issue, 'user.name', 'N/A'))) }}
                                    </div>
                                    <div class="text-[11px] text-violet-600 dark:text-cyan-400/80 font-mono tracking-tight mt-0.5">
                                        {{ data_get($issue, 'member.membership_no', 'N/A') }}
                                    </div>
                                </td>
                                @endif

                                <td class="px-6 py-4">
                                    <div class="font-mono text-xs font-semibold text-gray-800 dark:text-gray-200">
                                        <span class="text-[10px] uppercase font-sans text-gray-400 mr-1">{{ __('Issue:') }}</span>{{ data_get($issue, 'issue_date', 'N/A') }}
                                    </div>
                                    <div class="font-mono text-xs font-semibold text-gray-800 dark:text-gray-200 mt-1">
                                        <span class="text-[10px] uppercase font-sans text-gray-400 mr-1">{{ __('Due:') }}</span>{{ $dueDate ?? 'N/A' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 font-mono font-black">
                                    @if($fineAmount > 0)
                                    <span class="text-rose-600 dark:text-rose-400 drop-shadow-[0_0_8px_rgba(244,63,94,0.4)]">
                                        ₹{{ number_format($fineAmount, 2) }}
                                    </span>
                                    <div class="mt-1 flex flex-wrap items-center gap-1">
                                        @if($fineStatus === 'paid')
                                        <span class="px-2 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30">
                                            {{ __('Paid') }}
                                        </span>
                                        @elseif($fineStatus === 'waived')
                                        <span class="px-2 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/30" title="{{ data_get($issue, 'waiver_reason') }}">
                                            {{ __('Waived') }}
                                        </span>
                                        @else
                                        <span class="px-2 py-0.5 inline-flex text-[10px] font-bold rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/30">
                                            {{ __('Unpaid') }}
                                        </span>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-emerald-600 dark:text-emerald-400">
                                        ₹0.00
                                    </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center font-medium">
                                    <div class="inline-flex items-center justify-center gap-2 flex-wrap">
                                        <a href="{{ $showRoute }}" class="px-2.5 py-1 text-xs font-bold text-violet-600 dark:text-cyan-400 bg-violet-500/10 dark:bg-cyan-500/10 border border-violet-500/20 dark:border-cyan-500/30 rounded-lg hover:scale-105 transition-all">
                                            {{ __('View') }}
                                        </a>

                                        @if(in_array($status, ['issued', 'borrowed', 'approved', 'active', 'pending']))
                                        <form action="{{ $returnRoute }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-2.5 py-1 text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 rounded-lg shadow-[0_0_10px_rgba(16,185,129,0.3)] transition-all hover:scale-105"
                                                onclick="return confirm('Confirm returning this book?');">
                                                {{ __('Return') }}
                                            </button>
                                        </form>
                                        @endif

                                        @if($isAdmin && $fineAmount > 0 && $fineStatus === 'unpaid')
                                        <form action="{{ $payFineRoute }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 text-xs font-bold text-emerald-600 bg-emerald-500/10 border border-emerald-500/30 rounded-lg hover:bg-emerald-500/20 transition-all">
                                                <i class="fa-solid fa-check mr-1"></i> {{ __('Pay Fine') }}
                                            </button>
                                        </form>
                                        <button type="button" 
                                            onclick="let reason = prompt('Enter reason for waiving this fine:'); if(reason) { let f = document.createElement('form'); f.method='POST'; f.action='{{ $waiveFineRoute }}'; let token = document.createElement('input'); token.type='hidden'; token.name='_token'; token.value='{{ csrf_token() }}'; let input = document.createElement('input'); input.type='hidden'; input.name='waiver_reason'; input.value=reason; f.appendChild(token); f.appendChild(input); document.body.appendChild(f); f.submit(); }"
                                            class="px-2.5 py-1 text-xs font-bold text-blue-600 bg-blue-500/10 border border-blue-500/30 rounded-lg hover:bg-blue-500/20 transition-all">
                                            <i class="fa-solid fa-hand-holding-dollar mr-1"></i> {{ __('Waive') }}
                                        </button>
                                        @endif

                                        @if($isAdmin)
                                        <form action="{{ Route::has('admin.book_issues.destroy') ? route('admin.book_issues.destroy', $issueId) : (Route::has('book_issues.destroy') ? route('book_issues.destroy', $issueId) : url("/book-issues/{$issueId}")) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 rounded-lg hover:bg-rose-500/10 transition-all" onclick="return confirm('Are you sure you want to delete this record?')">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $isMemberView ? 4 : 5 }}" class="px-6 py-12 text-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fa-solid fa-folder-open text-3xl opacity-50"></i>
                                        <p>{{ __('No book issue records found.') }}</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if(isset($bookIssues) && method_exists($bookIssues, 'hasPages') && $bookIssues->hasPages())
                    <div class="mt-6 pt-4 border-t border-violet-100/80 dark:border-cyan-950/60">
                        {{ $bookIssues->withQueryString()->links() }}
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