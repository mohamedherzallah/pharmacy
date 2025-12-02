<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // تسجيل مستخدم جديد
//    public function register(Request $request)
//    {
//        $request->validate([
//            'name' => 'required',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|confirmed',
//        ]);
//
//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);
//
//        Auth::login($user);
//        return redirect()->route('home');
//    }
//
//    // تسجيل الدخول
//    public function login(Request $request)
//    {
//        $credentials = $request->only('email', 'password');
//        if (Auth::attempt($credentials)) {
//            return redirect()->route('home');
//        }
//        return back()->withErrors(['email' => 'Invalid credentials']);
//    }
//
//    // تسجيل الخروج
//    public function logout()
//    {
//        Auth::logout();
//        return redirect()->route('login');
//    }
}
