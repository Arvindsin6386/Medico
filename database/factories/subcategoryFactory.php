<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class SubCategoryFactory extends Factory
{
    public function definition(): array
    {
        $image = UploadedFile::fake()->image('subcategory.jpg', 400, 400);

        $path = $image->store('subcategories', 'public');

        return [

            'category_id' => Category::inRandomOrder()->first()->id,

            'name' => fake()->randomElement([
                'Fever',
                'Cold',
                'Pain Relief',
                'Skin Care',
                'Diabetes',
                'Heart Care',
                'Eye Care',
                'Baby Care',
                'Allergy',
                'Antibiotic',
            ]),

            'image' => $path,

            'description' => fake()->sentence(2),

            'status' => 1,
        ];
    }
}