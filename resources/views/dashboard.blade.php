@extends('layouts.app')
@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="space-y-1">
        <h2 class="font-extrabold text-2xl sm:text-3xl text-gray-900 dark:text-white tracking-tight leading-snug flex items-center gap-3">
            <span class="inline-flex items-center justify-center p-2.5 rounded-xl bg-cyan-500/10 dark:bg-cyan-500/20 text-cyan-600 dark:text-cyan-400 border border-cyan-500/30 shadow-[0_0_15px_rgba(6,182,212,0.35)]">
                <i class="fa-solid fa-chart-line text-xl drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]"></i>
            </span>
            <span class="bg-gradient-to-r from-cyan-600 via-fuchsia-600 to-indigo-600 dark:from-cyan-400 dark:via-fuchsia-400 dark:to-indigo-400 bg-clip-text text-transparent drop-shadow-[0_0_12px_rgba(168,85,247,0.4)]">
                {{ __('Library Dashboard') }}
            </span>
        </h2>
        <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400">
            @auth
            @if(strtolower(auth()->user()?->role ?? '') === 'admin' || auth()->user()?->is_admin)
            System overview, circulation analytics, and management shortcuts.
            @else
            Track your current borrowings, history, and fines.
            @endif
            @else
            Explore our collection catalog and public statistics.
            @endauth
        </p>
    </div>
    @auth
    @if(strtolower(auth()->user()?->role ?? '') === 'admin' || auth()->user()?->is_admin)
    <div class="flex items-center gap-2.5">
        @if(Route::has('admin.books.create'))
        <a href="{{ route('admin.books.create') }}" class="relative group overflow-hidden inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 active:scale-95 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(6,182,212,0.5)] hover:shadow-[0_0_25px_rgba(6,182,212,0.8)] border border-cyan-300/30">
            <i class="fa-solid fa-plus text-xs drop-shadow-[0_0_5px_rgba(255,255,255,0.8)]"></i>
            <span>Add Book</span>
        </a>
        @elseif(Route::has('books.create'))
        <a href="{{ route('books.create') }}" class="relative group overflow-hidden inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 active:scale-95 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(6,182,212,0.5)] hover:shadow-[0_0_25px_rgba(6,182,212,0.8)] border border-cyan-300/30">
            <i class="fa-solid fa-plus text-xs drop-shadow-[0_0_5px_rgba(255,255,255,0.8)]"></i>
            <span>Add Book</span>
        </a>
        @endif

        @if(Route::has('members.create'))
        <a href="{{ route('members.create') }}" class="relative group overflow-hidden inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 active:scale-95 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(16,185,129,0.5)] hover:shadow-[0_0_25px_rgba(16,185,129,0.8)] border border-emerald-300/30">
            <i class="fa-solid fa-user-plus text-xs drop-shadow-[0_0_5px_rgba(255,255,255,0.8)]"></i>
            <span>Add Member</span>
        </a>
        @endif
    </div>
    @endif
    @endauth
