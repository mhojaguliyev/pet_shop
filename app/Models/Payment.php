<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[\Illuminate\Database\Eloquent\Attributes\Guarded(['id'])]
class Payment extends Model
{
    /** @use HasFactory<\Illuminate\Database\Eloquent\Factories\Factory<self>> */
    use HasFactory;

    use HasUuid;

    /**
     * @return HasOne<Order, $this>
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'payment_uuid', 'uuid');
    }

    protected function casts(): array
    {
        return [
            'type' => PaymentType::class,
            'details' => 'array',
        ];
    }
}
