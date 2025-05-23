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
use App\Models\Schedule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Ensure users are authenticated for most methods, but not the welcome page
        $this->middleware('auth')->except('welcome');
    }

    /**
     * Show the welcome page for guests
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard based on role.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return $this->welcome();
        }

        $user = Auth::user();
        $position = $user->position;

        switch ($position) {
            case 'admin':
                return $this->admin_dashboard();
            case 'project-manager':
                return $this->projectManagerDashboard();
            case 'accountant':
                return $this->accountantDashboard();
            case 'supplier':
                return $this->supplierDashboard();
            case 'inventory-staff':
                return $this->inventoryDashboard();
            default:
                return $this->welcome();
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
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(WEEK FROM created_at) = EXTRACT(WEEK FROM NOW())")
            ->sum('amount');
        $monthlyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM NOW())")
            ->sum('amount');
        $lowStockItems = Inventory::where('in_stock', '<', 10)->count();
        $topCustomers = Customer::withCount('billingTransactions')
            ->orderBy('billing_transactions_count', 'desc')
            ->take(5)
            ->get();

        // New data for the enhanced dashboard
        $weeklyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(WEEK FROM created_at) = EXTRACT(WEEK FROM NOW())")
            ->sum('amount');
        $monthlyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM NOW())")
            ->sum('amount');

        // Project accomplishment calculation
        $totalProjects = Project::count();
        $completedProjects = Project::where('status', 'completed')->count();
        $ongoingProjects = Project::where('status', 'ongoing')->count();
        $pendingProjects = Project::where('status', 'pending')->count();
        $projectAccomplishment = $totalProjects > 0 ? round(($completedProjects / $totalProjects) * 100) : 0;

        // Dynamic area accomplishment calculation based on real data
        $designProjects = Project::where('status', 'completed')
            ->whereRaw("description LIKE '%design%' OR name LIKE '%design%'")
            ->count();
        $designPercentage = $totalProjects > 0 ? round(($designProjects / $totalProjects) * 100) : 0;

        $constructionProjects = Project::where('status', 'completed')
            ->whereRaw("description LIKE '%construction%' OR name LIKE '%construction%'")
            ->count();
        $constructionPercentage = $totalProjects > 0 ? round(($constructionProjects / $totalProjects) * 100) : 0;

        $planningProjects = Project::where('status', 'completed')
            ->whereRaw("description LIKE '%planning%' OR name LIKE '%planning%'")
            ->count();
        $planningPercentage = $totalProjects > 0 ? round(($planningProjects / $totalProjects) * 100) : 0;

        $implementationProjects = Project::where('status', 'completed')
            ->whereRaw("description LIKE '%implementation%' OR name LIKE '%implementation%'")
            ->count();
        $implementationPercentage = $totalProjects > 0 ? round(($implementationProjects / $totalProjects) * 100) : 0;

        $areaAccomplishment = [
            'Design' => max(min($designPercentage, 100), 0),
            'Construction' => max(min($constructionPercentage, 100), 0),
            'Planning' => max(min($planningPercentage, 100), 0),
            'Implementation' => max(min($implementationPercentage, 100), 0)
        ];

        // Top clients by purchase amount
        $topClients = Customer::join('billing_transactions as bt', 'customers.id', '=', 'bt.customer_id')
            ->select('customers.name', DB::raw('SUM(bt.amount) as total_purchase'))
            ->where('bt.status', 'paid')
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total_purchase', 'desc')
            ->take(5)
            ->get();

        // Get current month calendar events
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');
        $daysInMonth = now()->daysInMonth;

        // Get all schedules for the current month
        $schedules = Schedule::whereMonth('start_date', $currentMonth)
            ->whereYear('start_date', $currentYear)
            ->get();

        // Prepare calendar data
        $calendarData = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $calendarData[$i] = [];
        }

        foreach ($schedules as $schedule) {
            $day = (int)date('d', strtotime($schedule->start_date));
            if (isset($calendarData[$day])) {
                $calendarData[$day][] = $schedule;
            }
        }

        // Get month name for calendar header
        $monthName = date('F Y');

        return view('admin.dashboard', compact(
            'users',
            'projectsCount',
            'recentProjects',
            'weeklyIncome',
            'monthlyIncome',
            'lowStockItems',
            'topCustomers',
            'weeklyAnnualSale',
            'monthlyAnnualSale',
            'projectAccomplishment',
            'areaAccomplishment',
            'topClients',
            'totalProjects',
            'completedProjects',
            'ongoingProjects',
            'pendingProjects',
            'calendarData',
            'monthName'
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

        // Additional dashboard data for project manager
        $weeklyAnnualSale = BillingTransaction::whereHas('project', function($query) use ($user) {
                $query->where('manager_id', $user->id);
            })
            ->where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(WEEK FROM created_at) = EXTRACT(WEEK FROM NOW())")
            ->sum('amount');

        $monthlyAnnualSale = BillingTransaction::whereHas('project', function($query) use ($user) {
                $query->where('manager_id', $user->id);
            })
            ->where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM NOW())")
            ->sum('amount');

        // Project accomplishment for this manager
        $projectAccomplishment = $projectsCount > 0 ? round(($completedProjects / $projectsCount) * 100) : 0;

        // Area accomplishment for project manager
        $areaAccomplishment = [
            'planning' => 80,
            'execution' => 75,
            'team_management' => 85,
            'client_satisfaction' => 90
        ];

        // Top clients for this project manager
        $topClients = Customer::join('projects as p', 'customers.id', '=', 'p.customer_id')
            ->where('p.manager_id', $user->id)
            ->select('customers.name', DB::raw('COUNT(p.id) as total_projects'))
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total_projects', 'desc')
            ->take(5)
            ->get();

        return view('project_manager.dashboard', compact(
            'user',
            'projects',
            'projectsCount',
            'pendingProjects',
            'ongoingProjects',
            'completedProjects',
            'weeklyAnnualSale',
            'monthlyAnnualSale',
            'projectAccomplishment',
            'areaAccomplishment',
            'topClients'
        ));
    }

    /**
     * Display the accountant dashboard
     */
    public function accountantDashboard()
    {
        // Get data for accountant dashboard
        $weeklyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(WEEK FROM created_at) = EXTRACT(WEEK FROM NOW())")
            ->sum('amount');

        $monthlyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM NOW())")
            ->sum('amount');

        $pendingPayments = BillingTransaction::where('status', 'pending')->count();
        $recentTransactions = BillingTransaction::latest()->take(5)->get();

        // Additional dashboard data
        $weeklyAnnualSale = $weeklyIncome;
        $monthlyAnnualSale = $monthlyIncome;

        // Project accomplishment from financial perspective
        $totalBilled = BillingTransaction::where('status', 'paid')->sum('amount');
        $totalProjectValue = Project::sum('budget');
        $projectAccomplishment = $totalProjectValue > 0 ? round(($totalBilled / $totalProjectValue) * 100) : 0;

        // Area accomplishment for accountant
        $areaAccomplishment = [
            'invoicing' => 95,
            'collections' => 82,
            'reporting' => 88,
            'budget_management' => 75
        ];

        // Top clients by payment
        $topClients = Customer::join('billing_transactions as bt', 'customers.id', '=', 'bt.customer_id')
            ->select('customers.name', DB::raw('SUM(bt.amount) as total_paid'))
            ->where('bt.status', 'paid')
            ->groupBy('customers.id', 'customers.name')
            ->orderBy('total_paid', 'desc')
            ->take(5)
            ->get();

        return view('accountant.dashboard', compact(
            'weeklyIncome',
            'monthlyIncome',
            'pendingPayments',
            'recentTransactions',
            'weeklyAnnualSale',
            'monthlyAnnualSale',
            'projectAccomplishment',
            'areaAccomplishment',
            'topClients'
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
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(WEEK FROM created_at) = EXTRACT(WEEK FROM NOW())")
            ->sum('amount');
        $monthlyIncome = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM NOW())")
            ->sum('amount');
        $lowStockItems = Inventory::where('in_stock', '<', 10)->count();

        // New data for enhanced dashboard
        $weeklyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(WEEK FROM created_at) = EXTRACT(WEEK FROM NOW())")
            ->sum('amount');
        $monthlyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM NOW())")
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
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(WEEK FROM created_at) = EXTRACT(WEEK FROM NOW())")
            ->sum('amount');
        $monthlyAnnualSale = BillingTransaction::where('status', 'paid')
            ->whereRaw("EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM NOW()) AND EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM NOW())")
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
