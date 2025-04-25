<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Public/Homepage
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('welcome');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('password.email');

// Test route to check if LoginController is accessible
Route::get('/login-test', function() {
    return 'LoginController is correctly configured';
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::get('/admin/dashboard', [HomeController::class, 'admin_dashboard'])->name('admin_dashboard');

    // Project manager routes
    Route::get('/project-manager/dashboard', [HomeController::class, 'projectManagerDashboard'])->name('project_manager_dashboard');

    // Accountant routes
    Route::get('/accountant/dashboard', [HomeController::class, 'accountantDashboard'])->name('accountant_dashboard');

    // Inventory staff routes
    Route::get('/inventory/dashboard', [HomeController::class, 'inventoryDashboard'])->name('inventory_dashboard');

    // Supplier routes
    Route::get('/supplier/dashboard', [HomeController::class, 'supplierDashboard'])->name('supplier_dashboard');

    // User management routes
    Route::resource('users', UserController::class);

    // Project management routes
    Route::resource('projects', ProjectController::class);

    // Billing routes
    Route::resource('billings', BillingController::class);

    // Inventory routes
    Route::resource('inventory', InventoryController::class);

    // Supplier routes
    Route::resource('supplier', SupplierController::class);

    // Customer routes
    Route::resource('customers', CustomerController::class);

    // Report routes
    Route::get('/reports/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
});

// Add route definitions for all sidebar links
