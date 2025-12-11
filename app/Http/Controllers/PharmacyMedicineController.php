<?php

namespace App\Http\Controllers;
use App\Models\pharmacy_medicine;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmacyMedicineController extends Controller
{
    //
    public function index()
    {
        $pharmacyId = Auth::user()->Pharmacy->id;
        $medicines = pharmacy_medicine::with('medicine')
            ->where('pharmacy_id', $pharmacyId)
            ->get();

        return view('pharmacy.medicines.index', compact('medicines'));
    }

    // إضافة دواء من القائمة للصيدلية
    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        pharmacy_medicine::updateOrCreate(
            [
                'pharmacy_id' => Auth::user()->Pharmacy->id,
                'medicine_id' => $request->medicine_id,
            ],
            [
                'stock' => $request->stock,
                'price' => $request->price
            ]
        );

        return back()->with('success', 'Medicine added/updated successfully');
    }

    // إزالة دواء من الصيدلية
    public function destroy($id)
    {
        $pharmacyId = Auth::user()->Pharmacy->id;
        $pharmacyMedicine = pharmacy_medicine::where('id', $id)
            ->where('pharmacy_id', $pharmacyId)
            ->firstOrFail();
        $pharmacyMedicine->delete();

        return back()->with('success', 'Medicine removed successfully');
    }

}
