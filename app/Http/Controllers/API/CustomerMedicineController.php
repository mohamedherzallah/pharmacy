<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerMedicineController extends Controller
{
    /**
     * البحث عن دواء في الصيدليات
     * GET /api/customer/medicines/search?query=panadol&city=الرياض
     */
    public function search(Request $request)
    {
        // التحقق من البيانات
        $request->validate([
            'query' => 'required|string|min:1',
            'city' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'page' => 'nullable|integer|min:1',
            'in_stock' => 'nullable|boolean', // للفلترة حسب التوفر
        ]);

        try {
            // 1. بدء Query البحث في الأدوية
            $query = Medicine::query()->where('is_active', true);

            // البحث بالاسم
            $searchTerm = $request->input('query');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });

            // فلترة بالتصنيف
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // 2. جلب العلاقة مع الصيدليات مع تطبيق الفلاتر
            $query->with(['pharmacies' => function($q) use ($request) {
                // الأساس: فقط الصيدليات المعتمدة
                $q->where('pharmacies.is_approved', true);

                // فلترة بالمخزون إذا طلب
                $inStock = $request->boolean('in_stock', true);
                if ($inStock) {
                    $q->where('pharmacy_medicine.stock', '>', 0);
                }

                // فلترة بالسعر إذا طلب
                if ($request->has('min_price')) {
                    $q->where('pharmacy_medicine.price', '>=', $request->min_price);
                }
                if ($request->has('max_price')) {
                    $q->where('pharmacy_medicine.price', '<=', $request->max_price);
                }

                // فلترة بالمدينة (تحتاج إضافة حقل city في Pharmacy)
                if ($request->has('city')) {
                    // إذا كان لديك حقل city في Pharmacy
                    // $q->where('pharmacies.city', 'LIKE', '%' . $request->city . '%');
                    // بديل: البحث في العنوان
                    $q->where('pharmacies.address', 'LIKE', '%' . $request->city . '%');
                }

                // اختيار الأعمدة المطلوبة
                $q->select(
                    'pharmacies.id',
                    'pharmacies.pharmacy_name as name', // ملاحظة: pharmacy_name وليس name
                    'pharmacies.address',
                    'pharmacies.logo',
                    'pharmacy_medicine.price',
                    'pharmacy_medicine.stock'
                );

                // ترتيب بالسعر الأقل أولاً
                $q->orderBy('pharmacy_medicine.price', 'asc');
            }]);

            // 3. فقط الأدوية الموجودة في صيدليات معتمدة
            $query->whereHas('pharmacies', function($q) use ($request) {
                $q->where('pharmacies.is_approved', true);
                if ($request->boolean('in_stock', true)) {
                    $q->where('pharmacy_medicine.stock', '>', 0);
                }
            });

            // 4. الترحيم
            $perPage = $request->input('per_page', 15);
            $medicines = $query->paginate($perPage);

            // 5. تحسين شكل البيانات للإرجاع
            $formattedMedicines = $medicines->map(function($medicine) {
                return [
                    'medicine' => [
                        'id' => $medicine->id,
                        'name' => $medicine->name,
                        'description' => $medicine->description,
                        'category_id' => $medicine->category_id,
                        'image' => $medicine->image,
                        'general_stock' => $medicine->general_stock,
                        'category' => $medicine->category ? $medicine->category->name : null,
                    ],
                    'available_in' => $medicine->pharmacies->map(function($pharmacy) {
                        return [
                            'pharmacy_id' => $pharmacy->id,
                            'name' => $pharmacy->name,
                            'address' => $pharmacy->address,
                            'logo' => $pharmacy->logo,
                            'price' => $pharmacy->pivot->price,
                            'stock' => $pharmacy->pivot->stock,
                            'is_available' => $pharmacy->pivot->stock > 0
                        ];
                    }),
                    'price_range' => $medicine->pharmacies->count() > 0 ? [
                        'min' => $medicine->pharmacies->min('pivot.price'),
                        'max' => $medicine->pharmacies->max('pivot.price'),
                        'avg' => $medicine->pharmacies->avg('pivot.price')
                    ] : null
                ];
            });

            // 6. الاستجابة النهائية
            return response()->json([
                'status' => 'success',
                'message' => 'Search results retrieved successfully',
                'data' => [
                    'results' => $formattedMedicines,
                    'pagination' => [
                        'current_page' => $medicines->currentPage(),
                        'last_page' => $medicines->lastPage(),
                        'per_page' => $medicines->perPage(),
                        'total' => $medicines->total(),
                        'has_more' => $medicines->hasMorePages(),
                    ],
                    'search_params' => $request->only(['query', 'city', 'category_id', 'min_price', 'max_price'])
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search medicines',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * عرض أدوية صيدلية معينة
     * GET /api/customer/pharmacies/{pharmacy}/medicines
     */
    public function pharmacyMedicines(Request $request, Pharmacy $pharmacy)
    {
        // التحقق من أن الصيدلية معتمدة
        if (!$pharmacy->is_approved) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pharmacy is not approved or not found'
            ], 404);
        }

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'in_stock_only' => 'nullable|boolean',
            'sort_by' => 'nullable|in:name_asc,name_desc,price_asc,price_desc',
            'search' => 'nullable|string|min:1',
        ]);

        try {
            // بدء Query من خلال pivot table
            $query = DB::table('pharmacy_medicines')
                ->join('medicines', 'pharmacy_medicines.medicine_id', '=', 'medicines.id')
                ->leftJoin('categories', 'medicines.category_id', '=', 'categories.id')
                ->where('pharmacy_medicines.pharmacy_id', $pharmacy->id)
                ->where('pharmacy_medicines.stock', '>', 0) // فقط المتوفر
                ->where('medicines.is_active', true)
                ->select(
                    'medicines.id',
                    'medicines.name',
                    'medicines.description',
                    'medicines.image',
                    'categories.name as category_name',
                    'pharmacy_medicines.price',
                    'pharmacy_medicines.stock',
                    'pharmacy_medicines.updated_at as last_updated'
                );

            // تطبيق الفلاتر
            if ($request->has('category_id')) {
                $query->where('medicines.category_id', $request->category_id);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('medicines.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('medicines.description', 'LIKE', '%' . $search . '%');
                });
            }

            if ($request->boolean('in_stock_only', true)) {
                $query->where('pharmacy_medicines.stock', '>', 0);
            }

            // الترتيب
            $sortBy = $request->input('sort_by', 'name_asc');
            switch ($sortBy) {
                case 'name_desc': $query->orderBy('medicines.name', 'desc'); break;
                case 'price_asc': $query->orderBy('pharmacy_medicines.price', 'asc'); break;
                case 'price_desc': $query->orderBy('pharmacy_medicines.price', 'desc'); break;
                default: $query->orderBy('medicines.name', 'asc');
            }

            // الترحيم
            $perPage = $request->input('per_page', 20);
            $medicines = $query->paginate($perPage);

            // الاستجابة
            return response()->json([
                'status' => 'success',
                'data' => [
                    'pharmacy' => [
                        'id' => $pharmacy->id,
                        'name' => $pharmacy->pharmacy_name,
                        'address' => $pharmacy->address,
                        'logo' => $pharmacy->logo,
                        'is_approved' => $pharmacy->is_approved,
                    ],
                    'medicines' => $medicines->items(),
                    'pagination' => [
                        'current_page' => $medicines->currentPage(),
                        'total' => $medicines->total(),
                        'per_page' => $medicines->perPage(),
                        'last_page' => $medicines->lastPage(),
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve pharmacy medicines',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * عرض الأدوية حسب التصنيف مع الصيدليات
     * GET /api/customer/categories/{category}/medicines
     */
    public function medicinesByCategory(Request $request, Category $category)
    {
        $request->validate([
            'city' => 'nullable|string',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'in_stock' => 'nullable|boolean',
        ]);

        try {
            $query = $category->medicines()
                ->where('is_active', true)
                ->with(['pharmacies' => function($q) use ($request) {
                    $q->where('pharmacies.is_approved', true);

                    if ($request->boolean('in_stock', true)) {
                        $q->where('pharmacy_medicine.stock', '>', 0);
                    }

                    if ($request->has('min_price')) {
                        $q->where('pharmacy_medicine.price', '>=', $request->min_price);
                    }
                    if ($request->has('max_price')) {
                        $q->where('pharmacy_medicine.price', '<=', $request->max_price);
                    }

                    $q->select(
                        'pharmacies.id',
                        'pharmacies.pharmacy_name as name',
                        'pharmacies.address',
                        'pharmacy_medicine.price',
                        'pharmacy_medicine.stock'
                    );
                }])
                ->whereHas('pharmacies', function($q) use ($request) {
                    $q->where('pharmacies.is_approved', true);
                    if ($request->boolean('in_stock', true)) {
                        $q->where('pharmacy_medicine.stock', '>', 0);
                    }
                });

            $medicines = $query->paginate(20);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'avatar' => $category->avatar,
                    ],
                    'medicines' => $medicines->map(function($medicine) {
                        return [
                            'id' => $medicine->id,
                            'name' => $medicine->name,
                            'description' => $medicine->description,
                            'image' => $medicine->image,
                            'available_in_pharmacies' => $medicine->pharmacies->count(),
                            'price_range' => $medicine->pharmacies->count() > 0 ? [
                                'min' => $medicine->pharmacies->min('pivot.price'),
                                'max' => $medicine->pharmacies->max('pivot.price')
                            ] : null
                        ];
                    }),
                    'pagination' => [
                        'current_page' => $medicines->currentPage(),
                        'total' => $medicines->total(),
                        'per_page' => $medicines->perPage(),
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve medicines by category'
            ], 500);
        }
    }
}
