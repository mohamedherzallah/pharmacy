<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // سجل مستخدم (user أو pharmacy عبر role)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'nullable|string',
            'role' => 'required|in:user,pharmacy,admin'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'role'=> $request->role,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function registerPharmacy(Request $request)
    {
        $request->validate([
            // بيانات المستخدم (من جدول users)
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|string|unique:users,phone',

            // بيانات الصيدلية (من جدول pharmacies)
            'pharmacy_name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

            'license_image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 1) إنشاء المستخدم بدور pharmacy
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'pharmacy',
            'password' => Hash::make($request->password),
        ]);

        // 2) رفع صور الترخيص والشعار
        $licenseImage = null;
        $logoImage = null;

        if ($request->hasFile('license_image')) {
            $filename = time().'_license.'.$request->license_image->extension();
            $request->license_image->move(public_path('uploads/licenses'), $filename);
            $licenseImage = 'uploads/licenses/'.$filename;
        }

        if ($request->hasFile('logo')) {
            $filename = time().'_logo.'.$request->logo->extension();
            $request->logo->move(public_path('uploads/avatars'), $filename);
            $logoImage = 'uploads/avatars/'.$filename;
        }

        // 3) إنشاء سجل الصيدلية
        $pharmacy = Pharmacy::create([
            'user_id' => $user->id,
            'pharmacy_name' => $request->pharmacy_name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'license_image' => $licenseImage,
            'logo' => $logoImage,
            'is_approved' => false, // ريثما توافق الإدارة
        ]);

        // 4) توليد توكن الصيدلية
        $token = $user->createToken('pharmacy-token')->plainTextToken;

        return response()->json([
            'message' => 'Pharmacy registered successfully, pending admin approval.',
            'user' => $user,
            'pharmacy' => $pharmacy,
            'token' => $token,
        ], 201);
    }


    // تسجيل دخول
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // احذف توكنات سابقة (اختياري)
        // $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // تسجيل خروج
    public function logout(Request $request)
    {
        $user = $request->user();
        // احذف التوكن الحالي
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
