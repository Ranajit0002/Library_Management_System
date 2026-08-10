@php
$user = auth()->user();
$isAdmin = $user && ($user->is_admin || strtolower($user->role ?? '') === 'admin' || (method_exists($user, 'isAdmin') && $user->isAdmin()));
$isMember = $user && !$isAdmin;

$isInAdminBackend = request()->is('admin*') || request()->routeIs('admin.*');
$isInMemberPortal = request()->is('member*') || request()->routeIs('member.*');
$isInBackend = $isInAdminBackend || $isInMemberPortal;

$adminDashRoute = Route::has('admin.dashboard') ? route('admin.dashboard') : (Route::has('dashboard') ? route('dashboard') : '#');
$memberDashRoute = Route::has('member.dashboard') ? route('member.dashboard') : (Route::has('dashboard') ? route('dashboard') : '#');
$frontendHomeRoute = Route::has('home') ? route('home') : url('/');

$adminBooksRoute = Route::has('admin.books.index') ? route('admin.books.index') : url('/admin/books');
$adminCategoriesRoute = Route::has('admin.categories.index') ? route('admin.categories.index') : url('/admin/categories');
$adminMembersRoute = Route::has('admin.members.index') ? route('admin.members.index') : (Route::has('admin.users.index') ? route('admin.users.index') : url('/admin/members'));
$adminPublishersRoute = Route::has('admin.publishers.index') ? route('admin.publishers.index') : url('/admin/publishers');
$adminAuthorsRoute = Route::has('admin.authors.index') ? route('admin.authors.index') : url('/admin/authors');
$adminBookIssuesRoute = Route::has('admin.book_issues.index') ? route('admin.book_issues.index') : (Route::has('admin.issues.index') ? route('admin.issues.index') : url('/admin/book-issues'));
$adminReservationsRoute = Route::has('admin.reservations.index') ? route('admin.reservations.index') : (Route::has('reservations.index') ? route('reservations.index') : url('/admin/reservations'));
$adminFinesRoute = Route::has('admin.fines.index') ? route('admin.fines.index') : url('/admin/fines');
$adminReportsRoute = Route::has('admin.reports.index') ? route('admin.reports.index') : (Route::has('admin.reports') ? route('admin.reports') : url('/admin/reports'));

$publicBooksRoute = Route::has('books.index') ? route('books.index') : (Route::has('books.catalog') ? route('books.catalog') : url('/books'));
$memberBooksRoute = $isInMemberPortal ? (Route::has('member.books.index') ? route('member.books.index') : url('/member/books')) : $publicBooksRoute;

$backendBorrowingsRoute = Route::has('member.book_issues.my') ? route('member.book_issues.my')
    : (Route::has('member.book_issues.index') ? route('member.book_issues.index')
    : (Route::has('member.borrowings') ? route('member.borrowings')
    : (Route::has('book_issues.my') ? route('book_issues.my') : url('/member/book-issues/my'))));

$backendReservationsRoute = Route::has('member.reservations.my') ? route('member.reservations.my')
    : (Route::has('reservations.my') ? route('reservations.my') : url('/member/reservations/my'));

$backendFinesRoute = Route::has('member.fines.index') ? route('member.fines.index') : url('/member/fines');

$publicBorrowingsRoute = Route::has('books.my-borrowings') ? route('books.my-borrowings') : url('/my-borrowings');
$publicReservationsRoute = Route::has('books.my-reservations') ? route('books.my-reservations') : url('/my-reservations');
$publicFinesRoute = Route::has('books.my-fines') ? route('books.my-fines') : url('/my-fines');

$myBorrowingsRoute = $isInMemberPortal ? $backendBorrowingsRoute : $publicBorrowingsRoute;
$myReservationsRoute = $isInMemberPortal ? $backendReservationsRoute : $publicReservationsRoute;
$myFinesRoute = $isInMemberPortal ? $backendFinesRoute : $publicFinesRoute;

