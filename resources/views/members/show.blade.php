@extends('layouts.app')
@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        @php
            $memberId = data_get($member, 'id');
            $editRoute = Route::has('members.edit') && $memberId ? route('members.edit', $memberId) : '#';
            $indexRoute = Route::has('members.index') ? route('members.index') : '#';
            $name = data_get($member, 'user.name', 'N/A');
            $email = data_get($member, 'user.email', 'N/A');
            $membershipNo = data_get($member, 'membership_no', 'N/A');
            $phone = data_get($member, 'phone', 'N/A');
            $joiningDate = data_get($member, 'joining_date', 'N/A');
            $status = data_get($member, 'status', 'active');
            $address = data_get($member, 'address', __('No address provided.'));
            $borrowings = data_get($member, 'borrowings', []);
        @endphp
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)]">
                    {{ __('Member Profile Details') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-cyan-300/70 mt-1">{{ __('Comprehensive member info and borrowing history.') }}</p>
            </div>
            <div class="space-x-2 flex items-center">
                <a href="{{ $editRoute }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 text-white text-sm font-bold shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    {{ __('Edit Member') }}
                </a>
                <a href="{{ $indexRoute }}" class="px-4 py-2.5 rounded-xl border border-gray-300 dark:border-fuchsia-500/40 text-gray-700 dark:text-fuchsia-300 text-sm font-semibold hover:bg-fuchsia-50 dark:hover:bg-fuchsia-950/40 hover:border-fuchsia-400 hover:text-fuchsia-600 dark:hover:text-fuchsia-200 hover:shadow-[0_0_15px_rgba(217,70,239,0.4)] transition-all duration-300">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl overflow-hidden shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 p-6 md:p-8 mb-6 transition-all duration-300">
            <h3 class="text-xs font-bold text-gray-800 dark:text-cyan-300 uppercase tracking-widest mb-6 pb-2 border-b border-gray-200/80 dark:border-cyan-500/20 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_8px_rgba(6,182,212,0.8)]"></span>
                {{ __('Personal & Account Information') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div class="space-y-4">
                    <div>
                        <span class="block text-xs text-gray-400 dark:text-cyan-300/60 uppercase tracking-wider font-semibold">{{ __('Full Name') }}</span>
                        <span class="text-gray-900 dark:text-gray-100 font-bold text-lg">{{ $name }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 dark:text-cyan-300/60 uppercase tracking-wider font-semibold">{{ __('Email Address') }}</span>
                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $email }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 dark:text-cyan-300/60 uppercase tracking-wider font-semibold">{{ __('Membership Number') }}</span>
                        <span class="font-mono font-bold text-gray-900 dark:text-cyan-300 tracking-wider">{{ $membershipNo }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 dark:text-cyan-300/60 uppercase tracking-wider font-semibold">{{ __('Phone') }}</span>
                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $phone }}</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <span class="block text-xs text-gray-400 dark:text-cyan-300/60 uppercase tracking-wider font-semibold">{{ __('Joining Date') }}</span>
                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $joiningDate }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 dark:text-cyan-300/60 uppercase tracking-wider font-semibold">{{ __('Status') }}</span>
                        <span class="mt-1 px-3 py-1 inline-flex text-xs leading-4 font-bold rounded-full border transition-all duration-300 {{ $status == 'active' ? 'bg-emerald-500/10 border-emerald-500/40 text-emerald-600 dark:text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.3)]' : 'bg-rose-500/10 border-rose-500/40 text-rose-600 dark:text-rose-400 shadow-[0_0_10px_rgba(244,63,94,0.3)]' }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 dark:text-cyan-300/60 uppercase tracking-wider font-semibold mb-1">{{ __('Address') }}</span>
                        <span class="text-gray-700 dark:text-gray-200 block bg-gray-50/50 dark:bg-gray-950/60 p-3.5 rounded-xl border border-gray-200/80 dark:border-cyan-500/20 backdrop-blur-md leading-relaxed">{{ $address }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl overflow-hidden shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 p-6 md:p-8 transition-all duration-300">
            <h3 class="text-xs font-bold text-gray-800 dark:text-cyan-300 uppercase tracking-widest mb-6 pb-2 border-b border-gray-200/80 dark:border-cyan-500/20 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-fuchsia-400 shadow-[0_0_8px_rgba(217,70,239,0.8)]"></span>
                {{ __('Borrowing History') }}
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200/80 dark:divide-cyan-500/20">
                    <thead>
                        <tr class="border-b border-gray-200/80 dark:border-cyan-500/30">
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Book Title') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Issue Date') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Due Date') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Return Date') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200/80 dark:divide-cyan-500/20 bg-transparent">
                        @forelse($borrowings as $borrow)
                        @php
                            $bookTitle = data_get($borrow, 'book.title', __('Unknown Book'));
                            $issueDate = data_get($borrow, 'issue_date', 'N/A');
                            $dueDate = data_get($borrow, 'due_date', 'N/A');
                            $returnDate = data_get($borrow, 'return_date', __('Not Returned'));
                            $bStatus = data_get($borrow, 'status', 'active');
                        @endphp
                        <tr class="hover:bg-cyan-500/5 dark:hover:bg-cyan-500/10 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">
                                {{ $bookTitle }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $issueDate }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $dueDate }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $returnDate }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1 inline-flex text-xs leading-4 font-bold rounded-full border transition-all duration-300 {{ $bStatus == 'returned' ? 'bg-emerald-500/10 border-emerald-500/40 text-emerald-600 dark:text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.3)]' : 'bg-amber-500/10 border-amber-500/40 text-amber-600 dark:text-amber-400 shadow-[0_0_10px_rgba(245,158,11,0.3)]' }}">
                                    {{ ucfirst($bStatus) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-cyan-300/60 font-medium">
                                {{ __('No borrowing records found for this member.') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection