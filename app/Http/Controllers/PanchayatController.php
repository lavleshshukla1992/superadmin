<?php

namespace App\Http\Controllers;

use App\Models\Panchayat;
use Illuminate\Http\Request;
use App\Http\Resources\PanchayatResource;
use App\Http\Resources\PanchayatCollection;

class PanchayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panchayat  $panchayat
     * @return \Illuminate\Http\Response
     */
    public function show(Panchayat $panchayat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Panchayat  $panchayat
     * @return \Illuminate\Http\Response
     */
    public function edit(Panchayat $panchayat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Panchayat  $panchayat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Panchayat $panchayat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panchayat  $panchayat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panchayat $panchayat)
    {
        //
    }

  
    public function getList()
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Panchayat List Loaded successfully", 'data'=> new PanchayatCollection(Panchayat::all('id','name','state_id','status'))]);
    }
}
