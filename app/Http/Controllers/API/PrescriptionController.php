<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pharmacy_id' => 'nullable|exists:pharmacies,id',
            'image' => 'required|image|max:5120',
            'notes' => 'nullable|string'
        ]);

        $path = $request->file('image')->store('prescriptions','public');

        $prescription = Prescription::create([
            'user_id' => $request->user()->id,
            'pharmacy_id' => $request->pharmacy_id,
            'image' => $path,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Uploaded', 'prescription' => $prescription], 201);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $prescriptions = Prescription::where('user_id', $user->id)->latest()->paginate(20);
        return response()->json($prescriptions);
    }
}
