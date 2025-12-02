<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // عرض كل التصنيفات
    public function index()
    {
        $categories = Category::all();
        return view('catalog.categories', compact('categories'));
    }

    // صفحة إضافة تصنيف
    public function create()
    {
        return view('catalog.add-category');
    }

    // حفظ تصنيف جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // تجهيز البيانات
        $data['name'] = $request->name;

        // حفظ الصورة إن وُجدت
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('categories', 'public');
        }

        // إنشاء الصنف
        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    // صفحة تعديل تصنيف
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('catalog.edit-category', compact('category'));
    }

    // تحديث بيانات التصنيف
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'avatar' => 'nullable|image'
        ]);

        $category = Category::findOrFail($id);

        $data = $request->only(['name','avatar']);


        if ($request->hasFile('avatar')) {
            // (اختياري) حذف الصورة القديمة من الـ storage قبل استبدالها
            if ($category->avatar && \Storage::disk('public')->exists($category->avatar)) {
                \Storage::disk('public')->delete($category->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // حذف تصنيف
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // (اختياري) حذف صورة التصنيف من التخزين إن وُجدت
        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
