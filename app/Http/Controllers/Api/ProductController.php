<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * ✅ GET PRODUCTS API
     * Endpoint: GET /api/products
     * Fungsi: Mengambil data product dari database
     */
    public function getProduct()
    {
        $products = Product::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Data list produk berhasil diambil',
            'data' => $products
        ], 200);
    }
}
