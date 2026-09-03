<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_phone',
        'notes',
        'seller_agreement',
        'seller_rejection_reason',
        'seller_accepted_at',
        'product_sent_at',
        'customer_received_at',
        'admin_verified_at',
        'customer_rating',
        'customer_review',
        'customer_reviewed_at',
        'customer_dispute',
        'dispute_reason',
        'disputed_at',
    ];

    protected $casts = [
        'seller_accepted_at' => 'datetime',
        'product_sent_at' => 'datetime',
        'customer_received_at' => 'datetime',
        'admin_verified_at' => 'datetime',
        'customer_reviewed_at' => 'datetime',
        'disputed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }
}