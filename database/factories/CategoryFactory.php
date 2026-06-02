<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $imageUrls = [
            'https://images.unsplash.com/photo-1587854692152-cbe660dbde88',
            'https://images.unsplash.com/photo-1573883431205-98b5f10aaedb',
            'https://images.unsplash.com/photo-1603398938378-e54eab446dde',
            'https://images.unsplash.com/photo-1584017911766-d451b3d0e843',
            'https://images.unsplash.com/photo-1631549916768-4119b2e5f926',
        ];
        $url = $imageUrls[array_rand($imageUrls)];
        $imageContents = file_get_contents($url);
        $filename = 'categories/' . uniqid() . '.jpg';
        Storage::disk('public')->put($filename, $imageContents);


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

            'image' => $filename,

            'description' => fake()->sentence(2),

            'status' => 1,
        ];
    }
}
