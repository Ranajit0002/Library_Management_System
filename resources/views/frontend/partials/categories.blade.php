@php
    $catalogRoute = url('/books');
    $genresRoute  = $catalogRoute;

    $iconMap = [
        'fiction'    => 'fa-hat-wizard',
        'science'    => 'fa-microscope',
        'history'    => 'fa-landmark',
        'technology' => 'fa-laptop-code',
        'business'   => 'fa-chart-line',
        'arts'       => 'fa-palette',
        'biography'  => 'fa-user-pen',
        'math'       => 'fa-calculator',
    ];
@endphp
<section class="py-12 bg-slate-50/50 dark:bg-gray-900/40 border-y border-gray-200/60 dark:border-cyan-500/10 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-2.5">
                    <i class="fa-solid fa-layer-group text-teal-400 drop-shadow-[0_0_8px_rgba(45,212,191,0.8)]"></i>
                    <span>{{ __('Browse Categories') }}</span>
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Explore our collection by topic and genre') }}</p>
            </div>
            <a href="{{ $genresRoute }}" class="text-xs font-bold text-teal-600 dark:text-teal-400 hover:text-teal-500 hover:underline flex items-center gap-1">
                {{ __('All Genres') }} &rarr;
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @forelse($categories ?? [] as $item)
                @php
                    $catId   = is_object($item) || is_array($item) ? data_get($item, 'id') : null;
                    $catName = is_string($item) ? $item : data_get($item, 'name', 'General');
                    $catSlug = is_string($item) ? strtolower($item) : data_get($item, 'slug', strtolower($catName));
                    $catIcon = $iconMap[$catSlug] ?? 'fa-folder-open';
                    
                    $targetUrl = $catId 
                        ? $catalogRoute . '?category_id=' . $catId 
                        : $catalogRoute . '?category=' . urlencode($catName);
                @endphp
                <a href="{{ $targetUrl }}" class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl text-center shadow-[0_0_15px_rgba(20,184,166,0.08)] hover:shadow-[0_0_20px_rgba(20,184,166,0.25)] hover:-translate-y-1 transition-all duration-300 border border-gray-200/80 dark:border-teal-500/20 hover:border-teal-500/50 group flex flex-col items-center justify-center">
                    <div class="p-3.5 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 border border-teal-500/20 group-hover:scale-110 transition-transform duration-300 mb-3">
                        <i class="fa-solid {{ $catIcon }} text-xl"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 dark:text-gray-200 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors line-clamp-1">
                        {{ $catName }}
                    </span>
                </a>
            @empty
                @foreach(['Fiction', 'Science', 'History', 'Technology', 'Business', 'Arts'] as $fallbackName)
                    @php
                        $fallbackSlug = strtolower($fallbackName);
                        $fallbackIcon = $iconMap[$fallbackSlug] ?? 'fa-folder-open';
                        $targetUrl    = $catalogRoute . '?category=' . urlencode($fallbackName);
                    @endphp
                    <a href="{{ $targetUrl }}" class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl p-5 rounded-2xl text-center shadow-[0_0_15px_rgba(20,184,166,0.08)] hover:shadow-[0_0_20px_rgba(20,184,166,0.25)] hover:-translate-y-1 transition-all duration-300 border border-gray-200/80 dark:border-teal-500/20 hover:border-teal-500/50 group flex flex-col items-center justify-center">
                        <div class="p-3.5 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 border border-teal-500/20 group-hover:scale-110 transition-transform duration-300 mb-3">
                            <i class="fa-solid {{ $fallbackIcon }} text-xl"></i>
                        </div>
                        <span class="font-bold text-xs sm:text-sm text-gray-800 dark:text-gray-200 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors line-clamp-1">
                            {{ $fallbackName }}
                        </span>
                    </a>
                @endforeach
            @endforelse
        </div>
    </div>
</section>