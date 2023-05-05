<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use Illuminate\Http\Request;

class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schemes = Scheme::all('id','name','description','status')->toArray();
        $schemes = !is_null($schemes) ? json_decode(json_encode($schemes),true): [];
        return view('backend.pages.scheme.index',compact('schemes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.scheme.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Scheme::create($request->all());
        return redirect()->route('scheme.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Scheme  $scheme
     * @return \Illuminate\Http\Response
     */
    public function show(Scheme $scheme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scheme  $scheme
     * @return \Illuminate\Http\Response
     */
    public function edit(Scheme $scheme)
    {
        return view('backend.pages.scheme.edit',compact('scheme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Scheme  $scheme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scheme $scheme)
    {
        $scheme->fill($request->all());
        $scheme->save();
        return redirect()->route('scheme.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scheme  $scheme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scheme $scheme)
    {
        $scheme->delete();
        return redirect()->route('scheme.index');
        
    }
}
