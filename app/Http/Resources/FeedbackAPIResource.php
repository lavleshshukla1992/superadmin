<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ComplaintType;

class FeedbackAPIResource extends JsonResource
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
            'user_id' => $this->user_id,
            'type' => $this->type,
            'complaint_type' => $complaint_type,
            'date' => !is_null($this->date) ? date('d-m-Y',strtotime($this->date)) : null,
            'subject' => $this->subject,
            'status' => $this->status,
        ];
    }
}
