<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Library Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <!-- FontAwesome & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="relative min-h-screen overflow-x-hidden font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-500">
    <!-- Background Glow Blobs -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-100 via-indigo-50 to-cyan-100 dark:from-gray-950 dark:via-slate-950 dark:to-fuchsia-950 transition-colors duration-500"></div>
    <div class="absolute -top-32 -left-24 h-96 w-96 rounded-full bg-cyan-400/30 dark:bg-cyan-500/30 blur-3xl shadow-[0_0_80px_rgba(6,182,212,0.6)] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 h-[28rem] w-[28rem] rounded-full bg-fuchsia-400/25 dark:bg-fuchsia-600/30 blur-3xl shadow-[0_0_100px_rgba(217,70,239,0.5)] pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 h-80 w-80 -translate-x-1/2 -translate-y-1/2 rounded-full bg-indigo-500/20 dark:bg-cyan-400/15 blur-3xl pointer-events-none"></div>
    <div class="absolute inset-0 bg-white/30 dark:bg-gray-950/40 backdrop-blur-xl pointer-events-none border-b border-gray-200/50 dark:border-cyan-500/20"></div>

    <!-- Main Content Slot & Toast Alerts -->
    <div class="relative z-10 flex flex-col min-h-screen items-center justify-center px-4 py-10">
        @if (session('status'))
        <div class="mb-4 max-w-md w-full p-4 rounded-xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-700 dark:text-cyan-300 text-sm font-medium backdrop-blur-md shadow-lg">
            {{ session('status') }}
        </div>
        @endif
        @if (session('error'))
        <div class="mb-4 max-w-md w-full p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-700 dark:text-red-400 text-sm font-medium backdrop-blur-md shadow-lg">
            {{ session('error') }}
        </div>
        @endif
        @if (session('success'))
        <div class="mb-4 max-w-md w-full p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-400 text-sm font-medium backdrop-blur-md shadow-lg">
            {{ session('success') }}
        </div>
        @endif

        {{ $slot }}
    </div>

    <!-- Cookie Banner -->
    <div id="cookie-banner" class="fixed bottom-8 inset-x-0 z-50 px-4 sm:px-6 lg:px-8 hidden">
        <div class="max-w-7xl mx-auto w-full">
            <div class="w-full relative bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border border-violet-500/30 dark:border-cyan-500/40 rounded-2xl p-5 sm:px-8 shadow-xl text-gray-800 dark:text-gray-200 text-xs sm:text-sm leading-relaxed flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-center sm:text-left m-0">
                    {{ __('We use essential session cookies to ensure our Library Management System functions securely.') }}
                </p>
                <div class="flex items-center justify-end gap-3 shrink-0">
                    <button id="cookie-reject" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all cursor-pointer">
                        {{ __('Reject') }}
                    </button>
                    <button id="cookie-accept" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 to-cyan-500 hover:from-violet-500 hover:to-cyan-400 shadow-md transition-all cursor-pointer">
                        {{ __('Accept') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const banner = document.getElementById("cookie-banner");
            const acceptBtn = document.getElementById("cookie-accept");
            const rejectBtn = document.getElementById("cookie-reject");

            if (!localStorage.getItem("cookies_accepted") && banner) {
                banner.classList.remove("hidden");
            }
            if (acceptBtn) {
                acceptBtn.addEventListener("click", function() {
                    localStorage.setItem("cookies_accepted", "true");
                    if (banner) banner.classList.add("hidden");
                });
            }
            if (rejectBtn) {
                rejectBtn.addEventListener("click", function() {
                    localStorage.setItem("cookies_accepted", "rejected");
                    if (banner) banner.classList.add("hidden");
                });
            }
        });
    </script>
</body>

</html>