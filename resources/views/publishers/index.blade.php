@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        @php
            $createRoute = Route::has('publishers.create') ? route('publishers.create') : '#';
            $indexRoute = Route::has('publishers.index') ? route('publishers.index') : '#';
        @endphp

        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)] leading-tight">
                {{ __('Manage Publishers') }}
            </h2>
            <a href="{{ $createRoute }}" class="bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-400 border-0 inline-flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Add New Publisher') }}
            </a>
        </div>

        @if (session('success'))
        <div id="flash-success" class="mb-4 bg-emerald-500/10 dark:bg-emerald-950/40 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.2)] relative flex items-center justify-between backdrop-blur-md transition-opacity duration-500" role="alert">
            <span class="block sm:inline font-semibold text-sm drop-shadow-[0_0_5px_rgba(16,185,129,0.4)]">{{ session('success') }}</span>
            <button type="button" onclick="document.getElementById('flash-success')?.remove();" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-200 font-bold px-2 text-lg focus:outline-none">&times;</button>
        </div>
        @endif

        @if (session('error'))
        <div id="flash-error" class="mb-4 bg-rose-500/10 dark:bg-rose-950/40 border border-rose-500/30 text-rose-700 dark:text-rose-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(244,63,94,0.2)] relative flex items-center justify-between backdrop-blur-md transition-opacity duration-500" role="alert">
            <span class="block sm:inline font-semibold text-sm drop-shadow-[0_0_5px_rgba(244,63,94,0.4)]">{{ session('error') }}</span>
            <button type="button" onclick="document.getElementById('flash-error')?.remove();" class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-200 font-bold px-2 text-lg focus:outline-none">&times;</button>
        </div>
        @endif

        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-4 rounded-2xl shadow-lg dark:shadow-[0_0_20px_rgba(6,182,212,0.1)] border border-gray-200/80 dark:border-cyan-500/30 mb-6 transition-all duration-300">
            <form method="GET" action="{{ $indexRoute }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by publisher name, email, phone, or website...') }}" class="w-full text-sm bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 placeholder-gray-400 dark:placeholder-gray-500">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="bg-gradient-to-r from-cyan-600 to-indigo-600 hover:from-cyan-500 hover:to-indigo-500 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.5)]">
                        {{ __('Search') }}
                    </button>
                    @if(request('search'))
                    <a href="{{ $indexRoute }}" class="bg-transparent border border-gray-300 dark:border-fuchsia-500/40 text-gray-700 dark:text-fuchsia-300 text-sm font-semibold px-4 py-2.5 rounded-xl hover:bg-fuchsia-50 dark:hover:bg-fuchsia-950/40 hover:border-fuchsia-400 hover:text-fuchsia-600 dark:hover:text-fuchsia-200 hover:shadow-[0_0_15px_rgba(217,70,239,0.3)] transition-all duration-300">
                        {{ __('Reset') }}
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl overflow-hidden shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30">
            <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-cyan-500/20 text-left">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-950/50 text-xs font-bold text-gray-600 dark:text-cyan-300 uppercase tracking-wider">
                            <th class="px-6 py-3.5">{{ __('Name') }}</th>
                            <th class="px-6 py-3.5">{{ __('Email') }}</th>
                            <th class="px-6 py-3.5">{{ __('Phone') }}</th>
                            <th class="px-6 py-3.5">{{ __('Status') }}</th>
                            <th class="px-6 py-3.5 text-right">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-200 dark:divide-cyan-500/10 text-sm">
                        @forelse ($publishers ?? [] as $publisher)
                        @php
                            $pubId = data_get($publisher, 'id');
                            $pubName = data_get($publisher, 'name', 'N/A');
                            $pubEmail = data_get($publisher, 'email', 'N/A');
                            $pubPhone = data_get($publisher, 'phone', 'N/A');
                            $pubStatus = data_get($publisher, 'status', 'active');
                            $editRoute = Route::has('publishers.edit') ? route('publishers.edit', $pubId) : '#';
                            $destroyRoute = Route::has('publishers.destroy') ? route('publishers.destroy', $pubId) : '#';
                            $confirmMsg = addslashes(__('Are you sure you want to delete this publisher?'));
                        @endphp
                        <tr class="hover:bg-cyan-500/5 dark:hover:bg-cyan-950/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-cyan-100">{{ $pubName }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300/80">{{ $pubEmail }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300/80">{{ $pubPhone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-extrabold rounded-full border {{ $pubStatus == 'active' ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-600 dark:text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.3)]' : 'bg-rose-500/10 border-rose-500/30 text-rose-600 dark:text-rose-400 shadow-[0_0_10px_rgba(244,63,94,0.3)]' }}">
                                    {{ ucfirst($pubStatus) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-semibold space-x-3">
                                <a href="{{ $editRoute }}" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-400 dark:hover:text-cyan-300 hover:drop-shadow-[0_0_8px_rgba(6,182,212,0.8)] transition-all duration-200 inline-flex items-center">{{ __('Edit') }}</a>
                                <form action="{{ $destroyRoute }}" method="POST" class="inline" onsubmit="return confirm('{{ $confirmMsg }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 dark:text-rose-400 hover:text-rose-400 dark:hover:text-rose-300 hover:drop-shadow-[0_0_8px_rgba(244,63,94,0.8)] font-semibold transition-all duration-200">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-cyan-300/60 font-medium">
                                {{ __('No publishers found. Click "Add New Publisher" to create one.') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if(isset($publishers) && method_exists($publishers, 'hasPages') && $publishers->hasPages())
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-cyan-500/20">
                    {{ $publishers->withQueryString()->links() }}
                </div>
                @endif
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