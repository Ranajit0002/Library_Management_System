@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        @php
            $user = auth()->user();
            $isAdmin = $user && ($user->is_admin || strtolower($user->role ?? '') === 'admin');
            $backRoute = $isAdmin 
                ? (Route::has('admin.book_issues.index') ? route('admin.book_issues.index') : (Route::has('book_issues.index') ? route('book_issues.index') : url('/admin/book-issues')))
                : (Route::has('member.book_issues.my') ? route('member.book_issues.my') : (Route::has('book_issues.my') ? route('book_issues.my') : url('/member/book-issues/my')));
            
            $storeRoute = Route::has('admin.book_issues.store') 
                ? route('admin.book_issues.store') 
                : (Route::has('book_issues.store') ? route('book_issues.store') : url('/admin/book-issues'));
        @endphp
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                    {{ __('Issue Book to Member') }}
                </h2>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ __('Select an available book and active member to record a new loan.') }}</p>
            </div>
            <a href="{{ $backRoute }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl transition-all flex items-center justify-center">
                {{ __('Back to List') }}
            </a>
        </div>
        <div class="relative w-full">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-20 dark:opacity-40 blur-xl transition-all duration-500 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] p-6 md:p-8 transition-all duration-300">
                <form action="{{ $storeRoute }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Select Book *') }}</label>
                            <select
                                name="book_id"
                                class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 transition-all duration-300"
                                required>
                                <option value="" class="dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Select Available Book') }}</option>
                                @foreach($books ?? [] as $book)
                                @php
                                    $bookId = data_get($book, 'id');
                                    $availableQty = data_get($book, 'available_quantity', data_get($book, 'quantity', 0));
                                @endphp
                                <option value="{{ $bookId }}" {{ old('book_id') == $bookId ? 'selected' : '' }} class="dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                    {{ data_get($book, 'title', 'N/A') }} ({{ __('Available:') }} {{ $availableQty }})
                                </option>
                                @endforeach
                            </select>
                            @error('book_id') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Select Member *') }}</label>
                            <select
                                name="member_id"
                                class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 transition-all duration-300"
                                required>
                                <option value="" class="dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Select Active Member') }}</option>
                                @foreach($members ?? [] as $member)
                                @php
                                    $memberId = data_get($member, 'id');
                                    $memberName = data_get($member, 'user.name', data_get($member, 'name', 'N/A'));
                                    $membershipNo = data_get($member, 'membership_no', '');
                                @endphp
                                <option value="{{ $memberId }}" {{ old('member_id') == $memberId ? 'selected' : '' }} class="dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                    {{ $memberName }} @if($membershipNo) ({{ $membershipNo }}) @endif
                                </option>
                                @endforeach
                            </select>
                            @error('member_id') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Issue Date *') }}</label>
                            <input
                                type="date"
                                name="issue_date"
                                value="{{ old('issue_date', now()->toDateString()) }}"
                                class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 transition-all duration-300"
                                required>
                            @error('issue_date') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Return Due Date *') }}</label>
                            <input
                                type="date"
                                name="return_date"
                                value="{{ old('return_date', now()->addDays(14)->toDateString()) }}"
                                class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 transition-all duration-300"
                                required>
                            @error('return_date') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-3 items-center">
                        <a href="{{ $backRoute }}" class="px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl transition-all duration-300">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                            {{ __('Issue Book') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection