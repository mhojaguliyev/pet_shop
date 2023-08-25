<?php

namespace App\Listeners;

use App\Events\LoggedIn;
use App\Models\Auth\JwtToken;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SaveLoggedUserInfo
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoggedIn $event): void
    {
        // update user last login time
        $user = $event->user;
        $user->last_login_at = now();
        $user->save();

        // save jwt token
        $token = $event->token;
        $tokenData = [
            'unique_id' => $token,
            'user_uuid' => $user->uuid,
            'token_title' => config('jwt.algo'),
        ];

        JwtToken::create($tokenData);
    }
}
