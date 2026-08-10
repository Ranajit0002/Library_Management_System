@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight mb-6">
            {{ __('Add New Author') }}
        </h2>
        <div class="relative w-full">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-20 dark:opacity-40 blur-xl transition-all duration-500 group-hover:opacity-100 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] p-6 md:p-8 transition-all duration-300">
                <form action="{{ Route::has('authors.store') ? route('authors.store') : '#' }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Author Name *') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300" required>
                            @error('name') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Email') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300">
                            @error('email') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Phone') }}</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300">
                            @error('phone') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Status *') }}</label>
                            <select name="status" class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }} class="dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Active') }}</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }} class="dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Inactive') }}</option>
                            </select>
                            @error('status') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Author Photo') }}</label>
                            <input type="file" name="photo" accept="image/*" class="mt-1 block w-full px-4 py-2 text-sm text-gray-900 dark:text-gray-100 border border-violet-200 dark:border-cyan-900/60 rounded-xl bg-white/50 dark:bg-gray-900/60 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:uppercase file:bg-violet-600 file:text-white hover:file:bg-violet-500 transition-all duration-300">
                            @error('photo') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">{{ __('Biography') }}</label>
                            <textarea name="biography" rows="4" class="mt-1 block w-full px-4 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300">{{ old('biography') }}</textarea>
                            @error('biography') <span class="text-rose-500 dark:text-rose-400 text-xs font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-3 items-center">
                        <a href="{{ Route::has('authors.index') ? route('authors.index') : '#' }}" class="px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl shadow-[0_0_10px_rgba(255,255,255,0.05)] transition-all duration-300">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] dark:hover:shadow-[0_0_25px_rgba(139,92,246,0.7)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                            {{ __('Save Author') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection