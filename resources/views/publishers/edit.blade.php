@extends('layouts.app')

@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        @php
            $pubId = data_get($publisher, 'id');
            $updateRoute = Route::has('publishers.update') && $pubId ? route('publishers.update', $pubId) : '#';
            $indexRoute = Route::has('publishers.index') ? route('publishers.index') : '#';
        @endphp

        <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)] leading-tight mb-6">
            {{ __('Edit Publisher') }}
        </h2>

        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl overflow-hidden shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 p-6 md:p-8 transition-all duration-300">
            <form action="{{ $updateRoute }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('Publisher Name') }} *</label>
                        <input type="text" name="name" value="{{ old('name', data_get($publisher, 'name')) }}" class="block w-full px-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" required>
                        @error('name') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('Email') }}</label>
                        <input type="email" name="email" value="{{ old('email', data_get($publisher, 'email')) }}" class="block w-full px-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                        @error('email') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('Phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone', data_get($publisher, 'phone')) }}" class="block w-full px-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                        @error('phone') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('Website URL') }}</label>
                        <input type="url" name="website" value="{{ old('website', data_get($publisher, 'website')) }}" placeholder="https://example.com" class="block w-full px-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 placeholder-gray-400 dark:placeholder-gray-500">
                        @error('website') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('Status') }} *</label>
                        <select name="status" class="block w-full px-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" required>
                            <option value="active" {{ old('status', data_get($publisher, 'status', 'active')) == 'active' ? 'selected' : '' }} class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status', data_get($publisher, 'status')) == 'inactive' ? 'selected' : '' }} class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Inactive') }}</option>
                        </select>
                        @error('status') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-cyan-300 uppercase tracking-wider mb-1">{{ __('Address') }}</label>
                        <textarea name="address" rows="4" class="block w-full px-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">{{ old('address', data_get($publisher, 'address')) }}</textarea>
                        @error('address') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs font-semibold mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end items-center space-x-3">
                    <a href="{{ $indexRoute }}" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-fuchsia-500/40 text-gray-700 dark:text-fuchsia-300 text-sm font-semibold hover:bg-fuchsia-50 dark:hover:bg-fuchsia-950/40 hover:border-fuchsia-400 hover:text-fuchsia-600 dark:hover:text-fuchsia-200 hover:shadow-[0_0_15px_rgba(217,70,239,0.3)] transition-all duration-300">{{ __('Cancel') }}</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 text-white text-sm font-bold shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-400">{{ __('Update Publisher') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection