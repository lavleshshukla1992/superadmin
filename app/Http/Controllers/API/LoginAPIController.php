<?php

namespace App\Http\Controllers\API;

use App\Models\VendorDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\VendorDetailResource;
use Illuminate\Support\Facades\Auth;

class LoginAPIController extends Controller
{
    public function login(Request $request)
    {
        $mobilNumber = $request->get('mobile_number');
        $password = $request->get('password');
        $vendorDetail = VendorDetail::where('mobile_no',$mobilNumber)->select()->first();

        if ($vendorDetail instanceof VendorDetail) 
        {

            $vendorDetail = VendorDetail::leftJoin('roles as r','r.id','=','vendor_details.user_role')
            ->leftJoin('memeberships as m','m.user_id','=','vendor_details.id')
            ->select([
                'vendor_details.id','vendor_details.uid','vendor_details.vendor_first_name','vendor_details.vendor_last_name','vendor_details.parent_first_name','vendor_details.parent_last_name','vendor_details.date_of_birth','vendor_details.gender','vendor_details.marital_status','vendor_details.spouse_name','vendor_details.social_category','vendor_details.current_address','vendor_details.current_state','vendor_details.current_district','vendor_details.current_pincode','vendor_details.mobile_no','vendor_details.education_qualification','vendor_details.municipality_panchayat_birth','vendor_details.municipality_panchayat_current','vendor_details.is_current_add_and_birth_add_is_same','vendor_details.birth_address','vendor_details.birth_state','vendor_details.birth_district','vendor_details.birth_pincode','vendor_details.type_of_marketplace','vendor_details.type_of_vending','vendor_details.total_years_of_business','vendor_details.current_location_of_business','vendor_details.referral_code','vendor_details.profile_image_name','vendor_details.identity_image_name','vendor_details.membership_image','vendor_details.cov_image','vendor_details.lor_image','vendor_details.shop_image','vendor_details.status','r.name as user_role','vendor_details.mobile_no_verification_status','m.membership_id','m.validity_from','m.validity_to','vendor_details.language','vendor_details.password'
            ])->where('vendor_details.id',$vendorDetail->id)->get()->first();
            if ($vendorDetail->password == $password) 
            {
                return  response()->json([
                    'status_code' => 200,
                    'success' => true,
                    "message" => "Logged In  successfully",
                    'data'=> new VendorDetailResource($vendorDetail),
                    'token' => $vendorDetail->createToken("Login")->plainTextToken
                ]);
            }
            return  response()->json(['status_code' => 200,'success' => true,"message" => "Please provide valid password"]);
        }

        return  response()->json(['status_code' => 200,'success' => true,"message" => "User does not exist"]);
    }
    public function passwordUpdate(Request $request)
    {
        $mobilNumber = $request->get('mobile_number');
        $password = $request->get('password');
        $vendorDetail = VendorDetail::where('mobile_no',$mobilNumber)->select()->first();

        if ($vendorDetail instanceof VendorDetail) 
        {
            $vendorDetail->password = $password;
            $vendorDetail->save();
            return  response()->json(['status_code' => 200,'success' => true,"message" => "Password updated  successfully"]);

        }

        return  response()->json(['status_code' => 200,'success' => true,"message" => "User does not exist"]);
    }

    public function logout(Request $request)
    {
        $mobilNumber = $request->get('mobile_number');
        $vendorDetail = VendorDetail::where('mobile_no',$mobilNumber)->select()->first();

        if ($vendorDetail instanceof VendorDetail) 
        {
            $vendorDetail->tokens()->delete();
            return  response()->json([
                'status_code' => 200,
                'success' => true,
                "message" => "Logged Out  successfully",
            ]);
        }
        return  response()->json(['status_code' => 200,'success' => true,"message" => "User does not exist"]);
        
    }
}
