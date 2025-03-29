<?php

namespace App\Services\Midtrans;

use Midtrans\CoreApi;
use Midtrans\Snap;

class CreateVirtualAccountService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getVirtualAccount()
    {

        // **Ambil detail item dari order**
        $itemDetails = [];
        foreach ($this->order->items as $item) {
            $itemDetails[] = [
                'id' => $item->product->id,
                'price'    => (int) $item->product->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        }

        $params = [
            'payment_type' => 'bank_transfer',
            'transaction_details' => [
                'order_id' => $this->order->trx_number,
                'gross_amount' => $this->order->total_price,
            ],
            'customer_details' => [
                'first_name' => $this->order->user->name,
                'email' => $this->order->user->email,
            ],
            'item_details' => $itemDetails,
            'bank_transfer' => [
                'bank' => $this->order->bank_name,
            ],
        ];

        $response = CoreApi::charge($params);

        return $response;
    }
}
