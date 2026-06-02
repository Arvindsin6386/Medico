<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Medicine;
use App\Models\MedicineImages;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory(20)->create();

        SubCategory::factory(20)->create();

        Medicine::factory(20)->create();

        $medicines = Medicine::all();

        foreach ($medicines as $medicine) {

            $count = rand(2, 5);

            $images = MedicineImages::factory($count)->create([
                'medicine_id' => $medicine->id
            ]);

            // First image master
            $images->first()->update([
                'is_master' => true
            ]);
        }
    }
}
