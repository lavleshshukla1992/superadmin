<?php

namespace App\Http\Controllers\API;

use App\Models\Pincode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PincodeAPIController extends Controller
{
    public function getPinCodeList(Request $request)
    {
        $districtId = $request->get('district_id');
        $pinCodeList = Pincode::where('district_id',$districtId)->select('id','pincode','district_id')->get();

        return  response()->json(['status_code' => 200,'success' => true,"message" => "Pincode List Loaded successfully", 'data'=>$pinCodeList->toArray()]);

    }
}