$notificationsRoute = Route::has('notifications.index') ? route('notifications.index') : url('/notifications');
$unreadNotificationCount = ($user && method_exists($user, 'unreadNotifications')) ? $user->unreadNotifications()->count() : 0;

$isManageActive = request()->routeIs('admin.categories.*') || request()->routeIs('admin.authors.*') || request()->routeIs('admin.publishers.*');
$isCirculationActive = request()->routeIs('admin.book_issues.*') || request()->routeIs('admin.issues.*') || request()->routeIs('admin.reservations.*') || request()->routeIs('reservations.*');
$isBorrowingsActive = request()->routeIs('member.book_issues.*') || request()->routeIs('book_issues.*') || request()->routeIs('member.borrowings*') || request()->routeIs('books.my-borrowings');
$isReservationsActive = request()->routeIs('member.reservations.*') || request()->routeIs('admin.reservations.*') || request()->routeIs('reservations.*') || request()->routeIs('books.my-reservations');
$isFinesActive = request()->routeIs('*fines*') || request()->routeIs('books.my-fines');
@endphp

<nav x-data="{ open: false }" class="bg-white/90 dark:bg-gray-900/90 border-b border-gray-200 dark:border-cyan-500/30 sticky top-0 z-50 backdrop-blur-md transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-2">
            <div class="flex items-center space-x-3 lg:space-x-6 min-w-0">
                <div class="shrink-0 flex items-center">
                    <a href="{{ $isInAdminBackend ? $adminDashRoute : ($isInMemberPortal ? $memberDashRoute : $frontendHomeRoute) }}" class="font-extrabold text-base sm:text-lg lg:text-xl text-indigo-600 dark:text-cyan-400 tracking-wider flex items-center gap-2 group transition-all duration-300 whitespace-nowrap">
                        <i class="fa-solid fa-book-open-reader text-indigo-500 dark:text-cyan-400 drop-shadow-[0_0_8px_rgba(6,182,212,0.8)] group-hover:scale-110 transition-transform"></i>
                        <span class="dark:drop-shadow-[0_0_10px_rgba(6,182,212,0.6)]">
                            {{ $isInAdminBackend ? __('Admin Portal') : ($isInMemberPortal ? __('Member Portal') : __('L-M-S')) }}
                        </span>
                    </a>
                </div>
                <div class="hidden xl:flex space-x-3 lg:space-x-4 items-center">
                    @if(!$isInBackend)
                    <a href="{{ $frontendHomeRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') || request()->is('/') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-house mr-1.5 text-xs"></i>{{ __('Home') }}
                    </a>
                    <a href="{{ $publicBooksRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('books.*') && !request()->routeIs('books.my-*') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-book-open mr-1.5 text-xs"></i>{{ __('Catalog') }}
                    </a>
                    @auth
                    @if($isMember)
                    <a href="{{ $myBorrowingsRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ $isBorrowingsActive ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-hand-holding-hand mr-1.5 text-xs"></i>{{ __('Borrowings') }}
                    </a>
                    <a href="{{ $myReservationsRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ $isReservationsActive ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-bookmark mr-1.5 text-xs"></i>{{ __('Reservations') }}
                    </a>
                    <a href="{{ $myFinesRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ $isFinesActive ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-coins mr-1.5 text-xs"></i>{{ __('Fines') }}
                    </a>
                    @endif
                    @endauth
                    @elseif($isInAdminBackend)
                    <a href="{{ $adminDashRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-chart-pie mr-1.5 text-xs"></i>{{ __('Dashboard') }}
                    </a>
                    <a href="{{ $adminBooksRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.books.*') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-book mr-1.5 text-xs"></i>{{ __('Books') }}
                    </a>
                    <div class="relative inline-flex items-center h-full" x-data="{ circulationMenu: false }" @click.outside="circulationMenu = false" @keydown.escape.window="circulationMenu = false">
                        <button @click.prevent="circulationMenu = !circulationMenu" type="button" class="inline-flex items-center px-1 pt-1 border-b-2 {{ $isCirculationActive ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 focus:outline-none whitespace-nowrap">
                            <i class="fa-solid fa-hand-holding-hand mr-1.5 text-xs"></i>
                            <span>{{ __('Circulation') }}</span>
                            <i class="fa-solid fa-chevron-down ml-1.5 text-[10px] transition-transform duration-200" :class="circulationMenu ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="circulationMenu" x-cloak x-transition class="absolute top-14 left-0 w-48 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-cyan-500/40 shadow-xl py-2 z-50 backdrop-blur-lg">
                            <a href="{{ $adminBookIssuesRoute }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="circulationMenu = false">
                                <i class="fa-solid fa-hand-holding-hand w-5 text-indigo-500 dark:text-cyan-400 text-xs"></i>
                                <span>{{ __('Book Issues') }}</span>
                            </a>
                            <a href="{{ $adminReservationsRoute }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="circulationMenu = false">
                                <i class="fa-solid fa-clock-rotate-left w-5 text-indigo-500 dark:text-cyan-400 text-xs"></i>
                                <span>{{ __('Reservations') }}</span>
                            </a>
                        </div>
                    </div>
                    <a href="{{ $adminFinesRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.fines.*') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-coins mr-1.5 text-xs"></i>{{ __('Fines') }}
                    </a>
                    <div class="relative inline-flex items-center h-full" x-data="{ manageMenu: false }" @click.outside="manageMenu = false" @keydown.escape.window="manageMenu = false">
                        <button @click.prevent="manageMenu = !manageMenu" type="button" class="inline-flex items-center px-1 pt-1 border-b-2 {{ $isManageActive ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 focus:outline-none whitespace-nowrap">
                            <i class="fa-solid fa-sliders mr-1.5 text-xs"></i>
                            <span>{{ __('Manage') }}</span>
                            <i class="fa-solid fa-chevron-down ml-1.5 text-[10px] transition-transform duration-200" :class="manageMenu ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="manageMenu" x-cloak x-transition class="absolute top-14 left-0 w-48 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-cyan-500/40 shadow-xl py-2 z-50 backdrop-blur-lg">
                            <a href="{{ $adminCategoriesRoute }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="manageMenu = false">
                                <i class="fa-solid fa-layer-group w-5 text-indigo-500 dark:text-cyan-400 text-xs"></i>
                                <span>{{ __('Categories') }}</span>
                            </a>
                            <a href="{{ $adminAuthorsRoute }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="manageMenu = false">
                                <i class="fa-solid fa-feather-pointed w-5 text-indigo-500 dark:text-cyan-400 text-xs"></i>
                                <span>{{ __('Authors') }}</span>
                            </a>
                            <a href="{{ $adminPublishersRoute }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="manageMenu = false">
                                <i class="fa-solid fa-building w-5 text-indigo-500 dark:text-cyan-400 text-xs"></i>
                                <span>{{ __('Publishers') }}</span>
                            </a>
                        </div>
                    </div>
                    <a href="{{ $adminMembersRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.members.*') || request()->routeIs('admin.users.*') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-users mr-1.5 text-xs"></i>{{ __('Members') }}
                    </a>
                    <a href="{{ $adminReportsRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.reports.*') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-file-invoice mr-1.5 text-xs"></i>{{ __('Reports') }}
                    </a>
                    @elseif($isInMemberPortal)
                    <a href="{{ $memberDashRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('member.dashboard') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-gauge-high mr-1.5 text-xs"></i>{{ __('Dashboard') }}
                    </a>
                    <a href="{{ $memberBooksRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('member.books.*') ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-book-open mr-1.5 text-xs"></i>{{ __('Catalog') }}
                    </a>
                    <a href="{{ $backendBorrowingsRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ $isBorrowingsActive ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-hand-holding-hand mr-1.5 text-xs"></i>{{ __('Borrowings') }}
                    </a>
                    <a href="{{ $backendReservationsRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ $isReservationsActive ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-bookmark mr-1.5 text-xs"></i>{{ __('Reservations') }}
                    </a>
                    <a href="{{ $backendFinesRoute }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ $isFinesActive ? 'border-cyan-500 text-indigo-600 dark:text-cyan-300 font-semibold drop-shadow-[0_0_8px_rgba(6,182,212,0.6)]' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-cyan-400 hover:border-indigo-400 dark:hover:border-cyan-400' }} text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fa-solid fa-coins mr-1.5 text-xs"></i>{{ __('Fines') }}
                    </a>
                    @endif
                </div>
            </div>
            <div class="hidden xl:flex items-center space-x-3 shrink-0">
                @auth
                <a href="{{ $notificationsRoute }}" class="relative w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 text-indigo-600 dark:text-cyan-400 border border-gray-300 dark:border-cyan-500/50 flex items-center justify-center text-base shadow-sm hover:shadow-[0_0_15px_rgba(6,182,212,0.6)] active:scale-95 transition-all duration-300 focus:outline-none" title="Notifications">
                    <i class="fa-solid fa-bell"></i>
                    @if($unreadNotificationCount > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[9px] font-black text-white shadow-[0_0_8px_rgba(244,63,94,0.8)] animate-pulse">
                        {{ $unreadNotificationCount }}
                    </span>
                    @endif
                </a>
                @endauth
                <button onclick="cycleTheme()" class="themeToggleBtn w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 text-indigo-600 dark:text-cyan-400 border border-gray-300 dark:border-cyan-500/50 flex items-center justify-center text-lg shadow-sm hover:shadow-[0_0_15px_rgba(6,182,212,0.6)] active:scale-95 transition-all duration-300 focus:outline-none" title="Change Theme">
                    <i class="fas fa-desktop"></i>
                </button>
                @auth
                <div class="relative" x-data="{ userMenu: false }" @click.outside="userMenu = false" @keydown.escape.window="userMenu = false">
                    <button @click.prevent="userMenu = !userMenu" type="button" class="flex items-center space-x-2 focus:outline-none bg-gray-100 dark:bg-gray-800/90 hover:bg-gray-200 dark:hover:bg-gray-800 border border-gray-200 dark:border-cyan-500/40 px-3 py-1.5 rounded-full transition-all duration-300">
                        @if (Auth::user()->avatar ?? false)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-7 h-7 rounded-full object-cover border border-indigo-500 dark:border-cyan-400">
                        @else
                        <div class="w-7 h-7 rounded-full bg-gradient-to-r from-indigo-600 to-fuchsia-600 dark:from-cyan-500 dark:to-fuchsia-500 text-white flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        @endif
                        <span class="text-xs font-medium text-gray-800 dark:text-gray-200 truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 transition-transform duration-200" :class="userMenu ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="userMenu" x-cloak x-transition class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-cyan-500/40 shadow-xl py-2 z-50 backdrop-blur-lg">
                        <div class="px-4 py-2 border-b border-gray-100 dark:border-cyan-500/20">
                            <p class="text-[10px] uppercase tracking-wider text-gray-400 dark:text-cyan-400/70 font-semibold">{{ __('Signed in as') }}</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        @if($isAdmin)
                            @if(!$isInAdminBackend)
                            <a href="{{ $adminDashRoute }}" class="block px-4 py-2 text-sm text-cyan-600 dark:text-cyan-400 font-semibold bg-cyan-50/50 dark:bg-cyan-950/20 hover:bg-cyan-100 dark:hover:bg-cyan-900/40" @click="userMenu = false">
                                <i class="fa-solid fa-shield-halved mr-2"></i>{{ __('Dashboard') }}
                            </a>
                            @else
                            <a href="{{ $frontendHomeRoute }}" class="block px-4 py-2 text-sm text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/40" @click="userMenu = false">
                                <i class="fa-solid fa-globe mr-2"></i>{{ __('Home') }}
                            </a>
                            @endif
                        @else
                            @if(!$isInMemberPortal)
                            <a href="{{ $memberDashRoute }}" class="block px-4 py-2 text-sm text-cyan-600 dark:text-cyan-400 font-semibold bg-cyan-50/50 dark:bg-cyan-950/20 hover:bg-cyan-100 dark:hover:bg-cyan-900/40" @click="userMenu = false">
                                <i class="fa-solid fa-gauge-high mr-2"></i>{{ __('Dashboard') }}
                            </a>
                            @else
                            <a href="{{ $frontendHomeRoute }}" class="block px-4 py-2 text-sm text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/40" @click="userMenu = false">
                                <i class="fa-solid fa-globe mr-2"></i>{{ __('Home') }}
                            </a>
                            @endif
                        @endif
                        <div class="border-t border-gray-100 dark:border-cyan-500/20 my-1"></div>
                        @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="userMenu = false">
                            <i class="fa-solid fa-user-gear mr-2 text-gray-400 dark:text-cyan-400"></i>{{ __('Profile Settings') }}
                        </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-fuchsia-400 hover:bg-red-50 dark:hover:bg-fuchsia-950/40 flex items-center" @click="userMenu = false">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i>{{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="flex items-center space-x-2">
                    <a href="{{ route('login') }}" class="px-3.5 py-1.5 text-xs font-semibold text-indigo-600 dark:text-cyan-300 border border-indigo-600 dark:border-cyan-400/80 rounded-xl hover:bg-indigo-50 dark:hover:bg-cyan-950/50 transition-all">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-indigo-600 dark:bg-gradient-to-r dark:from-cyan-500 dark:to-fuchsia-600 rounded-xl shadow-md transition-all">{{ __('Register') }}</a>
                </div>
                @endauth
            </div>
            <div class="flex items-center xl:hidden space-x-2 shrink-0">
                @auth
                <a href="{{ $notificationsRoute }}" class="relative w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 text-indigo-600 dark:text-cyan-400 border border-gray-300 dark:border-cyan-500/50 flex items-center justify-center text-base active:scale-95 transition-all" title="Notifications">
                    <i class="fa-solid fa-bell"></i>
                    @if($unreadNotificationCount > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[9px] font-black text-white shadow-[0_0_8px_rgba(244,63,94,0.8)] animate-pulse">
                        {{ $unreadNotificationCount }}
                    </span>
                    @endif
                </a>
                @endauth
                <button onclick="cycleTheme()" class="themeToggleBtn w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 text-indigo-600 dark:text-cyan-400 border border-gray-300 dark:border-cyan-500/50 flex items-center justify-center text-base active:scale-95 transition-all" title="Change Theme">
                    <i class="fas fa-desktop"></i>
                </button>
                <button @click.prevent="open = !open" type="button" class="text-gray-500 hover:text-indigo-600 dark:text-cyan-400 focus:outline-none p-2 rounded-lg">
                    <i class="fa-solid fa-bars text-xl" x-show="!open"></i>
                    <i class="fa-solid fa-xmark text-xl" x-show="open" x-cloak></i>
                </button>
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': !open}" class="hidden xl:hidden border-t border-gray-200 dark:border-cyan-500/30 bg-white dark:bg-gray-900/95 px-4 pt-3 pb-4 space-y-2 backdrop-blur-md">
        @auth
        @if($isAdmin)
            @if($isInAdminBackend)
            <a href="{{ $frontendHomeRoute }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-950/20 mb-1" @click="open = false">
                <i class="fa-solid fa-globe mr-2"></i>{{ __('Home') }}
            </a>
            @else
            <a href="{{ $adminDashRoute }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-cyan-600 dark:text-cyan-400 bg-cyan-50/50 dark:bg-cyan-950/20 mb-1" @click="open = false">
                <i class="fa-solid fa-shield-halved mr-2"></i>{{ __('Dashboard') }}
            </a>
            @endif
        @elseif($isMember)
            @if($isInMemberPortal)
            <a href="{{ $frontendHomeRoute }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-950/20 mb-1" @click="open = false">
                <i class="fa-solid fa-globe mr-2"></i>{{ __('Home') }}
            </a>
            @else
            <a href="{{ $memberDashRoute }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-cyan-600 dark:text-cyan-400 bg-cyan-50/50 dark:bg-cyan-950/20 mb-1" @click="open = false">
                <i class="fa-solid fa-gauge-high mr-2"></i>{{ __('Dashboard') }}
            </a>
            @endif
        @endif
        @endauth

        @if(!$isInBackend)
        <a href="{{ $frontendHomeRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Home') }}</a>
        <a href="{{ $publicBooksRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Catalog') }}</a>
        @auth
        @if($isMember)
        <a href="{{ $myBorrowingsRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Borrowings') }}</a>
        <a href="{{ $myReservationsRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Reservations') }}</a>
        <a href="{{ $myFinesRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Fines') }}</a>
        @endif
        @endauth
        @elseif($isInAdminBackend)
        <a href="{{ $adminDashRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-indigo-600 dark:text-cyan-400" @click="open = false">{{ __('Dashboard') }}</a>
        <a href="{{ $adminBooksRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Books') }}</a>
        <a href="{{ $adminBookIssuesRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Book Issues') }}</a>
        <a href="{{ $adminReservationsRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Reservations') }}</a>
        <a href="{{ $adminFinesRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Fines') }}</a>
        <a href="{{ $adminMembersRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Members') }}</a>
        <a href="{{ $adminReportsRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Reports') }}</a>
        @elseif($isInMemberPortal)
        <a href="{{ $memberDashRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-cyan-600 dark:text-cyan-400" @click="open = false">{{ __('Dashboard') }}</a>
        <a href="{{ $memberBooksRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Catalog') }}</a>
        <a href="{{ $backendBorrowingsRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Borrowings') }}</a>
        <a href="{{ $backendReservationsRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Reservations') }}</a>
        <a href="{{ $backendFinesRoute }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Fines') }}</a>
        @endif
        @auth
        <div class="border-t border-gray-200 dark:border-cyan-500/30 pt-3 mt-3">
            <div class="flex items-center px-3 mb-3">
                @if (Auth::user()->avatar ?? false)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-full object-cover border border-indigo-500 dark:border-cyan-400 mr-3">
                @else
                <div class="w-9 h-9 rounded-full bg-gradient-to-r from-indigo-600 to-fuchsia-600 dark:from-cyan-500 dark:to-fuchsia-500 text-white flex items-center justify-center font-bold text-sm mr-3">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                @endif
                <div>
                    <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <a href="{{ $notificationsRoute }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60 mb-1" @click="open = false">
                <span class="flex items-center"><i class="fa-solid fa-bell w-5 text-indigo-500 dark:text-cyan-400"></i>{{ __('Notifications') }}</span>
                @if($unreadNotificationCount > 0)
                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-rose-500 text-white">{{ $unreadNotificationCount }}</span>
                @endif
            </a>
            @if(Route::has('profile.edit'))
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-cyan-950/60" @click="open = false">{{ __('Profile Settings') }}</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-base font-medium text-red-600 dark:text-fuchsia-400 hover:bg-red-50 dark:hover:bg-fuchsia-950/40" @click="open = false">{{ __('Logout') }}</button>
            </form>
        </div>
        @else
        <div class="border-t border-gray-200 dark:border-cyan-500/30 pt-3 mt-3 flex flex-col gap-2">
            <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 text-sm font-semibold text-indigo-600 dark:text-cyan-300 border border-indigo-600 dark:border-cyan-400 rounded-xl hover:bg-indigo-50 transition-all">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="w-full text-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 dark:bg-gradient-to-r dark:from-cyan-500 dark:to-fuchsia-600 rounded-xl shadow transition-all">{{ __('Register') }}</a>
        </div>
        @endauth
    </div>
</nav>