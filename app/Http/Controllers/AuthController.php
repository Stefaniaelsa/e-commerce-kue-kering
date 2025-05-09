<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // Import Hash
use App\Models\User;

class AuthController extends Controller
{

public function showLoginForm()
    {
        return view('login');  
    }

    public function login(Request $request)

    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Mencari user berdasarkan email
        $user = User::where('email', $request->email)->first();
    
        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
    
            // Cek role
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard_admin');
            } else {
                return redirect('/dashboard');
            }
        }
    
        // Jika gagal login
        return back()->with('error', 'Email atau password salah');
    }
    
}
