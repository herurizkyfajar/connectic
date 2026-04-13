<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminAccountController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.account.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();
        
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('admins')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->name = $request->name;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.account.index')->with('success', 'Akun berhasil diperbarui.');
    }
}
