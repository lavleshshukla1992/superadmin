<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $notices = Notice::all('id','name','created_by','updated_by')->toArray();
        $notices = Notice::select(
            'notices.id',
            'notices.name',
            'users_created.name as created_by',
            'users_updated.name as updated_by'
        )
        ->leftJoin('users as users_created', 'notices.created_by', '=', 'users_created.id')
        ->leftJoin('users as users_updated', 'notices.updated_by', '=', 'users_updated.id')
        ->get()
        ->toArray();
        $notices = !is_null($notices) ? json_decode(json_encode($notices),true): [];
        return view('backend.pages.notice.index',compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.notice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $media = $request->file('media');
        $input = $request->all();
        // if (! is_null($media)) 
        // {
        //     $mediaName = time().$media->getClientOriginalName();
        //     $media->move('uploads', $mediaName);
        //     $input['media'] = $mediaName;
        // }
        if ($request->hasFile('notice_image')) 
        {
            $noticeImage = $request->file('notice_image');
            $noticeImageName = time().$noticeImage->getClientOriginalName();
            $noticeImage->move('uploads', $noticeImageName); 
            $input['notice_image'] = $noticeImageName;
        }

        if ($request->hasFile('training_video')) 
        {
            $trainingVideo = $request->file('training_video');
            $trainingVideoName = time().$trainingVideo->getClientOriginalName();
            $trainingVideo->move('uploads', $trainingVideoName); 
            $input['training_video'] = $trainingVideoName;
        }
        
        $input['gender'] = !empty($input['gender'])?implode(',',$input['gender']):'';
        $input['social_category'] = !empty($input['social_category'])?implode(',',$input['social_category']):'';
        $input['educational_qualification'] = !empty($input['educational_qualification'])?implode(',',$input['educational_qualification']):'';
        $input['type_of_vending'] = !empty($input['type_of_vending'])?implode(',',$input['type_of_vending']):'';
        $input['type_of_marketplace'] = !empty($input['type_of_marketplace'])?implode(',',$input['type_of_marketplace']):'';
        $input['state_id'] = !empty($input['state_id'])?implode(',',$input['state_id']):'';
        $input['district_id'] = !empty($input['district_id'])?implode(',',$input['district_id']):'';
        $input['municipality_id'] = !empty($input['municipality_id'])?implode(',',$input['municipality_id']):'';

        Notice::create($input);
        return redirect()->route('notice.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {

        $members = DB::table('notice_vendor_detail as nvd')->where('notice_id',$notice->id)
        ->leftJoin('vendor_details as vd','vd.id','=','nvd.vendor_detail_id')
        ->select(['vd.vendor_first_name','nvd.status'])->get();
        $members = !is_null($members) ? json_decode(json_encode($members),true): [];

        
        return view('backend.pages.notice.detail',compact('notice','members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        return view('backend.pages.notice.edit',compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
      //  $media = $request->file('media');
        $input = $request->all();
        // if (! is_null($media)) 
        // {
        //     $mediaName = time().$media->getClientOriginalName();
        //     $media->move('uploads', $mediaName);
        //     $input['media'] = $mediaName;
        // }

        if ($request->hasFile('notice_image')) 
        {
            $noticeImage = $request->file('notice_image');
            $noticeImageName = time().$noticeImage->getClientOriginalName();
            $noticeImage->move('uploads', $noticeImageName); 
            $input['notice_image'] = $noticeImageName;
        }

        if ($request->hasFile('training_video')) 
        {
            $trainingVideo = $request->file('training_video');
            $trainingVideoName = time().$trainingVideo->getClientOriginalName();
            $trainingVideo->move('uploads', $trainingVideoName); 
            $input['training_video'] = $trainingVideoName;
        }
        
        $input['gender'] = !empty($input['gender'])?implode(',',$input['gender']):'';
        $input['social_category'] = !empty($input['social_category'])?implode(',',$input['social_category']):'';
        $input['educational_qualification'] = !empty($input['educational_qualification'])?implode(',',$input['educational_qualification']):'';
        $input['type_of_vending'] = !empty($input['type_of_vending'])?implode(',',$input['type_of_vending']):'';
        $input['type_of_marketplace'] = !empty($input['type_of_marketplace'])?implode(',',$input['type_of_marketplace']):'';
        $input['state_id'] = !empty($input['state_id'])?implode(',',$input['state_id']):'';
        $input['district_id'] = !empty($input['district_id'])?implode(',',$input['district_id']):'';
        $input['municipality_id'] = !empty($input['municipality_id'])?implode(',',$input['municipality_id']):'';
        
        $notice->fill($input);
        $notice->save();
        return redirect()->route('notice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('notice.index');
    }
}
