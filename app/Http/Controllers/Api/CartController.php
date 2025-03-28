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
    public function getCart()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
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
     *
     * Request Body:
     * - product_id (required, integer) -> ID produk yang akan ditambahkan
     * - quantity (required, integer, min:1) -> Jumlah produk yang ingin ditambahkan
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();

        if ($cart) {
            // Jika produk sudah ada di cart, tambah qty 1
            $cart->increment('quantity');
        } else {
            // Jika produk belum ada di cart, buat baru dengan qty 1
            $cart = Cart::create([
                'user_id' => Auth::id(),
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
     *
     * URL Parameter:
     * - id (required, integer) -> ID dari cart item yang akan diperbarui
     *
     * Request Body:
     * - quantity (required, integer, min:1) -> Jumlah produk yang baru
     */
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
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
     *
     * URL Parameter:
     * - id (required, integer) -> ID dari cart item yang akan dihapus
     */
    public function removeFromCart($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart'
        ]);
    }
}
