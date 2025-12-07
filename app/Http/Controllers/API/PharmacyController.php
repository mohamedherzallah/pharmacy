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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
}
