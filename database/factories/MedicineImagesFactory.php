<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;


/**
 * @extends Factory<Model>
 */
class MedicineImagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageUrls = [

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
        $url = $imageUrls[array_rand($imageUrls)];
        $imageContents = file_get_contents($url);
        $filename = 'medicines/' . uniqid() . '.jpg';
        Storage::disk('public')->put($filename, $imageContents);
        return [
            'medicine_id' => Medicine::inRandomOrder()->value('id'),
            'image_path' => $filename,
        ];
    }
}
