<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = ['id'];

    protected $casts = [
        'products' => 'array',
        'address' => 'array',
        'shipped_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<User, Order>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * @return BelongsTo<Payment, Order>
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_uuid', 'uuid');
    }

    /**
     * @return BelongsTo<OrderStatus, Order>
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_uuid', 'uuid');
    }
}
