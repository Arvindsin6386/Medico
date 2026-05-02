<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\MedicineController;

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
    Route::resource('subcategories',SubcategoryController::class);

    // Medicines (IMPORTANT)
    Route::resource('medicines', MedicineController::class);

    // OPTIONAL (if you really want custom add page)
    Route::get('/medicines/add', [MedicineController::class, 'create'])
        ->name('medicines.step.category');





});