@extends('layouts.app')

@section('header')
@php
    $user = auth()->user();
    $isAdmin = $user && (strtolower($user->role ?? '') === 'admin' || (bool) $user->is_admin);
    $isMember = $user && !$isAdmin;

    if ($isMember && Route::has('member.books.index')) {
        $catalogRoute = route('member.books.index');
    } elseif ($isAdmin && Route::has('admin.books.index')) {
        $catalogRoute = route('admin.books.index');
    } elseif (Route::has('books.index')) {
        $catalogRoute = route('books.index');
    } else {
        $catalogRoute = '#';
    }
@endphp

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h2 class="font-black text-2xl bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight leading-tight flex items-center gap-2">
        <i class="fa-solid fa-book text-violet-600 dark:text-cyan-400 drop-shadow-[0_0_10px_rgba(34,211,238,0.5)]"></i> {{ __('Library Catalog') }}
    </h2>
    @auth
    @if($isAdmin && Route::has('books.create'))
    <a href="{{ route('books.create') }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 rounded-xl shadow-[0_0_20px_rgba(168,85,247,0.5)] dark:shadow-[0_0_20px_rgba(34,211,238,0.4)] hover:shadow-[0_0_25px_rgba(34,211,238,0.7)] border border-fuchsia-300/30 dark:border-cyan-300/30 transition-all duration-300 flex items-center gap-1.5 w-fit transform active:scale-[0.99]">
        <i class="fa-solid fa-plus"></i> {{ __('Add New Book') }}
    </a>
    @endif
    @endauth
