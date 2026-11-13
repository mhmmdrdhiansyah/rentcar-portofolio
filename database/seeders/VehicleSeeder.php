<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Initial fleet list from the business owner (PRD §7.1).
     *
     * UNVERIFIED DATA (PRD TODO-06/TODO-07): with_driver/self_drive flags are
     * provisional defaults, not confirmed per-unit facts. No year, trim,
     * transmission, capacity, feature, or photo is seeded — those columns stay
     * null until the owner verifies each unit. Update flags in the database (or
     * this seeder) as the owner confirms each vehicle's modes.
     */
    public function run(): void
    {
        $category = fn (string $slug) => VehicleCategory::where('slug', $slug)->value('id');

        // TODO-07: provisional service modes pending owner verification.
        $provisional = ['with_driver' => true, 'self_drive' => false];

        $vehicles = [
            ['brand' => 'Honda', 'model' => 'Brio', 'slug' => 'honda-brio', 'category' => 'city-car', 'featured' => false],
            ['brand' => 'Toyota', 'model' => 'Avanza', 'slug' => 'toyota-avanza', 'category' => 'mpv', 'featured' => true],
            ['brand' => 'Daihatsu', 'model' => 'Xenia', 'slug' => 'daihatsu-xenia', 'category' => 'mpv', 'featured' => false],
            ['brand' => 'Suzuki', 'model' => 'Ertiga', 'slug' => 'suzuki-ertiga', 'category' => 'mpv', 'featured' => false],
            ['brand' => 'Toyota', 'model' => 'Innova', 'slug' => 'toyota-innova', 'category' => 'mpv', 'featured' => false],
            ['brand' => 'Toyota', 'model' => 'Innova Reborn', 'slug' => 'toyota-innova-reborn', 'category' => 'premium', 'featured' => true],
            ['brand' => 'Toyota', 'model' => 'Innova Zenix', 'slug' => 'toyota-innova-zenix', 'category' => 'premium', 'featured' => false],
            ['brand' => 'Honda', 'model' => 'CR-V', 'slug' => 'honda-crv', 'category' => 'suv', 'featured' => true],
            ['brand' => 'Toyota', 'model' => 'Alphard', 'slug' => 'toyota-alphard', 'category' => 'luxury', 'featured' => false],
            ['brand' => 'Toyota', 'model' => 'Hiace', 'slug' => 'toyota-hiace', 'category' => 'hiace', 'featured' => true],
        ];

        foreach ($vehicles as $i => $vehicle) {
            Vehicle::updateOrCreate(
                ['slug' => $vehicle['slug']],
                [
                    'vehicle_category_id' => $category($vehicle['category']),
                    'brand' => $vehicle['brand'],
                    'model' => $vehicle['model'],
                    'name' => $vehicle['brand'].' '.$vehicle['model'],
                    'description' => null,
                    'main_image' => null, // TODO-05: real unit photo required
                    'gallery' => null,
                    'specifications' => null, // TODO-06: verified specs only
                    ...$provisional, // TODO-07: verify per unit
                    'is_featured' => $vehicle['featured'],
                    'is_published' => true,
                    'sort_order' => $i + 1,
                ],
            );
        }
    }
}
