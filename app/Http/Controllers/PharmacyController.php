<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacies = Pharmacy::with('user')->latest()->paginate(10);
        return view('dashbord.pharmacies.indexa', compact('pharmacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // For selecting owner
        return view('dashboard.pharmacies.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'pharmacy_name'  => 'required|string|max:255',
            'address'        => 'nullable|string',
            'latitude'       => 'nullable|numeric',
            'longitude'      => 'nullable|numeric',
            'license_image'  => 'nullable|image|mimes:jpg,jpeg,png',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->all();

        // Handle Images
        if ($request->hasFile('license_image')) {
            $data['license_image'] = $request->file('license_image')->store('licenses', 'public');
        }
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Pharmacy::create($data);

        return redirect()->route('dashboard.pharmacies.index')
            ->with('success', 'Pharmacy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pharmacy = Pharmacy::with('user')->findOrFail($id);
        return view('dashboard.pharmacies.show', compact('pharmacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $users = User::all();

        return view('dashboard.pharmacies.edit', compact('pharmacy', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pharmacy = Pharmacy::findOrFail($id);

        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'pharmacy_name'  => 'required|string|max:255',
            'address'        => 'nullable|string',
            'latitude'       => 'nullable|numeric',
            'longitude'      => 'nullable|numeric',
            'license_image'  => 'nullable|image|mimes:jpg,jpeg,png',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->all();

        // Image update
        if ($request->hasFile('license_image')) {
            $data['license_image'] = $request->file('license_image')->store('licenses', 'public');
        }
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $pharmacy->update($data);

        return redirect()->route('dashboard.pharmacies.index')
            ->with('success', 'Pharmacy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $pharmacy->delete();

        return redirect()->route('dashboard.pharmacies.index')
            ->with('success', 'Pharmacy deleted successfully');
    }

    /**
     * Approve pharmacy (custom admin action)
     */
    public function approve($id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $pharmacy->update(['is_approved' => true]);

        return back()->with('success', 'Pharmacy approved');
    }
}
