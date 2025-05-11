<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('register'); 
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'            => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6|confirmed',
            'nomor_telepon'   => 'nullable|string|max:15',
            'alamat'          => 'nullable|string',
        ]);
    
        // Simpan data user ke database
        User::create([
            'nama'          => $request->name,  
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'nomor_telepon' => $request->nomor_telepon,
            'alamat'        => $request->alamat,
            'role'          => 'user', 
        ]);
        
        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
    
}
