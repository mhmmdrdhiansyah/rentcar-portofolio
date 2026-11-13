<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'featuredVehicles' => Vehicle::featured()->with('vehicleCategory')->ordered()->get(),
            'categories' => VehicleCategory::where('is_active', true)->orderBy('sort_order')->get(),
            'vehicles' => Vehicle::published()->with('vehicleCategory')->ordered()->get(),
        ]);
    }
}
