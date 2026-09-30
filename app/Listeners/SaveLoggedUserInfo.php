<?php

namespace App\Listeners;

use App\Events\LoggedIn;

class SaveLoggedUserInfo
{
    /**
     * Handle the event.
     */
    public function handle(LoggedIn $event): void
    {
        $event->user->forceFill(['last_login_at' => now()])->save();
    }
}
