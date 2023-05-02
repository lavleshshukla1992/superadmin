<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeedbackConversation;
use App\Http\Resources\FeedbackConversationResource;

class FeedbackConversationAPIController extends Controller
{
    public function store(Request $request)
    {
        $media = $request->file('media');
        $input = $request->all(); 
        if (! is_null($media)) 
        {
            $mediaName = time().$media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['media'] = $mediaName;
        }
        $feedback = FeedbackConversation::create($input);
        return response()->json(['status_code' => 200,'success' => true,"message" => "Feedback Conversation added successfully", 'feedback_id'=>$feedback->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(FeedbackConversation $feedbackConversation)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Feedback Conversation Loaded successfully", 'data'=> new FeedbackConversationResource($feedbackConversation)]);
    }
}
