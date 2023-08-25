<?php

namespace App\Providers;

use App\Events\LoggedIn;
use App\Listeners\SaveLoggedUserInfo;
use App\Models\Auth\JwtToken;
use App\Observers\Auth\JwtTokenObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        LoggedIn::class => [
            SaveLoggedUserInfo::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        JwtToken::observe(JwtTokenObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
