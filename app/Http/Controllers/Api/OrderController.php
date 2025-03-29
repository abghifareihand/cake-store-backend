<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Services\Midtrans\CreateVirtualAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * ✅ ORDER API
     * Endpoint: POST /api/order
     * Fungsi: Membuat order berdasarkan item yang ada di keranjang dan informasi yang diberikan oleh pengguna.
     *
     * Request Body:
     * - address (required, string) -> Alamat pengiriman
     * - payment_method (required, string) -> Metode pembayaran (misalnya, bank_transfer)
     * - items (required, array) -> Daftar produk yang akan dipesan (terambil dari cart)
     *
     * Response:
     * - status: success
     * - message: Order created successfully
     * - data: Data order yang telah dibuat beserta item dan harga total
     */
    public function order(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'bank_name' => 'required|string',
            'items' => 'required|array',
        ]);

        $userId = $request->user()->id;

        // Ambil semua item yang ada di cart berdasarkan user yang login
        $cartItems = Cart::where('user_id', $userId)->get();

        // Hitung total harga berdasarkan item yang ada di cart
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->quantity; // Menghitung harga berdasarkan quantity dan harga produk
        }

        $order = Order::create([
            'user_id' => $userId,
            'trx_number' => 'TRX-' . time(),
            'address' => $request->address,
            'status' => 'pending',
            'total_price' => $totalPrice,
            'payment_method' => 'bank_transfer',
            'bank_name' => $request->bank_name,
        ]);

        foreach ($cartItems as $cartItem) {
            // Misalnya OrderItem adalah model yang berhubungan dengan order
            // Mengasumsikan ada tabel order_items dengan relasi order_id dan product_id
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }

        // Panggil Midtrans untuk mendapatkan VA
        $midtransService = new CreateVirtualAccountService($order);
        $midtransResponse = $midtransService->getVirtualAccount();
        $order->payment_va = $midtransResponse->va_numbers[0]->va_number;
        $order->save();


        // Menghapus item dari cart setelah order dibuat
        Cart::where('user_id', $userId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => $order->makeHidden(['items', 'user']),
        ]);
    }

    /**
     * ✅ GET ORDER API
     * Endpoint: GET /api/orders
     * Fungsi: Mengambil daftar order berdasarkan user yang sedang login.
     */
    public function getOrder(Request $request)
    {
        $userId = $request->user()->id;

        // Ambil semua order yang dimiliki oleh user yang sedang login
        $orders = Order::where('user_id', $userId)->with('items.product')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Orders retrieved successfully',
            'data' => $orders
        ]);
    }
}
