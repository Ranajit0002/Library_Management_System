<x-guest-layout>
    <div class="relative w-full max-w-md mx-auto my-6">
        <!-- Ambient Neon Glow Backdrop -->
        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-30 dark:opacity-50 blur-xl transition-all duration-500 group-hover:opacity-100 pointer-events-none"></div>

        <div class="relative w-full min-h-[500px] flex flex-col justify-between p-7 bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl border border-violet-500/20 dark:border-cyan-500/30 rounded-2xl shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] transition-all duration-300">

            <div>
                <!-- Header / Title -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-violet-100/80 dark:bg-gray-900 border border-violet-400/30 dark:border-cyan-400/30 rounded-2xl flex items-center justify-center mx-auto mb-3 text-violet-600 dark:text-cyan-400 text-xl shadow-[0_0_15px_rgba(139,92,246,0.3)] dark:shadow-[0_0_15px_rgba(34,211,238,0.3)]">
                        <i class="fa-solid fa-lock text-violet-600 dark:text-cyan-400 drop-shadow-[0_0_6px_rgba(34,211,238,0.5)]"></i>
                    </div>
                    <h2 class="text-2xl font-black bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight">
                        Confirm Password
                    </h2>
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mt-1">
                        Secure Area Verification
                    </p>
                </div>

                <!-- Info Message -->
                <div class="mb-6 text-xs leading-relaxed text-gray-600 dark:text-gray-300 bg-white/50 dark:bg-gray-900/60 p-4 rounded-xl border border-violet-200/80 dark:border-cyan-900/50 shadow-inner">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="sr-only" />

                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-violet-500 dark:text-cyan-400 pointer-events-none transition-colors duration-200">
                                <i class="fa-solid fa-key text-sm drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]"></i>
                            </span>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your current password"
                                class="block w-full pl-10 pr-10 py-2.5 text-sm rounded-xl border border-violet-200 dark:border-cyan-900/60 bg-white/50 dark:bg-gray-900/60 text-gray-900 dark:text-gray-100 shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:focus:border-cyan-400 dark:focus:ring-cyan-400/40 focus:shadow-[0_0_15px_rgba(34,211,238,0.25)] transition-all duration-300" />

                            <button
                                type="button"
                                id="togglePasswordBtn"
                                class="absolute inset-y-0 right-0 z-20 flex items-center pr-3 text-violet-400 dark:text-cyan-400 hover:text-fuchsia-500 dark:hover:text-fuchsia-400 focus:outline-none transition-colors duration-200">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 drop-shadow-[0_0_4px_rgba(34,211,238,0.4)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7" />
                                </svg>
                                <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden drop-shadow-[0_0_4px_rgba(34,211,238,0.4)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-500 dark:text-rose-400 font-medium" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <x-primary-button class="relative w-full justify-center py-2.5 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-indigo-600 to-cyan-500 hover:from-violet-500 hover:via-indigo-500 hover:to-cyan-400 shadow-[0_0_20px_rgba(139,92,246,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] dark:hover:shadow-[0_0_25px_rgba(139,92,246,0.7)] border border-violet-300/30 dark:border-cyan-300/30 transition-all duration-300 transform active:scale-[0.99]">
                            <i class="fa-solid fa-shield-check mr-2 text-xs"></i> {{ __('Confirm Password') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Password Visibility Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('togglePasswordBtn');
            const input = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            const slash = document.getElementById('eyeSlashIcon');

            if (btn && input) {
                btn.addEventListener('click', function() {
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    eye.classList.toggle('hidden', isPassword);
                    slash.classList.toggle('hidden', !isPassword);
                });
            }
        });
    </script>
</x-guest-layout>