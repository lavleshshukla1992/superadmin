<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberSearchAPIResource extends JsonResource
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
            "id" => $this->id,
            "user_id" => $this->user_id,
            "date_of_birth" => $this->date_of_birth,
            "vendor_type" => $this->vendor_type,
            "name" => $this->name,
            "membership_id" => $this->membership_id,
            "state" => $this->state,
        ];
    }
}
