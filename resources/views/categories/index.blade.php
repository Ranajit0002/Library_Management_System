@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h2 class="font-black text-2xl bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight leading-tight flex items-center gap-2">
                <i class="fa-solid fa-folder-tree text-violet-600 dark:text-cyan-400 drop-shadow-[0_0_10px_rgba(34,211,238,0.5)]"></i> {{ __('Manage Categories') }}
            </h2>
            <a href="{{ Route::has('categories.create') ? route('categories.create') : '#' }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 rounded-xl shadow-[0_0_20px_rgba(168,85,247,0.5)] dark:shadow-[0_0_20px_rgba(34,211,238,0.4)] hover:shadow-[0_0_25px_rgba(34,211,238,0.7)] border border-fuchsia-300/30 dark:border-cyan-300/30 transition-all duration-300 flex items-center gap-1.5 w-fit transform active:scale-[0.99]">
                <i class="fa-solid fa-plus"></i> Add New Category
            </a>
        </div>
        @if (session('success'))
        <div id="flash-success" class="mb-4 bg-emerald-500/10 dark:bg-emerald-950/40 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.2)] relative flex items-center justify-between transition-opacity duration-500 backdrop-blur-md" role="alert">
            <span class="sm:inline font-medium text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 drop-shadow-[0_0_8px_rgba(16,185,129,0.5)]"></i> {{ session('success') }}
            </span>
        </div>
        @endif
        @if (session('error'))
        <div id="flash-error" class="mb-4 bg-rose-500/10 dark:bg-rose-950/40 border border-rose-500/30 text-rose-700 dark:text-rose-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(244,63,94,0.2)] relative flex items-center justify-between transition-opacity duration-500 backdrop-blur-md" role="alert">
            <span class="sm:inline font-medium text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark text-rose-600 dark:text-rose-400 drop-shadow-[0_0_8px_rgba(244,63,94,0.5)]"></i> {{ session('error') }}
            </span>
        </div>
        @endif
        <div class="relative w-full">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600/20 via-fuchsia-600/20 to-cyan-500/20 blur-xl pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl overflow-hidden shadow-[0_0_25px_rgba(139,92,246,0.12)] dark:shadow-[0_0_35px_rgba(6,182,212,0.12)] rounded-2xl border border-violet-500/20 dark:border-cyan-500/30 transition-all duration-300">
                <div class="p-4 md:p-6 border-b border-violet-100 dark:border-gray-800/80 bg-violet-50/30 dark:bg-gray-900/40 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <form method="GET" action="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" class="w-full sm:w-1/2 md:w-1/3 flex gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." class="w-full pl-3 pr-3 py-2 text-xs bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition-all duration-200">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-[0_0_15px_rgba(168,85,247,0.4)] dark:shadow-[0_0_15px_rgba(34,211,238,0.3)] transition-all duration-300 flex items-center gap-1.5 transform active:scale-[0.98]">
                            <i class="fa-solid fa-magnifying-glass"></i> Search
                        </button>
                    </form>
                    @if(request('search'))
                    <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" class="text-xs font-bold uppercase tracking-wider text-violet-600 dark:text-cyan-400 hover:text-fuchsia-600 dark:hover:text-cyan-300 transition-colors flex items-center gap-1">
                        <i class="fa-solid fa-rotate-right"></i> Clear Filter
                    </a>
                    @endif
                </div>
                <div class="p-4 md:p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-100 dark:divide-gray-800/80 text-left text-xs">
                        <thead>
                            <tr class="bg-violet-50/50 dark:bg-gray-900/90 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-violet-100 dark:border-gray-800">
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Description</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-violet-100/60 dark:divide-gray-800/60">
                            @forelse ($categories ?? [] as $category)
                            <tr class="hover:bg-violet-50/40 dark:hover:bg-cyan-950/20 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-900 dark:text-gray-100">{{ data_get($category, 'name') }}</td>
                                <td class="px-6 py-4 text-xs text-gray-600 dark:text-gray-400">{{ Str::limit(data_get($category, 'description'), 50) ?: 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs">
                                    <span class="px-2.5 py-1 inline-flex text-[11px] leading-4 font-bold rounded-lg border {{ data_get($category, 'status') == 'active' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/30 shadow-[0_0_10px_rgba(52,211,153,0.15)]' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/30 shadow-[0_0_10px_rgba(244,63,94,0.15)]' }}">
                                        {{ ucfirst(data_get($category, 'status', 'inactive')) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-2">
                                    @if(Route::has('categories.edit'))
                                    <a href="{{ route('categories.edit', data_get($category, 'id')) }}" class="inline-flex items-center gap-1 text-violet-600 dark:text-fuchsia-400 hover:text-fuchsia-600 dark:hover:text-fuchsia-300 font-bold hover:scale-105 transition-all duration-200">
                                        <i class="fa-solid fa-pen-to-square drop-shadow-[0_0_6px_rgba(217,70,239,0.4)]"></i> Edit
                                    </a>
                                    @endif
                                    @if(Route::has('categories.destroy'))
                                    <form action="{{ route('categories.destroy', data_get($category, 'id')) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 text-rose-500 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 font-bold hover:scale-105 transition-all duration-200">
                                            <i class="fa-solid fa-trash-can drop-shadow-[0_0_6px_rgba(244,63,94,0.4)]"></i> Delete
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-xs text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fa-solid fa-folder-open text-3xl bg-gradient-to-r from-violet-500 to-cyan-400 bg-clip-text text-transparent opacity-60"></i>
                                        <p class="font-medium">No categories found.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if(isset($categories) && method_exists($categories, 'hasPages') && $categories->hasPages())
                    <div class="mt-4 pt-4 border-t border-violet-100 dark:border-gray-800">
                        {{ $categories->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection