<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];

    /**
     * Relasi ke order (Many-to-One)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke product (Many-to-One)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
