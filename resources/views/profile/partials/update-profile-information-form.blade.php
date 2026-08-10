<section>
    @php
        $userName = data_get($user, 'name', 'User');
        $userEmail = data_get($user, 'email', '');
        $userAvatar = data_get($user, 'avatar');
        $initial = strtoupper(substr($userName, 0, 1));
        $verifyRoute = Route::has('verification.send') ? route('verification.send') : '#';
        $updateRoute = Route::has('profile.update') ? route('profile.update') : '#';
    @endphp

    <header class="mb-6">
        <h2 class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 via-indigo-500 to-fuchsia-500 dark:from-cyan-400 dark:via-indigo-400 dark:to-fuchsia-400 tracking-wide drop-shadow-[0_0_10px_rgba(6,182,212,0.3)] flex items-center gap-2">
            <i class="fa-solid fa-id-card text-cyan-500 dark:text-cyan-400 drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]"></i> {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-cyan-300/60 leading-relaxed">
            {{ __("Update your account's profile information, email address, and profile picture.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ $verifyRoute }}">
        @csrf
    </form>

    <form method="post" action="{{ $updateRoute }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center gap-6 p-4 bg-gray-50/50 dark:bg-gray-950/60 rounded-2xl border border-gray-200/80 dark:border-cyan-500/30 backdrop-blur-md">
            <div class="relative shrink-0" id="avatar-container">
                @if ($userAvatar)
                <img id="avatar-preview" src="{{ asset('storage/' . $userAvatar) }}" alt="{{ $userName }}" class="w-20 h-20 rounded-full object-cover shadow-[0_0_15px_rgba(6,182,212,0.4)] border-2 border-cyan-400">
                @else
                <div id="avatar-preview-fallback" class="w-20 h-20 rounded-full bg-gradient-to-br from-cyan-500 via-indigo-600 to-fuchsia-600 text-white font-extrabold text-2xl flex items-center justify-center shadow-[0_0_15px_rgba(6,182,212,0.4)] border-2 border-cyan-400">
                    {{ $initial }}
                </div>
                @endif
                <div class="absolute inset-0 rounded-full bg-black/50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer pointer-events-none backdrop-blur-xs">
                    <i class="fa-solid fa-camera text-white text-sm drop-shadow-[0_0_5px_rgba(255,255,255,0.8)]"></i>
                </div>
            </div>
            <div class="flex-1 space-y-2">
                <x-input-label for="avatar" :value="__('Profile Picture')" class="text-gray-700 dark:text-cyan-300 font-semibold" />
                <input id="avatar" name="avatar" type="file" accept="image/*" class="block w-full text-xs text-gray-500 dark:text-cyan-300/70 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border file:border-cyan-500/30 file:text-xs file:font-bold file:bg-cyan-500/10 file:text-cyan-600 dark:file:text-cyan-300 hover:file:bg-cyan-500/20 hover:file:shadow-[0_0_10px_rgba(6,182,212,0.3)] transition-all cursor-pointer" onchange="previewAvatarImage(event)" />
                <p class="text-[11px] text-gray-500 dark:text-cyan-300/60">{{ __('Supports all image formats (PNG, JPG, JPEG, WEBP, etc.)') }}</p>
                <x-input-error class="mt-1 text-xs text-fuchsia-500 dark:text-fuchsia-400 font-semibold drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="space-y-1">
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-cyan-300 font-semibold" />
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-cyan-400/60">
                    <i class="fa-solid fa-user text-sm"></i>
                </span>
                <x-text-input id="name" name="name" type="text" class="block w-full pl-10 pr-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" :value="old('name', $userName)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2 text-xs text-fuchsia-500 dark:text-fuchsia-400 font-semibold drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-1">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-cyan-300 font-semibold" />
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-cyan-400/60">
                    <i class="fa-solid fa-envelope text-sm"></i>
                </span>
                <x-text-input id="email" name="email" type="email" class="block w-full pl-10 pr-4 py-2.5 bg-gray-50/50 dark:bg-gray-950/60 border border-gray-300 dark:border-cyan-500/30 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 dark:focus:shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300" :value="old('email', $userEmail)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2 text-xs text-fuchsia-500 dark:text-fuchsia-400 font-semibold drop-shadow-[0_0_5px_rgba(217,70,239,0.5)]" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-3 p-3 bg-amber-500/10 dark:bg-amber-950/40 rounded-xl border border-amber-500/30 dark:border-amber-500/40 backdrop-blur-md">
                <p class="text-xs text-amber-800 dark:text-amber-300 font-medium flex items-center justify-between">
                    <span>{{ __('Your email address is unverified.') }}</span>
                    <button form="send-verification" class="font-bold underline hover:text-fuchsia-500 dark:hover:text-fuchsia-400 transition-colors">
                        {{ __('Re-send verification email') }}
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-bold text-xs text-emerald-600 dark:text-emerald-400 drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="py-2.5 px-6 rounded-xl bg-gradient-to-r from-cyan-500 via-indigo-600 to-fuchsia-600 hover:from-cyan-400 hover:via-indigo-500 hover:to-fuchsia-500 text-white font-bold shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:shadow-[0_0_30px_rgba(6,182,212,0.7)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-400 border-0">
                <i class="fa-solid fa-floppy-disk mr-2"></i> {{ __('Save Changes') }}
            </x-primary-button>
            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-xs text-emerald-500 dark:text-emerald-400 font-bold flex items-center gap-1 drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]">
                <i class="fa-solid fa-circle-check"></i> {{ __('Saved successfully.') }}
            </p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewAvatarImage(event) {
        const file = event.target.files ? event.target.files[0] : null;
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('avatar-container');
            if (!container) return;
            let img = document.getElementById('avatar-preview');
            const fallback = document.getElementById('avatar-preview-fallback');
            if (!img) {
                if (fallback) fallback.remove();
                img = document.createElement('img');
                img.id = 'avatar-preview';
                img.className = 'w-20 h-20 rounded-full object-cover shadow-[0_0_15px_rgba(6,182,212,0.4)] border-2 border-cyan-400';
                container.prepend(img);
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>