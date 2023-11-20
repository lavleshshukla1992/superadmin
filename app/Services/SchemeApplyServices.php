<?php
namespace App\Services;

use App\Models\SchemeApply;
use Illuminate\Support\Str;
use App\Models\VendorDetail;

class SchemeApplyServices
{
    public static function setEligibleVendorsToScheme($scheme)
    {
        // $states = !is_null($model->current_state) ? explode()

        $vendorDetail = new VendorDetail();

        if (!is_null($scheme->state_id)) 
        {
            $states = explode(',',$scheme->state_id);
            $vendorDetail = $vendorDetail->whereIn('current_state',$states);
        }

        if (!is_null($scheme->district_id))
        {
            $districts = explode(',',$scheme->district_id);
            $vendorDetail = $vendorDetail->whereIn('current_district',$districts);
        }

        if (!is_null($scheme->municipality_id)) 
        {
            $municipalities = explode(',',$scheme->municipality_id);
            $vendorDetail = $vendorDetail->whereIn('municipality_panchayat_current',$municipalities);
        }

        if (!is_null($scheme->gender)) 
        {
            $gender = explode(',',$scheme->gender);
            $vendorDetail = $vendorDetail->where('gender',$gender);
        }

        if (!is_null($scheme->social_category)) 
        {
            $socialCategories = explode(',',$scheme->social_category);
            $vendorDetail = $vendorDetail->whereIn('social_category',$socialCategories);
        }

        if (!is_null($scheme->educational_qualification)) 
        {
            $educationalQualifications = explode(',',$scheme->educational_qualification);
            $vendorDetail = $vendorDetail->where('education_qualification',$educationalQualifications);
        }

        if (!is_null($scheme->type_of_vending)) 
        {
            $typeOfVending = explode(',',$scheme->type_of_vending);
            $vendorDetail = $vendorDetail->whereIn('type_of_vending',$typeOfVending);
        }


        if (!is_null($scheme->type_of_marketplace)) 
        {
            $typeOfMarketPlace = explode(',',$scheme->type_of_marketplace);
            $vendorDetail = $vendorDetail->whereIn('type_of_marketplace',$typeOfMarketPlace);
        }

        $vendorDetail = $vendorDetail->select(['id','user_role','uid'])->get()->toArray();

        $schemeApplyChunks = array_chunk($vendorDetail,200);

        $schemeApplies = [];

        foreach ($vendorDetail as $key => $value) 
        {
           $schemeApplies[] = [
            'user_id' => $value['id'],
            'scheme_id' => $scheme->id,
            'user_type' => $value['user_role'],
            'apply_date' => null,
            'user_scheme_status' => 'not applied',
            'created_at' => now(),
            'updated_at' => now()
           ];
        }

        if (count($schemeApplies) > 0) 
        {
            SchemeApply::insert($schemeApplies);
        }
    }
}