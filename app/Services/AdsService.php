<?php
namespace App\Services;

use App\Models\AdsHistory;

class AdsService
{
    public static function getActiveAds()
    {
       $ads = AdsHistory::where('ad_status','1')->select(['ad_sr_no','ad_type','ad_status','google_script','ad_name','ad_media','google_script','ad_link','ad_from_dt','ad_to_dt'])->get();

       $result = [];

       foreach ($ads as $key => $ad) 
       {
            if ($ad->ad_type == 2) 
            {
                $result[] = [
                    "ad_sr_no" => $ad->ad_sr_no,
                    "ad_type" => $ad->ad_type,
                    "google_script" => $ad->google_script,
                    "ad_to_dt" => $ad->ad_to_dt,
                    "ad_status" => $ad->ad_status,
                ];
            }

            if ($ad->ad_type == 2) 
            {
                $result[] = [
                "ad_sr_no" => $ad->ad_sr_no,
                "ad_type" => $ad->ad_type,
                "ad_name" => $ad->ad_name,
                "ad_to_dt" => $ad->ad_to_dt,
                "ad_status" => $ad->ad_status,
                "ad_media" => $ad->ad_media,
                "ad_link" => $ad->ad_link,
                "ad_from_dt" => $ad->ad_from_dt,
                "ad_to_dt" => $ad->ad_to_dt,
                ];
            }
       }

       return $result;
    }
}