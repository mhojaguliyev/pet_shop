<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'uuid',
    'first_name',
    'last_name',
    'is_admin',
    'email',
    'email_verified_at',
    'password',
    'avatar',
    'address',
    'phone_number',
    'is_marketing',
    'last_login_at',
])]
#[\Illuminate\Database\Eloquent\Attributes\Hidden([
    'password',
])]
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use Notifiable;
    use HasUuid;

    /**
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_uuid', 'uuid');
    }

    public function getJWTIdentifier(): string
    {
        return $this->getKey();
    }

    /**
     * @return array<int, string>
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
