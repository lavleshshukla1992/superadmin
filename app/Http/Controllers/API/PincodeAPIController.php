<?php

namespace App\Http\Controllers\API;

use App\Models\Pincode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\PinCodeAPICollection;

class PincodeAPIController extends Controller
{
    public function getPinCodeList(Request $request)
    {
        $districtId = $request->get('district_id');
        $pinCodeList = Pincode::where('district_id',$districtId)->select('id','pincode','district_id')->orderBy('pincode', 'ASC')->paginate();

        $meta = [
            'first_page' => $pinCodeList->url(1),
            'last_page' => $pinCodeList->url($pinCodeList->lastPage()),
            'prev_page_url' =>$pinCodeList->previousPageUrl(),
            'per_page' => $pinCodeList->perPage(),
            'total_items' => $pinCodeList->total(),
            'total_pages' => $pinCodeList->lastPage()
        ];

        return  response()->json(['status_code' => 200,'success' => true,"message" => "Pincode List Loaded successfully",'meta'=> $meta, 'data'=> new PinCodeAPICollection($pinCodeList)]);

    }
}
