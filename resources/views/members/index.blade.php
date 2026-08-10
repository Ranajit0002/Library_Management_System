@extends('layouts.app')
@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        @php
            $createRoute = Route::has('members.create') ? route('members.create') : '#';
            $indexRoute = Route::has('members.index') ? route('members.index') : '#';
        @endphp
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)]">
                    {{ __('Manage Members') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-cyan-300/70 mt-1">{{ __('View, search, and manage library members and their profiles.') }}</p>
            </div>
            <a href="{{ $createRoute }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 text-white text-sm font-bold shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                {{ __('Register New Member') }}
            </a>
        </div>
        @if (session('success'))
        <div class="mb-6 bg-emerald-500/10 dark:bg-emerald-950/40 border border-emerald-500/40 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.2)] text-sm flex items-center justify-between backdrop-blur-md" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-300 font-bold text-lg leading-none">&times;</button>
        </div>
        @endif
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl overflow-hidden shadow-lg dark:shadow-[0_0_20px_rgba(6,182,212,0.1)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 p-4 mb-6 transition-all duration-300">
            <form action="{{ $indexRoute }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by name, email, membership no, or phone...') }}" class="w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                </div>
                <div class="flex gap-2">
                    <select name="status" class="w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-gray-800 dark:bg-cyan-950/80 border border-gray-700 dark:border-cyan-500/50 text-white dark:text-cyan-300 text-sm font-semibold hover:bg-gray-900 dark:hover:bg-cyan-900 dark:hover:shadow-[0_0_15px_rgba(6,182,212,0.4)] transition-all duration-300">{{ __('Filter') }}</button>
                    @if(request('search') || request('status'))
                    <a href="{{ $indexRoute }}" class="px-4 py-2 rounded-xl border border-gray-300 dark:border-fuchsia-500/40 text-gray-700 dark:text-fuchsia-300 text-sm font-semibold hover:bg-fuchsia-50 dark:hover:bg-fuchsia-950/40 hover:border-fuchsia-400 hover:shadow-[0_0_15px_rgba(217,70,239,0.4)] transition-all duration-300 flex items-center justify-center">{{ __('Reset') }}</a>
                    @endif
                </div>
            </form>
        </div>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl overflow-hidden shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 transition-all duration-300">
            <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200/80 dark:divide-cyan-500/20">
                    <thead>
                        <tr class="border-b border-gray-200/80 dark:border-cyan-500/30">
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Membership No') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Name / Email') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Phone') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Joining Date') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-left text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-950/60 text-right text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200/80 dark:divide-cyan-500/20 bg-transparent">
                        @forelse ($members ?? [] as $member)
                        @php
                            $memberId = data_get($member, 'id');
                            $membershipNo = data_get($member, 'membership_no', 'N/A');
                            $userName = data_get($member, 'user.name', 'N/A');
                            $userEmail = data_get($member, 'user.email', 'N/A');
                            $phone = data_get($member, 'phone', 'N/A');
                            $joiningDate = data_get($member, 'joining_date', 'N/A');
                            $status = data_get($member, 'status', 'active');
                            $showRoute = Route::has('members.show') && $memberId ? route('members.show', $memberId) : '#';
                            $editRoute = Route::has('members.edit') && $memberId ? route('members.edit', $memberId) : '#';
                            $destroyRoute = Route::has('members.destroy') && $memberId ? route('members.destroy', $memberId) : '#';
                            $confirmMsg = addslashes(__('Are you sure you want to remove this member? This action cannot be undone.'));
                        @endphp
                        <tr class="hover:bg-cyan-500/5 dark:hover:bg-cyan-500/10 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-semibold text-gray-900 dark:text-cyan-300">{{ $membershipNo }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                <span class="font-bold text-gray-900 dark:text-gray-100 block">{{ $userName }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $userEmail }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $joiningDate }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1 inline-flex text-xs leading-4 font-bold rounded-full border transition-all duration-300 {{ $status == 'active' ? 'bg-emerald-500/10 border-emerald-500/40 text-emerald-600 dark:text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.3)]' : 'bg-rose-500/10 border-rose-500/40 text-rose-600 dark:text-rose-400 shadow-[0_0_10px_rgba(244,63,94,0.3)]' }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ $showRoute }}" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-200 font-bold transition-all duration-300 drop-shadow-[0_0_8px_rgba(6,182,212,0.3)]">{{ __('View') }}</a>
                                <a href="{{ $editRoute }}" class="text-amber-500 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-200 font-bold transition-all duration-300 drop-shadow-[0_0_8px_rgba(245,158,11,0.3)]">{{ __('Edit') }}</a>
                                <form action="{{ $destroyRoute }}" method="POST" class="inline" onsubmit="return confirm('{{ $confirmMsg }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-200 font-bold transition-all duration-300 drop-shadow-[0_0_8px_rgba(244,63,94,0.3)]">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-cyan-300/60 font-medium">
                                {{ __('No library members found.') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if(isset($members) && method_exists($members, 'hasPages') && $members->hasPages())
                <div class="mt-4 pt-4 border-t border-gray-200/80 dark:border-cyan-500/20">
                    {{ $members->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection