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
use App\Http\Controllers\Admin\MedicineImagesController;

// ================== GUEST ==================
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

// ================== AUTH ==================
Route::middleware('auth:admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Categories
    Route::resource('categories', CategoryController::class);

    // SubCategories
    Route::resource('subcategories', SubcategoryController::class);

    // Medicine Images (MUST be before resource)
    Route::get('medicines/{id}/images', [MedicineImagesController::class, 'index'])
        ->name('medicines.images.index');
    Route::post('medicines/{id}/images', [MedicineImagesController::class, 'store'])
        ->name('medicines.images.store');
    Route::post('medicines/{id}/images/update', [MedicineImagesController::class, 'update'])
        ->name('medicines.images.update');
    Route::delete('medicines/{id}/images/{imageId}', [MedicineImagesController::class, 'destroy'])
        ->name('medicines.images.destroy');

    // Medicines
    Route::get('medicines-data', [MedicineController::class, 'getmedicine'])
        ->name('medicines.data');

    Route::get('/medicine/view/{id}', [MedicineController::class, 'view'])
        ->name('medicine.view');
    Route::resource('medicines', MedicineController::class);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/',          [ReportController::class, 'index'])->name('index');
        Route::get('/sales',     [ReportController::class, 'sales'])->name('sales');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
        Route::get('/expiry',    [ReportController::class, 'expiry'])->name('expiry');
        Route::get('/purchases', [ReportController::class, 'purchases'])->name('purchases');
        Route::get('/profit',    [ReportController::class, 'profit'])->name('profit');
    });

    // Billing
    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/',       [BillingController::class, 'index'])->name('index');
        Route::post('/store', [BillingController::class, 'store'])->name('store');
    });
});

 
