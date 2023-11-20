<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingAPIResource extends JsonResource
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
            
            'training_id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'training_end_at' => $this->training_end_at,
            'cover_image' =>  [
                'url' =>  !is_null($this->cover_image) ? URL::to('/').'/uploads/'.$this->cover_image : null,
                'name' => $this->cover_image
            ],
            'status' => $this->status,

            'training_video' => [
                'url' =>  !is_null($this->training_video) ? URL::to('/').'/uploads/'.$this->training_video : null,
                'name' => $this->training_video
            ],
            'live_link' => $this->live_link,
            'training_type' => $this->training_type,
            'educational_qualification' => $this->educational_qualification,
            "select_demography" => ($this->select_demography == 1) ? true : false,
            'gender' => $this->gender,
            'social_category'  => !is_null($this->social_category) ? explode(',',$this->social_category) : null,
            'type_of_vending' => !is_null($this->type_of_vending) ? explode(',',$this->type_of_vending) : null,
            'type_of_marketplace' => !is_null($this->type_of_marketplace) ? explode(',',$this->type_of_marketplace) : null,
            'state_id' => !is_null($this->state_id) ? explode(',',$this->state_id) : null,
            'district_id' => !is_null($this->district_id) ? explode(',',$this->district_id) : null,
            'municipality_id' => !is_null($this->municipality_id) ? explode(',',$this->municipality_id) : null,
            'user_id' => $this->user_id,
            'training_start_at' => $this->training_start_at,
            'training_end_at' => $this->training_end_at,
            'video_type' => $this->video_type,
            'video_link' => $this->video_link,
        ];
    }
}