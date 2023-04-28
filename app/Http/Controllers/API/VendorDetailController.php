<?php

namespace App\Http\Controllers\API;

use App\Models\VendorDetail;
use Illuminate\Http\Request;
use App\Services\VendorServices;
use Illuminate\Routing\Controller;
use App\Http\Resources\VendorDetailResource;
use App\Http\Resources\VendorDetailCollection;
use App\Http\Requests\StoreVendorDetailsRequest;

class VendorDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new VendorDetailCollection(VendorDetail::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StoreVendorDetailsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVendorDetailsRequest $request)
    {
        $input = VendorServices::getVendorInput($request);
        $vendor = VendorDetail::create($input);
        return response()->json(['success' => true,'vendor_id' => $vendor->id, 'message' => 'Successfully Signed Up']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VendorDetail $vendorDetail)
    {
        return response()->json(['success' => true,'data'=>new VendorDetailResource($vendorDetail)]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorDetail $vendorDetail)
    {
        if ($vendorDetail->mobile_no_verification_status == 1) 
        {
            $input = VendorServices::getVendorUpdateInput($request);
            $vendorDetail->fill($input);
            $vendorDetail->save();

            return response()->json(['success' => true,'vendor_id' => $vendorDetail->id, 'message' => 'Profile updated successfully']);
        }
        return response()->json(['success' => true,'message' => 'Mobile number not Verified']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
