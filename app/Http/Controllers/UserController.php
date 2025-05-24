<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class UserController extends Controller
{
    public function profil()
    {
        $user = Auth::user();

        $latestOrder = Order::where('user_id', $user->id)
                            ->orderBy('tanggal_pesanan', 'desc')
                            ->first();

        return view('profil', compact('user', 'latestOrder'));
    }
}
