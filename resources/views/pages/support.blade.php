@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between py-6">
    <h2 class="font-semibold text-2xl text-indigo-600 dark:text-cyan-400 leading-tight">
        <i class="fa-solid fa-headset mr-2"></i> {{ __('Support Center') }}
    </h2>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Support Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-fuchsia-600 dark:from-cyan-950 dark:via-gray-900 dark:to-fuchsia-950 p-8 sm:p-12 shadow-xl dark:shadow-[0_0_30px_rgba(6,182,212,0.2)] border border-transparent dark:border-cyan-500/30 text-white">
        <div class="relative z-10 max-w-2xl">
            <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-widest bg-white/20 dark:bg-cyan-500/20 text-white dark:text-cyan-300 backdrop-blur-md">{{ __('Help & Resources') }}</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-4 mb-3">{{ __('How can we help you today?') }}</h1>
            <p class="text-indigo-100 dark:text-gray-300 text-sm sm:text-base leading-relaxed">{{ __('Browse our FAQs for immediate answers, submit a ticket for administrative assistance, or review our library policies.') }}</p>
        </div>
        <div class="absolute right-[-10%] bottom-[-20%] opacity-10 dark:opacity-20 pointer-events-none">
            <i class="fa-solid fa-life-ring text-[250px] text-white dark:text-cyan-400"></i>
        </div>
    </div>

    <!-- Support Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: FAQs -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-cyan-500/30 shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.1)] hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-cyan-950/60 text-indigo-600 dark:text-cyan-400 flex items-center justify-center text-xl mb-4 border border-indigo-100 dark:border-cyan-500/30">
                <i class="fa-solid fa-circle-question"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">{{ __('Frequently Asked Questions') }}</h3>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">{{ __('Find instant answers to common questions about book renewals, maximum borrow limits, and profile settings.') }}</p>
            <a href="#faq-section" class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-cyan-400 hover:underline flex items-center gap-1">
                {{ __('Browse FAQs') }} <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- Card 2: Contact Admin -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-cyan-500/30 shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.1)] hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-fuchsia-50 dark:bg-fuchsia-950/60 text-fuchsia-600 dark:text-fuchsia-400 flex items-center justify-center text-xl mb-4 border border-fuchsia-100 dark:border-fuchsia-500/30">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">{{ __('Submit a Ticket') }}</h3>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">{{ __('Encountering a bug or missing a book in our inventory? Send a direct support message to our administrators.') }}</p>
            <a href="#support-form" class="text-xs font-bold uppercase tracking-wider text-fuchsia-600 dark:text-fuchsia-400 hover:underline flex items-center gap-1">
                {{ __('Open Ticket') }} <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- Card 3: Library Guidelines -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-cyan-500/30 shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.1)] hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl mb-4 border border-emerald-100 dark:border-emerald-500/30">
                <i class="fa-solid fa-book-tanakh"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">{{ __('Library Guidelines') }}</h3>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">{{ __('Review our policies regarding book handling, return periods, late fees, and membership conduct.') }}</p>
            <a href="{{ Route::has('terms') ? route('terms') : '#' }}" class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                {{ __('View Terms') }} <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>

    <!-- Contact Form & FAQs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" id="faq-section">
        <!-- FAQs Accordion (2 cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-2xl p-6 sm:p-8 border border-gray-200 dark:border-cyan-500/30 shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.1)] space-y-6">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="fa-solid fa-clipboard-question text-indigo-500 dark:text-cyan-400"></i> {{ __('Frequently Asked Questions') }}
            </h3>
            <div class="space-y-4" x-data="{ selected: null }">
                <!-- FAQ 1 -->
                <div class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden">
                    <button @click="selected !== 1 ? selected = 1 : selected = null" class="w-full flex justify-between items-center p-4 text-left font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-200 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <span>{{ __('How many books can I borrow at the same time?') }}</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': selected === 1 }"></i>
                    </button>
                    <div x-show="selected === 1" class="p-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-900 leading-relaxed" style="display: none;">
                        {{ __('Standard members are allowed to borrow up to 3 books concurrently for a standard duration of 14 days per book. Extensions can be requested through your Borrowings page if no other members have placed a reservation.') }}
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden">
                    <button @click="selected !== 2 ? selected = 2 : selected = null" class="w-full flex justify-between items-center p-4 text-left font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-200 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <span>{{ __('What happens if I return a book past its due date?') }}</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': selected === 2 }"></i>
                    </button>
                    <div x-show="selected === 2" class="p-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-900 leading-relaxed" style="display: none;">
                        {{ __('Overdue books may incur a small daily penalty fee as outlined in our system rules. Consistently late returns may temporarily restrict your online borrowing privileges until resolved with an administrator.') }}
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden">
                    <button @click="selected !== 3 ? selected = 3 : selected = null" class="w-full flex justify-between items-center p-4 text-left font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-200 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <span>{{ __('How do I reset my account password?') }}</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': selected === 3 }"></i>
                    </button>
                    <div x-show="selected === 3" class="p-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-900 leading-relaxed" style="display: none;">
                        {{ __('You can update your password directly from your Profile Settings page if you are currently logged in. If you are logged out, click the "Forgot Password" link on the login screen to receive a secure recovery token via email.') }}
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden">
                    <button @click="selected !== 4 ? selected = 4 : selected = null" class="w-full flex justify-between items-center p-4 text-left font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-200 bg-gray-50/50 dark:bg-gray-800/40 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <span>{{ __('Can I suggest a new book to add to the library catalog?') }}</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': selected === 4 }"></i>
                    </button>
                    <div x-show="selected === 4" class="p-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-900 leading-relaxed" style="display: none;">
                        {{ __('Yes! Use the support ticket form on this page to submit title and author suggestions. Our administrative team reviews new acquisitions weekly based on student and faculty demand.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Ticket Form (1 col) -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 sm:p-8 border border-gray-200 dark:border-cyan-500/30 shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.1)]" id="support-form">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-paper-plane text-fuchsia-500"></i> {{ __('Send a Message') }}
            </h3>
            @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-semibold">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ Route::has('support.store') ? route('support.store') : '#' }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-1">{{ __('Your Name') }}</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-cyan-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-cyan-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-1">{{ __('Email Address') }}</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-cyan-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-cyan-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-1">{{ __('Subject / Inquiry Type') }}</label>
                    <select name="subject" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-cyan-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-cyan-400 text-sm">
                        <option value="borrowing">{{ __('Borrowing & Return Issue') }}</option>
                        <option value="account">{{ __('Account & Login Problem') }}</option>
                        <option value="catalog">{{ __('Book Acquisition Request') }}</option>
                        <option value="other">{{ __('General Support Question') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-1">{{ __('Message') }}</label>
                    <textarea name="message" rows="4" required placeholder="{{ __('Describe your issue or request in detail...') }}" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-cyan-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-cyan-400 text-sm"></textarea>
                </div>
                <button type="submit" class="w-full py-3 px-4 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-indigo-600 to-fuchsia-600 dark:from-cyan-500 dark:to-fuchsia-600 hover:opacity-95 shadow-md dark:shadow-[0_0_15px_rgba(6,182,212,0.5)] transition-all cursor-pointer">
                    {{ __('Submit Support Ticket') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection