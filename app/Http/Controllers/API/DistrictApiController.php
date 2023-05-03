<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\DistrictCollection;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DistrictApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stateId = $request->get('state_id');
        $districtList = District::where('state_id',$stateId)->select('id','name','state_id','status')->get();
        return response()->json(['status_code' => 200,'success' => true,"message" => "District List Loaded successfully", 'data'=>new DistrictCollection($districtList)]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $district = District::create($request->all());
        return response()->json(['success' => true,'district_id' => $district->id, 'message' => 'District added successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        return response()->json(['success' => true,'data' => new DistrictResource($district)]);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
