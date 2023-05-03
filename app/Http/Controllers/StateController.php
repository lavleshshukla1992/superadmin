<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Pincode;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStateRequest;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::from('states')->select(['states.id','states.name','states.status','cs.name as country'])->leftJoin('countries as cs','cs.id','=','states.country_id')->toBase()->get();
        $states = !is_null($states) ? json_decode(json_encode($states),true) : [];
        return view('backend.pages.state.index',compact('states'));
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.state.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StoreStateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStateRequest $request)
    {
        State::create($request->all());
        return redirect()->route('state.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        return view('backend.pages.state.edit',compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StoreStateRequest  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStateRequest $request, State $state)
    {
        $state->fill($request->all());
        $state->save();
        return redirect()->route('state.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('state.index');
    }

    public function importData()
    {
        $filename = public_path('Pincode_30052019.csv');
        $delimiter = ',';

        if (!file_exists($filename) || !is_readable($filename))
        {
            return false;
        }

        $header = null;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        foreach ($data as $key => $row) 
        {

            $state = State::firstOrCreate([
                'name' => $row['StateName'],
                'country_id' => '1'
            ],[
                'status' => 'Active'
            ]);
            $district = District::firstOrCreate([
                'name' => $row['District'],
                'state_id' => $state->id
            ],['status' => 'Active']);

            $state = Pincode::firstOrCreate([
                'pincode' => $row['Pincode'],
                'district_id' => $district->id,
            ],['status' => 'Active']);
        }

        return $data;
    }
}
