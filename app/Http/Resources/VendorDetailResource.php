<?php

namespace App\Http\Resources;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Settings;
use App\Models\State;
use App\Models\District;
use App\Models\Panchayat;
use App\Models\Pincode;
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
        $setting = Settings::where('user_id', $this->id)->where('user_type', 'member')->first();
        $this->current_state = State::where('id', $this->current_state)->select('id','name', 'country_id')->first();
        $this->birth_state = State::where('id', $this->birth_state)->select('id','name', 'country_id')->first();
        $this->current_district = District::where('id', $this->current_district)->select('id','name','state_id','status')->first();
        $this->birth_district = District::where('id', $this->birth_district)->select('id','name', 'state_id','status')->first();
        $this->municipality_panchayat_current = Panchayat::where('id', $this->municipality_panchayat_current)->select('id','name', 'state_id','status')->first();
        $this->municipality_panchayat_birth = Panchayat::where('id', $this->municipality_panchayat_birth)->select('id','name', 'state_id','status')->first();
        $this->birth_pincode = Pincode::where('pincode', $this->birth_pincode)->select('id','pincode', 'district_id')->first();
        $this->current_pincode = Pincode::where('pincode', $this->current_pincode)->select('id','pincode', 'district_id')->first();

        return [
            'id' =>  $this->id,
            // 'uid' => $this->uid,
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
            'education_qualification' => $this->education_qualification,
            'municipality_panchayat_birth' => $this->municipality_panchayat_birth,
            'municipality_panchayat_current' => $this->municipality_panchayat_current,
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
           // 'status' => ($this->status == 'verified') ? 'verified' : 'unverified',
            'status' => $this->status,
            'user_role' => $this->user_role,
            'mobile_no_verification_status' => $this->mobile_no_verification_status == 1 ? "yes" : "no",   
            'member_id' => $this->membership_id,
            'validity_from' => $this->validity_from,
            'validity_to' => $this->validity_to,   
            'setting_id' => $setting->id??null,
            'language' => $setting->language??null,
            'notification' => $setting->notification??null,
            'text_size' => $setting->text_size??null,
            'user_type' => 'member',
            // 'password' => $this->password,
            // 'police_station' => $this->police_station,
        ];
    }
}