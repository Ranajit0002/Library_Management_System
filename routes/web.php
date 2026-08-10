<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BookReservationController;
use App\Http\Controllers\FineController;

Route::get('/', [BookController::class, 'home'])->name('home');
Route::redirect('/catalog', '/books')->name('books.catalog');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');
Route::view('/terms-and-conditions', 'pages.terms')->name('terms');
Route::get('/support', [SupportController::class, 'index'])->name('support');
Route::post('/support', [SupportController::class, 'store'])->name('support.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $user = $request->user() ?? Auth::user();
        if ($user && ($user->is_admin || strtolower($user->role ?? '') === 'admin')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('member.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/books/{book}/borrow', [BookIssueController::class, 'store'])->name('books.borrow');
    Route::post('/book-issues', [BookIssueController::class, 'store'])->name('book-issues.store');
    Route::post('/book-issues/store', [BookIssueController::class, 'store'])->name('book_issues.store');

    Route::post('/books/{book}/reserve', [BookReservationController::class, 'store'])->name('books.reserve');
    Route::post('/reservations', [BookReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [BookReservationController::class, 'destroy'])->name('reservations.destroy');
    
    // Frontend Public Member Views
    Route::get('/my-borrowings', [BookIssueController::class, 'myBorrowings'])->name('books.my-borrowings');
    Route::get('/my-reservations', [BookReservationController::class, 'myReservations'])->name('books.my-reservations');
    Route::get('/my-fines', [FineController::class, 'memberIndex'])->name('books.my-fines');

    Route::get('/reservations', [BookReservationController::class, 'index'])->name('reservations.index');
    Route::get('/books/{book}/read', [BookController::class, 'read'])->name('books.read');
    Route::get('/books/{book}/stream', [BookController::class, 'streamFile'])->name('books.stream');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('authors', AuthorController::class);
        Route::resource('publishers', PublisherController::class);
        Route::resource('books', BookController::class, ['names' => 'admin.books', 'except' => ['show']]);
        Route::resource('members', MemberController::class);
        Route::patch('members/{member}/toggle-status', [MemberController::class, 'toggleStatus'])->name('members.toggle-status');
        Route::get('members/{member}/history', [MemberController::class, 'history'])->name('members.history');
        Route::resource('book-issues', BookIssueController::class, ['names' => 'admin.book_issues', 'except' => ['store']]);
        Route::post('book-issues/{bookIssue}/return', [BookIssueController::class, 'returnBook'])->name('admin.book_issues.return');
        Route::post('/book-issues/{bookIssue}/pay-fine', [BookIssueController::class, 'payFine'])->name('admin.book_issues.pay_fine');
        Route::post('/book-issues/{bookIssue}/waive-fine', [BookIssueController::class, 'waiveFine'])->name('admin.book_issues.waive_fine');
        Route::get('/reservations', [BookReservationController::class, 'index'])->name('admin.reservations.index');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/fines', [FineController::class, 'adminIndex'])->name('admin.fines.index');
        Route::post('/fines/{fine}/waive', [FineController::class, 'waive'])->name('admin.fines.waive');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    Route::middleware('member')->prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'memberDashboard'])->name('dashboard');
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::get('/books/{book}/read', [BookController::class, 'read'])->name('books.read');
        Route::get('/books/{book}/stream', [BookController::class, 'streamFile'])->name('books.stream');
        Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
        Route::get('/book-issues/my', [BookIssueController::class, 'myBorrowings'])->name('book_issues.my');
        Route::get('/borrow-history', [BookIssueController::class, 'myBorrowings'])->name('borrow-history');
        Route::get('/book-issues/{bookIssue}', [BookIssueController::class, 'show'])->name('book_issues.show');
        Route::post('/book-issues/{bookIssue}/return', [BookIssueController::class, 'returnBook'])->name('book_issues.return');
        Route::get('/reservations/my', [BookReservationController::class, 'myReservations'])->name('reservations.my');
        Route::get('/fines', [FineController::class, 'memberIndex'])->name('fines.index');
        Route::post('/fines/{fine}/pay', [FineController::class, 'pay'])->name('fines.pay');
    });
});

Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

require __DIR__ . '/auth.php';