</div>
@endsection

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    @auth
    @if(strtolower(auth()->user()?->role ?? '') === 'admin' || auth()->user()?->is_admin)
    <!-- ADMIN DASHBOARD PANELS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Books Card -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_15px_rgba(99,102,241,0.15)] dark:shadow-[0_0_20px_rgba(99,102,241,0.25)] border border-indigo-500/20 dark:border-indigo-500/40 p-5 overflow-hidden flex flex-col justify-between hover:border-indigo-500/60 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-500 dark:text-indigo-400 block truncate">Total Books</span>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1 truncate drop-shadow-[0_0_8px_rgba(99,102,241,0.3)]">{{ number_format($stats['total_books'] ?? 0) }}</h3>
                </div>
                <div class="p-3 bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-xl shrink-0 border border-indigo-500/30 shadow-[0_0_12px_rgba(99,102,241,0.3)]">
                    <i class="fa-solid fa-book text-lg"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-xs">
                <span class="text-emerald-600 dark:text-emerald-400 font-semibold drop-shadow-[0_0_5px_rgba(16,185,129,0.3)]">{{ $stats['available_books'] ?? 0 }} Available</span>
                @if(Route::has('admin.books.index'))
                <a href="{{ route('admin.books.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium hover:underline">Manage &rarr;</a>
                @elseif(Route::has('books.index'))
                <a href="{{ route('books.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium hover:underline">Manage &rarr;</a>
                @endif
            </div>
        </div>

        <!-- Currently Issued Card -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_15px_rgba(245,158,11,0.15)] dark:shadow-[0_0_20px_rgba(245,158,11,0.25)] border border-amber-500/20 dark:border-amber-500/40 p-5 overflow-hidden flex flex-col justify-between hover:border-amber-500/60 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-amber-500 dark:text-amber-400 block truncate">Currently Issued</span>
                    <h3 class="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-1 truncate drop-shadow-[0_0_8px_rgba(245,158,11,0.5)]">{{ number_format($stats['issued_books'] ?? 0) }}</h3>
                </div>
                <div class="p-3 bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-xl shrink-0 border border-amber-500/30 shadow-[0_0_12px_rgba(245,158,11,0.3)]">
                    <i class="fa-solid fa-hand-holding-hand text-lg"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">{{ $stats['todays_issues'] ?? 0 }} Issued Today</span>
                @if(Route::has('book_issues.index'))
                <a href="{{ route('book_issues.index') }}" class="text-amber-600 dark:text-amber-400 hover:text-amber-500 dark:hover:text-amber-300 font-medium hover:underline">Issues &rarr;</a>
                @endif
            </div>
        </div>

        <!-- Registered Members Card -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_15px_rgba(217,70,239,0.15)] dark:shadow-[0_0_20px_rgba(217,70,239,0.25)] border border-fuchsia-500/20 dark:border-fuchsia-500/40 p-5 overflow-hidden flex flex-col justify-between hover:border-fuchsia-500/60 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-fuchsia-500 dark:text-fuchsia-400 block truncate">Registered Members</span>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1 truncate drop-shadow-[0_0_8px_rgba(217,70,239,0.3)]">{{ number_format($stats['total_members'] ?? 0) }}</h3>
                </div>
                <div class="p-3 bg-fuchsia-500/10 dark:bg-fuchsia-500/20 text-fuchsia-600 dark:text-fuchsia-400 rounded-xl shrink-0 border border-fuchsia-500/30 shadow-[0_0_12px_rgba(217,70,239,0.3)]">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">Active Patrons</span>
                @if(Route::has('members.index'))
                <a href="{{ route('members.index') }}" class="text-fuchsia-600 dark:text-fuchsia-400 hover:text-fuchsia-500 dark:hover:text-fuchsia-300 font-medium hover:underline">Members &rarr;</a>
                @endif
            </div>
        </div>

        <!-- Catalog Metadata Card -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_15px_rgba(20,184,166,0.15)] dark:shadow-[0_0_20px_rgba(20,184,166,0.25)] border border-teal-500/20 dark:border-teal-500/40 p-5 overflow-hidden flex flex-col justify-between hover:border-teal-500/60 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div class="min-w-0 flex-1">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-teal-500 dark:text-teal-400 block truncate">Catalog Metadata</span>
                    <h3 class="text-2xl font-extrabold text-teal-600 dark:text-teal-400 mt-1 truncate drop-shadow-[0_0_8px_rgba(20,184,166,0.5)]">{{ $stats['total_categories'] ?? 0 }} <span class="text-xs font-normal text-gray-400">Genres</span></h3>
                </div>
                <div class="p-3 bg-teal-500/10 dark:bg-teal-500/20 text-teal-600 dark:text-teal-400 rounded-xl shrink-0 border border-teal-500/30 shadow-[0_0_12px_rgba(20,184,166,0.3)]">
                    <i class="fa-solid fa-layer-group text-lg"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400 truncate">{{ $stats['total_authors'] ?? 0 }} Authors / {{ $stats['total_publishers'] ?? 0 }} Publishers</span>
                @if(Route::has('categories.index'))
                <a href="{{ route('categories.index') }}" class="text-teal-600 dark:text-teal-400 hover:text-teal-500 dark:hover:text-teal-300 font-medium hover:underline shrink-0">Categories &rarr;</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_20px_rgba(6,182,212,0.1)] dark:shadow-[0_0_25px_rgba(6,182,212,0.2)] border border-cyan-500/20 dark:border-cyan-500/30 p-5 overflow-hidden">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-cyan-500 drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]"></i> Monthly Circulation Activity
                    </h3>
                    <p class="text-[11px] text-gray-400">Book issues vs returns over the last 6 months</p>
                </div>
                @if(Route::has('reports.index'))
                <a href="{{ route('reports.index') }}" class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 hover:text-cyan-500 hover:underline">Reports &rarr;</a>
                @endif
            </div>
            <div class="h-64 mt-4 relative">
                <canvas id="monthlyCirculationChart"></canvas>
            </div>
        </div>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_20px_rgba(217,70,239,0.1)] dark:shadow-[0_0_25px_rgba(217,70,239,0.2)] border border-fuchsia-500/20 dark:border-fuchsia-500/30 p-5 overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                    <div>
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-pie-chart text-fuchsia-500 drop-shadow-[0_0_8px_rgba(217,70,239,0.8)]"></i> Category Spread
                        </h3>
                        <p class="text-[11px] text-gray-400">Book count distribution across top genres</p>
                    </div>
                </div>
                <div class="h-48 mt-4 relative">
                    <canvas id="categoryDistributionChart"></canvas>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100 dark:border-gray-800 text-[11px] text-gray-500 dark:text-gray-400 flex justify-between items-center">
                <span>Total Categories</span>
                <span class="font-bold text-fuchsia-600 dark:text-fuchsia-400 drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $stats['total_categories'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Tables & Shortcuts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_20px_rgba(99,102,241,0.1)] dark:shadow-[0_0_25px_rgba(99,102,241,0.2)] border border-indigo-500/20 dark:border-indigo-500/30 p-5 overflow-hidden">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-indigo-500 drop-shadow-[0_0_8px_rgba(99,102,241,0.8)]"></i> Recent Issue Log
                    </h3>
                    <p class="text-[11px] text-gray-400">Latest transactions registered in the library</p>
                </div>
                @if(Route::has('book_issues.index'))
                <a href="{{ route('book_issues.index') }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 hover:underline">View All &rarr;</a>
                @endif
            </div>
            <div class="overflow-x-auto mt-3">
                <table class="w-full text-left text-xs table-fixed">
                    <thead>
                        <tr class="text-[10px] uppercase text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                            <th class="py-2 w-1/3">Book</th>
                            <th class="py-2 w-1/3">Member</th>
                            <th class="py-2 w-1/6 text-center">Issued</th>
                            <th class="py-2 w-1/6 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800/60 text-gray-700 dark:text-gray-200">
                        @forelse($recentIssues ?? [] as $issue)
                        <tr class="hover:bg-indigo-500/5 transition-colors">
                            <td class="py-2.5 font-medium truncate" title="{{ data_get($issue, 'book.title', 'N/A') }}">
                                {{ data_get($issue, 'book.title', 'N/A') }}
                            </td>
                            <td class="py-2.5 truncate text-gray-500 dark:text-gray-400" title="{{ data_get($issue, 'member.name', 'N/A') }}">
                                {{ data_get($issue, 'member.name', 'N/A') }}
                            </td>
                            <td class="py-2.5 text-center font-mono text-[11px] text-gray-500 dark:text-gray-400">
                                {{ data_get($issue, 'issue_date') ? \Carbon\Carbon::parse(data_get($issue, 'issue_date'))->format('M d') : '-' }}
                            </td>
                            <td class="py-2.5 text-right">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold tracking-wide uppercase border {{ data_get($issue, 'status') === 'returned' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/30 shadow-[0_0_8px_rgba(16,185,129,0.3)]' : 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/30 shadow-[0_0_8px_rgba(245,158,11,0.3)]' }}">
                                    {{ ucfirst(data_get($issue, 'status', 'issued')) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-400 italic">No recent issues found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shortcuts Tile -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_20px_rgba(168,85,247,0.1)] dark:shadow-[0_0_25px_rgba(168,85,247,0.2)] border border-purple-500/20 dark:border-purple-500/30 p-5 overflow-hidden flex flex-col justify-between">
            <div>
                <div class="pb-3 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-purple-500 drop-shadow-[0_0_8px_rgba(168,85,247,0.8)]"></i> Administration Shortcuts
                    </h3>
                    <p class="text-[11px] text-gray-400">Fast-track navigation to primary catalog modules</p>
                </div>
                <div class="grid grid-cols-2 gap-3 mt-4">
                    @if(Route::has('admin.books.index'))
                    <a href="{{ route('admin.books.index') }}" class="p-3 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-cyan-500/10 dark:hover:bg-cyan-500/20 rounded-xl border border-gray-200/60 dark:border-gray-700/60 hover:border-cyan-500/50 transition-all duration-300 group shadow-xs hover:shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-book text-cyan-500 group-hover:scale-110 transition-transform drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]"></i>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200">Books</h4>
                                <p class="text-[10px] text-gray-400">Inventory & Stock</p>
                            </div>
                        </div>
                    </a>
                    @elseif(Route::has('books.index'))
                    <a href="{{ route('books.index') }}" class="p-3 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-cyan-500/10 dark:hover:bg-cyan-500/20 rounded-xl border border-gray-200/60 dark:border-gray-700/60 hover:border-cyan-500/50 transition-all duration-300 group shadow-xs hover:shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-book text-cyan-500 group-hover:scale-110 transition-transform drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]"></i>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200">Books</h4>
                                <p class="text-[10px] text-gray-400">Inventory & Stock</p>
                            </div>
                        </div>
                    </a>
                    @endif

                    @if(Route::has('categories.index'))
                    <a href="{{ route('categories.index') }}" class="p-3 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-teal-500/10 dark:hover:bg-teal-500/20 rounded-xl border border-gray-200/60 dark:border-gray-700/60 hover:border-teal-500/50 transition-all duration-300 group shadow-xs hover:shadow-[0_0_15px_rgba(20,184,166,0.3)]">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-layer-group text-teal-500 group-hover:scale-110 transition-transform drop-shadow-[0_0_8px_rgba(20,184,166,0.8)]"></i>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200">Categories</h4>
                                <p class="text-[10px] text-gray-400">Genres & Topics</p>
                            </div>
                        </div>
                    </a>
                    @endif

                    @if(Route::has('authors.index'))
                    <a href="{{ route('authors.index') }}" class="p-3 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-rose-500/10 dark:hover:bg-rose-500/20 rounded-xl border border-gray-200/60 dark:border-gray-700/60 hover:border-rose-500/50 transition-all duration-300 group shadow-xs hover:shadow-[0_0_15px_rgba(244,63,94,0.3)]">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-feather text-rose-500 group-hover:scale-110 transition-transform drop-shadow-[0_0_8px_rgba(244,63,94,0.8)]"></i>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200">Authors</h4>
                                <p class="text-[10px] text-gray-400">Writer Registry</p>
                            </div>
                        </div>
                    </a>
                    @endif

                    @if(Route::has('publishers.index'))
                    <a href="{{ route('publishers.index') }}" class="p-3 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-fuchsia-500/10 dark:hover:bg-fuchsia-500/20 rounded-xl border border-gray-200/60 dark:border-gray-700/60 hover:border-fuchsia-500/50 transition-all duration-300 group shadow-xs hover:shadow-[0_0_15px_rgba(217,70,239,0.3)]">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-building text-fuchsia-500 group-hover:scale-110 transition-transform drop-shadow-[0_0_8px_rgba(217,70,239,0.8)]"></i>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200">Publishers</h4>
                                <p class="text-[10px] text-gray-400">Publishing Houses</p>
                            </div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- MEMBER DASHBOARD PANELS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_20px_rgba(6,182,212,0.15)] border border-cyan-500/20 dark:border-cyan-500/40 p-5 flex items-center justify-between overflow-hidden">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-cyan-500 dark:text-cyan-400 block">Borrowed Books</span>
                <h3 class="text-2xl font-extrabold text-cyan-600 dark:text-cyan-400 mt-1 drop-shadow-[0_0_8px_rgba(6,182,212,0.5)]">{{ $memberStats['current_borrowed'] ?? 0 }}</h3>
                @if(Route::has('book_issues.my'))
                <a href="{{ route('book_issues.my') }}" class="text-xs text-cyan-600 dark:text-cyan-400 hover:underline mt-2 inline-block font-semibold">View My Borrowings &rarr;</a>
                @endif
            </div>
            <div class="p-3 bg-cyan-500/10 dark:bg-cyan-500/20 text-cyan-600 dark:text-cyan-400 rounded-xl border border-cyan-500/30 shadow-[0_0_12px_rgba(6,182,212,0.3)]">
                <i class="fa-solid fa-book-open text-xl"></i>
            </div>
        </div>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_20px_rgba(16,185,129,0.15)] border border-emerald-500/20 dark:border-emerald-500/40 p-5 flex items-center justify-between overflow-hidden">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-500 dark:text-emerald-400 block">Total Returned</span>
                <h3 class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1 drop-shadow-[0_0_8px_rgba(16,185,129,0.5)]">{{ $memberStats['total_returned'] ?? 0 }}</h3>
                <span class="text-xs text-gray-400 mt-2 block">Completed Reading</span>
            </div>
            <div class="p-3 bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl border border-emerald-500/30 shadow-[0_0_12px_rgba(16,185,129,0.3)]">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
        </div>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_20px_rgba(244,63,94,0.15)] border border-rose-500/20 dark:border-rose-500/40 p-5 flex items-center justify-between overflow-hidden">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-rose-500 dark:text-rose-400 block">Pending Fines</span>
                <h3 class="text-2xl font-extrabold text-rose-600 dark:text-rose-400 mt-1 drop-shadow-[0_0_8px_rgba(244,63,94,0.5)]">₹{{ number_format($memberStats['pending_fines'] ?? 0, 2) }}</h3>
                <span class="text-xs text-gray-400 mt-2 block">Dues & Late Charges</span>
            </div>
            <div class="p-3 bg-rose-500/10 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl border border-rose-500/30 shadow-[0_0_12px_rgba(244,63,94,0.3)]">
                <i class="fa-solid fa-receipt text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_20px_rgba(6,182,212,0.1)] dark:shadow-[0_0_25px_rgba(6,182,212,0.2)] border border-cyan-500/20 dark:border-cyan-500/30 p-5 overflow-hidden">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
            <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-list text-cyan-500 drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]"></i> My Recent Activity
            </h3>
            @if(Route::has('books.index'))
            <a href="{{ route('member.books.index') }}" class="text-xs text-cyan-600 dark:text-cyan-400 hover:underline font-semibold">Browse Catalog &rarr;</a>
            @endif
        </div>
        <div class="overflow-x-auto mt-3">
            <table class="w-full text-left text-xs table-fixed">
                <thead>
                    <tr class="text-[10px] uppercase text-gray-400 border-b border-gray-100 dark:border-gray-800">
                        <th class="py-2 w-1/2">Book Title</th>
                        <th class="py-2 w-1/4 text-center">Issue Date</th>
                        <th class="py-2 w-1/4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800/60 text-gray-700 dark:text-gray-200">
                    @forelse($myRecentIssues ?? [] as $issue)
                    <tr class="hover:bg-cyan-500/5 transition-colors">
                        <td class="py-2.5 font-medium truncate" title="{{ data_get($issue, 'book.title', 'N/A') }}">
                            {{ data_get($issue, 'book.title', 'N/A') }}
                        </td>
                        <td class="py-2.5 text-center text-gray-500 font-mono">
                            {{ data_get($issue, 'issue_date') ? \Carbon\Carbon::parse(data_get($issue, 'issue_date'))->format('M d, Y') : '-' }}
                        </td>
                        <td class="py-2.5 text-right">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold tracking-wide uppercase border {{ data_get($issue, 'status') === 'returned' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/30 shadow-[0_0_8px_rgba(16,185,129,0.3)]' : 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/30 shadow-[0_0_8px_rgba(245,158,11,0.3)]' }}">
                                {{ ucfirst(data_get($issue, 'status', 'issued')) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-400 italic">No borrowing records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @else
    <div class="bg-white dark:bg-indigo-950/50 backdrop-blur-xl rounded-2xl p-8 md:p-12 text-gray-900 dark:text-white shadow-[0_0_40px_rgba(99,102,241,0.25)] border border-gray-200 dark:border-indigo-500/40 relative overflow-hidden transition-all duration-300">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-cyan-500/10 dark:bg-cyan-500/25 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-fuchsia-500/10 dark:bg-fuchsia-500/25 rounded-full blur-3xl pointer-events-none"></div>
        <div class="max-w-3xl relative z-10 space-y-3">
            <h3 class="text-3xl md:text-4xl font-black tracking-tight drop-shadow-[0_0_15px_rgba(59,130,246,0.3)] dark:drop-shadow-[0_0_15px_rgba(59,130,246,0.8)] text-indigo-700 dark:text-yellow-300">
                Welcome to the Library Portal
            </h3>
            <p class="text-base md:text-lg text-gray-700 dark:text-pink-200 font-medium leading-relaxed">
                Explore our public library collection.
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 dark:text-white underline decoration-blue-400/60 hover:text-indigo-800 dark:hover:text-blue-200 transition-all duration-300">Register</a>
                or
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 dark:text-white underline decoration-blue-400/60 hover:text-indigo-800 dark:hover:text-blue-200 transition-all duration-300">Log In</a>
                to borrow books.
            </p>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl border border-gray-200 dark:border-cyan-500/40 shadow-[0_0_15px_rgba(6,182,212,0.15)]">
            <span class="text-xs text-cyan-600 dark:text-cyan-400 font-bold uppercase tracking-wider">Total Books</span>
            <h4 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $publicStats['total_books'] ?? 0 }}</h4>
        </div>
        <div class="bg-white dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl border border-gray-200 dark:border-emerald-500/40 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider">TOTAL AVAILABLE COPIES</span>
            <h4 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $publicStats['available_books'] ?? 0 }}</h4>
        </div>
        <div class="bg-white dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl border border-gray-200 dark:border-fuchsia-500/40 shadow-[0_0_15px_rgba(217,70,239,0.15)]">
            <span class="text-xs text-fuchsia-600 dark:text-fuchsia-400 font-bold uppercase tracking-wider">Categories</span>
            <h4 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $publicStats['total_categories'] ?? 0 }}</h4>
        </div>
    </div>
    @endauth
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chartMonthsData = JSON.parse('{!! json_encode($chartMonths ?? ["Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]) !!}');
        const issuedDataArr = JSON.parse('{!! json_encode($issuedData ?? [0, 0, 0, 0, 0, 0]) !!}');
        const returnedDataArr = JSON.parse('{!! json_encode($returnedData ?? [0, 0, 0, 0, 0, 0]) !!}');

        const circCtx = document.getElementById('monthlyCirculationChart');
        if (circCtx) {
            new Chart(circCtx, {
                type: 'bar',
                data: {
                    labels: chartMonthsData,
                    datasets: [{
                            label: 'Issues',
                            data: issuedDataArr,
                            backgroundColor: '#06b6d4',
                            borderRadius: 6
                        },
                        {
                            label: 'Returns',
                            data: returnedDataArr,
                            backgroundColor: '#10b981',
                            borderRadius: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2]
                            }
                        }
                    }
                }
            });
        }

        const catLabelsData = JSON.parse('{!! json_encode($categoryData["labels"] ?? []) !!}');
        const catCountsData = JSON.parse('{!! json_encode($categoryData["counts"] ?? []) !!}');
        const catCtx = document.getElementById('categoryDistributionChart');

        if (catCtx) {
            const hasCatData = Array.isArray(catCountsData) && catCountsData.length > 0;

            new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: hasCatData ? catLabelsData : ['No Categories'],
                    datasets: [{
                        data: hasCatData ? catCountsData : [1],
                        backgroundColor: hasCatData ? ['#06b6d4', '#d946ef', '#10b981', '#f59e0b', '#f43f5e'] : ['#374151']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection