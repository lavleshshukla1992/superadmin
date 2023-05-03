<?php

namespace App\Http\Controllers\API;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;

class FeedbackAPIController extends Controller
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
        $feedback = Feedback::create($input);
        return response()->json(['status_code' => 200,'success' => true,"message" => "Feedback added successfully", 'feedback_id'=>$feedback->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Feedback Loaded successfully", 'data'=> new FeedbackResource($feedback)]);
    }
}
