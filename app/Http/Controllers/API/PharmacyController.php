<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Http\Resources\PharmacyResource;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        $query = Pharmacy::query();

        if ($request->has('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        // ممكن فلترة حسب المسافة لو خزنت lat/lng (حسّب في الSQL أو بالـ app)
        $pharmacies = $query->paginate(20);

        return PharmacyResource::collection($pharmacies);
    }

    public function show($id)
    {
        $pharmacy = Pharmacy::with('medicines')->findOrFail($id);
        return new PharmacyResource($pharmacy);
    }

    // endpoint لتحديث بروفايل الصيدلية (مصادقة)
    public function update(Request $request)
    {
        $user = $request->user();
        $pharmacy = $user->pharmacy;
        if (! $pharmacy) {
            return response()->json(['message' => 'Pharmacy profile not found'], 404);
        }

        $data = $request->validate([
            'pharmacy_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'logo' => 'nullable|image',
            'license_image' => 'nullable|image',
            'delivery_available' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('pharmacies','public');
        }
        if ($request->hasFile('license_image')) {
            $data['license_image'] = $request->file('license_image')->store('pharmacies','public');
        }

        $pharmacy->update($data);

        return new PharmacyResource($pharmacy);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
}
