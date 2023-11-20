<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class InformationResource extends JsonResource
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
            'information_id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'information_link' => $this->information_link,
            'cover_image' => [
                'url' =>  !is_null($this->cover_image) ? URL::to('/').'/uploads/'.$this->cover_image : null,
                'name' => $this->cover_image
            ],

        ];
    }
}   
