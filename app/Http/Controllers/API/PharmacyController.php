<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Http\Resources\PharmacyResource;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    // في PharmacyController.php
    public function index(Request $request)
    {
        try {
            // فقط الصيدليات المعتمدة - بدون شرط status
            $query = Pharmacy::where('is_approved', true);

            if ($request->has('q')) {
                $search = $request->q;
                $query->where(function($q) use ($search) {
                    $q->where('pharmacy_name', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%');
                });
            }

            // فلترة حسب المدينة إذا كان الحقل موجوداً
            if ($request->has('city')) {
                // إذا كان لديك حقل city، أضفه هنا
                // $query->where('city', 'like', '%' . $request->city . '%');
            }

            // ترتيب حسب تاريخ الإنشاء
            $query->orderBy('created_at', 'desc');

            $pharmacies = $query->paginate($request->input('per_page', 20));

            return response()->json([
                'success' => true,
                'message' => 'Pharmacies retrieved successfully',
                'data' => PharmacyResource::collection($pharmacies),
                'meta' => [
                    'current_page' => $pharmacies->currentPage(),
                    'per_page' => $pharmacies->perPage(),
                    'total' => $pharmacies->total(),
                    'last_page' => $pharmacies->lastPage(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve pharmacies',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
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
    public function stats(Request $request)
    {
        $pharmacy = $request->user()->pharmacy; // نفترض أن الـ User مرتبط بصيدلية

        if (!$pharmacy) {
            return response()->json([
                'message' => 'الصيدلية غير موجودة'
            ], 404);
        }

        $medicineCount = $pharmacy->medicines()->count();
        $ordersCount = $pharmacy->orders()->count();

        return response()->json([
            'medicine_count' => $medicineCount,
            'orders_count' => $ordersCount,
        ]);
    }

}
