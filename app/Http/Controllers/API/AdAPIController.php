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
       return response()->json(['status_code' => 200,'success' => true,"message" => "Ads List Loaded successfully", 'data'=>AdsService::getActiveAds()]);
    }
}
