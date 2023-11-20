<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\ComplaintType;
use Illuminate\Http\Request;
use App\Models\FeedbackConversation;
use App\Http\Resources\FeedbackResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Carbon\Carbon;


class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $feedbacks = Feedback::leftJoin('complaint_types', 'feedback.complaint_type', '=', 'complaint_types.id')
       //->select('feedback.*')
       ->select('feedback.id', 'feedback.status', 'feedback.member_id', 'feedback.subject', 'feedback.media', 'feedback.message', 'feedback.type', 'feedback.complaint_type', 'feedback.created_at', 'complaint_types.name as complaint_type')
       ->orderBy('created_at', 'DESC')
       ->toBase()
       ->get();

        //$feedbacks = Feedback::select(['id', 'status', 'member_id', 'subject', 'media', 'message', 'type', 'complaint_type', 'created_at'])->orderBy('created_at', 'DESC')->get();
        $feedbacks = !is_null($feedbacks) ? json_decode(json_encode($feedbacks), true) : [];
        return view('backend.pages.feedback.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feedback = Feedback::create($request->all());
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Feedback added successfully", 'feedback_id' => $feedback->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        // $feedbackConversation = FeedbackConversation::leftJoin('memeberships as m','m.membership_id','feedback_conversations.membership_id')
        $feedbackConversation = FeedbackConversation::leftJoin('vendor_details as vd', 'vd.id', 'feedback_conversations.user_id')

            ->select('feedback_conversations.status', 'feedback_conversations.media', 'feedback_conversations.created_at as timestamp', 'feedback_conversations.reply as message', DB::raw("CONCAT(vendor_first_name, ' ', vendor_last_name) as sender"), 'feedback_conversations.user_type')

            ->where('feedback_conversations.feedback_id', $feedback->id)->toBase()->get();
        $feedbackConversation = !is_null($feedbackConversation) ? json_decode(json_encode($feedbackConversation), true) : [];

        // echo"<pre>";print_r($feedbackConversation);die;
        $feedbackConversation = json_encode($feedbackConversation);
        $feedback = compact('feedback', 'feedbackConversation');
        $complaint_type_id = $feedback['feedback']->complaint_type;
        $complaint_type = ComplaintType::select('name')->where('id', $complaint_type_id)->first();
        //echo "<pre>"; print_r($complaint_type->name);die;
        return view('backend.pages.feedback.detail', $feedback, ['complaint_type' => $complaint_type->name]);
        // return response()->json(['status_code' => 200,'success' => true,"message" => "Feedback added successfully", 'data'=> new FeedbackResource($feedback)]);
    }

    public function showMessage(Request $request)
    {
        $feedbackId = $request->input('feedback_id');

        $feedbackConversation = FeedbackConversation::leftJoin('vendor_details as vd', 'vd.id', 'feedback_conversations.user_id')

            ->select('feedback_conversations.status', 'feedback_conversations.media', 'feedback_conversations.created_at as timestamp', 'feedback_conversations.reply as message', DB::raw("CONCAT(vendor_first_name, ' ', vendor_last_name) as sender"), 'feedback_conversations.user_type')

            ->where('feedback_conversations.feedback_id', $feedbackId)->toBase()->get();
        $feedbackConversation = !is_null($feedbackConversation) ? json_decode(json_encode($feedbackConversation), true) : [];

        // echo"<pre>";print_r($feedbackConversation);die;
        $feedbackConversation = json_encode($feedbackConversation);

        // Render the view containing the updated HTML for the message container
        $html = view('backend.pages.feedback.message-container', compact('feedbackConversation'))->render();

        // Return the updated HTML in the JSON response
        return response()->json(['html' => $html]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }
    public function updateStatus(Request $request)
    {
        $status    = $request->get('status') ?? '';
        $feedback_id = $request->get('feedback_id');
        $member    = Feedback::where('id', $feedback_id)->first();

        if ($member instanceof Feedback) {
            $member->status = $status;
            $member->save();
        }

        $currentUserId = Auth::id();

        $feedbackconversation = new FeedbackConversation();
        $feedbackconversation->status = $status;
        $feedbackconversation->reply = $request->get('reply');
        $feedbackconversation->user_type = 'Super Admin';
        $feedbackconversation->user_id = $currentUserId;
        $media = $request->file('media');
        if (!is_null($media)) {
            $mediaName = time() . $media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $feedbackconversation->media = $mediaName;
        }
        $feedbackconversation->feedback_id = $feedback_id;
        $feedbackconversation->save();

        $notification = new Notification();
        $notification->user_id = $member->user_id;
        $notification->title = 'You have a Reply on Your '.ucfirst($member->type);
        $notification->type = 'feedbackconversation';
        $notification->type_id = $feedbackconversation->id;
        $notification->sent_at = Carbon::now();
        $notification->status = 1;
        $notification->save();
        //return redirect()->route('feedback.show', ['id' => $feedback_id]);
        return Redirect::route('feedback.show', ['feedback' => $feedback_id]);
        //return Redirect::route('feedback.show', ['id' => $feedback_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
