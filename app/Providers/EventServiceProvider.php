<?php

namespace App\Providers;

use App\Models\Travel;
use App\Observers\TravelObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];


    //! delete and use the method in the boot() method below
    protected $observer = [
        Travel::class => [TravelObserver::class]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //! make it a class above, to register and observer
        // Travel::observe(TravelObserver::class);
    }



    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function getObserver()
    {
        return $this->observer;
    }

    /**
     * @param mixed $observer
     * @return self
     */
    public function setObserver($observer): self
    {
        $this->observer = $observer;
        return $this;
    }
}
