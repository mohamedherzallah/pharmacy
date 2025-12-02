<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user()->load('pharmacy');
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'password' => 'nullable|confirmed|min:6',
        ]);

        if (! empty($data['password'])) {
            $user->password = bcrypt($data['password']);
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $user->update($data);

        return response()->json($user);
    }
}
