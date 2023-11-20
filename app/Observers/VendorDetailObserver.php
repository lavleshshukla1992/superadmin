<?php

namespace App\Observers;

use App\Models\VendorDetail;
use App\Services\VendorServices;

class VendorDetailObserver
{
    /**
     * Handle the VendorDetail "created" event.
     *
     * @param  \App\Models\VendorDetail  $VendorDetail
     * @return void
     */
    public function created(VendorDetail $vendor_info)
    {
        VendorServices::applySchemes($vendor_info);
    }
}
