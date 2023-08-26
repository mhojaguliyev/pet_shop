<?php

namespace App\Observers\Auth;

use App\Models\Auth\JwtToken;

class JwtTokenObserver
{
    public function creating(JwtToken $jwtToken): void
    {
        $jwtToken->expires_at = now()->addMinutes(config('jwt.ttl'));
    }
}
