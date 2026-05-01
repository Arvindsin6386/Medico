<?php

use Illuminate\Support\Facades\Route;

// Default route
Route::get('/', function(){
    return redirect()->route('admin.login');
});

// Load admin routes
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        require base_path('routes/admin.php');
    });