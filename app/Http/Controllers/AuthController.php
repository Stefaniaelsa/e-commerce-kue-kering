<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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

         $remember = $request->has('remember'); // Ambil checkbox remember me

        // 1. Coba cari di tabel admins
        $admin = Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin, $remember); // Pakai guard admin
            return redirect('/admin/dashboard_admin');
        }

        // 2. Kalau bukan admin, coba cari di tabel users
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $remember); // Guard default
            return redirect('/beranda');
        }

        // 3. Kalau gagal semua
        return back()->with('error', 'Email atau password salah');
    }
    public function showForgotForm()
    {
        return view('forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset berhasil dikirim ke email kamu.')
            : back()->withErrors(['email' => __($status)]);
    }
}
