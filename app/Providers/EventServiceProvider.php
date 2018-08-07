<?php

namespace App\Providers;

use App\Events\MatchPlayedEvent;
use App\Listeners\CalculateLeagueTableListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MatchPlayedEvent::class => [
            CalculateLeagueTableListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
