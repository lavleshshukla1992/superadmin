<?php

namespace App\Observers;

use App\Models\Scheme;
use App\Services\SchemeApplyServices;

class SchemeObserver
{
    /**
     * Handle the Scheme "created" event.
     *
     * @param  \App\Models\Scheme  $scheme
     * @return void
     */
    public function created(Scheme $scheme)
    {
        SchemeApplyServices::setEligibleVendorsToScheme($scheme);
    }

    /**
     * Handle the Scheme "updated" event.
     *
     * @param  \App\Models\Scheme  $scheme
     * @return void
     */
    public function updated(Scheme $scheme)
    {
      //  SchemeApplyServices::setEligibleVendorsToScheme($scheme);
    }

    /**
     * Handle the Scheme "deleted" event.
     *
     * @param  \App\Models\Scheme  $scheme
     * @return void
     */
    public function deleted(Scheme $scheme)
    {
        //
    }

    /**
     * Handle the Scheme "restored" event.
     *
     * @param  \App\Models\Scheme  $scheme
     * @return void
     */
    public function restored(Scheme $scheme)
    {
        //
    }

    /**
     * Handle the Scheme "force deleted" event.
     *
     * @param  \App\Models\Scheme  $scheme
     * @return void
     */
    public function forceDeleted(Scheme $scheme)
    {
        //
    }
}
