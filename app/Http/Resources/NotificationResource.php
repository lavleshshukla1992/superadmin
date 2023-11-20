<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
           // 'id' =>  $this->id,
            'notification_id' =>  $this->id,
            'user_id' =>  $this->user_id,
            'title' =>  $this->title,
            'status'  =>  $this->status,
            'type'  =>  $this->type,
            'type_id'  =>  $this->type_id,
            'sent_at'  =>  $this->sent_at,
            'is_read' => $this->is_read?true:false
        ];
    }
}
