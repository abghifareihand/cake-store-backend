<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * ✅ GET CART ITEMS API
     * Endpoint: GET /api/cart
     * Fungsi: Mengambil daftar produk dalam keranjang berdasarkan user yang sedang login.
     */
    public function getCart(Request $request)
    {
        $userId = $request->user()->id;  // Menggunakan user id dari request
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Cart retrieved successfully',
            'data' => $cartItems
        ]);
    }

    /**
     * ✅ ADD PRODUCT TO CART API
     * Endpoint: POST /api/cart
     * Fungsi: Menambahkan produk ke dalam keranjang atau menambahkan quantity jika produk sudah ada.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $userId = $request->user()->id;  // Menggunakan user id dari request
        $cart = Cart::where('user_id', $userId)->where('product_id', $request->product_id)->first();

        if ($cart) {
            // Jika produk sudah ada di cart, tambah qty 1
            $cart->increment('quantity');
        } else {
            // Jika produk belum ada di cart, buat baru dengan qty 1
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart',
        ]);
    }

    /**
     * ✅ UPDATE CART QUANTITY API
     * Endpoint: PUT /api/cart/{id}
     * Fungsi: Mengupdate jumlah produk dalam keranjang berdasarkan ID cart.
     */
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = $request->user()->id;  // Menggunakan user id dari request
        $cart = Cart::where('user_id', $userId)->where('id', $id)->firstOrFail();

        // Update quantity produk di cart
        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated successfully',
        ]);
    }

    /**
     * ✅ REMOVE ITEM FROM CART API
     * Endpoint: DELETE /api/cart/{id}
     * Fungsi: Menghapus produk dari keranjang berdasarkan ID cart.
     */
    public function removeFromCart(Request $request, $id)
    {
        $userId = $request->user()->id;  // Menggunakan user id dari request
        $cart = Cart::where('user_id', $userId)->where('id', $id)->firstOrFail();
        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart'
        ]);
    }

    /**
     * ✅ CLEAR CART API
     * Endpoint: DELETE /api/cart/clear
     * Fungsi: Menghapus semua produk dalam keranjang berdasarkan user yang sedang login.
     */
    public function clearCart(Request $request)
    {
        $userId = $request->user()->id;  // Menggunakan user id dari request
        Cart::where('user_id', $userId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'All items removed from cart'
        ]);
    }
}
