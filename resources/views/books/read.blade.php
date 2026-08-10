@extends('layouts.app')

@section('header')
@php
    $bookId = data_get($book, 'id');
    $bookTitle = data_get($book, 'title', 'Untitled');
    $bookIsbn = data_get($book, 'isbn', 'N/A');
    $categoryName = data_get($book, 'category.name');

    if (Route::has('member.books.stream') && auth()->user() && strtolower(auth()->user()->role ?? '') !== 'admin') {
        $streamRoute = route('member.books.stream', $bookId);
    } elseif (Route::has('books.stream')) {
        $streamRoute = route('books.stream', $bookId);
    } else {
        $streamRoute = url("/books/{$bookId}/stream");
    }
@endphp
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-3 min-w-0">
        <a href="{{ url()->previous() }}" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded-xl transition-all duration-200 shrink-0">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h2 class="font-black text-lg md:text-xl bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight leading-tight truncate">
            {{ $bookTitle }}
        </h2>
    </div>
    <div class="flex flex-wrap items-center gap-2 shrink-0">
        <span class="px-3 py-1 bg-violet-500/10 dark:bg-cyan-950/60 text-violet-700 dark:text-cyan-300 rounded-lg text-xs font-semibold border border-violet-200 dark:border-cyan-800/50">
            ISBN: {{ $bookIsbn }}
        </span>
        @if($categoryName)
        <span class="px-3 py-1 bg-fuchsia-500/10 text-fuchsia-700 dark:text-fuchsia-300 rounded-lg text-xs font-semibold border border-fuchsia-200 dark:border-fuchsia-800/50">
            {{ $categoryName }}
        </span>
        @endif
        <a href="{{ $streamRoute }}" target="_blank" class="px-4 py-2 bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-[0_0_15px_rgba(168,85,247,0.4)] dark:shadow-[0_0_15px_rgba(34,211,238,0.3)] transition-all duration-300 flex items-center gap-1.5 transform active:scale-[0.98]">
            <i class="fa-solid fa-up-right-from-square"></i> {{ __('Full Screen') }}
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-4">
    <div class="relative w-full h-[calc(100vh-14rem)] min-h-[500px] md:min-h-[650px] rounded-2xl overflow-hidden border border-violet-500/20 dark:border-cyan-500/30 shadow-[0_0_30px_rgba(139,92,246,0.15)] bg-gray-950 transition-all duration-300">
        <iframe 
            src="{{ $streamRoute }}" 
            class="absolute inset-0 w-full h-full border-0" 
            title="{{ $bookTitle }}">
            <p class="text-white p-6 text-center">
                Your browser does not support embedded PDFs. 
                <a href="{{ $streamRoute }}" class="text-cyan-400 underline">Click here to download/view the file directly.</a>
            </p>
        </iframe>
    </div>
</div>
@endsection