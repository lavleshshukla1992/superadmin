<?php

namespace App\Http\Controllers\API;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\FeedbackCollection;
use App\Http\Resources\FeedbackAPICollection;

class FeedbackAPIController extends Controller
{
    public function store(Request $request)
    {
        $media = $request->file('media');
        $input = $request->all();
        if (!is_null($media)) {
            $mediaName = time() . $media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['media'] = $mediaName;
        }
        $input['user_id'] = $input['user_id'] ?? 0;
        $user_info = $this->getUserInfo($input['user_id']);
        $input['user_type'] = $user_info->user_role ?? null;
        $feedback = Feedback::create($input);
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
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Feedback Loaded successfully", 'data' => new FeedbackResource($feedback)]);
    }

    public function userFeedbackHistory(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|min:1',
        ]);

        
        $user_id = $request->get('user_id');
        $type = $request->get('type', '');
        $complaint_type = $request->get('complaint_type', '');
        $status = $request->get('status', '');
        $search_input = $request->get('search_input', '');
        
        $userWiseFeedback = Feedback::where('user_id', $user_id);
        
        if (!empty($type)) {
            $type = explode(',', $type);
            $userWiseFeedback->whereIn('type', $type);
        }

        if (!empty($complaint_type)) { 
            $complaint_type = explode(',', rtrim($complaint_type, ','));
            $userWiseFeedback->whereIn('complaint_type', $complaint_type);
        }

        if (!empty($status)) {
            $status = explode(',', $status);
            $userWiseFeedback->whereIn('status', $status);
        }

        if (!empty($search_input)) {
            $userWiseFeedback->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%')
                    ->orWhere('subject', 'LIKE', '%' . $search_input . '%')
                    ->orWhere('id', 'LIKE', '%' . $search_input . '%');
                });
        }
        
        $userWiseFeedback->orderByDesc('id');

        $userWiseFeedback = $userWiseFeedback->paginate();

        $meta = [
            'first_page' => $userWiseFeedback->url(1),
            'last_page' => $userWiseFeedback->url($userWiseFeedback->lastPage()),
            'prev_page_url' => $userWiseFeedback->previousPageUrl(),
            'per_page' => $userWiseFeedback->perPage(),
            'total_items' => $userWiseFeedback->total(),
            'total_pages' => $userWiseFeedback->lastPage()
        ];
        return response()->json(['status_code' => 200, 'success' => true, "message" => "User Feedback Loaded successfully", 'meta' => $meta, 'data' => new FeedbackCollection($userWiseFeedback)]);
    }

    public function allFeedbackHistory(Request $request)
    {
        $type = $request->get('type', '');
        $status = $request->get('status', '');
        $search_input = $request->get('search_input', '');
        $userWiseFeedback = Feedback::leftjoin('vendor_details as vd', 'vd.id', '=', 'feedback.user_id')
            ->select([
                'vd.id as user_id',
                'feedback.type as type',
                'feedback.created_at as date',
                'feedback.subject as subject',
                'feedback.status as status',
                'feedback.id as id',
                'feedback.complaint_type as complaint_type'
            ]);
        

        if (!empty($type)) {
            $type = explode(',', $type);
            $userWiseFeedback->whereIn('feedback.type', $type);
        }

        if (!empty($status)) {
            $status = explode(',', $status);
            $userWiseFeedback->whereIn('feedback.status', $status);
        }

        if (!empty($request->get('state_id'))) {
			$state_id = explode(',', $request->get('state_id'));
			$userWiseFeedback->where('feedback.state_id', $state_id);
		}
		
		if (!empty($request->get('district_id'))) {
			$district_id = explode(',', $request->get('district_id'));
			$userWiseFeedback->where('feedback.district_id', $district_id);
		}
		
		if (!empty($request->get('municipality_id'))) {
			$municipality_id = explode(',', $request->get('municipality_id'));
			$userWiseFeedback->where('feedback.municipality_id', $municipality_id);
		}
        if (!empty($search_input)) {
            $userWiseFeedback->where(function ($query) use ($search_input) {
                $query->where('feedback.subject', 'LIKE', '%' . $search_input . '%')
                    ->orWhere('feedback.id', 'LIKE', '%' . $search_input . '%');
            });
        }

        $userWiseFeedback->orderByDesc('feedback.id'); // Add ORDER BY clause here

        $userWiseFeedback = $userWiseFeedback->paginate();
        $meta = [
            'first_page' => $userWiseFeedback->url(1),
            'last_page' => $userWiseFeedback->url($userWiseFeedback->lastPage()),
            'prev_page_url' => $userWiseFeedback->previousPageUrl(),
            'per_page' => $userWiseFeedback->perPage(),
            'total_items' => $userWiseFeedback->total(),
            'total_pages' => $userWiseFeedback->lastPage()
        ];
        return response()->json(['status_code' => 200, 'success' => true, "message" => "User Feedback Loaded successfully", 'meta' => $meta, 'data' => new FeedbackAPICollection($userWiseFeedback)]);
    }
}
