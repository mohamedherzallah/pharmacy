<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
//    public function profile(Request $request)
//    {
//        $user = $request->user()->load('pharmacy');
//        return response()->json($user);
//    }
//
//    public function update(Request $request)
//    {
//        $user = $request->user();
//        $data = $request->validate([
//            'name' => 'nullable|string|max:255',
//            'phone' => 'nullable|string',
//            'password' => 'nullable|confirmed|min:6',
//        ]);
//
//        if (! empty($data['password'])) {
//            $user->password = bcrypt($data['password']);
//            unset($data['password']);
//            unset($data['password_confirmation']);
//        }
//
//        $user->update($data);
//
//        return response()->json($user);
//    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
            // حقل جديد_password_confirmation لتأكيد كلمة المرور
        ]);

        $user = $request->user(); // المستخدم المسجّل الدخول

        // التحقق من كلمة المرور الحالية
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'كلمة المرور الحالية غير صحيحة'
            ], 403);
        }

        // تحديث كلمة المرور الجديدة
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'تم تغيير كلمة المرور بنجاح'
        ]);
    }
}