</div>
@endsection

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
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

    <!-- Search & Filters Block -->
    <div class="relative w-full">
        <div class="absolute -inset-0.5 rounded-2xl bg-gradient-to-r from-violet-600/30 via-fuchsia-600/30 to-cyan-500/30 blur-md transition-all pointer-events-none"></div>
        <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl p-4 rounded-2xl shadow-[0_0_20px_rgba(139,92,246,0.1)] dark:shadow-[0_0_25px_rgba(6,182,212,0.1)] border border-violet-500/20 dark:border-cyan-500/30 transition-colors duration-300">
            <form method="GET" action="{{ $catalogRoute }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-violet-500 dark:text-cyan-400">
                            <i class="fa-solid fa-magnifying-glass text-xs drop-shadow-[0_0_5px_rgba(34,211,238,0.5)]"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, ISBN, author, or publisher..." class="w-full pl-9 pr-3 py-2 text-xs bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 transition-all duration-200">
                    </div>
                </div>
                <div class="w-full md:w-64">
                    <select name="category_id" class="w-full px-3 py-2 text-xs bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 transition-all duration-200">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                        <option value="{{ data_get($category, 'id') }}" {{ (request('category_id') == data_get($category, 'id') || request('category') == data_get($category, 'slug')) ? 'selected' : '' }}>
                            {{ data_get($category, 'name') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-[0_0_15px_rgba(168,85,247,0.4)] dark:shadow-[0_0_15px_rgba(34,211,238,0.3)] transition-all duration-300 flex items-center gap-1.5 transform active:scale-[0.98]">
                        <i class="fa-solid fa-filter"></i> {{ __('Filter') }}
                    </button>
                    @if(request('search') || request('category_id') || request('category'))
                    <a href="{{ $catalogRoute }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider rounded-xl border border-gray-300/60 dark:border-gray-700 shadow-[0_0_10px_rgba(255,255,255,0.05)] hover:shadow-[0_0_15px_rgba(168,85,247,0.4)] transition-all duration-300 flex items-center gap-1.5">
                        <i class="fa-solid fa-rotate-right"></i> {{ __('Reset') }}
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Books Table -->
    <div class="relative w-full">
        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600/20 via-fuchsia-600/20 to-cyan-500/20 blur-xl pointer-events-none"></div>
        <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl overflow-hidden shadow-[0_0_25px_rgba(139,92,246,0.12)] dark:shadow-[0_0_35px_rgba(6,182,212,0.12)] rounded-2xl border border-violet-500/20 dark:border-cyan-500/30 transition-all duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-violet-100 dark:divide-gray-800/80 text-left">
                    <thead>
                        <tr class="bg-violet-50/50 dark:bg-gray-900/90 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-violet-100 dark:border-gray-800">
                            <th class="px-6 py-4">Cover</th>
                            <th class="px-6 py-4">Title / ISBN</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Author</th>
                            <th class="px-6 py-4">Stock</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-violet-100/60 dark:divide-gray-800/60 text-xs">
                        @forelse ($books ?? [] as $book)
                        @php
                            $authorName = is_object(data_get($book, 'author')) ? data_get($book, 'author.name', 'N/A') : (data_get($book, 'author') ?? 'N/A');
                            $bookId = data_get($book, 'id');
                            $filePath = data_get($book, 'file_path');
                            $availableQty = data_get($book, 'available_quantity', 0);

                            // Active Issue & Status Flags
                            $userActiveIssue = data_get($book, 'user_active_issue');
                            $userHasUnpaidFine = data_get($book, 'user_has_unpaid_fine', false);
                            $userReserved = data_get($book, 'user_reserved', false);

                            // Route Resolvers
                            $borrowRoute = Route::has('books.borrow') ? route('books.borrow', $bookId) : (Route::has('member.books.borrow') ? route('member.books.borrow', $bookId) : url("/books/{$bookId}/borrow"));
                            $returnRoute = Route::has('books.return') ? route('books.return', $bookId) : (Route::has('member.books.return') ? route('member.books.return', $bookId) : url("/books/{$bookId}/return"));
                            $reserveRoute = Route::has('books.reserve') ? route('books.reserve', $bookId) : (Route::has('member.books.reserve') ? route('member.books.reserve', $bookId) : url("/books/{$bookId}/reserve"));

                            if (Route::has('member.books.read') && $isMember) {
                                $readRoute = route('member.books.read', $bookId);
                            } elseif (Route::has('books.read')) {
                                $readRoute = route('books.read', $bookId);
                            } else {
                                $readRoute = url("/books/{$bookId}/read");
                            }
                        @endphp
                        <tr class="hover:bg-violet-50/40 dark:hover:bg-cyan-950/20 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(!empty(data_get($book, 'cover_image')))
                                <img src="{{ asset('storage/' . data_get($book, 'cover_image')) }}" alt="Cover" class="h-12 w-9 object-cover rounded-lg shadow-md border border-violet-300/40 dark:border-cyan-500/40">
                                @else
                                <div class="h-12 w-9 bg-gray-100/80 dark:bg-gray-900/80 rounded-lg border border-violet-200 dark:border-gray-800 flex flex-col items-center justify-center text-[9px] text-gray-400 dark:text-gray-500 font-medium">
                                    <i class="fa-regular fa-image text-xs mb-0.5 text-violet-400 dark:text-cyan-400"></i>
                                    <span>No Cover</span>
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-gray-100">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>{{ data_get($book, 'title', 'Untitled') }}</span>
                                    @if(!empty($filePath))
                                    <span class="px-1.5 py-0.5 text-[9px] font-black uppercase tracking-wider bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/30 rounded-md whitespace-nowrap">E-Book</span>
                                    @endif
                                </div>
                                <div class="text-[11px] font-mono font-normal text-violet-600 dark:text-cyan-400/90 mt-0.5">ISBN: {{ data_get($book, 'isbn', 'N/A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                <span class="px-2.5 py-1 bg-violet-500/10 dark:bg-cyan-950/60 text-violet-700 dark:text-cyan-300 rounded-lg text-[11px] font-semibold border border-violet-200 dark:border-cyan-800/50 shadow-[0_0_10px_rgba(168,85,247,0.1)]">
                                    {{ data_get($book, 'category.name', 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300 font-medium">
                                {{ $authorName }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold font-mono {{ $availableQty > 0 ? 'text-emerald-600 dark:text-emerald-400 drop-shadow-[0_0_8px_rgba(52,211,153,0.5)]' : 'text-rose-600 dark:text-rose-400 drop-shadow-[0_0_8px_rgba(244,63,94,0.5)]' }}">
                                    {{ $availableQty }}
                                </span>
                                <span class="text-gray-400 dark:text-gray-500 font-mono">/ {{ data_get($book, 'quantity', 0) }} Total</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Read E-Book Button --}}
                                    @if(!empty($filePath))
                                    <a href="{{ $readRoute }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:to-cyan-400 rounded-lg shadow-[0_0_10px_rgba(168,85,247,0.4)] transition-all duration-200 hover:scale-105"
                                        title="Read E-Book">
                                        <i class="fa-solid fa-book-open-reader text-xs"></i>
                                        <span>Read</span>
                                    </a>
                                    @endif

                                    {{-- View Details Button --}}
                                    @if(Route::has('books.show'))
                                    <a href="{{ route('books.show', $bookId) }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-semibold text-cyan-600 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-200 bg-cyan-500/10 hover:bg-cyan-500/20 rounded-lg border border-cyan-500/30 transition-all duration-200 hover:scale-105"
                                        title="View Book Details">
                                        <i class="fa-solid fa-eye text-xs drop-shadow-[0_0_8px_rgba(34,211,238,0.5)]"></i>
                                        <span>View</span>
                                    </a>
                                    @endif

                                    @auth
                                    {{-- ADMIN ACTIONS --}}
                                    @if($isAdmin)
                                        @if(Route::has('books.edit'))
                                        <a href="{{ route('books.edit', $bookId) }}"
                                            class="p-2 text-violet-600 dark:text-fuchsia-400 hover:text-fuchsia-600 dark:hover:text-fuchsia-300 rounded-lg hover:bg-fuchsia-500/10 transition-all duration-200 hover:scale-110"
                                            title="Edit Book">
                                            <i class="fa-solid fa-pen-to-square text-xs drop-shadow-[0_0_8px_rgba(217,70,239,0.4)]"></i>
                                        </a>
                                        @endif
                                        @if(Route::has('books.destroy'))
                                        <form action="{{ route('books.destroy', $bookId) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-rose-500 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 rounded-lg hover:bg-rose-500/10 transition-all duration-200 hover:scale-110"
                                                title="Delete Book">
                                                <i class="fa-solid fa-trash-can text-xs drop-shadow-[0_0_8px_rgba(244,63,94,0.4)]"></i>
                                            </button>
                                        </form>
                                        @endif

                                    {{-- MEMBER ACTIONS (DYNAMIC CTAs) --}}
                                    @elseif($isMember)
                                        @if($userHasUnpaidFine)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold text-amber-600 dark:text-amber-400 bg-amber-500/10 border border-amber-500/30 rounded-lg" title="Pay pending fines to borrow again">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                                <span>Blocked: Fine Due</span>
                                            </span>
                                        @elseif($userActiveIssue)
                                            @if(data_get($userActiveIssue, 'status') === 'pending')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold text-cyan-600 dark:text-cyan-400 bg-cyan-500/10 border border-cyan-500/30 rounded-lg">
                                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                                    <span>Pending Approval</span>
                                                </span>
                                            @else
                                                <form action="{{ $returnRoute }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 rounded-lg shadow-[0_0_12px_rgba(16,185,129,0.4)] transition-all duration-200 hover:scale-105 active:scale-95">
                                                        <i class="fa-solid fa-rotate-left text-xs"></i>
                                                        <span>Return Book</span>
                                                    </button>
                                                </form>
                                            @endif
                                        @elseif($availableQty <= 0)
                                            @if($userReserved)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-bold text-violet-600 dark:text-fuchsia-400 bg-fuchsia-500/10 border border-fuchsia-500/30 rounded-lg">
                                                    <i class="fa-solid fa-bookmark"></i>
                                                    <span>Reserved</span>
                                                </span>
                                            @else
                                                <form action="{{ $reserveRoute }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-fuchsia-600 to-violet-600 hover:from-fuchsia-500 hover:to-violet-500 rounded-lg shadow-[0_0_12px_rgba(217,70,239,0.4)] transition-all duration-200 hover:scale-105 active:scale-95">
                                                        <i class="fa-solid fa-bookmark text-xs"></i>
                                                        <span>Reserve</span>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <form action="{{ $borrowRoute }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 rounded-lg shadow-[0_0_12px_rgba(6,182,212,0.4)] transition-all duration-200 hover:scale-105 active:scale-95">
                                                        <i class="fa-solid fa-hand-holding-hand text-xs"></i>
                                                        <span>Borrow</span>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                    @else
                                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 rounded-lg hover:text-cyan-500 transition-all">
                                        <i class="fa-solid fa-right-to-bracket text-xs"></i>
                                        <span>Login to Borrow</span>
                                    </a>
                                    @endauth
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-book-open text-3xl bg-gradient-to-r from-violet-500 to-cyan-400 bg-clip-text text-transparent opacity-60"></i>
                                    <p class="font-medium">No books found in catalog.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($books, 'hasPages') && $books->hasPages())
            <div class="px-6 py-4 border-t border-violet-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/40">
                {{ $books->withQueryString()->links() }}
            </div>
            @endif
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