<?php
namespace App\Services;

use App\Models\VendorDetail;
use Illuminate\Support\Facades\Http;

class OTPService 
{
    public static function verifyMobileNumber($mobilNumber)
    {
        $mobileNumberCount = VendorDetail::where('mobile_no',$mobilNumber)->count('id');

        return $mobileNumberCount > 0 ? true : false;
    }

    public static function sendOTP($mobileNo,$otp)
    {
        $apiKey = env('2FA_SMS_API_KEY');
        $smsURL = 'https://2factor.in/API/V1/'.$apiKey.'/SMS//'.$mobileNo.'/'.$otp.'/OTP1';

        $response = Http::post( $smsURL);

        if ($response->successful()) 
        {
            return true;
        }

        return false;
    }

    // https://2factor.in/API/V1/XXXX-XXXX-XXXX-XXXX-XXXX/SMS/VERIFY3/91XXXXXXXXXX/12345

    public static function verifyOTP($mobileNo,$otp)
    {
        $apiKey = env('2FA_SMS_API_KEY');
        $smsURL = 'https://2factor.in/API/V1/'.$apiKey.'/SMS/VERIFY3/'.$mobileNo.'/'.$otp;
        $response = Http::post( $smsURL);
        if ($response->successful()) 
        {
            return true;
        }

        return false;
    }
}