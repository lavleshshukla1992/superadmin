<?php

namespace App\Http\Controllers;

use App\Models\MarketPlace;
use Illuminate\Http\Request;

class MarketPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marketPlaces = MarketPlace::select(['id','name','description','status'])->toBase()->get();
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
        return view('backend.pages.marketplace.create');
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MarketPlace::create($request->all());
        return redirect()->route('market-places.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MarketPlace  $marketPlace
     * @return \Illuminate\Http\Response
     */
    public function show(MarketPlace $marketPlace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MarketPlace  $marketPlace
     * @return \Illuminate\Http\Response
     */
    public function edit(MarketPlace $marketPlace)
    {
        return view('backend.pages.marketplace.edit',compact('marketPlace'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MarketPlace  $marketPlace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarketPlace $marketPlace)
    {
        $marketPlace->fill($request->all());
        $marketPlace->save();
        return redirect()->route('market-places.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MarketPlace  $marketPlace
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarketPlace $marketPlace)
    {
        //
    }
}
