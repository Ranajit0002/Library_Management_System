<x-guest-layout>
    <div class="relative w-full max-w-md mx-auto my-6">
        <!-- Ambient Neon Glow Backdrop -->
        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-30 dark:opacity-50 blur-xl transition-all duration-500 group-hover:opacity-100 pointer-events-none"></div>

        <div class="relative w-full min-h-[520px] flex flex-col justify-between p-7 bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] transition-all duration-300">

            <div>
                <!-- Header / Title -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-violet-100/80 dark:bg-gray-900 border border-violet-400/30 dark:border-cyan-400/30 rounded-2xl flex items-center justify-center mx-auto mb-3 text-violet-600 dark:text-cyan-400 text-xl shadow-[0_0_15px_rgba(139,92,246,0.3)] dark:shadow-[0_0_15px_rgba(34,211,238,0.3)]">
                        <i class="fa-solid fa-key text-violet-600 dark:text-cyan-400 drop-shadow-[0_0_6px_rgba(34,211,238,0.5)]"></i>
                    </div>
                    <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                        Reset Password
                    </h2>
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mt-1">
                        Recover your account access
                    </p>
                </div>

                <div class="mb-6 text-xs leading-relaxed text-gray-600 dark:text-gray-300 bg-white/50 dark:bg-gray-900/60 p-4 rounded-xl border border-violet-200/80 dark:border-cyan-900/50 shadow-inner">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="sr-only" />
                        
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-violet-500 dark:text-cyan-400 pointer-events-none transition-colors duration-200">
                                <i class="fa-solid fa-envelope text-sm drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]"></i>
                            </span>
                            
                            <input
                                id="email"
                                class="block w-full pl-10 pr-3 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                placeholder="name@example.com" />
                        </div>

                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-500 dark:text-rose-400 font-medium" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <x-primary-button class="relative w-full justify-center py-2.5 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] dark:hover:shadow-[0_0_25px_rgba(139,92,246,0.7)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                            <i class="fa-solid fa-paper-plane mr-2 text-xs"></i> {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>
                    
                    <!-- Back Link -->
                    <div class="text-center pt-2">
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-violet-600 dark:text-cyan-400 hover:text-fuchsia-500 dark:hover:text-fuchsia-300 transition-colors inline-flex items-center">
                            <i class="fa-solid fa-arrow-left mr-1.5 text-[10px]"></i> Back to Login
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>