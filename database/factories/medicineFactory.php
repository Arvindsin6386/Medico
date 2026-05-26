<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    public function definition(): array
    {
        $images = [

            'https://images.unsplash.com/photo-1587854692152-cbe660dbde88',
            'https://images.unsplash.com/photo-1584017911766-d451b3d0e843',
            'https://images.unsplash.com/photo-1573883431205-98b5f10aaedb',
            'https://images.unsplash.com/photo-1603398938378-e54eab446dde',
            'https://images.unsplash.com/photo-1631549916768-4119b2e5f926',

            'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae',
            'https://images.unsplash.com/photo-1626716493137-b67fe9501e76',
            'https://images.unsplash.com/photo-1585435557343-3b092031a831',
            'https://images.unsplash.com/photo-1516549655169-df83a0774514',
            'https://images.unsplash.com/photo-1603398938378-e54eab446dde',

        ];

        return [

            'subcategory_id' => SubCategory::inRandomOrder()->first()->id,

            'name' => fake()->randomElement([
                'Paracetamol',
                'Dolo 650',
                'Crocin',
                'Ibuprofen',
                'Azithromycin',
                'Amoxicillin',
                'Cetirizine',
                'Disprin',
                'ORS',
                'Vitamin C',
            ]),


            'purchase_price' => fake()->numberBetween(20, 500),
            'selling_price' => fake()->numberBetween(200, 5000),

            'stock' => fake()->numberBetween(10, 100),

            'expiry_date' => fake()->dateTimeBetween('+6 months', '+3 years'),

            // LIVE IMAGE URL
            'image' => fake()->randomElement($images),

            'description' => fake()->sentence(3),

            'status' => 1,
        ];
    }
}