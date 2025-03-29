<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'trx_number',
        'total_price',
        'status',
        'payment_method',
        'payment_va',
        'bank_name',
    ];

    /**
     * Relasi ke order items (One-to-Many)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke User (Many-to-One)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
