<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
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
            'notice_id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'notice_image' => [
                'url' =>  !is_null($this->notice_image) ? URL::to('/').'/uploads/'.$this->notice_image : null,
                'name' => $this->notice_image
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
            // 'created_by' => $this->created_by,
            // 'updated_by' => $this->updated_by,
        ];
    }
}
