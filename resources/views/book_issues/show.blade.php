@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        @php
            $user = auth()->user();
            $isAdmin = $user && ($user->is_admin || strtolower($user->role ?? '') === 'admin');
            $issueId = data_get($bookIssue, 'id');
            $bookId = data_get($bookIssue, 'book_id', data_get($bookIssue, 'book.id'));
            $bookFilePath = data_get($bookIssue, 'book.file_path');
            $status = data_get($bookIssue, 'status', 'issued');
            $dueDate = data_get($bookIssue, 'return_date', data_get($bookIssue, 'due_date'));
            $isOverdue = in_array($status, ['issued', 'borrowed', 'active']) && $dueDate && \Carbon\Carbon::parse($dueDate)->isPast();
            $fineAmount = (float) data_get($bookIssue, 'fine', 0);
            $fineStatus = data_get($bookIssue, 'fine_status', 'unpaid');

            // Dynamic Back Route Resolver
            if ($isAdmin) {
                $backRoute = Route::has('admin.book_issues.index') 
                    ? route('admin.book_issues.index') 
                    : (Route::has('book_issues.index') ? route('book_issues.index') : url('/admin/book-issues'));
                $returnRoute = Route::has('admin.book_issues.return') 
                    ? route('admin.book_issues.return', $issueId) 
                    : (Route::has('book_issues.return') ? route('book_issues.return', $issueId) : '#');
                $payFineRoute = Route::has('admin.book_issues.pay_fine') ? route('admin.book_issues.pay_fine', $issueId) : url("/admin/book-issues/{$issueId}/pay-fine");
                $waiveFineRoute = Route::has('admin.book_issues.waive_fine') ? route('admin.book_issues.waive_fine', $issueId) : url("/admin/book-issues/{$issueId}/waive-fine");
            } else {
                $backRoute = Route::has('member.book_issues.my') 
                    ? route('member.book_issues.my') 
                    : (Route::has('book_issues.my') ? route('book_issues.my') : url('/member/book-issues/my'));
                $returnRoute = Route::has('member.book_issues.return') 
                    ? route('member.book_issues.return', $issueId) 
                    : (Route::has('book_issues.return') ? route('book_issues.return', $issueId) : '#');
            }

            $readRoute = Route::has('member.books.read') 
                ? route('member.books.read', $bookId) 
                : (Route::has('books.read') ? route('books.read', $bookId) : url("/books/{$bookId}/read"));
            $confirmMsg = __('Process return and calculate fine if applicable?');
        @endphp

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                    {{ __('Book Issue Details') }}
                </h2>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ __('Overview of circulation transaction and loan status.') }}</p>
            </div>
            <a href="{{ $backRoute }}" class="px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl shadow-[0_0_10px_rgba(255,255,255,0.05)] transition-all duration-300 flex items-center justify-center">
                {{ __('Back to List') }}
            </a>
        </div>

        <div class="relative w-full mb-6">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-20 dark:opacity-40 blur-xl transition-all duration-500 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] p-6 md:p-8 transition-all duration-300">
                <h3 class="text-xs font-bold text-gray-800 dark:text-cyan-400 uppercase tracking-wider mb-6 pb-3 border-b border-violet-100 dark:border-cyan-950/80">{{ __('Transaction Summary') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div class="space-y-5">
                        <div>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Book Title') }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-900 dark:text-gray-100 font-bold text-base block">{{ data_get($bookIssue, 'book.title', 'N/A') }}</span>
                                @if(!empty($bookFilePath) && in_array($status, ['issued', 'borrowed', 'approved', 'active']))
                                <a href="{{ $readRoute }}" class="px-2.5 py-1 text-xs font-bold text-white bg-gradient-to-r from-violet-600 to-cyan-500 hover:from-violet-500 hover:to-cyan-400 rounded-lg shadow-md transition-all flex items-center gap-1">
                                    <i class="fa-solid fa-book-open text-xs"></i> {{ __('Read Digital Copy') }}
                                </a>
                                @endif
                            </div>
                            <span class="block text-xs text-violet-600 dark:text-cyan-400/80 font-mono mt-0.5">{{ __('ISBN:') }} {{ data_get($bookIssue, 'book.isbn', 'N/A') }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Borrower Member') }}</span>
                            <span class="text-gray-900 dark:text-gray-100 font-bold text-base block">{{ data_get($bookIssue, 'member.user.name', data_get($bookIssue, 'member.name', data_get($bookIssue, 'user.name', 'N/A'))) }}</span>
                            <span class="block text-xs text-violet-600 dark:text-cyan-400/80 font-mono mt-0.5">{{ __('Membership No:') }} {{ data_get($bookIssue, 'member.membership_no', 'N/A') }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Status') }}</span>
                            @if($isOverdue)
                            <span class="mt-1 px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/30 shadow-[0_0_10px_rgba(244,63,94,0.2)]">
                                {{ __('Overdue') }}
                            </span>
                            @elseif(in_array($status, ['issued', 'borrowed', 'active']))
                            <span class="mt-1 px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/30 shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                                {{ ucfirst($status) }}
                            </span>
                            @else
                            <span class="mt-1 px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                                {{ ucfirst($status) }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Issue Date') }}</span>
                            <span class="text-gray-800 dark:text-gray-200 font-mono font-medium block">{{ data_get($bookIssue, 'issue_date', 'N/A') }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Due Date') }}</span>
                            <span class="text-gray-800 dark:text-gray-200 font-mono font-medium block">{{ $dueDate ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Actual Return Date') }}</span>
                            <span class="text-gray-800 dark:text-gray-200 font-mono font-medium block">{{ data_get($bookIssue, 'actual_return_date', __('Not yet returned')) }}</span>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Late Fine Assessment') }}</span>
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="text-gray-900 dark:text-cyan-300 font-mono font-bold text-lg drop-shadow-[0_0_8px_rgba(34,211,238,0.3)] block">₹{{ number_format($fineAmount, 2) }}</span>
                                @if($fineAmount > 0)
                                    @if($fineStatus === 'paid')
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30">
                                        {{ __('Paid') }}
                                    </span>
                                    @elseif($fineStatus === 'waived')
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/30" title="{{ data_get($bookIssue, 'waiver_reason') }}">
                                        {{ __('Waived') }}
                                    </span>
                                    @else
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/30">
                                        {{ __('Unpaid') }}
                                    </span>
                                    @endif
                                @endif
                            </div>

                            @if($isAdmin && $fineAmount > 0 && $fineStatus === 'unpaid')
                            <div class="mt-3 flex items-center gap-2">
                                <form action="{{ $payFineRoute }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-emerald-600 bg-emerald-500/10 border border-emerald-500/30 rounded-lg hover:bg-emerald-500/20 transition-all">
                                        <i class="fa-solid fa-check mr-1"></i> {{ __('Pay Fine') }}
                                    </button>
                                </form>
                                <button type="button" 
                                    onclick="let reason = prompt('Enter reason for waiving this fine:'); if(reason) { let f = document.createElement('form'); f.method='POST'; f.action='{{ $waiveFineRoute }}'; let token = document.createElement('input'); token.type='hidden'; token.name='_token'; token.value='{{ csrf_token() }}'; let input = document.createElement('input'); input.type='hidden'; input.name='waiver_reason'; input.value=reason; f.appendChild(token); f.appendChild(input); document.body.appendChild(f); f.submit(); }"
                                    class="px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-500/10 border border-blue-500/30 rounded-lg hover:bg-blue-500/20 transition-all">
                                    <i class="fa-solid fa-hand-holding-dollar mr-1"></i> {{ __('Waive Fine') }}
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if(in_array($status, ['issued', 'borrowed', 'approved', 'active']))
                <div class="mt-8 pt-6 border-t border-violet-100 dark:border-cyan-950/80 flex justify-end">
                    <form action="{{ $returnRoute }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-500 hover:from-emerald-500 hover:via-teal-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(16,185,129,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] border border-emerald-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]"
                            onclick="return confirm('{{ addslashes($confirmMsg) }}')">
                            {{ __('Process Book Return') }}
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection