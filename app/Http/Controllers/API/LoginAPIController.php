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
