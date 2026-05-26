<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class MedicineFactory extends Factory
{
    public function definition(): array
    {
        $image = UploadedFile::fake()->image('medicine.jpg', 400, 400);

        $path = $image->store('medicines', 'public');

        return [

            'subcategory_id' => SubCategory::inRandomOrder()->first()->id,

            'name' => fake()->randomElement([
                'Paracetamol',
                'Dolo 650',
                'Crocin',
                'Cetirizine',
                'Azithromycin',
                'Amoxicillin',
                'Ibuprofen',
                'ORS',
                'Vitamin C',
                'Disprin',
            ]),

            'expiry_date' => fake()->dateTimeBetween('+2 months', '+6 months'),
            'image' => $path,

            'purchase_price' => fake()->numberBetween(50, 500),
            'selling_price' => fake()->numberBetween(80, 600),

            'stock' => fake()->numberBetween(10, 100),

            'description' => fake()->sentence(3),

            'status' => 1,
        ];
    }
}
