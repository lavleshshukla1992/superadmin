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
            
            'id' => $this->id,
            'name' => $this->name,
            'all_state' => $this->all_state,
            'cover_image' => ($this->cover_image ) ? URL::to('/').'/uploads/'.$this->cover_image : $this->cover_image,
            'user_id' => $this->user_id,
            'training_start_at' => $this->training_start_at,
            'training_end_at' => $this->training_end_at,
            'video_type' => $this->video_type,
            'video_link' => $this->video_link,
            'live_link' => $this->live_link,
            'state_id' => $this->state_id,
            'district_id' => $this->district_id,
            'municipality_id' => $this->municipality_id,
            'status' => $this->status
        ];
    }
}