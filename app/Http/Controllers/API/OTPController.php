<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\OTP;
use App\Models\Admin;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreOTPRequest;
use App\Http\Requests\VerifyOTPRequest;
use App\Models\VendorDetail;
use App\Http\Resources\VendorDetailResource;
use App\Http\Resources\AdminAPIResource;

class OTPController extends Controller
{
    public function sendOTP(StoreOTPRequest $request)
    {
        $mobilNumber = $request->get('mobile_no');
        $slug = $request->get('slug');
        $isValidMobileNumber  = OTPService::verifyMobileNumber($mobilNumber, $request->get('user_type', 'member'));
        $otp =  random_int(100000, 999999);

        if ($isValidMobileNumber &&  $slug == 'signup') {
            return response()->json(['success' => true, 'status_code' => 200, 'message' => 'User already exist']);
        }

        if ($isValidMobileNumber ||  $slug == 'signup') {
            OTP::create([
                'mobile_no' => $mobilNumber,
                'otp' =>  $otp,
                'verify_status' => 0,
                'otp_type' => $slug,
                'user_type' => $request->get('user_type', 'member'),
                'expired_at' =>  Carbon::now()->addMinutes(5),
            ]);
            if (OTPService::sendOTP($mobilNumber, $otp)) {
                return response()->json(['success' => true, 'message' => 'OTP Sent successfully']);
            }
            return response()->json(['success' => true, 'message' => 'SMS Not sent ']);
        }
        return response()->json(['success' => true, 'message' => 'User does not exist']);
    }

    public function reSendOTP(StoreOTPRequest $request)
    {
        $mobilNumber = $request->get('mobile_no');
        $isValidMobileNumber  = OTPService::verifyMobileNumber($mobilNumber, $request->get('user_type', 'member'));
        $otp = random_int(100000, 999999);
        $slug = $request->get('slug');

        if ($isValidMobileNumber &&  $slug == 'signup') {
            return response()->json(['success' => true, 'status_code' => 200, 'message' => 'User Already Exist']);
        }

        if ($isValidMobileNumber || $slug == 'signup') {
            OTP::updateOrCreate(
                [
                    'mobile_no' => $mobilNumber,
                    'otp_type' => $slug,
                    'user_type' => $request->get('user_type', 'member'),
                    'verify_status' => 0,
                ],
                [
                    'otp' => $otp,
                    'expired_at' =>  Carbon::now()->addMinutes(5),
                ]
            );

            if (OTPService::sendOTP($mobilNumber, $otp)) {
                return response()->json(['success' => true, 'status_code' => 200, 'message' => 'OTP ReSent successfully']);
            } else {
                return response()->json(['success' => true, 'status_code' => 200, 'message' => 'SMS Not sent ']);
            }
        }
        return response()->json(['success' => true, 'status_code' => 200, 'message' => 'User Does Not Exist']);
    }

    public function verifyOTP(VerifyOTPRequest $request)
    {
        $mobilNumber = $request->get('mobile_no');
        $otp = $request->get('otp');
        $slug = $request->get('slug');
        $isValidMobileNumber  = OTPService::verifyMobileNumber($mobilNumber, $request->get('user_type', 'member'));
        $otp =  OTP::where([
            'mobile_no' => $mobilNumber,
            'otp_type' => $slug,
            'user_type' => $request->get('user_type', 'member'),
            'verify_status' => 0,
            'otp' => $otp,
        ])->first();
        if (!$otp instanceof OTP) {
            return response()->json(['success' => true, 'message' => 'Invalid OTP']);
        }
        if ($otp->expired_at > Carbon::now()) {
            $otp->fill([
                'verified_at' => now(),
                'verify_status' => 1

            ]);
            $otp->save();
            if (OTPService::verifyOTP($mobilNumber, $otp)) {
                if ($slug == 'login') {
                    $user_type = $request->get('user_type', 'member');
                    if ($user_type == 'member') {
                        $vendorDetail = $this->getVendorDetail($mobilNumber);
                        return  response()->json([
                            'status_code' => 200,
                            'success' => true,
                            "message" => "OTP Verified successfully",
                            'data' => new VendorDetailResource($vendorDetail),
                            'token' => $vendorDetail->createToken("Login")->plainTextToken
                        ]);
                    } else {
                        $admin = $this->getAdminDetail($mobilNumber);
                        return  response()->json([
                            'status_code' => 200,
                            'success' => true,
                            "message" => "OTP Verified successfully",
                            'data' => new AdminAPIResource($admin),
                            'token' => $admin->createToken("Login")->plainTextToken
                        ]);
                    }
                }
                return response()->json(['success' => true, 'message' => 'OTP Verified successfully', 'data' => []]);
            }
        }
        return response()->json(['success' => true, 'message' => 'OTP Expired']);
    }

    public function getVendorDetail($mobilNumber)
    {
        return VendorDetail::leftJoin('memeberships as m', 'm.user_id', '=', 'vendor_details.id')
            ->select([
                'vendor_details.id', 'vendor_details.uid', 'vendor_details.vendor_first_name', 'vendor_details.vendor_last_name', 'vendor_details.parent_first_name', 'vendor_details.parent_last_name', 'vendor_details.date_of_birth', 'vendor_details.gender', 'vendor_details.marital_status', 'vendor_details.spouse_name', 'vendor_details.social_category', 'vendor_details.current_address', 'vendor_details.current_state', 'vendor_details.current_district', 'vendor_details.current_pincode', 'vendor_details.mobile_no', 'vendor_details.education_qualification', 'vendor_details.municipality_panchayat_birth', 'vendor_details.municipality_panchayat_current', 'vendor_details.is_current_add_and_birth_add_is_same', 'vendor_details.birth_address', 'vendor_details.birth_state', 'vendor_details.birth_district', 'vendor_details.birth_pincode', 'vendor_details.type_of_marketplace', 'vendor_details.type_of_vending', 'vendor_details.total_years_of_business', 'vendor_details.current_location_of_business', 'vendor_details.referral_code', 'vendor_details.profile_image_name', 'vendor_details.identity_image_name', 'vendor_details.membership_image', 'vendor_details.cov_image', 'vendor_details.lor_image', 'vendor_details.shop_image', 'vendor_details.status', 'vendor_details.user_role', 'vendor_details.mobile_no_verification_status', 'm.membership_id', 'm.validity_from', 'm.validity_to', 'vendor_details.language',
            ])->where('vendor_details.mobile_no', $mobilNumber)
            ->get()->first();
    }

    public function getAdminDetail($mobilNumber)
    {
        return Admin::where('mobile_no', $mobilNumber)
            ->get()->first();
    }
}
