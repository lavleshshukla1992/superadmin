<?php

namespace App\Http\Resources;

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
            'state_id' => $this->state_id,
            'district_id' => $this->district_id,
            'municipality_id' => $this->municipality_id,
            'status' => $this->status
        ];
    }
}
