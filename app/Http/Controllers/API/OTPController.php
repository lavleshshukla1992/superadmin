<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\OTP;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreOTPRequest;
use App\Http\Requests\VerifyOTPRequest;

class OTPController extends Controller
{
    public function sendOTP(StoreOTPRequest $request)
    {
        $mobilNumber = $request->get('mobile_no');
        $slug = $request->get('slug');
        $isValidMobileNumber  = OTPService::verifyMobileNumber($mobilNumber); 
        $otp =  random_int(100000, 999999);  
        
        if ($isValidMobileNumber &&  $slug == 'signup') 
        {
            return response()->json(['success' => true,'status_code' =>200 ,'message' => 'User already exist']);
        }

        if ($isValidMobileNumber) {
            OTP::create([
                'mobile_no' => $mobilNumber,
                'otp' =>  $otp,
                'verify_status' => 0,
                'otp_type' => $slug,
                'expired_at' =>  Carbon::now()->addMinutes(5),
            ]);
            if(OTPService::sendOTP($mobilNumber,$otp))
            {
                return response()->json(['success' => true,'message' => 'OTP Sent successfully']);
            }
            else
            {
                return response()->json(['success' => true,'message' => 'User does not exist']);
            }

            return response()->json(['success' => true,'message' => 'OTP Sent successfully']);
        }
        return response()->json(['success' => true,'message' => 'User does not exist']);

    }

    public function reSendOTP(StoreOTPRequest $request)
    {
        $mobilNumber = $request->get('mobile_no');
        $isValidMobileNumber  = OTPService::verifyMobileNumber($mobilNumber);    
        $otp = random_int(100000, 999999);
        $slug = $request->get('slug');

        if ($isValidMobileNumber &&  $slug == 'signup') 
        {
            return response()->json(['success' => true,'status_code' =>200 ,'message' => 'User Already Exist']);
        }

        if ($isValidMobileNumber) {
            OTP::updateOrCreate([
                'mobile_no' => $mobilNumber,
                'otp_type' => $slug,
                'verify_status' => 0,
            ],
            [
                'otp' => $otp,
                'expired_at' =>  Carbon::now()->addMinutes(5),
            ]);

            if(OTPService::sendOTP($mobilNumber,$otp))
            {
                return response()->json(['success' => true,'status_code' =>200 ,'message' => 'OTP ReSent successfully']);
            }
            else
            {
                return response()->json(['success' => true,'status_code' =>200 ,'message' => 'User Does Not Exist']);
            }

        }
        return response()->json(['success' => true,'status_code' =>200 ,'message' => 'User Does Not Exist']);

    }

    public function verifyOTP(VerifyOTPRequest $request)
    {
        $mobilNumber = $request->get('mobile_no');
        $otp = $request->get('otp');
        $isValidMobileNumber  = OTPService::verifyMobileNumber($mobilNumber);    
        if ($isValidMobileNumber) {
           $otp =  OTP::where([
                'mobile_no' => $mobilNumber,
                'otp_type' => 'signup',
                'verify_status' => 0,
                'otp' => $otp,
            ])->first();
            if (! $otp instanceof OTP) 
            {
                return response()->json(['success' => true,'message' => 'Invalid OTP']);
            }
            if ($otp->expired_at > Carbon::now()) 
            {
                $otp->fill([
                    'verified_at' => now(),
                    'verify_status' => 1
    
                ]);
                $otp->save();
               if( OTPService:: verifyOTP($mobilNumber,$otp))
               {
                   return response()->json(['success' => true,'message' => 'OTP Verified successfully']);
               }
            }
            return response()->json(['success' => true,'message' => 'OTP Expired']);

        }
        return response()->json(['success' => true,'message' => 'Invalid OTP']);    }
}
