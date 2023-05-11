<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
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
            'name' => $this->name,
            'membership_id' => $this->membership_id,
            'subject' => $this->subject,
            'media' => $this->media,
            'message' => $this->message,
            'type' => $this->type,
            'mobile_number' => $this->mobile_number
        ];
    }
}
