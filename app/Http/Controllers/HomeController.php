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
use Illuminate\Support\Facades\DB;

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

        // New data for the enhanced dashboard
        $weeklyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->sum('amount');
        $monthlyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->sum('amount');

        // Project accomplishment calculation (example: percentage of completed projects)
        $totalProjects = Project::count();
        $completedProjects = Project::where('status', 'completed')->count();
        $projectAccomplishment = $totalProjects > 0 ? round(($completedProjects / $totalProjects) * 100) : 0;

        // Area accomplishment data - can be customized based on your business logic
        $areaAccomplishment = [
            'design' => 85,
            'construction' => 70,
            'planning' => 90,
            'implementation' => 65
        ];

        // Top clients by purchase amount
        $topClients = Customer::join('billing_transactions as bt', 'customers.id', '=', 'bt.customer_id')
            ->select('customers.name', DB::raw('SUM(bt.amount) as total_purchase'))
            ->where('bt.status', 'paid')
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total_purchase', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'users',
            'projectsCount',
            'recentProjects',
            'weeklyIncome',
            'monthlyIncome',
            'lowStockItems',
            'topCustomers',
            // New variables
            'weeklyAnnualSale',
            'monthlyAnnualSale',
            'projectAccomplishment',
            'areaAccomplishment',
            'topClients'
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

        // New data for enhanced dashboard
        $weeklyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->sum('amount');
        $monthlyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->sum('amount');

        // Project accomplishment - supplier perspective
        $suppliedProjects = Project::whereHas('inventory')->count();
        $totalProjects = Project::count();
        $projectAccomplishment = $totalProjects > 0 ? round(($suppliedProjects / $totalProjects) * 100) : 0;

        // Area accomplishment - supplier perspective
        $areaAccomplishment = [
            'materials_delivery' => 80,
            'quality_assurance' => 75,
            'on_time_delivery' => 90
        ];

        // Top clients for supplier
        $topClients = Customer::join('projects as p', 'customers.id', '=', 'p.customer_id')
            ->join('project_inventory as pi', 'p.id', '=', 'pi.project_id')
            ->select('customers.name', DB::raw('COUNT(pi.inventory_id) as total_purchase'))
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total_purchase', 'desc')
            ->take(5)
            ->get();

        return view('supplier.dashboard', compact(
            'projectsCount',
            'recentProjects',
            'inventory',
            'weeklyIncome',
            'monthlyIncome',
            'lowStockItems',
            // New variables
            'weeklyAnnualSale',
            'monthlyAnnualSale',
            'projectAccomplishment',
            'areaAccomplishment',
            'topClients'
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

        // New data for enhanced dashboard
        $weeklyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw('YEARWEEK(created_at) = YEARWEEK(NOW())')
            ->sum('amount');
        $monthlyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw('MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')
            ->sum('amount');

        // Project accomplishment - inventory perspective
        $inventoryUtilization = Inventory::sum('in_stock') > 0 ?
            round((Inventory::sum('used') / (Inventory::sum('in_stock') + Inventory::sum('used'))) * 100) : 0;
        $projectAccomplishment = $inventoryUtilization;

        // Area accomplishment - inventory perspective
        $areaAccomplishment = [
            'stock_management' => 85,
            'inventory_accuracy' => 92,
            'distribution' => 78
        ];

        // Top clients by inventory usage
        $topClients = Customer::join('projects as p', 'customers.id', '=', 'p.customer_id')
            ->join('project_inventory as pi', 'p.id', '=', 'pi.project_id')
            ->select('customers.name', DB::raw('SUM(pi.quantity) as total_purchase'))
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total_purchase', 'desc')
            ->take(5)
            ->get();

        return view('inventory.dashboard', compact(
            'inventoryCount',
            'lowStockItems',
            'lowStockItemsList',
            'recentItems',
            'categoriesCount',
            'suppliersCount',
            // New variables
            'weeklyAnnualSale',
            'monthlyAnnualSale',
            'projectAccomplishment',
            'areaAccomplishment',
            'topClients'
        ));
    }
}
