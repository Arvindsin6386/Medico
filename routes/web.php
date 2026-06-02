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


Route::get('/test-array', function () {

    $array = [1,2,3,4,5,6,7,8,9,10];

    shuffle($array);
   // dd($array);

    $randomItems = array_slice($array, 0, rand(2,5));

    //dd($randomItems);

});

// Route::get('/test-array', function () {

//     $array = [7,2,9,1,4,6];

//     $randomItems = array_slice($array, 0, 3);

//     dd($randomItems);

// });
