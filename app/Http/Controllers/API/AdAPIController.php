<?php

namespace App\Http\Controllers\API;

use App\Models\AdsHistory;
use App\Services\AdsService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;

class AdAPIController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getActiveAds(Request $request)
    {

        $ads = AdsHistory::where('ad_status','1')->select(['ad_sr_no','ad_type','ad_status','google_script','ad_name','ad_media','google_script','ad_link'])->paginate();

        $meta = [
            'first_page' => $ads->url(1),
            'last_page' => $ads->url($ads->lastPage()),
            'prev_page_url' =>$ads->previousPageUrl(),
            'per_page' => $ads->perPage(),
            'total_items' => $ads->total(),
            'total_pages' => $ads->lastPage()
        ];

        $result = [];
 
        foreach ($ads as $key => $ad) 
        {
            if ($ad->ad_type == 1) 
            {
                $result[] = [
                    "ad_sr_no" => $ad->ad_sr_no,
                    "ad_type" => $ad->ad_type,
                    "google_script" => $ad->google_script,
                ];
            }

            if ($ad->ad_type == 2) 
            {

                $result[] = [
                "ad_sr_no" => $ad->ad_sr_no,
                "ad_type" => $ad->ad_type,
                "ad_name" => $ad->ad_name,
                "ad_media" => ($ad->ad_media ) ? URL::to('/').'/uploads/'.$ad->ad_media : $ad->ad_media,
                "ad_link" => $ad->ad_link,
                ];
            }
        }
        
       return response()->json(['status_code' => 200,'success' => true,"message" => "Ads List Loaded successfully",'meta'=> $meta, 'data'=> $result]);
    }
}
