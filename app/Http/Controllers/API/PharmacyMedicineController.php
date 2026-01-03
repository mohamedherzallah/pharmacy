<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\pharmacy_medicine;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PharmacyMedicineController extends Controller
{
    // أدوية الصيدلية الحالية
    public function index(Request $request)
    {
        $pharmacy = $request->user()->pharmacy;
        if (! $pharmacy) return response()->json(['message'=>'No pharmacy profile'], 404);

        $items = $pharmacy->medicines()->withPivot('price','stock')->paginate(20);
        return response()->json($items);
    }

    // إضافة أو تحديث دواء للصيدلية
    public function store(Request $request)
    {
        $request->validate([
            'medicines' => 'required|array',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.price' => 'nullable|numeric|min:0',
            'medicines.*.stock' => 'required|integer|min:0',
        ]);

        $pharmacy = $request->user()->pharmacy;
        if (!$pharmacy) {
            return response()->json(['message' => 'No pharmacy profile'], 404);
        }

        DB::transaction(function() use ($request, $pharmacy) {
            foreach ($request->medicines as $item) {
                $medicine = Medicine::findOrFail($item['medicine_id']);
                $requestedStock = $item['stock'];

                // 1. الحصول على المخزون الحالي في الصيدلية لهذا الدواء
                $existingRecord = $pharmacy->medicines()
                    ->where('medicine_id', $medicine->id)
                    ->first();

                $currentStockInPharmacy = $existingRecord ? $existingRecord->pivot->stock : 0;

                // 2. حساب الفرق المطلوب
                $stockDifference = $requestedStock - $currentStockInPharmacy;

                // 3. إذا طلب زيادة في المخزون
                if ($stockDifference > 0) {
                    // التحقق من المخزون العام
                    if ($medicine->general_stock < $stockDifference) {
                        throw new \Exception("Not enough general stock for {$medicine->name}. Available: {$medicine->general_stock}, Requested: {$stockDifference}");
                    }

                    // خصم الفرق فقط من المخزون العام
                    $medicine->decrement('general_stock', $stockDifference);
                }
                // 4. إذا طلب تقليل المخزون (إرجاع للعام)
                elseif ($stockDifference < 0) {
                    $medicine->increment('general_stock', abs($stockDifference));
                }

                // 5. تحديث أو إضافة الدواء في الصيدلية
                $pharmacy->medicines()->syncWithoutDetaching([
                    $medicine->id => [
                        'price' => $item['price'] ?? $existingRecord?->pivot?->price ?? 0,
                        'stock' => $requestedStock,
                    ]
                ]);
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Medicines saved successfully'
        ], 200);
    }



    // إزالة دواء من الصيدلية
    public function destroy(Request $request, $medicineId)
    {
        $pharmacy = $request->user()->pharmacy;
        if (! $pharmacy) return response()->json(['message'=>'No pharmacy profile'], 404);

        $pharmacy->medicines()->detach($medicineId);

        return response()->json(['message' => 'Removed']);
    }
}
// public function store(Request $request)
//    {
//        $request->validate([
//            'medicines' => 'required|array',
//            'medicines.*.medicine_id' => 'required|exists:medicines,id',
//            'medicines.*.price' => 'nullable|numeric|min:0',
//            'medicines.*.stock' => 'required|integer|min:0',
//        ]);
//
//        $pharmacy = $request->user()->pharmacy;
//        if (! $pharmacy) {
//            return response()->json(['message' => 'No pharmacy profile'], 404);
//        }
//
//        DB::transaction(function() use ($request, $pharmacy) {
//
//            $attachData = [];
//
//            foreach ($request->medicines as $item) {
//                $medicine = Medicine::findOrFail($item['medicine_id']);
//                $quantity = $item['stock'];
//
//                // تحقق من المخزون العام
//                if ($medicine->general_stock < $quantity) {
//                    throw new \Exception("Not enough general stock for medicine ID {$medicine->id}");
//                }
//
//                // خصم من المخزون العام
//                $medicine->general_stock -= $quantity;
//                $medicine->save();
//
//                $attachData[$medicine->id] = [
//                    'price' => $item['price'] ?? 0,
//                    'stock' => $quantity,
//                ];
//            }
//
//            // يحافظ على الأدوية السابقة ويضيف الجديدة أو يحدث الموجود
//            $pharmacy->medicines()->syncWithoutDetaching($attachData);
//        });
//
//        return response()->json([
//            'status' => 'success',
//            'message' => 'Medicines saved successfully',
//            'data' => $request->medicines
//        ], 200);
//    }
