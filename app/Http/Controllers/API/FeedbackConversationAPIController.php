<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\FeedbackConversation;
use App\Http\Resources\FeedbackConversationResource;
use App\Http\Resources\FeedbackConversationCollection;
use Illuminate\Support\Facades\URL;
use App\Models\Notification;
use Carbon\Carbon;
use App\Services\OTPService;

class FeedbackConversationAPIController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|min:1',
            'feedback_id' => 'required|integer|min:1',
        ]);
        $media = $request->file('media');
        $input = $request->all();
        if (!is_null($media)) {
            $mediaName = time() . $media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['media'] = $mediaName;
        }

        $fdk = Feedback::find($input['feedback_id']);
        $fdk->status = $input['status'];
        $fdk->save();
        $feedback = FeedbackConversation::create($input);
        if(!empty($input['user_type']) && strtolower($input['user_type'])!='member'){
            $notification = new Notification();
            $notification->user_id = $fdk->user_id;
            $notification->title = 'You have a Reply on Your '.ucfirst($fdk->type);
            $notification->type = 'Feedback';
            $notification->type_id = $fdk->id;
            $notification->sent_at = Carbon::now();
            $notification->status = 1;
            $notification->save();
            
            OTPService::sendSMS($fdk->mobile_number, $notification->title);
            
        }
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Feedback Conversation added successfully", 'feedback_id' => $feedback->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show($feedbackId)
    {

        $feedback = Feedback::where('id', $feedbackId)->first();
        $media = [
            'name' => $feedback->media ?? null,
            'url' => !is_null($feedback->media) ? URL::to('/') . '/uploads/' . $feedback->media : null
        ];

       
        // Retrieve the paginated FeedbackConversation records
        $feedbackConversation = FeedbackConversation::where('feedback_id', $feedbackId)
            ->select(['user_type', 'user_id', 'reply', 'status', 'created_at', 'media'])
            ->paginate();
        $feedbackConversationData = FeedbackConversationResource::collection($feedbackConversation);
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Feedback Conversation Loaded successfully", 'feedback_id' => $feedbackId, 'type' => $feedback->type ?? '', 'registration_date' => !empty($feedback->created_at) ? date('Y-m-d H:i:s', strtotime($feedback->created_at)) : '', 'user_id' => $feedback->user_id,'user_type' => $feedback->user_type, 'subject' => $feedback->subject ?? '', 'status' => $feedback->status, 'name' => $feedback->name, 'message' => $feedback->message,'media' => $media,  'data' => $feedbackConversation]);
    }
}
