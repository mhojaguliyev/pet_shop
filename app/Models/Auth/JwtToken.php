<?php

namespace App\Models\Auth;

use App\Observers\Auth\JwtTokenObserver;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
#[ObservedBy(JwtTokenObserver::class)]
class JwtToken extends Model
{
    /** @use HasFactory<Factory<self>> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'restrictions' => 'array',
            'permissions' => 'array',
            'expires_at' => 'datetime',
            'last_used_at' => 'datetime',
            'refreshed_at' => 'datetime',
        ];
    }
}
