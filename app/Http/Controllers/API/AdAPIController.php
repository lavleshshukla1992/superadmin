<?php

namespace App\Http\Controllers\API;

use App\Services\AdsService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdAPIController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return AdsService::getActiveAds();
    }
}
