@php
    $catalogRoute = Route::has('books.index') ? route('books.index') : (Route::has('books.catalog') ? route('books.catalog') : url('/books'));
@endphp

<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-2.5">
                <i class="fa-solid fa-star text-amber-400 drop-shadow-[0_0_8px_rgba(251,191,36,0.8)]"></i>
                <span>{{ __('Featured Books') }}</span>
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Hand-picked selections from our collection') }}</p>
        </div>
        <a href="{{ $catalogRoute }}" class="text-xs font-bold text-cyan-600 dark:text-cyan-400 hover:text-cyan-500 hover:underline flex items-center gap-1">
            {{ __('View Catalog') }} &rarr;
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($featuredBooks ?? [] as $book)
            @php
                $authorName = is_object(data_get($book, 'author')) ? data_get($book, 'author.name', 'Unknown Author') : (data_get($book, 'author') ?? 'Unknown Author');
                $bookId = data_get($book, 'id', 1);
                $detailsRoute = Route::has('books.show') ? route('books.show', $bookId) : url('/books/' . $bookId);
            @endphp
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_15px_rgba(6,182,212,0.1)] dark:shadow-[0_0_20px_rgba(6,182,212,0.15)] border border-gray-200/80 dark:border-cyan-500/20 hover:border-cyan-500/50 transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="h-52 bg-slate-100 dark:bg-gray-800/60 relative flex items-center justify-center overflow-hidden">
                    @if(!empty(data_get($book, 'cover_image')))
                        <img src="{{ asset('storage/' . data_get($book, 'cover_image')) }}" alt="{{ data_get($book, 'title', 'Book Cover') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="p-4 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-book-open text-4xl"></i>
                        </div>
                    @endif
                    <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-black/60 backdrop-blur-md text-cyan-300 border border-cyan-500/30">
                        {{ data_get($book, 'category.name', 'General') }}
                    </span>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white line-clamp-1 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors" title="{{ data_get($book, 'title', 'Untitled Book') }}">
                        {{ data_get($book, 'title', 'Untitled Book') }}
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">
                        By {{ $authorName }}
                    </p>
                    <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-800/80">
                        <a href="{{ $detailsRoute }}" class="block w-full text-center py-2 px-4 rounded-xl text-xs font-bold uppercase tracking-wider bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-indigo-600 hover:text-white transition-all duration-300 shadow-xs">
                            {{ __('View Details') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            @for ($i = 1; $i <= 4; $i++)
                @php
                    $fallbackRoute = Route::has('books.show') ? route('books.show', $i) : url('/books/' . $i);
                @endphp
                <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-[0_0_15px_rgba(6,182,212,0.08)] border border-gray-200/80 dark:border-cyan-500/20 overflow-hidden flex flex-col group">
                    <div class="h-48 bg-slate-100 dark:bg-gray-800/50 flex items-center justify-center text-cyan-500/60">
                        <i class="fa-solid fa-book text-4xl"></i>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400">Technology</span>
                        <h3 class="font-bold text-base text-gray-900 dark:text-white mt-1">Clean Architecture</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Robert C. Martin</p>
                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-800/80">
                            <a href="{{ $fallbackRoute }}" class="block w-full text-center py-2 px-4 rounded-xl text-xs font-bold uppercase tracking-wider bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gradient-to-r hover:from-cyan-500 hover:to-indigo-600 hover:text-white transition-all duration-300">{{ __('View Details') }}</a>
                        </div>
                    </div>
                </div>
            @endfor
        @endforelse
    </div>
</section>