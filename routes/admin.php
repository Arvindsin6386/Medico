<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BillingController;

// ================== GUEST ==================
Route::middleware('guest:admin')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

// ================== AUTH ==================
Route::middleware('auth:admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // FIXED LOGOUT (IMPORTANT)
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Categories
    Route::resource('categories', CategoryController::class);

    // SubCategorie
    Route::resource('subcategories', SubcategoryController::class);

    // Medicines (IMPORTANT)
    Route::resource('medicines', MedicineController::class);
    Route::get('medicines-data', [MedicineController::class, 'getmedicine'])
    ->name('medicines.data');

    // OPTIONAL (if you really want custom add page)
    // Route::get('/medicines/add', [MedicineController::class, 'create'])
    //     ->name('medicines.step.category');
    Route::get('/reports',           [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales',     [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/expiry',    [ReportController::class, 'expiry'])->name('reports.expiry');
    Route::get('/reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
    Route::get('/reports/profit',    [ReportController::class, 'profit'])->name('reports.profit');


    Route::get('/billing', [BillingController::class, 'index'])
        ->name('billing.index');

    Route::post('/billing/store', [BillingController::class, 'store'])
        ->name('billing.store');

    // Search medicine by name/barcode (Ajax GET)
    // Route::get('/search-medicine', [BillingController::class, 'searchMedicine'])->name('search');

    // // List all bills
    // Route::get('/list', [BillingController::class, 'billList'])->name('list');

    // // Print a single bill
    // Route::get('/{id}/print', [BillingController::class, 'printBill'])->name('print');



});
