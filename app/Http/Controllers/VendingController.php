<?php

namespace App\Http\Controllers;

use App\Models\Vending;
use Illuminate\Http\Request;

class VendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendings = Vending::select(['id','name','description','status'])->toBase()->get();
        $vendings = !is_null($vendings) ? json_decode(json_encode($vendings),true) : [];
        return view('backend.pages.vending.index',compact('vendings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.vending.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Vending::create($request->all());
        return redirect()->route('vending.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vending  $vending
     * @return \Illuminate\Http\Response
     */
    public function show(Vending $vending)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vending  $vending
     * @return \Illuminate\Http\Response
     */
    public function edit(Vending $vending)
    {
        return view('backend.pages.vending.edit',compact('vending'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vending  $vending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vending $vending)
    {
        $vending->fill($request->all());
        $vending->save();
        return redirect()->route('vending.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vending  $vending
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vending $vending)
    {
        $vending->delete();
        return redirect()->route('vending.index');

    }
}
