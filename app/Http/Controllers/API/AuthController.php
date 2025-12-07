<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;
use App\Models\Pharmacy;


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
        // التحقق من بيانات المستخدم فقط
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|string|unique:users,phone',
        ]);

        // 1) إنشاء المستخدم بدور pharmacy
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'pharmacy',
            'password' => Hash::make($request->password),
        ]);

        // 2) إنشاء سجل صيدلية فارغ سيتم استكماله لاحقاً
        $pharmacy = Pharmacy::create([
            'user_id' => $user->id,
            'pharmacy_name' => null,
            'address' => null,
            'latitude' => null,
            'longitude' => null,
            'license_image' => null,
            'logo' => null,
            'is_approved' => false,
        ]);

        // 3) توليد التوكن
        $token = $user->createToken('pharmacy-token')->plainTextToken;

        return response()->json([
            'message' => 'Pharmacy registered successfully. Complete your profile.',
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
            'user' => new UserResource($user),
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
