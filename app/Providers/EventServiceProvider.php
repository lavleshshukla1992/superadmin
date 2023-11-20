<?php

namespace App\Providers;

use App\Models\Scheme;
use App\Observers\SchemeObserver;
use App\Models\VendorDetail;
use App\Observers\VendorDetailObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Scheme::observe(SchemeObserver::class);
        VendorDetail::observe(VendorDetailObserver::class);
    }
}
