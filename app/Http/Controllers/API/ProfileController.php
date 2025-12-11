<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pharmacy;

class ProfileController extends Controller
{
    // جلب بيانات البروفايل
    public function getProfile(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'Not authenticated'
            ], 401);
        }

        if ($user->role === 'pharmacy') {
            // بيانات الصيدلية المرتبطة بالمستخدم
            $profile = Pharmacy::where('user_id', $user->id)->first();
        } else {
            // بيانات المستخدم العادي
            $profile = $user;
        }

        return response()->json([
            'profile' => $profile
        ]);
    }

    // تحديث بيانات البروفايل
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'pharmacy') {
            $profile = Pharmacy::where('user_id', $user->id)->firstOrFail();

            // تحقق من البيانات
            $request->validate([
                'pharmacy_name' => 'string|max:255',
                'address' => 'string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'license_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
                'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ]);

            // رفع صورة الترخيص
            if ($request->hasFile('license_image')) {
                $filename = time().'_license.'.$request->license_image->extension();
                $request->license_image->move(public_path('uploads/licenses'), $filename);
                $profile->license_image = 'uploads/licenses/'.$filename;
            }

            // رفع الشعار
            if ($request->hasFile('logo')) {
                $filename = time().'_logo.'.$request->logo->extension();
                $request->logo->move(public_path('uploads/logos'), $filename);
                $profile->logo = 'uploads/logos/'.$filename;
            }

            // تحديث البيانات
            $profile->pharmacy_name = $request->pharmacy_name;
            $profile->address = $request->address;
            $profile->latitude = $request->latitude;
            $profile->longitude = $request->longitude;
            $profile->save();

            // تحديث اسم المستخدم تلقائياً
            $user->name = $request->pharmacy_name;
            $user->save();

        } else {
            // المستخدم العادي
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                // أضف أي حقول أخرى تحتاجها
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        }

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $user->role === 'pharmacy' ? $profile : $user
        ], 200);
    }
}
