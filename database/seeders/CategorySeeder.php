<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Storage;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                Category::factory()->count(10)->create();

//             $now = now();


// $categories = [
//     [
//         'name' => 'Men Health',
//         'description' => 'Health products for men',
//         'status' => 'active',
//         'image' => 'categories/Vitamin C Daily Glow Cream 80 g.avif',

//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Women Health',
//         'description' => 'Health products for women',
//         'status' => 'active',
//         'image' => 'categories/images (3).jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Child Care',
//         'description' => 'Health for children',
//         'status' => 'active',
//         'image' => 'categories/images (4).jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Eye Care',
//         'description' => 'Eye related products',
//         'status' => 'active',
//         'image' => 'categories/eye-drops-closeup.webp',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Ear Care',
//         'description' => 'Ear treatment products',
//         'status' => 'active',
//         'image' => 'categories/ear.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Dental Care',
//         'description' => 'Teeth and oral care',
//         'status' => 'active',
//         'image' => 'categories/dental.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Skin Care',
//         'description' => 'Skin treatment products',
//         'status' => 'active',
//         'image' => 'categories/skin.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Hair Care',
//         'description' => 'Hair growth and care',
//         'status' => 'active',
//         'image' => 'categories/hair.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Heart Care',
//         'description' => 'Cardio health products',
//         'status' => 'active',
//         'image' => 'categories/heart.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Liver Care',
//         'description' => 'Liver detox products',
//         'status' => 'active',
//         'image' => 'categories/liver.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Kidney Care',
//         'description' => 'Kidney health support',
//         'status' => 'active',
//         'image' => 'categories/kidney.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Bone Care',
//         'description' => 'Bone strength products',
//         'status' => 'active',
//         'image' => 'categories/bone.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Joint Care',
//         'description' => 'Joint pain relief',
//         'status' => 'active',
//         'image' => 'categories/joint.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Respiratory Care',
//         'description' => 'Lungs and breathing health',
//         'status' => 'active',
//         'image' => 'categories/respiratory.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Digestive Health',
//         'description' => 'Stomach and digestion',
//         'status' => 'active',
//         'image' => 'categories/digestive.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Immunity Booster',
//         'description' => 'Boost immune system',
//         'status' => 'active',
//         'image' => 'categories/immunity.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Herbal Medicine',
//         'description' => 'Natural herbal products',
//         'status' => 'active',
//         'image' => 'categories/herbal.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Diabetes Care',
//         'description' => 'Sugar control products',
//         'status' => 'active',
//         'image' => 'categories/diabetes.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Blood Pressure Care',
//         'description' => 'BP control medicine',
//         'status' => 'active',
//         'image' => 'categories/bp.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
//     [
//         'name' => 'Mental Health',
//         'description' => 'Stress and mental wellness',
//         'status' => 'active',
//         'image' => 'categories/mental.jpg',
//         'created_at' => $now,
//         'updated_at' => $now,
//     ],
// ];

//     Category::insert($categories);

//     }
}
}
