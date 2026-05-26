<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $image = UploadedFile::fake()->image('category.jpg', 400, 400);

        $path = $image->store('categories', 'public');

        return [

            'name' => fake()->randomElement([
                'Tablet',
                'Capsule',
                'Syrup',
                'Injection',
                'Cream',
                'Drops',
                'Powder',
                'Gel',
                'Soap',
                'Vitamin',
            ]),

            'image' => $path,

            'description' => fake()->sentence(2),

            'status' => 1,
        ];
    }
}