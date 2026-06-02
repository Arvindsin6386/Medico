<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;


class MedicineFactory extends Factory
{
    public function definition(): array
    {
       

       return [

    'subcategory_id' => SubCategory::inRandomOrder()->value('id'),

    'name' => fake()->word(),

    'purchase_price' => rand(100,500),

    'selling_price' => rand(600,2000),

    'stock' => rand(10,100),

    'expiry_date' => fake()->dateTimeBetween('+1 year', '+5 years'),

    'description' => fake()->sentence(),

    'status' => 1,

];
    }
}
