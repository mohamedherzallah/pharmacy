<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Medicine;

use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $medicines = Medicine::all();
        return view('catalog.products', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('catalog.add-product', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                    'name' => 'required|string',
                    'image' => 'nullable|image',
                     'manufacturer'=> 'string'
                ]);

                $data = $request->all();

                if ($request->hasFile('image')) {
                    $data['image'] = $request->file('image')->store('medicines', 'public');
                }

                Medicine::create($data);

                return redirect()->route('Medicines.index')->with('success', 'product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $medicine = Medicine::findOrFail($id);
         $categories = Category::orderBy('name')->get();
        return view('catalog.edit-product', compact('medicine', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
                    'name' => 'required|string',
                ]);

                $medicine = Medicine::findOrFail($id);
                $data = $request->all();

                if ($request->hasFile('image')) {
                    $data['image'] = $request->file('image')->store('medicines', 'public');
                }

                $medicine->update($data);

                return redirect()->route('Medicines.index')->with('success', 'product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Medicine::findOrFail($id)->delete();
        return redirect()->route('Medicines.index')->with('success', 'medicine deleted.');
    }
}
