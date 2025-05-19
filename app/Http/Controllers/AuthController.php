<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLoginForm()
{
    if (Auth::guard('admin')->check()) {
        return redirect('/admin/dashboard_admin');
    }

    if (Auth::check()) {
        return redirect('/beranda');
    }

    return view('login');
}


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Coba cari di tabel admins
        $admin = Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin); // Pakai guard admin
            return redirect('/admin/dashboard_admin');
        }

        // 2. Kalau bukan admin, coba cari di tabel users
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); // Guard default
            return redirect('/beranda');
        }

        // 3. Kalau gagal semua
        return back()->with('error', 'Email atau password salah');
    }
}
