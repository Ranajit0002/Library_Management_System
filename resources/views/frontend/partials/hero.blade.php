@php
    $searchAction = Route::has('books.index') ? route('books.index') : (Route::has('books.catalog') ? route('books.catalog') : url('/books'));
@endphp

<section class="relative overflow-hidden py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-indigo-50/80 via-slate-100 to-cyan-50/80 dark:from-slate-950 dark:via-indigo-950 dark:to-slate-950 text-slate-900 dark:text-white rounded-3xl border border-indigo-200/60 dark:border-indigo-500/20 shadow-xl dark:shadow-[0_0_50px_rgba(99,102,241,0.15)] my-6 transition-colors duration-500">
    <div class="absolute -top-24 -left-20 w-80 h-80 bg-cyan-400/20 dark:bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-20 w-80 h-80 bg-fuchsia-400/20 dark:bg-fuchsia-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative z-10 max-w-3xl mx-auto text-center space-y-6">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight leading-tight">
            Discover Your Next <span class="bg-gradient-to-r from-cyan-600 via-fuchsia-600 to-indigo-600 dark:from-cyan-400 dark:via-fuchsia-400 dark:to-indigo-400 bg-clip-text text-transparent drop-shadow-sm dark:drop-shadow-[0_0_20px_rgba(6,182,212,0.4)]">Great Read</span>
        </h1>
        <p class="text-base sm:text-lg text-slate-600 dark:text-indigo-200/80 font-medium max-w-2xl mx-auto">
            Explore thousands of books, manage borrowings seamlessly, and expand your mind.
        </p>
        <form action="{{ $searchAction }}" method="GET" class="flex flex-col sm:flex-row items-center max-w-xl mx-auto gap-2 bg-white/80 dark:bg-gray-900/60 backdrop-blur-xl p-2 rounded-2xl border border-indigo-200 dark:border-indigo-500/30 shadow-lg dark:shadow-[0_0_25px_rgba(99,102,241,0.2)]">
            <div class="relative w-full flex items-center pl-3">
                <i class="fa-solid fa-magnifying-glass text-indigo-500 dark:text-indigo-300 mr-2 text-sm"></i>
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    aria-label="Search books by title, author, or ISBN"
                    placeholder="Search by title, author, or ISBN..."
                    class="w-full py-2 bg-transparent text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-indigo-200/50 text-sm border-0 outline-none focus:outline-none focus:ring-0 focus:border-0">
            </div>
            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-cyan-600 dark:from-cyan-500 dark:to-indigo-600 hover:from-indigo-500 hover:to-cyan-500 dark:hover:from-cyan-400 dark:hover:to-indigo-500 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-md dark:shadow-[0_0_15px_rgba(6,182,212,0.4)] hover:shadow-lg dark:hover:shadow-[0_0_20px_rgba(6,182,212,0.7)] transition-all duration-300 shrink-0 cursor-pointer">
                {{ __('Search') }}
            </button>
        </form>
    </div>
</section>