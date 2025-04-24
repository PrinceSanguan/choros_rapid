<?php

namespace App\Http\Controllers;

use App\Models\BillingTransaction;
use App\Models\Project;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display weekly reports.
     */
    public function weekly(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        if ($request->has('week_start')) {
            $startOfWeek = Carbon::parse($request->week_start);
            $endOfWeek = (clone $startOfWeek)->addDays(6);
        }

        $weeklyTransactions = BillingTransaction::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->with(['project', 'customer'])
            ->get();

        $weeklyIncome = $weeklyTransactions->where('status', 'paid')->sum('amount');
        $weeklyPending = $weeklyTransactions->where('status', 'pending')->sum('amount');

        $dailyAmounts = [];
        for ($day = 0; $day < 7; $day++) {
            $date = (clone $startOfWeek)->addDays($day);
            $dailyAmounts[$date->format('Y-m-d')] = $weeklyTransactions
                ->where('status', 'paid')
                ->filter(function ($transaction) use ($date) {
                    return Carbon::parse($transaction->created_at)->isSameDay($date);
                })
                ->sum('amount');
        }

        // Get data for projects started/completed this week
        $weeklyProjects = Project::whereBetween('start_date', [$startOfWeek, $endOfWeek])
            ->orWhereBetween('end_date', [$startOfWeek, $endOfWeek])
            ->with('manager')
            ->get();

        // Get low stock inventory items
        $lowStockItems = Inventory::where('in_stock', '<', 10)
            ->with('category')
            ->get();

        return view('reports.weekly', compact(
            'startOfWeek',
            'endOfWeek',
            'weeklyTransactions',
            'weeklyIncome',
            'weeklyPending',
            'dailyAmounts',
            'weeklyProjects',
            'lowStockItems'
        ));
    }

    /**
     * Display monthly reports.
     */
    public function monthly(Request $request)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        if ($request->has('month') && $request->has('year')) {
            $month = $request->month;
            $year = $request->year;
        }

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $monthlyTransactions = BillingTransaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->with(['project', 'customer'])
            ->get();

        $monthlyIncome = $monthlyTransactions->where('status', 'paid')->sum('amount');
        $monthlyPending = $monthlyTransactions->where('status', 'pending')->sum('amount');

        // Get data for project progress this month
        $monthlyProjects = Project::where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
                        $q->where('start_date', '<', $startOfMonth)
                          ->where(function ($subQ) use ($endOfMonth) {
                              $subQ->where('end_date', '>', $endOfMonth)
                                  ->orWhereNull('end_date');
                          });
                    });
            })
            ->with('manager')
            ->get();

        // Get inventory movement data (additions and subtractions)
        $inventoryMovement = Inventory::whereBetween('updated_at', [$startOfMonth, $endOfMonth])
            ->with('category')
            ->get();

        return view('reports.monthly', compact(
            'startOfMonth',
            'endOfMonth',
            'month',
            'year',
            'monthlyTransactions',
            'monthlyIncome',
            'monthlyPending',
            'monthlyProjects',
            'inventoryMovement'
        ));
    }

    /**
     * Export weekly report as PDF.
     */
    public function exportWeeklyPdf(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        if ($request->has('week_start')) {
            $startOfWeek = Carbon::parse($request->week_start);
            $endOfWeek = (clone $startOfWeek)->addDays(6);
        }

        $weeklyTransactions = BillingTransaction::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->with(['project', 'customer'])
            ->get();

        $weeklyIncome = $weeklyTransactions->where('status', 'paid')->sum('amount');
        $weeklyPending = $weeklyTransactions->where('status', 'pending')->sum('amount');

        $pdf = PDF::loadView('reports.pdf.weekly', compact(
            'startOfWeek',
            'endOfWeek',
            'weeklyTransactions',
            'weeklyIncome',
            'weeklyPending'
        ));

        return $pdf->download('weekly-report-' . $startOfWeek->format('Y-m-d') . '.pdf');
    }

    /**
     * Export monthly report as PDF.
     */
    public function exportMonthlyPdf(Request $request)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        if ($request->has('month') && $request->has('year')) {
            $month = $request->month;
            $year = $request->year;
        }

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $monthlyTransactions = BillingTransaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->with(['project', 'customer'])
            ->get();

        $monthlyIncome = $monthlyTransactions->where('status', 'paid')->sum('amount');
        $monthlyPending = $monthlyTransactions->where('status', 'pending')->sum('amount');

        $pdf = PDF::loadView('reports.pdf.monthly', compact(
            'startOfMonth',
            'endOfMonth',
            'month',
            'year',
            'monthlyTransactions',
            'monthlyIncome',
            'monthlyPending'
        ));

        return $pdf->download('monthly-report-' . $startOfMonth->format('Y-m') . '.pdf');
    }
}
