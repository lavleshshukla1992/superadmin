<?php

namespace App\Http\Controllers\API;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\StateCollection;
use App\Http\Requests\StoreStateRequest;
use App\Http\Resources\StateResource;

class StateApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "State List Loaded successfully", 'data'=> new StateCollection(State::all('id','name','country_id'))]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStateRequest $request)
    {
        $state = State::create($request->all());
        return response()->json(['success' => true,'state_id' => $state->id, 'message' => 'State added successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        return response()->json(['success' => true,'data' => new StateResource($state)]);
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
