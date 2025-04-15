<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === "admin@inikue.com" && $password === "password123") {
            Session::flash('success', 'Login berhasil!');
            // redirect ke halaman dashboard, misalnya:
            return redirect()->route('dashboard');
        } else {
            Session::flash('error', 'Email atau password salah!');
            return redirect()->back();
        }
    }
}
