<?php

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

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


//  Route::get('test-factory', function () {

//     // $url = fake()->imageUrl();
//     $category = Category::factory()->create();



//     return $category;
// });