<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineResource;
use App\Models\Medicine;
use App\Models\Pharmacy;

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

        // فلترة حسب الفئة
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // البحث الجزئي مع تجاهل الحالة
        if ($request->has('q')) {
            $query->search($request->q);
        }

        $medicines = $query->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => MedicineResource::collection($medicines),
            'pagination' => [
                'total' => $medicines->total(),
                'per_page' => $medicines->perPage(),
                'current_page' => $medicines->currentPage(),
                'last_page' => $medicines->lastPage(),
            ]
        ]);
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
