<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ------------------- عرض المستخدمين -------------------
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('manage-user', compact('users'));
    }

    // ------------------- عرض صفحة إنشاء مستخدم -------------------
    public function create()
    {
        return view('dashboard.users.create');
    }

    // ------------------- حفظ مستخدم جديد -------------------
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'nullable', // toggle (checkbox) قد لا يكون موجود
        ]);

        // Handle avatar upload
        $filename = null;
        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('uploads/avatars'), $filename);
        }

        // Create user
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'avatar' => $filename,
            'status' => $request->has('status') ? 1 : 0, // <-- toggle
        ]);

        return redirect()->back()->with('success', 'User created successfully');
    }
    // ------------------- صفحة تعديل مستخدم -------------------
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.edit', compact('user'));
    }

    // ------------------- تعديل مستخدم -------------------
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|unique:users,email,' . $id,
            'phone'    => 'required|unique:users,phone,' . $id,
            'role'     => 'required|in:user,pharmacy,admin',
            'status'   => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name','email','phone','role','status']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // ------------------- حذف مستخدم -------------------
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => true]);
    }


}
