@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
        <h2 class="font-black text-2xl bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent leading-tight mb-6 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-violet-600 dark:text-cyan-400 drop-shadow-[0_0_10px_rgba(34,211,238,0.5)]"></i> {{ __('Edit Category') }}
        </h2>
        <div class="relative w-full">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600/20 via-fuchsia-600/20 to-cyan-500/20 blur-xl pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl overflow-hidden shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] rounded-2xl border border-violet-500/20 dark:border-cyan-500/30 p-6 md:p-8 transition-colors duration-300">
                <form action="{{ Route::has('categories.update') ? route('categories.update', data_get($category, 'id')) : '#' }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">{{ __('Category Name *') }}</label>
                            <input type="text" name="name" value="{{ old('name', data_get($category, 'name')) }}" class="mt-1 block w-full rounded-xl border border-violet-200 dark:border-gray-800 bg-gray-50/80 dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400 transition-all duration-200" required>
                            @error('name') <span class="text-rose-600 dark:text-rose-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_6px_rgba(244,63,94,0.4)]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">{{ __('Description') }}</label>
                            <textarea name="description" rows="4" class="mt-1 block w-full rounded-xl border border-violet-200 dark:border-gray-800 bg-gray-50/80 dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400 transition-all duration-200">{{ old('description', data_get($category, 'description')) }}</textarea>
                            @error('description') <span class="text-rose-600 dark:text-rose-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_6px_rgba(244,63,94,0.4)]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">{{ __('Status *') }}</label>
                            <select name="status" class="mt-1 block w-full rounded-xl border border-violet-200 dark:border-gray-800 bg-gray-50/80 dark:bg-gray-900/80 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400 transition-all duration-200" required>
                                <option value="active" {{ old('status', data_get($category, 'status')) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ old('status', data_get($category, 'status')) == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                            @error('status') <span class="text-rose-600 dark:text-rose-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_6px_rgba(244,63,94,0.4)]">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-8 flex items-center justify-end gap-3 pt-4 border-t border-violet-100 dark:border-gray-800">
                        <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl shadow-[0_0_10px_rgba(255,255,255,0.05)] hover:shadow-[0_0_15px_rgba(168,85,247,0.4)] transition-all duration-300">{{ __('Cancel') }}</a>
                        <button type="submit" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 rounded-xl shadow-[0_0_20px_rgba(168,85,247,0.5)] dark:shadow-[0_0_20px_rgba(34,211,238,0.4)] hover:shadow-[0_0_25px_rgba(34,211,238,0.7)] border border-fuchsia-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">{{ __('Update Category') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection