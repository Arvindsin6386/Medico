<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    public function definition(): array
    {
        $subcategory = SubCategory::inRandomOrder()->first();

        return [

            'category_id' => $subcategory->category_id,

            'subcategory_id' => $subcategory->id,

            'name' => fake()->word(),

            'purchase_price' => rand(100, 500),

            'selling_price' => rand(600, 2000),

            'stock' => rand(10, 100),

            'expiry_date' => fake()->dateTimeBetween('+1 year', '+5 years'),

            'description' => fake()->sentence(),

            'status' => 1,

        ];
    }
}