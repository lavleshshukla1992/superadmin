<?php

namespace App\Http\Controllers\API;

use App\Models\VendorDetail;
use App\Models\Settings;
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
        $vendors = VendorDetail::leftJoin('memeberships as m','m.user_id','=','vendor_details.uid')
        ->select([
            'vendor_details.id','vendor_details.uid','vendor_details.vendor_first_name','vendor_details.vendor_last_name','vendor_details.parent_first_name','vendor_details.parent_last_name','vendor_details.date_of_birth','vendor_details.gender','vendor_details.marital_status','vendor_details.spouse_name','vendor_details.social_category','vendor_details.current_address','vendor_details.current_state','vendor_details.current_district','vendor_details.current_pincode','vendor_details.mobile_no','vendor_details.education_qualification','vendor_details.municipality_panchayat_birth','vendor_details.municipality_panchayat_current','vendor_details.is_current_add_and_birth_add_is_same','vendor_details.birth_address','vendor_details.birth_state','vendor_details.birth_district','vendor_details.birth_pincode','vendor_details.type_of_marketplace','vendor_details.type_of_vending','vendor_details.total_years_of_business','vendor_details.current_location_of_business','vendor_details.referral_code','vendor_details.profile_image_name','vendor_details.identity_image_name','vendor_details.membership_image','vendor_details.cov_image','vendor_details.lor_image','vendor_details.shop_image','vendor_details.status','vendor_details.user_role','vendor_details.mobile_no_verification_status','m.membership_id','m.validity_from','m.validity_to','vendor_details.language',
        ])->orderByDesc('vendor_details.id')->paginate();
        $meta = [
            'first_page' => $vendors->url(1),
            'last_page' => $vendors->url($vendors->lastPage()),
            'prev_page_url' =>$vendors->previousPageUrl(),
            'per_page' => $vendors->perPage(),
            'total_items' => $vendors->total(),
            'total_pages' => $vendors->lastPage()
        ];
        return response()->json(['success' => true,'status_code' =>200 , 'message' => 'Vendor list loaded Successfully','meta'=> $meta,'data'=>new VendorDetailCollection($vendors)]) ;
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
        $roleName = 'member';
        $setting = new Settings();
        $setting->user_id = $vendor->id;
        $setting->user_type = $roleName;
        $setting->save();
        return response()->json(['success' => true,'status_code' =>200 ,'vendor_id' => $vendor->id, 'message' => 'Successfully Signed Up']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VendorDetail $vendorDetail)
    {
        $vendorDetail = $vendorDetail::leftJoin('memeberships as m','m.user_id','=','vendor_details.id')
        ->select([
            'vendor_details.id','vendor_details.uid','vendor_details.vendor_first_name','vendor_details.vendor_last_name','vendor_details.parent_first_name','vendor_details.parent_last_name','vendor_details.date_of_birth','vendor_details.gender','vendor_details.marital_status','vendor_details.spouse_name','vendor_details.social_category','vendor_details.current_address','vendor_details.current_state','vendor_details.current_district','vendor_details.current_pincode','vendor_details.mobile_no','vendor_details.education_qualification','vendor_details.municipality_panchayat_birth','vendor_details.municipality_panchayat_current','vendor_details.is_current_add_and_birth_add_is_same','vendor_details.birth_address','vendor_details.birth_state','vendor_details.birth_district','vendor_details.birth_pincode','vendor_details.type_of_marketplace','vendor_details.type_of_vending','vendor_details.total_years_of_business','vendor_details.current_location_of_business','vendor_details.referral_code','vendor_details.profile_image_name','vendor_details.identity_image_name','vendor_details.membership_image','vendor_details.cov_image','vendor_details.lor_image','vendor_details.shop_image','vendor_details.status','vendor_details.user_role','vendor_details.mobile_no_verification_status','m.membership_id','m.validity_from','m.validity_to','vendor_details.language',
        ])->where('vendor_details.id',$vendorDetail->id)
        ->get()->first();
        
        return response()->json(['success' => true,'status_code' =>200 , 'message' => 'Vendor detail loaded Successfully','data'=>new VendorDetailResource($vendorDetail)]) ;
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

            return response()->json(['success' => true,'status_code' =>200,'vendor_id' => $vendorDetail->id, 'message' => 'Profile updated successfully']);
        }
        return response()->json(['success' => true,'status_code' => 200,'message' => 'Mobile number not Verified']);
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
