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
            'media' => ($this->media ) ? URL::to('/').'/uploads/'.$this->media : $this->media,
            'state_id' => $this->state_id,
            'district_id' => $this->district_id,
            'municipality_id' => $this->municipality_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status
        ];
    }
}
