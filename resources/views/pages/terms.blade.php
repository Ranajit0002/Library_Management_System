@extends('layouts.app')

@section('content')
<div class="py-12 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                {{ __('Terms & Conditions') }}
            </h2>
            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                {{ __('Last updated:') }} {{ now()->format('F Y') }}
            </p>
        </div>
        <div class="relative w-full">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-25 dark:opacity-35 blur-xl transition-all duration-500 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] p-8 sm:p-10 text-gray-800 dark:text-gray-200 space-y-6 text-sm leading-relaxed">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('1. Acceptance of Terms') }}</h3>
                    <p>{{ __('By accessing and using this Library Management System, you agree to comply with and be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must refrain from using our library services.') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('2. Member Accounts & Responsibilities') }}</h3>
                    <p>{{ __('Users are responsible for maintaining the confidentiality of their login credentials and membership numbers. Any borrowing transactions or activity conducted under your account profile remain your sole responsibility.') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('3. Book Loans & Returns') }}</h3>
                    <p>{{ __('Books must be returned on or before the specified due date. Failure to return items on time may result in automatic late fee accumulation as determined by library circulation policies. Repeated overdue infractions may lead to temporary suspension of borrowing privileges.') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('4. System Modifications') }}</h3>
                    <p>{{ __('We reserve the right to modify, suspend, or discontinue any aspect of the library platform at any time without prior notice. We are not liable to you or any third party for any modification or service interruption.') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('5. Governing Law') }}</h3>
                    <p>{{ __('These terms are governed by and construed in accordance with applicable local regulations governing public and institutional library operations.') }}</p>
                </div>
                <div class="pt-6 border-t border-violet-100 dark:border-cyan-950/60 flex justify-end">
                    <a href="{{ Route::has('dashboard') ? route('dashboard') : url('/') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_15px_rgba(139,92,246,0.3)] hover:shadow-[0_0_20px_rgba(34,211,238,0.5)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                        {{ __('Back to Dashboard') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection