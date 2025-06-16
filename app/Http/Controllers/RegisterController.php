<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alamat;
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
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'nomor_telepon'=> 'nullable|string|max:15',
            'jalan'        => 'required|string|max:150',
            'kota'         => 'required|string|max:100',
            'provinsi'     => 'nullable|string|max:100',
        ]);

        // Simpan data user ke tabel users
        $user = User::create([
            'nama'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'nomor_telepon' => $request->nomor_telepon,
            // 'role'          => 'user', // default role
        ]);

        // Simpan data alamat ke tabel alamat
        Alamat::create([
            'user_id'  => $user->id,
            'jalan'    => $request->jalan,
            'kota'     => $request->kota,
            'provinsi' => $request->provinsi,
        ]);

        // Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
