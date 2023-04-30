<?php
namespace App\Services;

use App\Models\AdsHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AdsService
{
    public static function getActiveAds()
    {
       $ads = AdsHistory::where('ad_status','1')->select(['ad_sr_no','ad_type','ad_status','google_script','ad_name','ad_media','google_script','ad_link'])->get();
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

       return $result;
    }

    public static function prepareAdHistoryData($adId)
    {
        $ad = DB::table('ads')->where('id',$adId)->get()->first();

        $adHistoryData = [
            'ad_id' => $ad->id ?? '',
            'uid' => $ad->uid ?? '',
            'ad_sr_no' => $ad->ad_sr_no ?? '',
            'ad_type' => $ad->ad_type ?? '',
            'google_script' => $ad->google_script ?? '',
            'ad_name' => $ad->ad_name ?? '',
            'ad_media' => $ad->ad_media ?? '',
            'ad_link' => $ad->ad_link ?? '',
            'ad_status' => $ad->ad_status ?? '',
            'deleted' => 0 ?? '',
            'created_at' => now(),
        ];
        DB::table('ads_history')->whereNull('deleted_at')->where('ad_id',$ad->id)->update(['deleted_at' => now()]);

        DB::table('ads_history')->insert($adHistoryData);

    }
}