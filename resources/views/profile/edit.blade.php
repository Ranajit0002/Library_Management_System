@extends('layouts.app')
@section('header')
<div class="flex items-center justify-center">
    <h2 class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)] leading-tight flex items-center gap-2">
        <i class="fa-solid fa-user-gear text-cyan-500 dark:text-cyan-400 drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]"></i> {{ __('Profile Settings') }}
    </h2>
</div>
@endsection
@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    @if (session('status') === 'profile-updated')
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="p-4 bg-emerald-500/10 dark:bg-emerald-950/40 border border-emerald-500/40 text-emerald-700 dark:text-emerald-300 rounded-2xl flex items-center gap-3 shadow-[0_0_20px_rgba(16,185,129,0.25)] backdrop-blur-xl transition-all duration-300">
        <i class="fa-solid fa-circle-check text-lg text-emerald-500 dark:text-emerald-400 drop-shadow-[0_0_8px_rgba(16,185,129,0.6)]"></i>
        <span class="text-sm font-semibold">{{ __('Profile information and avatar updated successfully.') }}</span>
    </div>
    @endif
    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 overflow-hidden transition-all duration-300">
        <div class="p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 overflow-hidden transition-all duration-300">
        <div class="p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>
    </div>
    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.15)] rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 overflow-hidden transition-all duration-300">
        <div class="p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection