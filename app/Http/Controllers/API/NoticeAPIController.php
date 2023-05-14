<?php

namespace App\Http\Controllers\API;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\NoticeCollection;

class NoticeAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Scheme List Loaded successfully", 'data'=>new NoticeCollection(Notice::all())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if ($request->hasFile('media')) 
        {
            $media = $request->file('media');
            $mediaName = time().$media->getClientOriginalName();
            $media->move('uploads', $mediaName); 
            $input['media'] = $mediaName;
        }

        $notice = Notice::create($input);

        return response()->json(['success' => true,'notice_id' => $notice->id, 'message' => 'Notice added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Notice Detail Loaded successfully", 'data'=>new NoticeResource($notice)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        $input = $request->all();

        if ($request->hasFile('media')) 
        {
            $media = $request->file('media');
            $mediaName = time().$media->getClientOriginalName();
            $media->move('uploads', $mediaName); 
            $input['media'] = $mediaName;
        }

        $notice->fill($input);
        $notice->save();

        return response()->json(['success' => true,'notice_id' => $notice->id, 'message' => 'Notice updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();
        return response()->json(['success' => true, 'message' => 'Notice deleted successfully']);
    }
}
