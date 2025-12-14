<?php
// app/Http/Controllers/API/FavoriteController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * عرض جميع مفضلات المستخدم
     */
    public function index()
    {
        $user = Auth::user();

        // جلب المفضلات مع معلومات الدواء
        $favorites = $user->favorites()->with(['medicine.category', 'medicine.pharmacy'])
            ->orderBy('created_at', 'desc')
            ->get();

        // تنسيق البيانات
        $formattedFavorites = $favorites->map(function ($favorite) {
            return [
                'id' => $favorite->id,
                'medicine' => [
                    'id' => $favorite->medicine->id,
                    'name' => $favorite->medicine->name,
                    'description' => $favorite->medicine->description,
                    'price' => $favorite->medicine->price,
                    'image' => $favorite->medicine->image,
                    'category' => $favorite->medicine->category->name ?? null,
                    'pharmacy' => $favorite->medicine->pharmacy->name ?? null
                ],
                'added_at' => $favorite->created_at
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $favorites->count(),
            'data' => $formattedFavorites
        ]);
    }

    /**
     * إضافة دواء للمفضلة
     */
    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id'
        ]);

        $user = Auth::user();
        $medicineId = $request->medicine_id;

        // التحقق إذا كان الدواء موجود بالفعل في المفضلة
        $existingFavorite = $user->favorites()
            ->where('medicine_id', $medicineId)
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'success' => false,
                'message' => 'الدواء موجود بالفعل في المفضلة'
            ], 400);
        }

        // التحقق من وجود الدواء
        $medicine = Medicine::find($medicineId);
        if (!$medicine) {
            return response()->json([
                'success' => false,
                'message' => 'الدواء غير موجود'
            ], 404);
        }

        // إضافة للمفضلة
        $favorite = $user->favorites()->create([
            'medicine_id' => $medicineId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الدواء إلى المفضلة',
            'data' => [
                'id' => $favorite->id,
                'medicine' => [
                    'id' => $medicine->id,
                    'name' => $medicine->name,
                    'price' => $medicine->price
                ]
            ]
        ], 201);
    }

    /**
     * إزالة دواء من المفضلة
     */
    public function destroy($id)
    {
        $user = Auth::user();

        // البحث باستخدام medicine_id أو favorite_id
        $favorite = $user->favorites()
            ->where(function ($query) use ($id) {
                $query->where('id', $id)
                    ->orWhere('medicine_id', $id);
            })
            ->first();

        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'العنوان غير موجود في المفضلة'
            ], 404);
        }

        $medicineName = $favorite->medicine->name;
        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => "تم إزالة '$medicineName' من المفضلة"
        ]);
    }

    /**
     * التحقق إذا كان دواء في المفضلة
     */
    public function check($medicineId)
    {
        $user = Auth::user();

        $isFavorite = $user->favorites()
            ->where('medicine_id', $medicineId)
            ->exists();

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite
        ]);
    }
}
