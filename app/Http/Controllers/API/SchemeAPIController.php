<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Scheme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchemeResource;
use App\Http\Resources\SchemeCollection;

class SchemeAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scheme = Scheme::where('end_at','<',date('Y-m-d h:i:s'))->paginate();
        return response()->json(['status_code' => 200,'success' => true,"message" => "Scheme List Loaded successfully", 'data'=>new SchemeCollection($scheme)]);
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

        $scheme = Scheme::create($input);

        return response()->json(['success' => true,'scheme_id' => $scheme->id, 'message' => 'Scheme added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Scheme $scheme)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Scheme Detail Loaded successfully", 'data'=>new SchemeResource($scheme)]);
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
        $input = $request->all();
        if ($request->hasFile('media')) 
        {
            $media = $request->file('media');
            $mediaName = time().$media->getClientOriginalName();
            $media->move('uploads', $mediaName); 
            $input['media'] = $mediaName;
        }

        $scheme->fill($input);
        $scheme->save();

        return response()->json(['success' => true,'scheme_id' => $scheme->id, 'message' => 'Scheme updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scheme $scheme)
    {
        $scheme->delete();
        return response()->json(['success' => true, 'message' => 'Scheme deleted successfully']);
    }

    public function liveScheme()
    {
        $scheme = Scheme::where('end_at','>',date('Y-m-d h:i:s'))->paginate();
        return response()->json(['status_code' => 200,'success' => true,"message" => "Live Scheme List Loaded successfully", 'data'=>new SchemeCollection($scheme)]);
    }
}
