@extends('layouts.app')
@section('content')
<div class="py-6 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        @php
            $memberId = data_get($member, 'id');
            $updateRoute = Route::has('members.update') && $memberId ? route('members.update', $memberId) : '#';
            $indexRoute = Route::has('members.index') ? route('members.index') : '#';
        @endphp
        <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide mb-6 drop-shadow-[0_0_10px_rgba(6,182,212,0.3)]">
            {{ __('Edit Member Details') }}
        </h2>
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl overflow-hidden shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 p-6 md:p-8 transition-all duration-300">
            <form action="{{ $updateRoute }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-cyan-300">{{ __('Full Name') }} *</label>
                        <input type="text" name="name" value="{{ old('name', data_get($member, 'user.name')) }}" class="mt-1.5 block w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" required>
                        @error('name') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-cyan-300">{{ __('Email Address') }} *</label>
                        <input type="email" name="email" value="{{ old('email', data_get($member, 'user.email')) }}" class="mt-1.5 block w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" required>
                        @error('email') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-cyan-300">{{ __('Membership Number') }} *</label>
                        <input type="text" name="membership_no" value="{{ old('membership_no', data_get($member, 'membership_no')) }}" class="mt-1.5 block w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-cyan-300 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] font-mono transition-all duration-300" required>
                        @error('membership_no') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-cyan-300">{{ __('Joining Date') }} *</label>
                        <input type="date" name="joining_date" value="{{ old('joining_date', data_get($member, 'joining_date')) }}" class="mt-1.5 block w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" required>
                        @error('joining_date') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-cyan-300">{{ __('Phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone', data_get($member, 'phone')) }}" class="mt-1.5 block w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">
                        @error('phone') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-cyan-300">{{ __('Status') }} *</label>
                        <select name="status" class="mt-1.5 block w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" required>
                            <option value="active" {{ old('status', data_get($member, 'status', 'active')) == 'active' ? 'selected' : '' }} class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status', data_get($member, 'status')) == 'inactive' ? 'selected' : '' }} class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ __('Inactive') }}</option>
                        </select>
                        @error('status') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-cyan-300">{{ __('Address') }}</label>
                        <textarea name="address" rows="3" class="mt-1.5 block w-full rounded-xl border-gray-300 dark:border-cyan-500/30 bg-gray-50/50 dark:bg-gray-950/60 text-gray-900 dark:text-gray-100 shadow-sm text-sm focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/50 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300">{{ old('address', data_get($member, 'address')) }}</textarea>
                        @error('address') 
                            <span class="text-fuchsia-500 dark:text-fuchsia-400 text-xs mt-1 block drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>
                <div class="mt-8 flex justify-end items-center gap-4 border-t border-gray-200/80 dark:border-cyan-500/20 pt-6">
                    <a href="{{ $indexRoute }}" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-fuchsia-500/40 text-gray-700 dark:text-fuchsia-300 text-sm font-semibold hover:bg-fuchsia-50 dark:hover:bg-fuchsia-950/40 hover:border-fuchsia-400 hover:text-fuchsia-600 dark:hover:text-fuchsia-200 hover:shadow-[0_0_15px_rgba(217,70,239,0.4)] transition-all duration-300">{{ __('Cancel') }}</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 text-white text-sm font-bold shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-400">{{ __('Update Member') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection