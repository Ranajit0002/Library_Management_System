@php
    $totalBooks   = data_get($stats ?? [], 'total_books', 0);
    $totalMembers = data_get($stats ?? [], 'total_members', 0);
    $issuedBooks  = data_get($stats ?? [], 'issued_books', 0);
@endphp

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 transition-colors duration-300">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
        <!-- Total Books Card -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-6 rounded-2xl shadow-[0_0_20px_rgba(6,182,212,0.1)] dark:shadow-[0_0_25px_rgba(6,182,212,0.2)] border border-cyan-500/20 dark:border-cyan-500/40 relative overflow-hidden group hover:border-cyan-500/60 transition-all duration-300">
            <div class="flex items-center justify-center gap-3 mb-2">
                <i class="fa-solid fa-book text-cyan-500 text-2xl drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]"></i>
                <h4 class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                    {{ number_format($totalBooks) }}+
                </h4>
            </div>
            <p class="text-xs sm:text-sm font-bold text-slate-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Total Books Available') }}</p>
        </div>

        <!-- Active Members Card -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-6 rounded-2xl shadow-[0_0_20px_rgba(217,70,239,0.1)] dark:shadow-[0_0_25px_rgba(217,70,239,0.2)] border border-fuchsia-500/20 dark:border-fuchsia-500/40 relative overflow-hidden group hover:border-fuchsia-500/60 transition-all duration-300">
            <div class="flex items-center justify-center gap-3 mb-2">
                <i class="fa-solid fa-users text-fuchsia-500 text-2xl drop-shadow-[0_0_8px_rgba(217,70,239,0.8)]"></i>
                <h4 class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-fuchsia-600 to-pink-600 dark:from-fuchsia-400 dark:to-pink-400 bg-clip-text text-transparent">
                    {{ number_format($totalMembers) }}+
                </h4>
            </div>
            <p class="text-xs sm:text-sm font-bold text-slate-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Active Patrons & Members') }}</p>
        </div>

        <!-- Active Book Circulation Card -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-6 rounded-2xl shadow-[0_0_20px_rgba(16,185,129,0.1)] dark:shadow-[0_0_25px_rgba(16,185,129,0.2)] border border-emerald-500/20 dark:border-emerald-500/40 relative overflow-hidden group hover:border-emerald-500/60 transition-all duration-300">
            <div class="flex items-center justify-center gap-3 mb-2">
                <i class="fa-solid fa-hand-holding-hand text-emerald-500 text-2xl drop-shadow-[0_0_8px_rgba(16,185,129,0.8)]"></i>
                <h4 class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-400 dark:to-teal-400 bg-clip-text text-transparent">
                    {{ number_format($issuedBooks) }}+
                </h4>
            </div>
            <p class="text-xs sm:text-sm font-bold text-slate-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Active Book Circulation') }}</p>
        </div>
    </div>
</section>