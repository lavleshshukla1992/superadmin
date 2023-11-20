<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Information;
use App\Models\Scheme;
use App\Models\SchemeApply;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InformationResource;
use App\Http\Resources\SchemeResource;
use App\Http\Resources\ApiSchemeResource;
use App\Http\Resources\ApiInformationResource;
use App\Http\Resources\SchemeCollection;
use App\Http\Resources\ApiSchemeCollection;
use App\Http\Resources\ApiInformationCollection;
use App\Http\Resources\LiveSchemeColection;
use Illuminate\Support\Facades\DB;

class InformationAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Information::query();

        $query->orderByDesc('id');

        $information = $query->paginate();

        $meta = [
            'first_page' => $information->url(1),
            'last_page' => $information->url($information->lastPage()),
            'prev_page_url' => $information->previousPageUrl(),
            'per_page' => $information->perPage(),
            'total_items' => $information->total(),
            'total_pages' => $information->lastPage()
        ];
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Information List Loaded successfully", 'meta' => $meta, 'data' => new ApiInformationCollection($information)]);
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        /*$request->validate([
            'end_at' => ['required', 'date', 'after_or_equal:' . Carbon::today()->format('Y-m-d')],
        ]);*/
        $request->validate([
            'information_link' => ['', 'url', ''],
        ]);
        $input = $request->all();
        if ($request->hasFile('cover_image')) {
            $media = $request->file('cover_image');
            $mediaName = time() . $media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['cover_image'] = $mediaName;
        }

        $information = Information::create($input);

        return response()->json(['success' => true, 'information_id' => $information->id, 'message' => 'Information added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        //$count = Information::where('id', $information->id)->count();
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Information Detail Loaded successfully", 'data' => new InformationResource($information),/*'total_applied' => $count*/]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    {
        // $request->validate([
        //     'information_link' => ['', 'url', ''],
        // ]);

        $input = $request->all();

        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image');
            $mediaName = time() . $cover_image->getClientOriginalName();
            $cover_image->move('uploads', $mediaName);
            $input['cover_image'] = $mediaName;
        }

        $information->fill($input);
        $information->save();

        return response()->json(['success' => true, 'information_id' => $information->id, 'message' => 'Information updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Information $information)
    {
        $informationId = $information->id;

        $informationApplied = Information::where('id', $informationId);

        /*$confirmed = $request->get('confirm_update');

        if ($informationApplied && $confirmed == 0) {
            return response()->json(['success' => true, 'information_id' => $information->id, 'message' => 'Are You sure you want to update the Information ?']);
        }*/

        $information->delete();
        return response()->json(['success' => true, 'message' => 'Information deleted successfully']);
    }

}
