<?php

namespace App\Http\Controllers;

use App\Models\Memebership;
use Illuminate\Http\Request;

class MemebershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marketPlaces = Memebership::select(['id','name','description','status'])->toBase()->get();
        $marketPlaces = !is_null($marketPlaces) ? json_decode(json_encode($marketPlaces),true) : [];
        return view('backend.pages.marketplace.index',compact('marketPlaces'));
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
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function show(Memebership $memebership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function edit(Memebership $memebership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memebership $memebership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memebership $memebership)
    {
        //
    }
}
