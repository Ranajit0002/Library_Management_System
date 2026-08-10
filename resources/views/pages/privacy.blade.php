@extends('layouts.app')

@section('content')
<div class="py-12 w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                {{ __('Privacy Policy') }}
            </h2>
            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                {{ __('Last updated:') }} {{ now()->format('F Y') }}
            </p>
        </div>
        <div class="relative w-full">
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-25 dark:opacity-35 blur-xl transition-all duration-500 pointer-events-none"></div>
            <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] p-8 sm:p-10 text-gray-800 dark:text-gray-200 space-y-6 text-sm leading-relaxed">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('1. Information We Collect') }}</h3>
                    <p>{{ __('Welcome to our Library Management System. We collect personal information that you provide during account registration, including your full name, email address, membership identifier, phone number, and physical mailing address.') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('2. How We Use Your Information') }}</h3>
                    <p>{{ __('Your data is processed strictly for library administration purposes. This includes managing book loans, processing automated due date notifications, calculating late circulation fines, and maintaining secure member profiles across our inventory catalog.') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('3. Data Security & Protection') }}</h3>
                    <p>{{ __('We deploy strict security measures, including database transaction locking, password hashing, and active session enforcement, to safeguard your personal profile details and borrowing history against unauthorized access.') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('4. Cookies and Session Storage') }}</h3>
                    <p>{{ __('Our application uses core session cookies exclusively to maintain your authenticated login state and remember your theme layout (dark/light mode) preferences. No intrusive third-party tracking or advertising scripts are used.') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-cyan-400 mb-2">{{ __('5. Contact Information') }}</h3>
                    <p>{{ __('If you have any questions or require clarification concerning this Privacy Policy, please feel free to reach out to our system administration team through the support portal.') }}</p>
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