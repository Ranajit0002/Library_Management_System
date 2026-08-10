@extends('layouts.app')

@section('header')
@php
    $user = auth()->user();
    $isAdmin = $user && (strtolower($user->role ?? '') === 'admin' || (bool) $user->is_admin);
    $isMember = $user && !$isAdmin;
@endphp

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h2 class="font-black text-2xl bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight leading-tight flex items-center gap-2">
        <i class="fa-solid fa-book text-violet-600 dark:text-cyan-400 drop-shadow-[0_0_10px_rgba(34,211,238,0.5)]"></i> {{ __('Book Details') }}
    </h2>
    <div class="flex items-center gap-2">
        @auth
            @if($isAdmin && Route::has('books.edit'))
            <a href="{{ route('books.edit', data_get($book, 'id')) }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 rounded-xl shadow-[0_0_20px_rgba(168,85,247,0.5)] dark:shadow-[0_0_20px_rgba(34,211,238,0.4)] hover:shadow-[0_0_25px_rgba(34,211,238,0.7)] border border-fuchsia-300/30 dark:border-cyan-300/30 transition-all duration-300 flex items-center gap-1.5 transform active:scale-[0.99]">
                <i class="fa-solid fa-pen-to-square"></i> {{ __('Edit Book') }}
            </a>
            @endif
        @endauth
        <a href="{{ Route::has('admin.books.index') ? route('admin.books.index') : (Route::has('books.index') ? route('books.index') : url('/books')) }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl shadow-[0_0_10px_rgba(255,255,255,0.05)] hover:shadow-[0_0_15px_rgba(168,85,247,0.4)] transition-all duration-300 flex items-center gap-1.5 w-fit">
            <i class="fa-solid fa-arrow-left"></i> {{ __('Back to List') }}
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    @if (session('success'))
    <div id="flash-success" class="bg-emerald-500/10 dark:bg-emerald-950/40 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.2)] relative flex items-center justify-between transition-opacity duration-500 backdrop-blur-md" role="alert">
        <span class="sm:inline font-medium text-xs flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 drop-shadow-[0_0_8px_rgba(16,185,129,0.5)]"></i> {{ session('success') }}
        </span>
        <button type="button" onclick="document.getElementById('flash-success').remove();" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-200 font-bold px-2 text-base focus:outline-none">&times;</button>
    </div>
    @endif
    @if (session('error'))
    <div id="flash-error" class="bg-rose-500/10 dark:bg-rose-950/40 border border-rose-500/30 text-rose-700 dark:text-rose-300 px-4 py-3 rounded-xl shadow-[0_0_15px_rgba(244,63,94,0.2)] relative flex items-center justify-between transition-opacity duration-500 backdrop-blur-md" role="alert">
        <span class="sm:inline font-medium text-xs flex items-center gap-2">
            <i class="fa-solid fa-circle-xmark text-rose-600 dark:text-rose-400 drop-shadow-[0_0_8px_rgba(244,63,94,0.5)]"></i> {{ session('error') }}
        </span>
        <button type="button" onclick="document.getElementById('flash-error').remove();" class="text-rose-600 dark:text-rose-400 hover:text-rose-900 dark:hover:text-rose-200 font-bold px-2 text-base focus:outline-none">&times;</button>
    </div>
    @endif
    @php
        $authorName = is_object(data_get($book, 'author')) ? data_get($book, 'author.name', 'N/A') : (data_get($book, 'author') ?? 'N/A');
        $publisherName = is_object(data_get($book, 'publisher')) ? data_get($book, 'publisher.name', 'N/A') : (data_get($book, 'publisher') ?? 'N/A');
        $availableQty = (int) data_get($book, 'available_quantity', 0);
        $bookId = data_get($book, 'id');
        $filePath = data_get($book, 'file_path');

        // Dynamic State Flags
        $userActiveIssue = data_get($book, 'user_active_issue');
        $userHasUnpaidFine = data_get($book, 'user_has_unpaid_fine', false);
        $userReserved = data_get($book, 'user_reserved', false);

        // Route Resolvers
        $borrowRoute = Route::has('books.borrow') ? route('books.borrow', $bookId) : (Route::has('book-issues.store') ? route('book-issues.store') : url('/book-issues'));
        $returnRoute = Route::has('books.return') ? route('books.return', $bookId) : (Route::has('member.books.return') ? route('member.books.return', $bookId) : url("/books/{$bookId}/return"));
        $reserveRoute = Route::has('books.reserve') ? route('books.reserve', $bookId) : (Route::has('member.books.reserve') ? route('member.books.reserve', $bookId) : url("/books/{$bookId}/reserve"));
        $readRoute = Route::has('books.read') ? route('books.read', $bookId) : url("/books/{$bookId}/read");
    @endphp
    <div class="relative w-full">
        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600/20 via-fuchsia-600/20 to-cyan-500/20 blur-xl pointer-events-none"></div>
        <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl overflow-hidden shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] rounded-2xl border border-violet-500/20 dark:border-cyan-500/30 p-6 md:p-8 transition-colors duration-300">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex flex-col items-center md:items-start space-y-4">
                    <div class="w-full max-w-xs h-80 bg-gray-50 dark:bg-gray-900 rounded-xl overflow-hidden flex items-center justify-center border border-violet-300/40 dark:border-cyan-500/40 shadow-md">
                        @if(!empty(data_get($book, 'cover_image')))
                        <img src="{{ asset('storage/' . data_get($book, 'cover_image')) }}" alt="{{ data_get($book, 'title', 'Book Cover') }}" class="w-full h-full object-cover">
                        @else
                        <div class="text-center p-6">
                            <i class="fa-solid fa-book-open text-5xl text-violet-400/80 dark:text-cyan-400/80 mb-2 block drop-shadow-[0_0_10px_rgba(34,211,238,0.4)]"></i>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">No Cover Available</span>
                        </div>
                        @endif
                    </div>
                    <div class="w-full max-w-xs bg-violet-50/40 dark:bg-gray-900/80 p-4 rounded-xl border border-violet-200/80 dark:border-cyan-900/60 space-y-2 shadow-sm">
                        <span class="text-xs font-bold text-violet-700 dark:text-cyan-400 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-boxes-stacked text-fuchsia-500 dark:text-cyan-400 drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]"></i> Inventory Metrics
                        </span>
                        <div class="text-xs text-gray-700 dark:text-gray-300 flex justify-between py-1.5 border-b border-violet-100 dark:border-gray-800">
                            <span>Total Stock:</span>
                            <span class="font-bold text-gray-900 dark:text-white font-mono">{{ data_get($book, 'quantity', 0) }}</span>
                        </div>
                        <div class="text-xs text-gray-700 dark:text-gray-300 flex justify-between py-1.5 border-b border-violet-100 dark:border-gray-800">
                            <span>Available:</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400 font-mono drop-shadow-[0_0_6px_rgba(52,211,153,0.4)]">{{ $availableQty }}</span>
                        </div>
                        <div class="text-xs text-gray-700 dark:text-gray-300 flex justify-between py-1.5">
                            <span>Status:</span>
                            <span class="font-bold uppercase tracking-wider text-[11px] {{ $availableQty > 0 ? 'text-emerald-600 dark:text-emerald-400 drop-shadow-[0_0_6px_rgba(52,211,153,0.4)]' : 'text-rose-600 dark:text-rose-400 drop-shadow-[0_0_6px_rgba(244,63,94,0.4)]' }}">
                                {{ ucfirst(str_replace('_', ' ', data_get($book, 'status') ?? ($availableQty > 0 ? 'available' : 'out_of_stock'))) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <span class="inline-flex items-center gap-1.5 bg-violet-500/10 dark:bg-cyan-950/80 text-violet-700 dark:text-cyan-300 border border-violet-200/80 dark:border-cyan-800/60 text-xs font-bold px-3 py-1 rounded-full mb-3 shadow-[0_0_10px_rgba(168,85,247,0.1)]">
                            <i class="fa-solid fa-tag text-[10px] text-fuchsia-500 dark:text-cyan-400"></i> {{ data_get($book, 'category.name', 'Uncategorized') }}
                        </span>
                        <h1 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white leading-tight tracking-tight">{{ data_get($book, 'title', 'Untitled') }}</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1.5">
                            <span>ISBN:</span>
                            <span class="font-mono font-medium text-violet-700 dark:text-cyan-300 bg-violet-50/80 dark:bg-gray-900 px-2 py-0.5 rounded-lg border border-violet-200 dark:border-cyan-900/60">{{ data_get($book, 'isbn', 'N/A') }}</span>
                        </p>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 py-4 border-y border-violet-100 dark:border-gray-800">
                        <div>
                            <span class="block text-gray-400 dark:text-gray-500 text-[11px] uppercase tracking-wider font-bold">Author</span>
                            <span class="text-gray-800 dark:text-gray-200 text-xs font-semibold mt-0.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-feather text-violet-500 dark:text-cyan-400 text-[10px]"></i> {{ $authorName }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-gray-400 dark:text-gray-500 text-[11px] uppercase tracking-wider font-bold">Publisher</span>
                            <span class="text-gray-800 dark:text-gray-200 text-xs font-semibold mt-0.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-building text-violet-500 dark:text-cyan-400 text-[10px]"></i> {{ $publisherName }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-gray-400 dark:text-gray-500 text-[11px] uppercase tracking-wider font-bold">Edition</span>
                            <span class="text-gray-800 dark:text-gray-200 text-xs font-semibold mt-0.5 block">{{ data_get($book, 'edition', 'N/A') }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-400 dark:text-gray-500 text-[11px] uppercase tracking-wider font-bold">Language</span>
                            <span class="text-gray-800 dark:text-gray-200 text-xs font-semibold mt-0.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-language text-violet-500 dark:text-cyan-400 text-[10px]"></i> {{ data_get($book, 'language', 'N/A') }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-gray-400 dark:text-gray-500 text-[11px] uppercase tracking-wider font-bold">Price</span>
                            <span class="text-transparent bg-gradient-to-r from-violet-600 to-cyan-500 dark:from-violet-400 dark:to-cyan-400 bg-clip-text text-sm font-black mt-0.5 block font-mono drop-shadow-[0_0_8px_rgba(34,211,238,0.3)]">₹{{ number_format((float) data_get($book, 'price', 0), 2) }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-400 dark:text-gray-500 text-[11px] uppercase tracking-wider font-bold">Publish Year</span>
                            <span class="text-gray-800 dark:text-gray-200 text-xs font-semibold mt-0.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar text-violet-500 dark:text-cyan-400 text-[10px]"></i> {{ data_get($book, 'publish_year', 'N/A') }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-solid fa-align-left text-violet-600 dark:text-cyan-400"></i> Description
                        </h3>
                        <div class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed bg-gray-50/80 dark:bg-gray-900/80 p-4 rounded-xl border border-violet-200/80 dark:border-gray-800 whitespace-pre-line shadow-inner">
                            {{ data_get($book, 'description') ?? 'No description provided for this book.' }}
                        </div>
                    </div>
                    <div class="pt-4 border-t border-violet-100 dark:border-gray-800 space-y-3">
                        @auth
                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                @if($isMember)
                                    @if($userHasUnpaidFine)
                                        <div class="w-full sm:w-auto p-3 bg-amber-500/10 border border-amber-500/30 rounded-xl text-amber-600 dark:text-amber-400 text-xs font-bold flex items-center gap-2">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                            <span>Blocked: Please pay outstanding fines to borrow or reserve books.</span>
                                        </div>
                                    @elseif($userActiveIssue)
                                        @if(data_get($userActiveIssue, 'status') === 'pending')
                                            <div class="w-full sm:w-auto p-3 bg-cyan-500/10 border border-cyan-500/30 rounded-xl text-cyan-600 dark:text-cyan-400 text-xs font-bold flex items-center gap-2">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                                <span>Borrow Request Pending Approval</span>
                                            </div>
                                        @else
                                            <form action="{{ $returnRoute }}" method="POST" class="w-full sm:w-auto">
                                                @csrf
                                                <button type="submit" class="w-full sm:w-auto px-6 py-3 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-emerald-500 via-teal-600 to-cyan-600 hover:from-emerald-400 hover:via-teal-500 hover:to-cyan-500 rounded-xl shadow-[0_0_20px_rgba(16,185,129,0.4)] transition-all duration-300 flex items-center justify-center gap-2 transform active:scale-[0.98]">
                                                    <i class="fa-solid fa-rotate-left text-sm"></i> {{ __('Return Book') }}
                                                </button>
                                            </form>
                                        @endif
                                    @elseif($availableQty <= 0)
                                        @if($userReserved)
                                            <div class="w-full sm:w-auto p-3 bg-fuchsia-500/10 border border-fuchsia-500/30 rounded-xl text-fuchsia-600 dark:text-fuchsia-400 text-xs font-bold flex items-center gap-2">
                                                <i class="fa-solid fa-bookmark"></i>
                                                <span>Book Reserved (Queue Active)</span>
                                            </div>
                                        @else
                                            <form action="{{ $reserveRoute }}" method="POST" class="w-full sm:w-auto">
                                                @csrf
                                                <button type="submit" class="w-full sm:w-auto px-6 py-3 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-fuchsia-600 to-violet-600 hover:from-fuchsia-500 hover:to-violet-500 rounded-xl shadow-[0_0_20px_rgba(217,70,239,0.4)] transition-all duration-300 flex items-center justify-center gap-2 transform active:scale-[0.98]">
                                                    <i class="fa-solid fa-bookmark text-sm"></i> {{ __('Reserve Book') }}
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ $borrowRoute }}" method="POST" class="w-full sm:w-auto">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $bookId }}">
                                            <button type="submit" class="w-full sm:w-auto px-6 py-3 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-emerald-500 via-teal-600 to-cyan-600 hover:from-emerald-400 hover:via-teal-500 hover:to-cyan-500 rounded-xl shadow-[0_0_20px_rgba(16,185,129,0.4)] transition-all duration-300 flex items-center justify-center gap-2 transform active:scale-[0.98]">
                                                <i class="fa-solid fa-hand-holding-hand text-sm"></i> {{ __('Request to Borrow') }}
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                @if($filePath && ($isAdmin || $userActiveIssue))
                                    <a href="{{ $readRoute }}" class="w-full sm:w-auto px-6 py-3 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 rounded-xl shadow-[0_0_20px_rgba(168,85,247,0.4)] dark:shadow-[0_0_20px_rgba(34,211,238,0.4)] hover:shadow-[0_0_25px_rgba(34,211,238,0.7)] border border-fuchsia-300/30 dark:border-cyan-300/30 transition-all duration-300 flex items-center justify-center gap-2 transform active:scale-[0.98]">
                                        <i class="fa-solid fa-book-open-reader text-sm"></i> {{ __('Read Digital Copy') }}
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="p-4 bg-violet-500/10 dark:bg-cyan-950/40 border border-violet-500/20 dark:border-cyan-500/30 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-3">
                                <div class="text-xs text-gray-700 dark:text-gray-300">
                                    <span class="font-bold text-violet-700 dark:text-cyan-400">{{ __('Want to borrow or read this book?') }}</span> {{ __('Please sign in to your library account.') }}
                                </div>
                                <a href="{{ route('login') }}" class="px-5 py-2 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 to-cyan-500 hover:from-violet-500 hover:to-cyan-400 rounded-xl shadow-[0_0_15px_rgba(34,211,238,0.4)] transition-all duration-300">
                                    {{ __('Sign In') }} &rarr;
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        ['flash-success', 'flash-error'].forEach(function(id) {
            let alertBox = document.getElementById(id);
            if (alertBox) {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }
        });
    }, 4000);
</script>
@endsection