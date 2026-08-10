<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\BookIssue;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate  = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate    = $request->input('end_date', Carbon::now()->toDateString());
        $reportType = $request->input('type', 'issues');
        $startDateTime = Carbon::parse($startDate)->startOfDay();
        $endDateTime   = Carbon::parse($endDate)->endOfDay();
        $query = BookIssue::with(['book', 'member.user'])
            ->whereBetween('created_at', [$startDateTime, $endDateTime]);
        if ($reportType === 'returned') {
            $query->where('status', 'returned');
        } elseif ($reportType === 'overdue') {
            $query->whereIn('status', ['issued', 'borrowed', 'pending'])
                ->where('return_date', '<', Carbon::now()->toDateString());
        }
        $records = $query->latest()->paginate(10)->withQueryString();
        $totalBooks   = Book::count();
        $totalMembers = Member::count();
        $totalIssuedInRange = BookIssue::whereBetween('created_at', [$startDateTime, $endDateTime])->count();
        $totalFineCollected = BookIssue::whereBetween('updated_at', [$startDateTime, $endDateTime])
            ->where('status', 'returned')
            ->sum(DB::raw('ABS(fine)'));
        return view('reports.index', compact(
            'records',
            'startDate',
            'endDate',
            'reportType',
            'totalBooks',
            'totalMembers',
            'totalIssuedInRange',
            'totalFineCollected'
        ));
    }
}