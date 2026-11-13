<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'City Car / Economy', 'slug' => 'city-car', 'sort_order' => 1],
            ['name' => 'Family / Standard MPV', 'slug' => 'mpv', 'sort_order' => 2],
            ['name' => 'Premium MPV', 'slug' => 'premium', 'sort_order' => 3],
            ['name' => 'SUV', 'slug' => 'suv', 'sort_order' => 4],
            ['name' => 'Luxury', 'slug' => 'luxury', 'sort_order' => 5],
            ['name' => 'Hiace', 'slug' => 'hiace', 'sort_order' => 6],
            ['name' => 'Group Transportation', 'slug' => 'group-transportation', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            VehicleCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category + ['is_active' => true],
            );
        }
    }
}
