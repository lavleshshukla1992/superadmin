<?php
namespace App\Services;
class VendorServices 
{
    public static function getVendorInput($request)
    {
        $profileImage = $request->file('profile_image_name');
        $profileImageName = time().$profileImage->getClientOriginalName();
        $profileImage->move('uploads', $profileImageName); 
        
        $identityImage = $request->file('identity_image_name');
        $identityImageName = time().$identityImage->getClientOriginalName();
        $identityImage->move('uploads', $identityImageName);

        $memberShipImage = $request->file('membership_image');
        $memberShipImageName = time().$memberShipImage->getClientOriginalName();
        $memberShipImage->move('uploads', $memberShipImageName); 

        $covImage = $request->file('cov_image');
        $covImageName = time().$covImage->getClientOriginalName();
        $covImage->move('uploads', $covImageName); 

        $lorImage = $request->file('lor_image');
        $lorImageName = time().$lorImage->getClientOriginalName();
        $lorImage->move('uploads', $lorImageName); 

        $uuid = $request->get('uid',3);
        $input = $request->all();
        $input['uid'] = $uuid;

        // $input['name'] = $input['vendor_first_name'] .' '.$input['vendor_last_name'];

        if (isset($input['profile_image_name'])) 
        {
            $input['profile_image_name'] = $profileImageName;
        }

        if (isset($input['identity_image_name'])) 
        {
            $input['identity_image_name'] = $identityImageName;
        }

        if (isset($input['membership_image'])) 
        {
            $input['membership_image'] = $memberShipImageName;
        }

        if (isset($input['cov_image'])) 
        {
            $input['cov_image'] = $covImageName;
        }

        if (isset($input['lor_image'])) 
        {
            $input['lor_image'] = $lorImageName;
        }

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

        $uuid = $request->get('uid',3);
        $input['uid'] = $uuid;

        // $input['name'] = $input['first_name'] .' '.$input['last_name'];
        return $input;
    }

}