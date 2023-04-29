<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' =>  $this->id,
            'uid' => $this->uid,
            'vendor_first_name' => $this->vendor_first_name,
            'vendor_last_name' => $this->vendor_last_name,
            'parent_first_name' => $this->parent_first_name,
            'parent_last_name' => $this->parent_last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'spouse_name' => $this->spouse_name,
            'social_category' => $this->social_category,
            'current_address' => $this->current_address,
            'current_state' => $this->current_state,
            'current_district' => $this->current_district,
            'current_pincode' => $this->current_pincode,
            'mobile_no' => $this->mobile_no,
            'municipality_panchayat' => $this->municipality_panchayat,
            'police_station' => $this->police_station,
            'is_current_add_and_birth_add_is_same' => $this->is_current_add_and_birth_add_is_same,
            'birth_address' => $this->birth_address,
            'birth_state' => $this->birth_state,
            'birth_district' => $this->birth_district,
            'birth_pincode' => $this->birth_pincode,
            'type_of_marketplace' => $this->type_of_marketplace,
            'type_of_vending' => $this->type_of_vending,
            'total_years_of_business' => $this->total_years_of_business,
            'current_location_of_business' => $this->current_location_of_business,
            'referral_code' => $this->referral_code,
            'profile_image_name' => $this->profile_image_name,
            'identity_image_name' => $this->identity_image_name,
            'membership_image' => $this->membership_image,
            'cov_image' => $this->cov_image,
            'lor_image' => $this->lor_image,
            'shop_image' => $this->shop_image,
            'password' => $this->password,
            'status' => $this->status,
            'user_role' => $this->user_role,
            'mobile_no_verification_status' => $this->mobile_no_verification_status,       
        ];
    }
}