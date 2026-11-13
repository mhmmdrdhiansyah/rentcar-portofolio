<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleModelsTest extends TestCase
{
    use RefreshDatabase;

    // Covers vehicle/category models and seeders (PRD §7, §15).
    public function test_seeders_create_thirteen_vehicles_in_seven_categories(): void
    {
        $this->seed();

        $this->assertSame(13, Vehicle::count());
        $this->assertSame(7, VehicleCategory::count());

        $names = Vehicle::query()->orderBy('sort_order')->pluck('model')->all();
        $this->assertSame([
            'Brio', 'Agya', 'Ayla', 'Mobilio', 'Avanza', 'Xenia',
            'Ertiga', 'Innova', 'Innova Reborn', 'Innova Zenix',
            'CR-V', 'Alphard', 'Hiace',
        ], $names);
    }

    public function test_published_scope_excludes_unpublished_vehicles(): void
    {
        $this->seed();
        Vehicle::query()->where('model', 'Alphard')->update(['is_published' => false]);

        $this->assertSame(12, Vehicle::published()->count());
    }

    public function test_featured_scope_returns_four_seeded_vehicles(): void
    {
        $this->seed();

        $this->assertSame(4, Vehicle::featured()->count());
    }

    public function test_service_mode_flags_are_strictly_boolean_per_vehicle(): void
    {
        $this->seed();

        Vehicle::all()->each(function (Vehicle $vehicle): void {
            $this->assertIsBool($vehicle->with_driver, $vehicle->name);
            $this->assertIsBool($vehicle->self_drive, $vehicle->name);
        });
    }
}
