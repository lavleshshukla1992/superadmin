<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pincode;
use App\Models\Memebership;
use Illuminate\Http\Request;
use App\Http\Resources\MembershipResource;

class MemebershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memeberships = Memebership::select(['id','validity_from','validity_to','membership_id','status'])->toBase()->get();
        $memeberships = !is_null($memeberships) ? json_decode(json_encode($memeberships),true) : [];
        return view('backend.pages.memberships.index',compact('memeberships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.memberships.create');
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
        $year = Carbon::now()->format('Y');
        $input['membership_id'] = "MEMB".$year.$input['user_id'] ?? '';

        $memebership = Memebership::create($input);
        return response()->json(['success' => true,'status_code' =>200 , 'message' => 'Membership Created Successfully','membership_id'=>$memebership->id]) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function show(Memebership $memebership)
    {
        return response()->json(['success' => true,'status_code' =>200 , 'message' => 'Membership detail loaded Successfully','data'=> new MembershipResource($memebership)]);
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
