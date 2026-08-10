<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-rose-500 via-fuchsia-500 to-indigo-500 dark:from-rose-400 dark:via-fuchsia-400 dark:to-indigo-400 tracking-wide drop-shadow-[0_0_10px_rgba(244,63,94,0.3)] flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-rose-500 dark:text-rose-400 drop-shadow-[0_0_8px_rgba(244,63,94,0.6)]"></i> {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-cyan-300/60 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 via-fuchsia-600 to-indigo-600 hover:from-rose-500 hover:via-fuchsia-500 hover:to-indigo-500 text-white font-bold shadow-[0_0_20px_rgba(244,63,94,0.4)] hover:shadow-[0_0_30px_rgba(244,63,94,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-rose-400 border-0">
        <i class="fa-solid fa-user-xmark mr-2"></i> {{ __('Delete Account') }}
    </x-danger-button>

    @php
        $showModal = $errors->hasBag('userDeletion') && $errors->userDeletion->isNotEmpty();
        $destroyRoute = Route::has('profile.destroy') ? route('profile.destroy') : '#';
        $passwordErrors = $errors->hasBag('userDeletion') ? $errors->userDeletion->get('password') : [];
    @endphp

    <x-modal name="confirm-user-deletion" :show="$showModal" focusable>
        <form method="post" action="{{ $destroyRoute }}" class="p-6 sm:p-8 bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl rounded-2xl shadow-2xl dark:shadow-[0_0_30px_rgba(244,63,94,0.2)] border border-gray-200/80 dark:border-rose-500/30 transition-all duration-300">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-500 dark:text-rose-400 drop-shadow-[0_0_8px_rgba(244,63,94,0.6)]"></i> {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500 dark:text-cyan-300/60 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6 space-y-1">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-cyan-400/60">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <x-text-input id="password" name="password" type="password" class="block w-full pl-10 pr-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 dark:focus:shadow-[0_0_15px_rgba(244,63,94,0.4)] transition-all duration-300 placeholder-gray-400 dark:placeholder-gray-500" placeholder="{{ __('Password') }}" />
                </div>
                <x-input-error :messages="$passwordErrors" class="mt-2 text-xs text-rose-600 dark:text-rose-400 font-semibold" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="py-2.5 px-5 rounded-xl border border-gray-300 dark:border-fuchsia-500/40 text-gray-700 dark:text-fuchsia-300 font-semibold bg-transparent hover:bg-fuchsia-50 dark:hover:bg-fuchsia-950/40 hover:border-fuchsia-400 hover:text-fuchsia-600 dark:hover:text-fuchsia-200 hover:shadow-[0_0_15px_rgba(217,70,239,0.3)] transition-all duration-300">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-0 py-2.5 px-5 rounded-xl bg-gradient-to-r from-rose-600 via-fuchsia-600 to-indigo-600 hover:from-rose-500 hover:via-fuchsia-500 hover:to-indigo-500 text-white font-bold shadow-[0_0_20px_rgba(244,63,94,0.4)] hover:shadow-[0_0_30px_rgba(244,63,94,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-rose-400 border-0">
                    <i class="fa-solid fa-trash mr-2"></i> {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>