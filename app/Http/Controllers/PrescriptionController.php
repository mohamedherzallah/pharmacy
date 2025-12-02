<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:jpg,png,pdf']);
        Prescription::create([
            'user_id' => Auth::id(),
            'file' => $request->file('file')->store('prescriptions'),
        ]);
        return back()->with('success', 'Prescription uploaded');
    }
}
