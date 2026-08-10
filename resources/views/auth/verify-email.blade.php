<x-guest-layout>
    <div class="relative w-full max-w-md mx-auto my-6">
        <!-- Ambient Neon Glow Backdrop -->
        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-30 dark:opacity-50 blur-xl transition-all duration-500 group-hover:opacity-100 pointer-events-none"></div>

        <div class="relative w-full min-h-[520px] flex flex-col justify-between p-7 bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] transition-all duration-300">

            <div>
                <!-- Header / Title -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-violet-100/80 dark:bg-gray-900 border border-violet-400/30 dark:border-cyan-400/30 rounded-2xl flex items-center justify-center mx-auto mb-3 text-violet-600 dark:text-cyan-400 text-xl shadow-[0_0_15px_rgba(139,92,246,0.3)] dark:shadow-[0_0_15px_rgba(34,211,238,0.3)]">
                        <i class="fa-solid fa-envelope-circle-check text-violet-600 dark:text-cyan-400 drop-shadow-[0_0_6px_rgba(34,211,238,0.5)]"></i>
                    </div>
                    <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                        Verify Your Email
                    </h2>
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mt-1">
                        Account activation required
                    </p>
                </div>

                <!-- Info Message -->
                <div class="mb-6 text-xs leading-relaxed text-gray-600 dark:text-gray-300 bg-white/50 dark:bg-gray-900/60 p-4 rounded-xl border border-violet-200/80 dark:border-cyan-900/50 shadow-inner">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                <!-- Status Alert -->
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 font-medium text-xs text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 dark:bg-emerald-950/40 p-3.5 rounded-xl border border-emerald-500/30 dark:border-emerald-500/40 shadow-[0_0_15px_rgba(16,185,129,0.15)] flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]"></i>
                        <span>{{ __('A new verification link has been sent to the email address you provided during registration.') }}</span>
                    </div>
                @endif

                <!-- Actions -->
                <div class="space-y-4 pt-2">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <x-primary-button class="relative w-full justify-center py-2.5 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] dark:hover:shadow-[0_0_25px_rgba(139,92,246,0.7)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                            <i class="fa-solid fa-paper-plane mr-2 text-xs"></i> {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </form>

                    <div class="flex items-center justify-center pt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-violet-600 dark:hover:text-cyan-400 transition-colors flex items-center gap-1.5 focus:outline-none">
                                <i class="fa-solid fa-right-from-bracket text-[10px]"></i> {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>