<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'language' => $this->language,
            'text_size' => $this->text_size,
            'user_id' => $this->user_id,
            'user_type' => $this->user_type,
            'notification' => $this->notification,
            'delete_account' => $this->delete_account,
        ];
    }
}
