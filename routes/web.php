<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Make root URL show the login form
Route::get('/', [LoginController::class, 'showLoginForm'])->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [LoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [LoginController::class, 'register']);

    // Password Reset Routes
    Route::get('forgot-password', [LoginController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [LoginController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function() {
        if (Auth::user()->position === 'project-manager') {
            return redirect()->route('project_manager_dashboard');
        } elseif (Auth::user()->position === 'supplier') {
            return redirect()->route('supplier_dashboard');
        } elseif (Auth::user()->position === 'inventory-staff') {
            return redirect()->route('inventory_dashboard');
        }
        return redirect()->route('admin_dashboard');
    })->name('dashboard');

    // Dashboard routes for different roles
    Route::get('/admin_dashboard', [HomeController::class, 'admin_dashboard'])->name('admin_dashboard');
    Route::get('/project_manager/dashboard', [HomeController::class, 'projectManagerDashboard'])->name('project_manager_dashboard');
    Route::get('/supplier/dashboard', [HomeController::class, 'supplierDashboard'])->name('supplier_dashboard');
    Route::get('/inventory/dashboard', [HomeController::class, 'inventoryDashboard'])->name('inventory_dashboard');

    // User Management View
    Route::get('/users/manage', [HomeController::class, 'users'])->name('users.index');

    // User Management - Admin only
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.list');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Project Management - Admin and Project Manager
    Route::prefix('projects')->group(function () {
        Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('/registration', [ProjectController::class, 'registration'])->name('projects.registration');
    });

    // Project list and view - All authenticated users
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('projects.show');
    });

    // Billing Transactions - Admin and Accountant
    Route::prefix('billings')->group(function () {
        Route::get('/', [BillingController::class, 'index'])->name('billings.index');
        Route::get('/create', [BillingController::class, 'create'])->name('billings.create');
        Route::post('/', [BillingController::class, 'store'])->name('billings.store');
        Route::get('/{billing}', [BillingController::class, 'show'])->name('billings.show');
        Route::get('/{billing}/edit', [BillingController::class, 'edit'])->name('billings.edit');
        Route::put('/{billing}', [BillingController::class, 'update'])->name('billings.update');
        Route::delete('/{billing}', [BillingController::class, 'destroy'])->name('billings.destroy');
    });

    // Inventory Management - Admin and Inventory Staff
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
        Route::post('/', [InventoryController::class, 'store'])->name('inventory.store');
        Route::get('/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
        Route::get('/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
        Route::put('/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    });

    // Supplier Management - Admin and Inventory Staff
    Route::prefix('suppliers')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('/', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    });

    // Customer Management - Admin and Accountant
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    // Reports - Admin and Manager
    Route::prefix('reports')->group(function () {
        Route::get('/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/weekly/pdf', [ReportController::class, 'exportWeeklyPdf'])->name('reports.weekly.pdf');
        Route::get('/monthly/pdf', [ReportController::class, 'exportMonthlyPdf'])->name('reports.monthly.pdf');
    });
});

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');
