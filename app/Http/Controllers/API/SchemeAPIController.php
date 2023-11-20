<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Scheme;
use App\Models\SchemeApply;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchemeResource;
use App\Http\Resources\ApiSchemeResource;
use App\Http\Resources\SchemeCollection;
use App\Http\Resources\ApiSchemeCollection;
use App\Http\Resources\LiveSchemeColection;
use Illuminate\Support\Facades\DB;

class SchemeAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Scheme::query();

        if (!empty($request->get('status'))) {
            $status = explode(',', $request->get('status'));
            $query->whereIn('status', $status);
        }

        if (!empty($request->get('user_id'))) {
            $admin_info = Admin::find($request->get('user_id'));
            $role = !empty($admin_info)?$admin_info->roles->first():'';
            $roleName = $role->name ?? '';
            if ($roleName != 'Admin') {
                $current_state          = !empty($admin_info->current_state) ? explode(',', $admin_info->current_state) :[];
                $current_district       = !empty($admin_info->current_district) ? explode(',', $admin_info->current_district) :[];
                $municipality_panchayat_current   = !empty($admin_info->municipality_panchayat_current) ? explode(',', $admin_info->municipality_panchayat_current) :[];

                if (!empty($current_state)) {
                    $query->where(function ($query) use ($current_state) {
                        $query->where(function ($query) use ($current_state) {
                            foreach ($current_state as $state) {
                                $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                            }
                        })->orWhereNull('state_id');
                    });
                }
                if (!empty($current_district)) {
                    $query->where(function ($query) use ($current_district) {
                        $query->where(function ($query) use ($current_district) {
                            foreach ($current_district as $district) {
                                $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                            }
                        })->orWhereNull('district_id');
                    });
                }
                if (!empty($municipality_panchayat_current)) {
                    $query->where(function ($query) use ($municipality_panchayat_current) {
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
            $query->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $query->orderByDesc('id');

        $scheme = $query->paginate();

        $meta = [
            'first_page' => $scheme->url(1),
            'last_page' => $scheme->url($scheme->lastPage()),
            'prev_page_url' => $scheme->previousPageUrl(),
            'per_page' => $scheme->perPage(),
            'total_items' => $scheme->total(),
            'total_pages' => $scheme->lastPage()
        ];
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Scheme List Loaded successfully", 'meta' => $meta, 'data' => new ApiSchemeCollection($scheme)]);
    }
    
    public function globalIndex(Request $request)
    {
        $query = Scheme::query();

        if (!empty($request->get('status'))) {
            $status = explode(',', $request->get('status'));
            $query->whereIn('status', $status);
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
                    $query->where(function ($query) use ($current_state) {
                        $query->where(function ($query) use ($current_state) {
                            foreach ($current_state as $state) {
                                $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                            }
                        })->orWhereNull('state_id');
                    });
                }
                if (!empty($current_district)) {
                    $query->where(function ($query) use ($current_district) {
                        $query->where(function ($query) use ($current_district) {
                            foreach ($current_district as $district) {
                                $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                            }
                        })->orWhereNull('district_id');
                    });
                }
                if (!empty($municipality_panchayat_current)) {
                    $query->where(function ($query) use ($municipality_panchayat_current) {
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
            $query->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $query->orderByDesc('id');
        $scheme = $query->paginate();

        $meta = [
            'first_page' => $scheme->url(1),
            'last_page' => $scheme->url($scheme->lastPage()),
            'prev_page_url' => $scheme->previousPageUrl(),
            'per_page' => $scheme->perPage(),
            'total_items' => $scheme->total(),
            'total_pages' => $scheme->lastPage()
        ];
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Scheme List Loaded successfully", 'meta' => $meta, 'data' => new ApiSchemeCollection($scheme)]);
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
            'end_at' => ['required', 'date', 'after_or_equal:' . Carbon::today()->format('Y-m-d')],
        ]);
        $input = $request->all();
        if ($request->hasFile('scheme_image')) {
            $media = $request->file('scheme_image');
            $mediaName = time() . $media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['scheme_image'] = $mediaName;
        }

        $scheme = Scheme::create($input);

        $this->addDemoGraphyNotification('scheme', $scheme->id);

        return response()->json(['success' => true, 'scheme_id' => $scheme->id, 'message' => 'Scheme added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Scheme $scheme)
    {
        $count = SchemeApply::where('user_scheme_status', 'applied')->where('scheme_id', $scheme->id)->count();
        
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Scheme Detail Loaded successfully", 'data' => new SchemeResource($scheme),'total_applied' => $count]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scheme $scheme)
    {
        $schemeId = $scheme->id;
        
        $schemeApplied = SchemeApply::where('scheme_id', $schemeId)->where('user_scheme_status', 'applied')->exists();

        $confirmed = $request->get('confirm_update');

        if ($schemeApplied && $confirmed == 0) {
            return response()->json(['success' => true, 'scheme_id' => $scheme->id, 'message' => 'Are You sure you want to update the Scheme ?']);
        }

        $input = $request->all();
        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $mediaName = time() . $media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['media'] = $mediaName;
        }

        $scheme->fill($input);
        $scheme->save();

        return response()->json(['success' => true, 'scheme_id' => $scheme->id, 'message' => 'Scheme updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Scheme $scheme)
    {
        $schemeId = $scheme->id;

        $schemeApplied = SchemeApply::where('scheme_id', $schemeId)->where('user_scheme_status', 'applied')->exists();

        $confirmed = $request->get('confirm_update');

        if ($schemeApplied && $confirmed == 0) {
            return response()->json(['success' => true, 'scheme_id' => $scheme->id, 'message' => 'Are You sure you want to update the Scheme ?']);
        }

        $scheme->delete();
        return response()->json(['success' => true, 'message' => 'Scheme deleted successfully']);
    }

    public function liveScheme(Request $request)
    {
        Scheme::whereDate('end_at', '<', date('Y-m-d'))->update(['status' => 'In Active']);

        $request->validate([
            'user_id' => 'required|integer|min:1',
        ]);

        $userId = $request->get('user_id');

        $scheme = SchemeApply::leftJoin('schemes as s', 's.id', 'scheme_applies.scheme_id')
            ->where('scheme_applies.user_id', $userId)
            ->where('s.deleted_at', null)
            ->where('end_at', '>', date('Y-m-d h:i:s'))
            ->select('s.*', 'scheme_applies.user_scheme_status as user_scheme_status', 'scheme_applies.user_id as user_id');

        $today = date('Y-m-d');
        $scheme->where(function ($query) use ($today) {
            $query->whereDate('start_at', '<=', $today)
                ->orWhereNull('start_at');
        });

        // Add the additional conditions based on request parameters
        if (!empty($request->get('user_scheme_status'))) {
            $user_scheme_status = explode(',', $request->get('user_scheme_status'));
            $scheme->whereIn('scheme_applies.user_scheme_status', $user_scheme_status);
        }

        if (!empty($request->get('status'))) {
            $status = explode(',', $request->get('status'));
            $scheme->whereIn('s.status', $status);
        }

        if (!empty($request->get('scheme_id'))) {
            $scheme->where('s.id', 'LIKE', '%' . $request->get('scheme_id') . '%');
        }

        $search_input = $request->get('search_input', '');
        if (!empty($search_input)) {
            $scheme->where(function ($query) use ($search_input) {
                $query->where('s.name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $scheme->orderByDesc('scheme_applies.id');
        // Get the paginated result
        $scheme = $scheme->paginate();

        $meta = [
            'first_page' => $scheme->url(1),
            'last_page' => $scheme->url($scheme->lastPage()),
            'prev_page_url' => $scheme->previousPageUrl(),
            'per_page' => $scheme->perPage(),
            'total_items' => $scheme->total(),
            'total_pages' => $scheme->lastPage()
        ];
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Live Scheme List Loaded successfully", 'meta' => $meta, 'data' => new LiveSchemeColection($scheme)]);
    }
}
