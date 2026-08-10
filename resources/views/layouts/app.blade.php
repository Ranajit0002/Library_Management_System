<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Library Management System') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="min-h-screen flex flex-col justify-between">
        <div>
            @include('layouts.navigation')
            @hasSection('header')
            <header>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    @yield('header')
                </div>
            </header>
            @elseif(isset($header))
            <header>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    {{ $header }}
                </div>
            </header>
            @endif
            <main class="w-full py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
        <footer class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-t border-gray-200 dark:border-cyan-500/30 py-6 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                <div class="mb-4 sm:mb-0 flex items-center gap-2">
                    <i class="fa-solid fa-book-bookmark text-indigo-500 dark:text-cyan-400 drop-shadow-[0_0_6px_rgba(6,182,212,0.8)]"></i>
                    <span>&copy; {{ date('Y') }} {{ __('Library Management System. All rights reserved.') }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if(Route::has('privacy'))
                    <a href="{{ route('privacy') }}" class="hover:text-indigo-600 dark:hover:text-cyan-300 transition-all duration-200">{{ __('Privacy Policy') }}</a>
                    <span class="text-gray-300 dark:text-cyan-900">|</span>
                    @endif
                    @if(Route::has('terms'))
                    <a href="{{ route('terms') }}" class="hover:text-indigo-600 dark:hover:text-cyan-300 transition-all duration-200">{{ __('Terms & Conditions') }}</a>
                    <span class="text-gray-300 dark:text-cyan-900">|</span>
                    @endif
                    @if(Route::has('support'))
                    <a href="{{ route('support') }}" class="hover:text-indigo-600 dark:hover:text-cyan-300 transition-all duration-200">{{ __('Support') }}</a>
                    @endif
                </div>
            </div>
        </footer>
    </div>
</body>

</html>