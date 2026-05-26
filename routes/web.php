<?php

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

// Default route
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Load admin routes
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        require base_path('routes/admin.php');
    });


Route::get('test-factory', function () {
    $images = [
        'https://images.unsplash.com/photo-1587854692152-cbe660dbde88',
        'https://images.unsplash.com/photo-1573883431205-98b5f10aaedb',
        'https://images.unsplash.com/photo-1603398938378-e54eab446dde',
        'https://images.unsplash.com/photo-1584017911766-d451b3d0e843',
        'https://images.unsplash.com/photo-1631549916768-4119b2e5f926',
    ];
    $order = rand(1, 5);
    $image = $images[$order];
    

    return $image;
    // $url = fake()->imageUrl();
    // $category = Category::factory()->create();



    return $category;
});
