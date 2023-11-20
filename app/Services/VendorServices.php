<?php
namespace App\Services;
use App\Models\Scheme;
use App\Models\SchemeApply;
use App\Http\Controllers\Controller;
class VendorServices 
{
    public static function getVendorInput($request)
    {
        $input = $request->all();

        if ($request->hasFile('profile_image_name')) {
           $profileImage = $request->file('profile_image_name');
           $profileImageName = time().$profileImage->getClientOriginalName();
           $profileImage->move('uploads', $profileImageName); 
           // $controller = new Controller();
            //$profileImageName =  $controller->uploadFile($request->file('profile_image_name'),'uploads',$profileImageName); 
            //print_r($profileImageName);die;
            $input['profile_image_name'] = $profileImageName;

        }

        if ($request->hasFile('identity_image_name')) {
            $identityImage = $request->file('identity_image_name');
            $identityImageName = time().$identityImage->getClientOriginalName();
            $identityImage->move('uploads', $identityImageName);
            $input['identity_image_name'] = $identityImageName;
        }
        
        
        if ($request->hasFile('membership_image')) {
            $memberShipImage = $request->file('membership_image');
            $memberShipImageName = time().$memberShipImage->getClientOriginalName();
            $memberShipImage->move('uploads', $memberShipImageName); 
            $input['membership_image'] = $memberShipImageName;

        }

        if ($request->hasFile('cov_image')) {

            $covImage = $request->file('cov_image');
            $covImageName = time().$covImage->getClientOriginalName();
            $covImage->move('uploads', $covImageName); 
            $input['cov_image'] = $covImageName;

        }


        if ($request->hasFile('lor_image')) {

            $lorImage = $request->file('lor_image');
            $lorImageName = time().$lorImage->getClientOriginalName();
            $lorImage->move('uploads', $lorImageName); 
            $input['lor_image'] = $lorImageName;

        }


        if ($request->hasFile('shop_image')) {

            $shopImage = $request->file('shop_image');
            $shopImageName = time().$shopImage->getClientOriginalName();
            $shopImage->move('uploads', $shopImageName); 
            $input['shop_image'] = $shopImageName;

        }

        $uuid = $request->get('uid',3);
        $input['uid'] = $uuid;
        $input['mobile_no_verification_status'] = 1;
        $input['status'] = 'unverified';

        return $input;
    }
    
    public static function getVendorUpdateInput($request)
    {
        $input = $request->all();
        if($request->hasFile('profile_image_name'))
        {
            $profileImage = $request->file('profile_image_name');
            $profileImageName = time().$profileImage->getClientOriginalName();
            $profileImage->move('uploads', $profileImageName); 
            $input['profile_image_name'] = $profileImageName;
        }

        if($request->hasFile('identity_image_name'))
        {
            $identityImage = $request->file('identity_image_name');
            $identityImageName = time().$identityImage->getClientOriginalName();
            $identityImage->move('uploads', $identityImageName);
            $input['identity_image_name'] = $identityImageName;
        }

        if($request->hasFile('membership_image'))
        {
            $memberShipImage = $request->file('membership_image');
            $memberShipImageName = time().$memberShipImage->getClientOriginalName();
            $memberShipImage->move('uploads', $memberShipImageName); 
            $input['membership_image'] = $memberShipImageName;

        }

        if($request->hasFile('cov_image'))
        {
            $covImage = $request->file('cov_image');
            $covImageName = time().$covImage->getClientOriginalName();
            $covImage->move('uploads', $covImageName); 
            $input['cov_image'] = $covImageName;
        }

        if($request->hasFile('lor_image'))
        {
            $lorImage = $request->file('lor_image');
            $lorImageName = time().$lorImage->getClientOriginalName();
            $lorImage->move('uploads', $lorImageName); 
            $input['lor_image'] = $lorImageName;
        }

        if($request->hasFile('shop_image'))
        {
            $shopImage = $request->file('shop_image');
            $shopImageName = time().$shopImage->getClientOriginalName();
            $shopImage->move('uploads', $shopImageName); 
            $input['shop_image'] = $shopImageName;
        }

        $uuid = $request->get('uid',3);
        $input['uid'] = $uuid;

        // $input['name'] = $input['first_name'] .' '.$input['last_name'];
        return $input;
    }
    public static function applySchemes($vendor_info)
    {
        $query = Scheme::query();
        $current_state          = !empty($vendor_info->current_state) ? explode(',', $vendor_info->current_state) : [];
        $current_district       = !empty($vendor_info->current_district) ? explode(',', $vendor_info->current_district) : [];
        $municipality_panchayat_current   = !empty($vendor_info->municipality_panchayat_current) ? explode(',', $vendor_info->municipality_panchayat_current) : [];

        if (!empty($current_state)) {
            $query->where(function ($query) use ($current_state) {
                $query->where(function ($query) use ($current_state) {
                    foreach ($current_state as $state) {
                        $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                    }
                })->orWhereNull('state_id');
            });
        }
        if (!empty($current_district)) {
            $query->where(function ($query) use ($current_district) {
                $query->where(function ($query) use ($current_district) {
                    foreach ($current_district as $district) {
                        $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                    }
                })->orWhereNull('district_id');
            });
        }
        if (!empty($municipality_panchayat_current)) {
            $query->where(function ($query) use ($municipality_panchayat_current) {
                $query->where(function ($query) use ($municipality_panchayat_current) {
                    foreach ($municipality_panchayat_current as $municipality) {
                        $query->orWhereRaw("FIND_IN_SET(?, municipality_id)", [$municipality]);
                    }
                })->orWhereNull('municipality_id');
            });
        }
        $query->select('id');
        $scheme_infos = $query->get();
        foreach ($scheme_infos as $key => $scheme) {
            $schemeapply = new SchemeApply();
            $schemeapply->user_id = $vendor_info->id;
            $schemeapply->scheme_id = $scheme->id;
            $schemeapply->user_type = 'member';
            $schemeapply->user_scheme_status = 'not applied';
            $schemeapply->save();
        }
    }

}