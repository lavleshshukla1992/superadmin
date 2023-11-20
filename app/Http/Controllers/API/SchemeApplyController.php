<?php

namespace App\Http\Controllers\API;

use App\Models\SchemeApply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchemeApplyCollection;
use App\Http\Resources\ApiAppliedSchemeCollection;

class SchemeApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|min:1',
            'user_type' => 'required|string',
        ]);
        $userId = $request->get('user_id');
        $userType = $request->get('user_type');
        $query = SchemeApply::leftJoin('schemes as sm', 'sm.id', '=', 'scheme_applies.scheme_id')
            ->where('scheme_applies.user_id', $userId)
            ->where('sm.deleted_at', null)
            ->where('scheme_applies.user_type', $userType)
            ->where('sm.end_at', '>', date('Y-m-d h:i:s'))
            ->select([
                'sm.id', 'sm.name', 'sm.status', 'sm.start_at', 'sm.end_at', 'sm.description as description',
                'scheme_applies.scheme_id as scheme_id', 'scheme_applies.apply_date as apply_date',
                'sm.scheme_image', 'scheme_applies.user_scheme_status as user_scheme_status'
            ]);

        if (!empty($request->get('user_scheme_status'))) {
            $user_scheme_status = explode(',', $request->get('user_scheme_status'));
            $query->whereIn('scheme_applies.user_scheme_status', $user_scheme_status);
        }

        if (!empty($request->get('status'))) {
            $status = explode(',', $request->get('status'));
            $query->whereIn('sm.status', $status);
        }

        $search_input = $request->get('search_input', '');
        if (!empty($search_input)) {
            $query->where(function ($query) use ($search_input) {
                $query->where('sm.name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $query->orderByDesc('scheme_applies.id');

        $data = $query->paginate(10);

        $meta = [
            'first_page' => $data->url(1),
            'last_page' => $data->url($data->lastPage()),
            'prev_page_url' => $data->previousPageUrl(),
            'per_page' => $data->perPage(),
            'total_items' => $data->total(),
            'total_pages' => $data->lastPage()
        ];
        //return response()->json($data);die;
        return response()->json(['status_code' => 200, 'success' => true, "message" => "User Scheme History List Loaded successfully", 'meta' => $meta, 'data' => new SchemeApplyCollection($data)]);
    }
    public function userAppliedScheme(Request $request)
    {
        $request->validate([
            'user_type' => 'required|string',
        ]);
        $userId = $request->get('user_id');
        $userType = $request->get('user_type');

        $query = SchemeApply::leftJoin('schemes as sm', 'sm.id', '=', 'scheme_applies.scheme_id')
            ->where('scheme_applies.user_type', $userType)
            ->where('sm.end_at', '>', date('Y-m-d h:i:s'))
            ->select([
                'sm.id', 'sm.name', 'sm.status', 'sm.start_at', 'sm.description as description',
                'scheme_applies.scheme_id as scheme_id', 'scheme_applies.apply_date as apply_date',
                'sm.scheme_image', 'scheme_applies.user_scheme_status as user_scheme_status'
            ]);

        if (!empty($request->get('user_scheme_status'))) {
            $user_scheme_status = explode(',', $request->get('user_scheme_status'));
            $query->whereIn('scheme_applies.user_scheme_status', $user_scheme_status);
        }

        if (!empty($request->get('status'))) {
            $status = explode(',', $request->get('status'));
            $query->whereIn('sm.status', $status);
        }

        $search_input = $request->get('search_input', '');
        if (!empty($search_input)) {
            $query->where(function ($query) use ($search_input) {
                $query->where('sm.name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $query->orderByDesc('scheme_applies.id');

        $data = $query->paginate(10);

        $meta = [
            'first_page' => $data->url(1),
            'last_page' => $data->url($data->lastPage()),
            'prev_page_url' => $data->previousPageUrl(),
            'per_page' => $data->perPage(),
            'total_items' => $data->total(),
            'total_pages' => $data->lastPage()
        ];

        return response()->json(['status_code' => 200, 'success' => true, "message" => "User Scheme History List Loaded successfully", 'meta' => $meta, 'data' => new SchemeApplyCollection($data)]);
    }
    public function appliedScheme(Request $request)
    {
        $request->validate([
            'scheme_id' => 'required|string',
        ]);
        $scheme_id = $request->get('scheme_id');

        $query = SchemeApply::leftJoin('vendor_details as vd', 'vd.id', '=', 'scheme_applies.user_id')
            ->leftJoin('states as s', 's.id', '=', 'vd.current_state')
			->leftJoin('vendings as v', 'v.id', '=', 'vd.type_of_vending')
            ->where('scheme_applies.scheme_id', $scheme_id)
            ->where('scheme_applies.user_scheme_status', 'applied')
            ->select(['scheme_applies.id','scheme_applies.apply_date','vd.id as user_id', 'vd.uid', 'vd.date_of_birth', 'v.name as vendor_type', \DB::raw('CONCAT(vd.vendor_first_name, " ", vd.vendor_last_name) as name'), 's.name as state']);

        $query->orderByDesc('scheme_applies.apply_date');

        $data = $query->paginate(10);

        $meta = [
            'first_page' => $data->url(1),
            'last_page' => $data->url($data->lastPage()),
            'prev_page_url' => $data->previousPageUrl(),
            'per_page' => $data->perPage(),
            'total_items' => $data->total(),
            'total_pages' => $data->lastPage()
        ];

        return response()->json(['status_code' => 200, 'success' => true, "message" => "User Scheme History List Loaded successfully", 'meta' => $meta, 'data' => new ApiAppliedSchemeCollection($data)]);
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
        $userId = $request->get('user_id');
        $schemeId = $request->get('scheme_id');
        $schemeApply = SchemeApply::where('user_id', $userId)->where('scheme_id', $schemeId)->update([
            'apply_date' => date('Y-m-d'),
            'user_scheme_status' => 'applied'
        ]);
        $schemeApply =  SchemeApply::where('user_id', $userId)->where('scheme_id', $schemeId)->first('id');
        return response()->json(['success' => true, 'scheme_appication_id' => $schemeApply->id, 'message' => 'Scheme Applied successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchemeApply  $schemeApply
     * @return \Illuminate\Http\Response
     */
    public function show(SchemeApply $schemeApply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchemeApply  $schemeApply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchemeApply $schemeApply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchemeApply  $schemeApply
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchemeApply $schemeApply)
    {
        //
    }
}
