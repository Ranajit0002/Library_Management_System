<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="relative w-full max-w-md mx-auto">
            <!-- Ambient Neon Glow Backdrop -->
            <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-30 dark:opacity-50 blur-xl transition-all duration-500 pointer-events-none"></div>

            <div class="relative w-full max-w-md p-6 sm:p-7 bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] transition-all duration-300">

                <!-- Close Button -->
                <a href="/" class="absolute -top-3 -right-3 flex h-9 w-9 items-center justify-center rounded-full bg-white dark:bg-gray-900 border border-violet-400/40 dark:border-cyan-400/40 text-violet-600 dark:text-cyan-400 hover:scale-110 hover:shadow-[0_0_15px_rgba(34,211,238,0.6)] dark:hover:shadow-[0_0_15px_rgba(168,85,247,0.6)] shadow-md transition-all duration-300 z-20" title="Close">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </a>

                <!-- Top Navigation / Sliding Pill Switcher -->
                <div class="flex items-center justify-center mb-5">
                    <div class="relative inline-flex p-1 bg-gray-100/80 dark:bg-gray-900/90 border border-violet-500/20 dark:border-cyan-500/20 rounded-full text-xs font-medium w-52 shadow-inner">

                        <!-- Sliding Background Pill -->
                        <div class="absolute top-1 bottom-1 left-1 w-[calc(50%-4px)] rounded-full bg-gradient-to-r from-violet-600 to-cyan-500 shadow-[0_0_12px_rgba(139,92,246,0.5)] transition-transform duration-300 ease-in-out"></div>

                        <!-- Sign In -->
                        <a href="{{ route('login') }}"
                            class="relative z-10 w-1/2 py-1.5 text-center font-bold tracking-wide text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.9)] transition-colors duration-300">
                            Sign in
                        </a>

                        <!-- Sign Up -->
                        <a href="{{ route('register') }}"
                            class="relative z-10 w-1/2 py-1.5 text-center font-bold tracking-wide text-gray-500 hover:text-violet-600 dark:text-gray-400 dark:hover:text-cyan-400 transition-colors duration-300">
                            Sign up
                        </a>

                    </div>
                </div>

                <!-- Header -->
                <div class="mb-4">
                    <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                        Welcome Back
                    </h2>
                    <p class="mt-0.5 text-xs text-gray-600 dark:text-gray-400 font-medium">
                        Please enter your details to sign in.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status
                    class="mb-3"
                    :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-3">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="sr-only" />

                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-violet-500 dark:text-cyan-400 pointer-events-none transition-colors duration-200">
                                <i class="fa-regular fa-envelope text-sm drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]"></i>
                            </span>

                            <input
                                id="email"
                                class="block w-full pl-10 pr-3 py-2 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Enter your email" />
                        </div>

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-0.5 text-xs text-rose-500 dark:text-rose-400 font-medium" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="sr-only" />

                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-violet-500 dark:text-cyan-400 pointer-events-none transition-colors duration-200">
                                <i class="fa-solid fa-lock text-sm drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]"></i>
                            </span>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="block w-full pl-10 pr-10 py-2 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300">

                            <button
                                type="button"
                                id="togglePasswordBtn"
                                class="absolute inset-y-0 right-0 z-20 flex items-center pr-3 text-violet-400 dark:text-cyan-400 hover:text-fuchsia-500 dark:hover:text-fuchsia-400 focus:outline-none transition-colors duration-200">

                                <!-- Eye (Shown when password is masked) -->
                                <svg
                                    id="eyeIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 drop-shadow-[0_0_4px_rgba(34,211,238,0.4)]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7" />
                                </svg>

                                <!-- Eye Slash -->
                                <svg
                                    id="eyeSlashIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 hidden drop-shadow-[0_0_4px_rgba(34,211,238,0.4)]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>

                            </button>
                        </div>

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-0.5 text-xs text-rose-500 dark:text-rose-400 font-medium" />
                    </div>

                    <!-- Remember / Forgot -->
                    <div class="flex items-center justify-between pt-0.5 text-xs">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="rounded border-violet-300 dark:border-cyan-900 text-cyan-500 focus:ring-cyan-400 dark:bg-gray-900 checked:bg-cyan-500 shadow-[0_0_8px_rgba(34,211,238,0.3)] transition">

                            <span class="ms-2 text-gray-600 dark:text-gray-400 group-hover:text-violet-600 dark:group-hover:text-cyan-400 transition-colors">
                                {{ __('Remember me') }}
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-xs text-violet-600 dark:text-cyan-400 hover:text-fuchsia-500 dark:hover:text-fuchsia-300 hover:underline transition-colors">
                            {{ __('Forgot password?') }}
                        </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div class="pt-1">
                        <x-primary-button class="relative w-full justify-center py-2.5 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] dark:hover:shadow-[0_0_25px_rgba(139,92,246,0.7)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>

                <!-- Footer Links -->
                <div class="pt-3 text-center space-y-1">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Don't have an account?
                        <a
                            href="{{ route('register') }}"
                            class="font-semibold text-violet-600 dark:text-cyan-400 hover:text-fuchsia-500 dark:hover:text-fuchsia-300 hover:underline ml-0.5 transition-colors">
                            Sign Up
                        </a>
                    </p>

                    <p class="text-[10px] text-gray-400 dark:text-gray-500">
                        By signing in, you agree to our
                        <a href="{{ route('terms') }}" class="underline hover:text-violet-600 dark:hover:text-cyan-400 transition-colors">
                            Terms &amp; Service
                        </a>.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    eyeIcon.classList.toggle('hidden', isPassword);
                    eyeSlashIcon.classList.toggle('hidden', !isPassword);
                });
            }
        });
    </script>
</x-guest-layout>