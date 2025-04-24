<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\BillingTransaction;
use App\Models\Inventory;
use App\Models\Customer;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Ensure users are authenticated
    }

    /**
     * Show the application dashboard based on role.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $position = $user->position;

        switch ($position) {
            case 'admin':
                return $this->admin_dashboard();
            case 'project-manager':
                return $this->projectManagerDashboard();
            case 'supplier':
                return $this->supplierDashboard();
            case 'inventory-staff':
                return $this->inventoryDashboard();
            default:
                return view('welcome');
        }
    }

    /**
     * Show the admin dashboard
     */
    public function admin_dashboard()
    {
        // Get users for admin dashboard
        $users = User::all();

        // Get counts for dashboard overview
        $projectsCount = Project::count();
        $recentProjects = Project::latest()->take(5)->get();
        $weeklyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->sum('amount');
        $monthlyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->sum('amount');
        $lowStockItems = Inventory::where('in_stock', '<', 10)->count();
        $topCustomers = Customer::withCount('billingTransactions')
            ->orderBy('billing_transactions_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'users',
            'projectsCount',
            'recentProjects',
            'weeklyIncome',
            'monthlyIncome',
            'lowStockItems',
            'topCustomers'
        ));
    }

    /**
     * Display the user management page
     */
    public function users()
    {
        $users = User::all();
        return view('user_management', compact('users'));
    }

    /**
     * Display the project manager dashboard
     */
    public function projectManagerDashboard()
    {
        $user = Auth::user();
        $projects = Project::where('manager_id', $user->id)->latest()->take(5)->get();
        $projectsCount = Project::where('manager_id', $user->id)->count();
        $pendingProjects = Project::where('manager_id', $user->id)->where('status', 'pending')->count();
        $ongoingProjects = Project::where('manager_id', $user->id)->where('status', 'ongoing')->count();
        $completedProjects = Project::where('manager_id', $user->id)->where('status', 'completed')->count();

        return view('project_manager.dashboard', compact(
            'user',
            'projects',
            'projectsCount',
            'pendingProjects',
            'ongoingProjects',
            'completedProjects'
        ));
    }

    /**
     * Display the supplier dashboard
     */
    public function supplierDashboard()
    {
        // Get data for supplier dashboard
        $projectsCount = Project::count();
        $recentProjects = Project::latest()->take(5)->get();
        $inventory = Inventory::all();
        $weeklyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->sum('amount');
        $monthlyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->sum('amount');
        $lowStockItems = Inventory::where('in_stock', '<', 10)->count();

        return view('supplier.dashboard', compact(
            'projectsCount',
            'recentProjects',
            'inventory',
            'weeklyIncome',
            'monthlyIncome',
            'lowStockItems'
        ));
    }

    /**
     * Display the inventory staff dashboard
     */
    public function inventoryDashboard()
    {
        // Get data for inventory dashboard
        $inventoryCount = Inventory::count();
        $lowStockItems = Inventory::where('in_stock', '<', 10)->count();
        $lowStockItemsList = Inventory::where('in_stock', '<', 10)->get();
        $recentItems = Inventory::latest()->take(5)->get();
        $categoriesCount = Inventory::distinct('category')->count('category');
        $suppliersCount = Supplier::count();

        return view('inventory.dashboard', compact(
            'inventoryCount',
            'lowStockItems',
            'lowStockItemsList',
            'recentItems',
            'categoriesCount',
            'suppliersCount'
        ));
    }
}
