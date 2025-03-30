<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Midtrans\CallbackService;

class CallbackController extends Controller
{
    public function callback()
    {
        $callback = new CallbackService();
        $order = $callback->getOrder();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        // Pastikan signature valid sebelum update status
        // if (!$callback->isSignatureKeyVerified()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Invalid signature',
        //     ], 403);
        // }

        // Update order berdasarkan status Midtrans
        if ($callback->isSuccess()) {
            $order->update([
                'status' => 'paid',
            ]);
        } else if ($callback->isExpire()) {
            $order->update([
                'status' => 'expired',
            ]);
        } else if ($callback->isCancelled()) {
            $order->update([
                'status' => 'cancelled',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Callback processed success',
        ]);
    }
}
