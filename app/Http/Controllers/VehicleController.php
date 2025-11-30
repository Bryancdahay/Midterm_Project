<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Brand;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('brand')->orderBy('id')->get();
        $brands = Brand::orderBy('name')->get();
        $totalVehicles = Vehicle::count();
        $totalBrands = Brand::count();
        $vehiclesWithoutBrand = Vehicle::whereNull('brand_id')->count();

        return view('dashboard', compact('vehicles', 'brands', 'totalVehicles', 'totalBrands', 'vehiclesWithoutBrand'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'model_year' => 'nullable|integer',
            'color' => 'nullable|string|max:100',
            'price' => 'nullable|numeric',
        ]);

        Vehicle::create($data);

        return redirect()->route('dashboard')->with('success', 'Vehicle added successfully.');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'model_year' => 'nullable|integer',
            'color' => 'nullable|string|max:100',
            'price' => 'nullable|numeric',
        ]);

        $vehicle->update($data);

        return redirect()->route('dashboard')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('dashboard')->with('success', 'Vehicle deleted successfully.');
    }
}
