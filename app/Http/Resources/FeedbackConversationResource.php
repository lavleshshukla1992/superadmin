<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackConversationResource extends JsonResource
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
            //'membership_id' => $this->membership_id,
            'user_id' => $this->user_id,
            'user_type' => $this->user_type,
            'reply'=> $this->reply,
            //'reply_date' => date('Y-m-d',strtotime($this->created_at)),
            'reply_date' => date('Y-m-d h:i:s',strtotime($this->created_at)),
            //'type' => $this->type,
            //'date' => $this->created_at,
            //'subject' => $this->subject,
            'status' => $this->status,
            'media'=> [
                'name' => $this->media ?? null,
                'url' => !is_null($this->media) ? URL::to('/').'/uploads/'.$this->media : null
            ],
        ];
    }
}
