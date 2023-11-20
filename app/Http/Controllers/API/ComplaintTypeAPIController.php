<?php

namespace App\Http\Controllers\API;

use App\Models\ComplaintType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintTypeResource;
use App\Http\Resources\ComplaintTypeCollection;


class ComplaintTypeAPIController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        dd($input);
        
        /*$input['user_id'] = $input['user_id'] ?? 0;
        $user_info = $this->getUserInfo($input['user_id']);
        $input['user_type'] = $user_info->user_role ?? null;
        $feedback = ComplaintType::create($input);
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Feedback added successfully", 'feedback_id' => $feedback->id]);*/
    }


    public function show(Request $request, ComplaintType $complainttype)
    {
        $query = ComplaintType::query();

        $query->orderByDesc('id');

        $information = $query->paginate();

        return response()->json(['status_code' => 200, 'success' => true, "message" => "Complaint Types Loaded successfully", 'data' => new ComplaintTypeCollection($information)]);


        //$complainttype_info = ComplaintType::all();
        //echo '<pre>'; print_r($complainttype_info);

        //return response()->json(['status_code' => 200, 'success' => true, "message" => "Nominee Detail Loaded successfully", 'data' => new ComplaintTypeCollection($complainttype)]);
    }

}