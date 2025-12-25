<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\pharmacy_medicine;
use App\Models\Medicine;
use Illuminate\Http\Request;

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
        if (! $pharmacy) {
            return response()->json(['message' => 'No pharmacy profile'], 404);
        }

        DB::transaction(function() use ($request, $pharmacy) {

            $attachData = [];

            foreach ($request->medicines as $item) {
                $medicine = Medicine::findOrFail($item['medicine_id']);
                $quantity = $item['stock'];

                // تحقق من المخزون العام
                if ($medicine->general_stock < $quantity) {
                    throw new \Exception("Not enough general stock for medicine ID {$medicine->id}");
                }

                // خصم من المخزون العام
                $medicine->general_stock -= $quantity;
                $medicine->save();

                $attachData[$medicine->id] = [
                    'price' => $item['price'] ?? 0,
                    'stock' => $quantity,
                ];
            }

            // يحافظ على الأدوية السابقة ويضيف الجديدة أو يحدث الموجود
            $pharmacy->medicines()->syncWithoutDetaching($attachData);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Medicines saved successfully',
            'data' => $request->medicines
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
