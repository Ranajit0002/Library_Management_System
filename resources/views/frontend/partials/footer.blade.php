<footer class="bg-white/80 dark:bg-gray-900/80 border-t border-gray-200 dark:border-cyan-500/20 py-6 mt-auto backdrop-blur-md transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-book-bookmark text-indigo-500 dark:text-cyan-400 drop-shadow-[0_0_6px_rgba(6,182,212,0.8)]"></i>
            <span>&copy; {{ date('Y') }} Library Management System. All rights reserved.</span>
        </div>
        <div class="flex items-center space-x-6 text-xs sm:text-sm">
            @if(Route::has('privacy'))
                <a href="{{ route('privacy') }}" class="hover:text-indigo-600 dark:hover:text-cyan-400 transition-colors">{{ __('Privacy Policy') }}</a>
            @else
                <a href="#" class="hover:text-indigo-600 dark:hover:text-cyan-400 transition-colors">{{ __('Privacy Policy') }}</a>
            @endif

            @if(Route::has('terms'))
                <a href="{{ route('terms') }}" class="hover:text-indigo-600 dark:hover:text-cyan-400 transition-colors">{{ __('Terms & Conditions') }}</a>
            @else
                <a href="#" class="hover:text-indigo-600 dark:hover:text-cyan-400 transition-colors">{{ __('Terms & Conditions') }}</a>
            @endif

            @if(Route::has('support'))
                <a href="{{ route('support') }}" class="hover:text-indigo-600 dark:hover:text-cyan-400 transition-colors">{{ __('Support') }}</a>
            @else
                <a href="#" class="hover:text-indigo-600 dark:hover:text-cyan-400 transition-colors">{{ __('Support') }}</a>
            @endif
        </div>
    </div>
</footer>