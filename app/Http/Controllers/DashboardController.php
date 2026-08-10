<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Member;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookIssue;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        $stats = [
            'total_books'      => Book::count(),
            'available_books'  => Book::sum('available_quantity'),
            'issued_books'     => class_exists(BookIssue::class) ? BookIssue::whereIn('status', ['issued', 'borrowed', 'active', 'pending'])->count() : 0,
            'total_members'    => class_exists(Member::class) ? Member::count() : (class_exists(User::class) ? User::count() : 0),
            'total_categories' => Category::count(),
            'total_authors'    => Author::count(),
            'total_publishers' => Publisher::count(),
            'todays_issues'    => class_exists(BookIssue::class) ? BookIssue::whereDate('created_at', today())->count() : 0,
            'todays_returns'   => class_exists(BookIssue::class) ? BookIssue::where('status', 'returned')->whereDate('updated_at', today())->count() : 0,
        ];

        $recentIssues = class_exists(BookIssue::class)
            ? BookIssue::with(['book', 'member.user'])->latest()->take(5)->get()
            : collect();

        $topCategories = Category::withCount('books')->orderBy('books_count', 'desc')->take(5)->get();

        $categoryData = [
            'labels' => $topCategories->pluck('name')->toArray(),
            'counts' => $topCategories->pluck('books_count')->toArray(),
        ];

        $chartMonths  = [];
        $issuedData   = [];
        $returnedData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartMonths[] = $month->format('M Y');

            $issuedData[] = class_exists(BookIssue::class)
                ? BookIssue::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count()
                : 0;

            $returnedData[] = class_exists(BookIssue::class)
                ? BookIssue::whereYear('updated_at', $month->year)
                    ->whereMonth('updated_at', $month->month)
                    ->where('status', 'returned')
                    ->count()
                : 0;
        }

        $viewName = view()->exists('admin.dashboard') ? 'admin.dashboard' : 'dashboard';

        return view($viewName, compact(
            'stats',
            'recentIssues',
            'categoryData',
            'chartMonths',
            'issuedData',
            'returnedData'
        ));
    }

    public function memberDashboard(Request $request)
    {
        /** @var User|null $user */
        $user = $request->user() ?? Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $memberId = null;
        if (method_exists($user, 'getOrCreateMemberProfile')) {
            $member = $user->getOrCreateMemberProfile();
            $memberId = $member?->id;
        } elseif (method_exists($user, 'member') && $user->member) {
            $memberId = $user->member->id;
        } else {
            $memberId = Member::where('user_id', $user->id)->value('id') ?? $user->id;
        }

        $myIssuesQuery = class_exists(BookIssue::class)
            ? BookIssue::where('member_id', $memberId)
            : null;

        // Calculate pending fine safely regardless of column name
        $pendingFines = 0;
        if ($myIssuesQuery) {
            try {
                $pendingFines = (clone $myIssuesQuery)->sum('fine_amount');
            } catch (\Exception $e) {
                try {
                    $pendingFines = (clone $myIssuesQuery)->sum('fine');
                } catch (\Exception $ex) {
                    $pendingFines = 0;
                }
            }
        }

        $memberStats = [
            'current_borrowed' => $myIssuesQuery ? (clone $myIssuesQuery)->whereIn('status', ['issued', 'borrowed', 'active', 'pending'])->count() : 0,
            'total_returned'   => $myIssuesQuery ? (clone $myIssuesQuery)->where('status', 'returned')->count() : 0,
            'pending_fines'    => $pendingFines,
        ];

        $myRecentIssues = $myIssuesQuery
            ? (clone $myIssuesQuery)->with('book')->latest()->take(5)->get()
            : collect();

        $recommendedBooks = Book::with(['category', 'author'])->where('available_quantity', '>', 0)->latest()->take(4)->get();

        $publicStats = [
            'total_books'      => Book::count(),
            'available_books'  => Book::sum('available_quantity'),
            'total_categories' => Category::count(),
        ];

        $viewName = view()->exists('member.dashboard') ? 'member.dashboard' : 'dashboard';

        return view($viewName, compact('memberStats', 'myRecentIssues', 'recommendedBooks', 'publicStats'));
    }
}