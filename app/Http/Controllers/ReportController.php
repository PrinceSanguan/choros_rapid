<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\BillingTransaction;
use App\Models\Inventory;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display weekly reports.
     */
    public function weekly()
    {
        // Get weekly data for reports
        $weeklyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->sum('amount');

        $weeklyProjects = Project::whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->count();

        $weeklyNewCustomers = Customer::whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->count();

        // Get daily data for current week
        $dailyStats = BillingTransaction::where('status', 'paid')
            ->whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->get();

        return view('reports.weekly', compact(
            'weeklyIncome',
            'weeklyProjects',
            'weeklyNewCustomers',
            'dailyStats'
        ));
    }

    /**
     * Display monthly reports.
     */
    public function monthly()
    {
        // Get monthly data for reports
        $monthlyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->sum('amount');

        $monthlyProjects = Project::whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->count();

        $monthlyNewCustomers = Customer::whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->count();

        // Get weekly data for current month
        $weeklyStats = BillingTransaction::where('status', 'paid')
            ->whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->select(DB::raw('WEEK(created_at) as week'), DB::raw('SUM(amount) as total'))
            ->groupBy('week')
            ->get();

        return view('reports.monthly', compact(
            'monthlyIncome',
            'monthlyProjects',
            'monthlyNewCustomers',
            'weeklyStats'
        ));
    }
}
