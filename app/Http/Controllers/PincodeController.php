<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\State;
use App\Models\Pincode;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pinCodes = Pincode::from('pincodes as pc')->select(['pc.id','pc.pincode','d.name as district','pc.status'])
        ->leftJoin('districts as d','d.id','=','pc.district_id')
        ->toBase()->get()->take(10);

        $pinCodes = !is_null($pinCodes) ? json_decode(json_encode($pinCodes),true) : [];
        return view('backend.pages.pincode.index',compact('pinCodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.pincode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Pincode::create($request->all());
        return redirect()->route('pin-codes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pincode $pinCode)
    {
       return view('backend.pages.pincode.edit',compact('pinCode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pincode $pinCode)
    {
        $pinCode->fill($request->all());
        $pinCode->save();
        return redirect()->route('pin-codes.index');
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

    public function getDistrictList(Request $request)
    {
        $stateId = $request->get('state');
        $result = [];

        if (! is_null($stateId)) 
        {
           $result = District::where('state_id',$stateId)->pluck('name','id')->toArray();
        }

        return $result;
    }
}
