<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'date_of_birth' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:male,female',
            'marital_status' => 'required|in:yes,no',
            'current_address' => 'required|string|max:400',
            'current_pincode' => 'required|digits:6',
            'birth_address' => 'required|string|max:400',
            'birth_pincode' => 'required|digits:6',
            'exp_no_of_years' => 'required|int|max:20',
            'previus_work_details' => 'required|string|max:400',
            'previus_supervisor_name' => 'required|string|max:400',
            'previus_supervisor_contact_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'profile_image_name' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'identity_image_name' => 'required|image|mimes:jpeg,png,jpg,pdf,doc|max:2048',

            // 'current_state' => 'required|integer|exists:states,id',
            // 'current_district' => 'required|integer|exists:districts,id',
            //'birth_state' => 'required|integer|exists:states,id',
            //'birth_district' => 'required|integer|exists:districts,id',
            //'pro_category_id' => 'required|integer|exists:categorys,id',
            //'pro_sub_category_id' => 'required|integer|exists:subcategorys,id',
        ];
    }
}
