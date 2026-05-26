<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Medicine;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory(20)->create();

        SubCategory::factory(20)->create();

        Medicine::factory(20)->create();
    }
}