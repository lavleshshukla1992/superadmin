<?php

namespace App\Http\Controllers\API;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\NoticeCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class NoticeAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $noticesQuery = Notice::query();

        if (!empty($request->get('status'))) {
            $status = explode(',', $request->get('status'));
            $noticesQuery->whereIn('status', $status);
        }
        if (!empty($request->get('user_id'))) {
            $vendor_info = DB::table('vendor_details')->find($request->get('user_id'));
            $current_state          = !empty($vendor_info->current_state) ? explode(',', $vendor_info->current_state) : [];
            $current_district       = !empty($vendor_info->current_district) ? explode(',', $vendor_info->current_district) : [];
            $municipality_panchayat_current   = !empty($vendor_info->municipality_panchayat_current) ? explode(',', $vendor_info->municipality_panchayat_current) : [];

            if (!empty($current_state)) {
                $noticesQuery->where(function ($query) use ($current_state) {
                    $query->where(function ($query) use ($current_state) {
                        foreach ($current_state as $state) {
                            $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                        }
                    })->orWhereNull('state_id');
                });
            }
            if (!empty($current_district)) {
                $noticesQuery->where(function ($query) use ($current_district) {
                    $query->where(function ($query) use ($current_district) {
                        foreach ($current_district as $district) {
                            $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                        }
                    })->orWhereNull('district_id');
                });
            }
            if (!empty($municipality_panchayat_current)) {
                $noticesQuery->where(function ($query) use ($municipality_panchayat_current) {
                    $query->where(function ($query) use ($municipality_panchayat_current) {
                        foreach ($municipality_panchayat_current as $municipality) {
                            $query->orWhereRaw("FIND_IN_SET(?, municipality_id)", [$municipality]);
                        }
                    })->orWhereNull('municipality_id');
                });
            }
        }

        $search_input = $request->get('search_input', '');
        
        if (!empty($search_input)) {
            $noticesQuery->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $noticesQuery->orderByDesc('id');

        // Get the paginated result
        $notices = $noticesQuery->paginate();

        $meta = [
            'first_page' => $notices->url(1),
            'last_page' => $notices->url($notices->lastPage()),
            'prev_page_url' =>$notices->previousPageUrl(),
            'per_page' => $notices->perPage(),
            'total_items' => $notices->total(),
            'total_pages' => $notices->lastPage()
        ];
        return response()->json(['status_code' => 200,'success' => true,"message" => "Notice History List Loaded successfully",'meta'=> $meta, 'data'=>new NoticeCollection($notices)]);
    }
    public function globalIndex(Request $request)
    {
        $noticesQuery = Notice::query();

        if (!empty($request->get('status'))) {
            $status = explode(',', $request->get('status'));
            $noticesQuery->whereIn('status', $status);
        }
        if (!empty($request->get('user_id'))) {
            $vendor_info = Admin::find($request->get('user_id'));
            $role = !empty($vendor_info)?$vendor_info->roles->first():'';
            $roleName = $role->name ?? '';
            if ($roleName != 'Admin') {
                $current_state          = !empty($vendor_info->current_state) ? explode(',', $vendor_info->current_state) : [];
                $current_district       = !empty($vendor_info->current_district) ? explode(',', $vendor_info->current_district) : [];
                $municipality_panchayat_current   = !empty($vendor_info->municipality_panchayat_current) ? explode(',', $vendor_info->municipality_panchayat_current) : [];

                if (!empty($current_state)) {
                    $noticesQuery->where(function ($query) use ($current_state) {
                        $query->where(function ($query) use ($current_state) {
                            foreach ($current_state as $state) {
                                $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                            }
                        })->orWhereNull('state_id');
                    });
                }
                if (!empty($current_district)) {
                    $noticesQuery->where(function ($query) use ($current_district) {
                        $query->where(function ($query) use ($current_district) {
                            foreach ($current_district as $district) {
                                $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                            }
                        })->orWhereNull('district_id');
                    });
                }
                if (!empty($municipality_panchayat_current)) {
                    $noticesQuery->where(function ($query) use ($municipality_panchayat_current) {
                        $query->where(function ($query) use ($municipality_panchayat_current) {
                            foreach ($municipality_panchayat_current as $municipality) {
                                $query->orWhereRaw("FIND_IN_SET(?, municipality_id)", [$municipality]);
                            }
                        })->orWhereNull('municipality_id');
                    });
                }
            }
        }

        $search_input = $request->get('search_input', '');
        
        if (!empty($search_input)) {
            $noticesQuery->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $noticesQuery->orderByDesc('id');

        // Get the paginated result
        $notices = $noticesQuery->paginate();
        $meta = [
            'first_page' => $notices->url(1),
            'last_page' => $notices->url($notices->lastPage()),
            'prev_page_url' =>$notices->previousPageUrl(),
            'per_page' => $notices->perPage(),
            'total_items' => $notices->total(),
            'total_pages' => $notices->lastPage()
        ];
        return response()->json(['status_code' => 200,'success' => true,"message" => "Notice History List Loaded successfully",'meta'=> $meta, 'data'=>new NoticeCollection($notices)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'end_date' => ['required', 'date', 'after_or_equal:' . Carbon::today()->format('Y-m-d')],
        ]);

        $input = $request->all();

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

        $notice = Notice::create($input);

        $this->addDemoGraphyNotification('notice',$notice->id);

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

    public function liveNotice(Request $request)
    {

        Notice::whereDate('end_date', '<', date('Y-m-d'))->update(['status' => 'In Active']);
        
        $noticesQuery = Notice::whereDate('end_date', '>=', date('Y-m-d'));

        if (!empty($request->get('status'))) {
            $status = explode(',', $request->get('status'));
            $noticesQuery->whereIn('status', $status);
        }
        if (!empty($request->get('user_id'))) {
            $vendor_info = DB::table('vendor_details')->find($request->get('user_id'));
            $current_state          = !empty($vendor_info->current_state) ? explode(',', $vendor_info->current_state) : [];
            $current_district       = !empty($vendor_info->current_district) ? explode(',', $vendor_info->current_district) : [];
            $municipality_panchayat_current   = !empty($vendor_info->municipality_panchayat_current) ? explode(',', $vendor_info->municipality_panchayat_current) : [];

            if (!empty($current_state)) {
                $noticesQuery->where(function ($query) use ($current_state) {
                    $query->where(function ($query) use ($current_state) {
                        foreach ($current_state as $state) {
                            $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                        }
                    })->orWhereNull('state_id');
                });
            }
            if (!empty($current_district)) {
                $noticesQuery->where(function ($query) use ($current_district) {
                    $query->where(function ($query) use ($current_district) {
                        foreach ($current_district as $district) {
                            $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                        }
                    })->orWhereNull('district_id');
                });
            }
            if (!empty($municipality_panchayat_current)) {
                $noticesQuery->where(function ($query) use ($municipality_panchayat_current) {
                    $query->where(function ($query) use ($municipality_panchayat_current) {
                        foreach ($municipality_panchayat_current as $municipality) {
                            $query->orWhereRaw("FIND_IN_SET(?, municipality_id)", [$municipality]);
                        }
                    })->orWhereNull('municipality_id');
                });
            }
        }

        $search_input = $request->get('search_input', '');
        if (!empty($search_input)) {
            $noticesQuery->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $noticesQuery->orderByDesc('id');

        $notices = $noticesQuery->paginate();

        $meta = [
            'first_page' => $notices->url(1),
            'last_page' => $notices->url($notices->lastPage()),
            'prev_page_url' =>$notices->previousPageUrl(),
            'per_page' => $notices->perPage(),
            'total_items' => $notices->total(),
            'total_pages' => $notices->lastPage()
        ];
        return response()->json(['status_code' => 200,'success' => true,"message" => "Notice Live List Loaded successfully",'meta'=> $meta, 'data'=>new NoticeCollection($notices)]);
    }
}
