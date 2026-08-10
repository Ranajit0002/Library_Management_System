@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                {{ __('Manage Authors') }}
            </h2>
            <a href="{{ Route::has('authors.create') ? route('authors.create') : '#' }}" class="relative inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] dark:hover:shadow-[0_0_25px_rgba(139,92,246,0.7)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                <svg class="w-4 h-4 mr-2 drop-shadow-[0_0_4px_rgba(255,255,255,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Add New Author') }}
            </a>
        </div>
        @if (session('success'))
        <div id="flash-success" class="mb-6 bg-emerald-500/10 dark:bg-emerald-950/30 border border-emerald-500/40 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.2)] relative flex items-center justify-between transition-opacity duration-500 backdrop-blur-md" role="alert">
            <span class="block sm:inline font-medium text-sm drop-shadow-[0_0_5px_rgba(16,185,129,0.3)]">{{ session('success') }}</span>
            <button type="button" onclick="document.getElementById('flash-success').remove();" class="text-emerald-500 hover:text-emerald-400 font-bold px-2 text-lg focus:outline-none transition-colors">&times;</button>
        </div>
        @endif
        @if (session('error'))
        <div id="flash-error" class="mb-6 bg-rose-500/10 dark:bg-rose-950/30 border border-rose-500/40 text-rose-700 dark:text-rose-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(244,63,94,0.2)] relative flex items-center justify-between transition-opacity duration-500 backdrop-blur-md" role="alert">
            <span class="block sm:inline font-medium text-sm drop-shadow-[0_0_5px_rgba(244,63,94,0.3)]">{{ session('error') }}</span>
            <button type="button" onclick="document.getElementById('flash-error').remove();" class="text-rose-500 hover:text-rose-400 font-bold px-2 text-lg focus:outline-none transition-colors">&times;</button>
        </div>
        @endif
        <div class="relative mb-6">
            <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-r from-violet-600/30 via-fuchsia-600/20 to-cyan-500/30 blur-md opacity-50 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl p-4 rounded-2xl border border-violet-500/20 dark:border-cyan-500/30 shadow-[0_0_20px_rgba(139,92,246,0.1)] dark:shadow-[0_0_25px_rgba(6,182,212,0.1)] transition-all duration-300">
                <form method="GET" action="{{ Route::has('authors.index') ? route('authors.index') : '#' }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by author name or email..." class="w-full pl-4 pr-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300">
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-fuchsia-600 to-violet-600 hover:from-fuchsia-500 hover:to-violet-500 rounded-xl shadow-[0_0_15px_rgba(217,70,239,0.3)] hover:shadow-[0_0_20px_rgba(217,70,239,0.5)] border border-fuchsia-300/30 transition-all duration-300 active:scale-[0.98]">
                            {{ __('Search') }}
                        </button>
                        @if(request('search'))
                        <a href="{{ Route::has('authors.index') ? route('authors.index') : '#' }}" class="px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl shadow-[0_0_10px_rgba(255,255,255,0.1)] transition-all duration-300">
                            {{ __('Reset') }}
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="relative">
            <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-r from-violet-600/20 via-fuchsia-600/20 to-cyan-500/20 blur-md opacity-40 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl overflow-hidden shadow-[0_0_25px_rgba(139,92,246,0.1)] dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-violet-500/20 dark:border-cyan-500/30 transition-all duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full divide-y divide-violet-200/40 dark:divide-cyan-900/40 text-left">
                        <thead>
                            <tr class="bg-violet-50/50 dark:bg-gray-900/60 text-xs font-bold text-violet-700 dark:text-cyan-400 uppercase tracking-wider">
                                <th class="px-6 py-4">{{ __('Photo') }}</th>
                                <th class="px-6 py-4">{{ __('Name') }}</th>
                                <th class="px-6 py-4">{{ __('Email') }}</th>
                                <th class="px-6 py-4">{{ __('Phone') }}</th>
                                <th class="px-6 py-4">{{ __('Status') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-violet-100/60 dark:divide-gray-900/80 text-sm">
                            @forelse ($authors ?? [] as $author)
                            <tr class="hover:bg-violet-50/30 dark:hover:bg-cyan-950/20 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(!empty(data_get($author, 'photo')))
                                    <img src="{{ asset('storage/' . data_get($author, 'photo')) }}" alt="{{ data_get($author, 'name') }}" class="w-10 h-10 rounded-full object-cover border border-cyan-400/50 shadow-[0_0_10px_rgba(34,211,238,0.3)]">
                                    @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-violet-600 to-cyan-500 text-white font-black flex items-center justify-center text-xs border border-cyan-300/40 shadow-[0_0_10px_rgba(34,211,238,0.4)]">
                                        {{ strtoupper(substr(data_get($author, 'name', 'AU'), 0, 2)) }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-gray-100">{{ data_get($author, 'name') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ data_get($author, 'email', 'N/A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ data_get($author, 'phone', 'N/A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ data_get($author, 'status', 'active') == 'active' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/30 shadow-[0_0_10px_rgba(16,185,129,0.25)]' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/30 shadow-[0_0_10px_rgba(244,63,94,0.25)]' }}">
                                        {{ ucfirst(data_get($author, 'status', 'active')) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-medium space-x-3">
                                    @if(Route::has('authors.edit'))
                                    <a href="{{ route('authors.edit', data_get($author, 'id')) }}" class="text-cyan-600 dark:text-cyan-400 hover:text-fuchsia-500 dark:hover:text-fuchsia-400 font-bold drop-shadow-[0_0_5px_rgba(34,211,238,0.3)] transition-colors inline-flex items-center" title="Edit">
                                        {{ __('Edit') }}
                                    </a>
                                    @endif
                                    @if(Route::has('authors.destroy'))
                                    <form action="{{ route('authors.destroy', data_get($author, 'id')) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 dark:hover:text-rose-300 font-bold drop-shadow-[0_0_5px_rgba(244,63,94,0.3)] transition-colors" onclick="return confirm('Are you sure you want to delete this author?')">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('No authors found. Click "Add New Author" to create one.') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if(isset($authors) && method_exists($authors, 'hasPages') && $authors->hasPages())
                    <div class="mt-6">
                        {{ $authors->withQueryString()->links() }}
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