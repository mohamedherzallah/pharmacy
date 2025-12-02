<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // كل الأدوية (قد تحتاج pagination)
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $medicines = $query->paginate(20);

        return MedicineResource::collection($medicines);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicine = Medicine::with('category')->findOrFail($id);
        return new MedicineResource($medicine);
    }
    public function byPharmacy($pharmacyId)
    {
        $pharmacy = Pharmacy::findOrFail($pharmacyId);
        $medicines = $pharmacy->medicines()->paginate(20);
        return MedicineResource::collection($medicines);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
