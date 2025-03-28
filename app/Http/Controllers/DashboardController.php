<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah semua user
        $totalAllUser = User::count();

        // Jumlah user dengan rola 'ADMIN'
        $totalAdmin = User::where('role', 'admin')->count();

        // Jumlah user dengan rola 'USER'
        $totalUser = User::where('role', 'user')->count();

        // Jumlah semua produk
        $totalProducts = Product::count();

        return view('pages.dashboard', compact('totalAllUser', 'totalAdmin', 'totalUser', 'totalProducts'));
    }
}
