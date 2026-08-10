@extends('layouts.app')
@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h2 class="font-black text-2xl bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-cyan-400 bg-clip-text text-transparent tracking-tight leading-tight flex items-center gap-2">
        <i class="fa-solid fa-plus text-violet-600 dark:text-cyan-400 drop-shadow-[0_0_10px_rgba(34,211,238,0.5)]"></i> {{ __('Add New Book') }}
    </h2>
    <a href="{{ Route::has('admin.books.index') ? route('admin.books.index') : (Route::has('books.index') ? route('books.index') : url('/books')) }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300/50 dark:border-gray-700 rounded-xl shadow-[0_0_10px_rgba(255,255,255,0.05)] hover:shadow-[0_0_15px_rgba(168,85,247,0.4)] transition-all duration-300 flex items-center gap-1.5 w-fit">
        <i class="fa-solid fa-arrow-left"></i> {{ __('Back to List') }}
    </a>
</div>
@endsection
@section('content')
@php
    $storeRoute = Route::has('admin.books.store') ? route('admin.books.store') : (Route::has('books.store') ? route('books.store') : url('/books'));
@endphp
<div class="max-w-5xl mx-auto space-y-6">
    <div class="relative w-full">
        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 opacity-20 dark:opacity-35 blur-xl transition-all duration-500 pointer-events-none"></div>
        <div class="relative bg-white/90 dark:bg-gray-950/80 backdrop-blur-xl overflow-hidden shadow-[0_0_25px_rgba(139,92,246,0.15)] dark:shadow-[0_0_35px_rgba(6,182,212,0.15)] rounded-2xl border border-violet-500/20 dark:border-cyan-500/30 p-6 md:p-8 transition-all duration-300">
            <form action="{{ $storeRoute }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <x-input-label for="title" :value="__('Book Title *')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 focus:bg-white dark:focus:bg-gray-950 transition-all duration-200" required>
                        @error('title') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="isbn" :value="__('ISBN *')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 focus:bg-white dark:focus:bg-gray-950 transition-all duration-200 font-mono" required>
                        @error('isbn') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="category_id" :value="__('Category *')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <select id="category_id" name="category_id" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 transition-all duration-200" required>
                            <option value="">Select Category</option>
                            @foreach($categories ?? [] as $category)
                            <option value="{{ data_get($category, 'id') }}" {{ old('category_id') == data_get($category, 'id') ? 'selected' : '' }}>{{ data_get($category, 'name') }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="author_id" :value="__('Author *')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <select id="author_id" name="author_id" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 transition-all duration-200" required>
                            <option value="">Select Author</option>
                            @foreach($authors ?? [] as $author)
                            <option value="{{ data_get($author, 'id') }}" {{ old('author_id') == data_get($author, 'id') ? 'selected' : '' }}>{{ data_get($author, 'name') }}</option>
                            @endforeach
                        </select>
                        @error('author_id') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="publisher_id" :value="__('Publisher *')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <select id="publisher_id" name="publisher_id" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 transition-all duration-200" required>
                            <option value="">Select Publisher</option>
                            @foreach($publishers ?? [] as $publisher)
                            <option value="{{ data_get($publisher, 'id') }}" {{ old('publisher_id') == data_get($publisher, 'id') ? 'selected' : '' }}>{{ data_get($publisher, 'name') }}</option>
                            @endforeach
                        </select>
                        @error('publisher_id') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="edition" :value="__('Edition')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="text" id="edition" name="edition" value="{{ old('edition') }}" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 focus:bg-white dark:focus:bg-gray-950 transition-all duration-200">
                        @error('edition') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="language" :value="__('Language *')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="text" id="language" name="language" value="{{ old('language', 'English') }}" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 focus:bg-white dark:focus:bg-gray-950 transition-all duration-200" required>
                        @error('language') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="price" :value="__('Price (₹) *')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="number" id="price" step="0.01" name="price" value="{{ old('price') }}" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 focus:bg-white dark:focus:bg-gray-950 transition-all duration-200 font-mono" required>
                        @error('price') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="quantity" :value="__('Total Quantity *')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 focus:bg-white dark:focus:bg-gray-950 transition-all duration-200 font-mono" required>
                        @error('quantity') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="publish_year" :value="__('Publish Year')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="number" id="publish_year" name="publish_year" value="{{ old('publish_year') }}" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 focus:bg-white dark:focus:bg-gray-950 transition-all duration-200 font-mono">
                        @error('publish_year') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="cover_image" :value="__('Cover Image')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-wider file:bg-violet-500/10 file:text-violet-600 dark:file:bg-cyan-950/80 dark:file:text-cyan-300 hover:file:bg-violet-500/20 dark:hover:file:bg-cyan-900/80 border border-violet-200 dark:border-gray-800 rounded-xl bg-gray-50/80 dark:bg-gray-900/80 cursor-pointer transition-all duration-200">
                        @error('cover_image') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-label for="file_path" :value="__('Digital Book (PDF, EPUB etc.)')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <input type="file" id="file_path" name="file_path" accept=".pdf,.epub,.txt,.doc,.docx,.rtf,.odt,.djvu" class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-wider file:bg-violet-500/10 file:text-violet-600 dark:file:bg-cyan-950/80 dark:file:text-cyan-300 hover:file:bg-violet-500/20 dark:hover:file:bg-cyan-900/80 border border-violet-200 dark:border-gray-800 rounded-xl bg-gray-50/80 dark:bg-gray-900/80 cursor-pointer transition-all duration-200">
                        @error('file_path') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <x-input-label for="description" :value="__('Description')" class="text-gray-700 dark:text-gray-300 font-bold text-xs uppercase tracking-wider" />
                        <textarea id="description" name="description" rows="4" class="block w-full px-3 py-2 bg-gray-50/80 dark:bg-gray-900/80 border border-violet-200 dark:border-gray-800 text-gray-900 dark:text-gray-100 text-xs rounded-xl focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 dark:focus:ring-cyan-400 focus:bg-white dark:focus:bg-gray-950 transition-all duration-200">{{ old('description') }}</textarea>
                        @error('description') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-violet-100 dark:border-cyan-950/80">
                    <a href="{{ Route::has('admin.books.index') ? route('admin.books.index') : (Route::has('books.index') ? route('books.index') : url('/books')) }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold uppercase tracking-wider rounded-xl border border-gray-300/60 dark:border-gray-700 shadow-[0_0_10px_rgba(255,255,255,0.05)] hover:shadow-[0_0_15px_rgba(168,85,247,0.4)] transition-all duration-300 flex items-center gap-1.5">
                        <i class="fa-solid fa-xmark"></i> {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-violet-600 via-fuchsia-600 to-cyan-500 hover:from-violet-500 hover:via-fuchsia-500 hover:to-cyan-400 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-[0_0_20px_rgba(168,85,247,0.5)] dark:shadow-[0_0_20px_rgba(34,211,238,0.4)] hover:shadow-[0_0_25px_rgba(34,211,238,0.7)] border border-fuchsia-300/30 dark:border-cyan-300/30 transition-all duration-300 flex items-center gap-1.5 transform active:scale-[0.99]">
                        <i class="fa-solid fa-floppy-disk"></i> {{ __('Save Book') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection