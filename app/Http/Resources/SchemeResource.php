<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class SchemeResource extends JsonResource
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
            'scheme_id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'apply_link' => $this->apply_link,
            //'user_id' => $this->created_by,
            'scheme_image' => [
                'url' =>  !is_null($this->scheme_image) ? URL::to('/').'/uploads/'.$this->scheme_image : null,
                'name' => $this->scheme_image
            ],
            'gender' => $this->gender,
			'state_id' => !is_null($this->state_id) ? explode(',',$this->state_id) : null,
            'district_id' => !is_null($this->district_id) ? explode(',',$this->district_id) : null,
            'municipality_id' => !is_null($this->municipality_id) ? explode(',',$this->municipality_id) : null,
            'social_category'  => !is_null($this->social_category) ? explode(',',$this->social_category) : null,
            'educational_qualification' => $this->educational_qualification,
            'type_of_vending' => !is_null($this->type_of_vending) ? explode(',',$this->type_of_vending) : null,
            'type_of_marketplace' => !is_null($this->type_of_marketplace) ? explode(',',$this->type_of_marketplace) : null,
            "select_demography" => ($this->select_demography == 1) ? true : false,

        ];
    }
}   
