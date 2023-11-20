<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class SchemeApplyResource extends JsonResource
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
            "scheme_id" => $this->id,
            "name"=> $this->name,
            "description"=> $this->description,
            "status" => $this->status,
            "user_scheme_status"=> $this->user_scheme_status ,
            "start_at"=> $this->start_at,
            "end_at"=> $this->end_at,
            "apply_date" => $this->apply_date,
            "scheme_image" => !is_null($this->scheme_image) ?[
                'url' => URL::to('/').'/uploads/'.$this->scheme_image,
                'name' => $this->scheme_image
            ] : [
                'url' => null,
                'name' => null
            ]
        ];
    }
}
