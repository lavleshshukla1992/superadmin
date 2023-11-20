<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveSchemeResource extends JsonResource
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
            'user_scheme_status' => $this->user_scheme_status,
            // 'start_at' => $this->start_at,
            // 'user_id' => $this->user_id,
            // 'user_scheme_status' => $this->user_scheme_status,
            'scheme_image' => [
                'url' =>  !is_null($this->scheme_image) ? URL::to('/').'/uploads/'.$this->scheme_image : null,
                'name' => $this->scheme_image
            ],
            'end_at' => $this->end_at,
        ];
    }
}
