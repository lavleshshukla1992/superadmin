<?php

namespace App\Services;

use App\Models\VendorDetail;
use App\Models\Admin;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class OTPService
{
    public static function verifyMobileNumber($mobilNumber, $user_type = 'member')
    {
        if ($user_type == 'member') {
            $mobileNumberCount = VendorDetail::where('mobile_no', $mobilNumber)->count('id');
        } else {
            $mobileNumberCount = Admin::where('mobile_no', $mobilNumber)->count('id');
        }

        return $mobileNumberCount > 0 ? true : false;
    }

    public static function sendOTP($mobileNo, $otp)
    {
        $apiKey = env('2FA_SMS_API_KEY');
        $smsURL = 'https://2factor.in/API/V1/' . $apiKey . '/SMS//' . $mobileNo . '/' . $otp . '/OTP1';

        $response = Http::post($smsURL);

        // echo"<pre>";print_r($response);die;

        if ($response->successful()) {
            return true;
        }

        return false;
    }

    // https://2factor.in/API/V1/XXXX-XXXX-XXXX-XXXX-XXXX/SMS/VERIFY3/91XXXXXXXXXX/12345

    public static function verifyOTP($mobileNo, $otp)
    {
        $apiKey = env('2FA_SMS_API_KEY');
        $smsURL = 'https://2factor.in/API/V1/' . $apiKey . '/SMS/VERIFY3/' . $mobileNo . '/' . $otp;
        $response = Http::post($smsURL);
        if ($response->successful()) {
            return true;
        }

        return false;
    }

    public static function sendSMS($mobileNo, $sms)
    {
        $apiKey = env('2FA_SMS_API_KEY');
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://2factor.in/API/R1/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'module=TRANS_SMS&apikey='.$apiKey.'&to='.$mobileNo.'&from=HEADER&msg='.$sms.'&ctid=',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // echo "<pre>";
        // print_r($response);
        // die;
    }
}
