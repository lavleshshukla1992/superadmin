<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use App\Models\ComplaintType;

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
        $complaint_type = $this->complaint_type;
        $data = ComplaintType::where('id', $complaint_type)->first();
        if (!empty($data->name)) {
           $complaint_type = $data->name;
        }
        else{
            $complaint_type = '';
        }
        return [
            'feedback_id' => $this->id,
            'type' => $this->type,
            'complaint_type' => $complaint_type,
            'date' => !is_null($this->created_at) ? date('d-m-Y H:i:s',strtotime($this->created_at)) : null,
            'user_id' => $this->user_id,
            'subject' => $this->subject,
            'status' => $this->status,
            'name' => $this->name,
            'message' => $this->message,
            'media'=> [
                'name' => $this->media ?? null,
                'url' => !is_null($this->media) ? URL::to('/').'/uploads/'.$this->media : null
            ],
        ];
    }
}
