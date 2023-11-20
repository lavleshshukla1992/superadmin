<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Settings;
use App\Models\State;
use App\Models\District;
use App\Models\Panchayat;
use App\Models\Pincode;
use Spatie\Permission\Models\Role;

class AdminAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $role = $this->roles->first();
        $setting = Settings::where('user_id', $this->id)->where('user_type', $role->name)->first();

        $states = explode(',', $this->current_state);
        $this->current_state = [];
        foreach ($states as $state_id) {
            $this->current_state[] = State::where('id', $state_id)->select('id','name', 'country_id')->first();
        }

        $districts = explode(',', $this->current_district);
        $this->current_district = [];
        foreach ($districts as $district_id) {
            $this->current_district[] = District::where('id', $district_id)->select('id','name','state_id','status')->first();
        }

        $municipality = explode(',', $this->municipality_panchayat_current);
        $this->municipality_panchayat_current = [];
        foreach ($municipality as $municipality_id) {
            $this->municipality_panchayat_current[] = Panchayat::where('id', $municipality_id)->select('id','name', 'state_id','status')->first();
        }

        //$this->current_state = State::where('id', $this->current_state)->select('id','name', 'country_id')->first();
        //$this->current_district = District::where('id', $this->current_district)->select('id','name','state_id','status')->first();
        //$this->municipality_panchayat_current = Panchayat::where('id', $this->municipality_panchayat_current)->select('id','name', 'state_id','status')->first();

        $this->current_pincode = Pincode::where('pincode', $this->current_pincode)->select('id','pincode', 'district_id')->first();

        if($role->name!='admin'){
            return [
                'user_id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'mobile_no' => $this->mobile_no,
                'email' => $this->email,
                'profile_image' => $this->profile_image,
                'identity_image' => $this->identity_image,
                'assign_demography' => $this->assign_demography,
                'state_id' => $this->current_state,
                'district_id' => $this->current_district,
                'municipality_id' => $this->municipality_panchayat_current,
                'user_type' => $role->name??'',
                'setting_id' => $setting->id??null,
                'language' => $setting->language??null,
                'notification' => $setting->notification??null,
                'text_size' => $setting->text_size??null,
            ];
        }else{
            return [
                'user_id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'mobile_no' => $this->mobile_no,
                'email' => $this->email,
                'profile_image' => $this->profile_image,
                'user_type' => $role->name??'',
                'setting_id' => $setting->id??null,
                'language' => $setting->language??null,
                'notification' => $setting->notification??null,
                'text_size' => $setting->text_size??null,
            ];
            
        }
    }
}
