<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorDetail extends Model
{
    use HasFactory,SoftDeletes,HasApiTokens,Authenticatable;

    protected $perPage = 10;


    public $fillable = [
        'uid',
        'vendor_first_name',
        'vendor_last_name',
        'parent_first_name',
        'parent_last_name',
        'social_category',
        'municipality_panchayat_birth',
        'municipality_panchayat_current',
        'police_station',
        'is_current_add_and_birth_add_is_same',
        'type_of_marketplace',
        'type_of_vending',
        'current_location_of_business',
        'total_years_of_business',
        'user_role',
        'name',
        'father_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'spouse_name',
        'current_address',
        'current_state',
        'current_district',
        'current_pincode',
        'birth_address',
        'birth_state',
        'birth_district',
        'birth_pincode',
        'pro_category_id',
        'pro_sub_category_id',
        'exp_no_of_years',
        'previus_work_details',
        'previus_supervisor_name',
        'previus_supervisor_contact_no',
        'mobile_no',
        'mobile_no_verification_status',
        'randor_otp',
        'referral_code',
        'profile_image_name',
        'identity_image_name',
        'membership_image',
        'cov_image',
        'lor_image',
        'password',
        'status',
        'language',
        'education_qualification',
        'marketpalce_others',
        'vending_others',
        'shop_image',
        'certificate_of_vending',
        'letter_of_recommendation'
    ];

    protected $cast = [

        'total_years_of_business' => 'integer',
        'current_state' => 'integer',
        'current_district' => 'integer',
        'current_pincode' => 'integer',
        'birth_address' => 'integer',
        'birth_state' => 'integer',
        'birth_district' => 'integer',
        'birth_pincode' => 'integer',
        'birth_state' => 'integer',
        'birth_district' => 'integer',
        'birth_pincode' => 'integer',
        'pro_category_id' => 'integer',
        'pro_sub_category_id' => 'integer',
        'exp_no_of_years' => 'integer',
    ];

    public function mobileNo(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  (int) $value
        );
    }

    // public function educationQualification(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) =>  (int) $value
    //     );
    // }

    public function uid(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  (int) $value
        );
    }

    protected function covImage(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }
    protected function profileImageName(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }
    protected function identityImageName(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }
    protected function membershipImage(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }
    protected function lorImage(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }
    protected function shopImage(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }
}
