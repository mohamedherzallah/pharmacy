<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PharmacyMedicine;
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
            'medicine_id' => 'required|exists:medicines,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $pharmacy = $request->user()->pharmacy;
        if (! $pharmacy) return response()->json(['message'=>'No pharmacy profile'], 404);

        $pharmacy->medicines()->syncWithoutDetaching([
            $request->medicine_id => [
                'price' => $request->price,
                'stock' => $request->stock
            ]
        ]);

        return response()->json(['message' => 'Saved']);
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
