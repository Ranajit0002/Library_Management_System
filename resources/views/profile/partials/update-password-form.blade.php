<section>
    <header class="mb-6">
        <h2 class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)] flex items-center gap-2">
            <i class="fa-solid fa-key text-cyan-500 dark:text-cyan-400 drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]"></i> {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-cyan-300/60 leading-relaxed">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    @php
        $updateRoute = Route::has('password.update') ? route('password.update') : '#';
        $hasPasswordBag = $errors->hasBag('updatePassword');
        $currentPasswordErrors = $hasPasswordBag ? $errors->updatePassword->get('current_password') : [];
        $passwordErrors = $hasPasswordBag ? $errors->updatePassword->get('password') : [];
        $confirmationErrors = $hasPasswordBag ? $errors->updatePassword->get('password_confirmation') : [];
    @endphp

    <form method="post" action="{{ $updateRoute }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-1">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700 dark:text-cyan-300 font-semibold" />
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-cyan-400/60">
                    <i class="fa-solid fa-lock text-sm"></i>
                </span>
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full pl-10 pr-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" autocomplete="current-password" />
            </div>
            <x-input-error :messages="$currentPasswordErrors" class="mt-2 text-xs text-fuchsia-500 dark:text-fuchsia-400 font-semibold drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]" />
        </div>

        <div class="space-y-1">
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700 dark:text-cyan-300 font-semibold" />
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-cyan-400/60">
                    <i class="fa-solid fa-key text-sm"></i>
                </span>
                <x-text-input id="update_password_password" name="password" type="password" class="block w-full pl-10 pr-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$passwordErrors" class="mt-2 text-xs text-fuchsia-500 dark:text-fuchsia-400 font-semibold drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]" />
        </div>

        <div class="space-y-1">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-cyan-300 font-semibold" />
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-cyan-400/60">
                    <i class="fa-solid fa-shield-check text-sm"></i>
                </span>
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full pl-10 pr-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$confirmationErrors" class="mt-2 text-xs text-fuchsia-500 dark:text-fuchsia-400 font-semibold drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="py-2.5 px-6 rounded-xl bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 text-white font-bold shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-400 border-0">
                <i class="fa-solid fa-floppy-disk mr-2"></i> {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-xs text-emerald-500 dark:text-emerald-400 font-bold flex items-center gap-1 drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]">
                <i class="fa-solid fa-circle-check"></i> {{ __('Saved.') }}
            </p>
            @endif
        </div>
    </form>
</section>