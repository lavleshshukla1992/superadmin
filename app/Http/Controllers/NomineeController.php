<?php

namespace App\Http\Controllers;

use App\Models\Nominee;
use App\Models\Memebership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NomineeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view();
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Information  $scheme
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Nominee $nominee)
    {  
        $member_id = $request->route('id');
        $nominee_details = Nominee::where('vendor_id',$member_id)->first();

        if (!empty($nominee_details->nominee)) {
            $nominees = unserialize($nominee_details->nominee);
        }
        
        $i = 1;
        $name1=$name2=$name3=$name4=$name5=$field1=$field2=$field3=$field4=$field5='';
        if (isset($nominees) && is_array($nominees)) {
            foreach ($nominees as $key => $value) {
                foreach ($value as $type => $name) {
                    if ($i == 1) {
                        $name1 = $name;
                        $field1 = $type;
                    }
                    if ($i == 2) {
                        $name2 = $name;
                        $field2 = $type;
                    }
                    if ($i == 3) {
                        $name3 = $name;
                        $field3 = $type;
                    }
                    if ($i == 4) {
                        $name4 = $name;
                        $field4 = $type;
                    }
                    if ($i == 5) {
                        $name5 = $name;
                        $field5 = $type;
                    }
                    
                    $i++;
                }
                
            }
        }
        //print_r($name5);die;
        //echo "<pre>"; print_r($nominees);die;
        //dd($nominee_details);
        $nominee_id = !empty($nominee_details->id) ? $nominee_details->id : '';
        $vendor_id = !empty($nominee_details->vendor_id) ? $nominee_details->vendor_id : '';

        $row = Memebership::where('user_id',$vendor_id)->first();
        if (!empty($nominee_details->vendor_id)) {
            $memebership_id = $row->id;
        }
        else{
            $member_row = Memebership::where('user_id',$member_id)->first();
            $memebership_id = $member_row->id;
            $vendor_id = $member_row->user_id;
        }

        $type = ['no'=>'--Select Nominee Type--', 'father'=>'Father', 'mother'=>'Mother', 'brother'=>'Brother', 'sister'=>'Sister', 'daughter'=>'Daughter', 'son'=>'Son', 'husband'=>'Husband', 'wife'=>'Wife' ];
        return view('backend.pages.nominee.edit',[
                                                    'memebership_id' => $memebership_id,
                                                    'nominee_details' => $nominee_details,
                                                    'nominee_id' => $nominee_id,
                                                    'vendor_id' => $vendor_id,
                                                    'nominee' => $nominee,
                                                    'name1' => $name1,
                                                    'field1' => $field1,
                                                    'name2' => $name2,
                                                    'field2' => $field2,
                                                    'name3' => $name3,
                                                    'field3' => $field3,
                                                    'name4' => $name4,
                                                    'field4' => $field4,
                                                    'name5' => $name5,
                                                    'field5' => $field5,
                                                    'type' => $type,
                                                ], );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nominee $nominee)
    {
        $input = $request->all();
        $names = $input['name'];
        $types = $input['type'];
//print_r($types);
        $i = 0;
        foreach ($names as $name) {
            if (!empty($name)) {

                if ($types[$i] !== 'no') {
                    $nominees[$types[$i]] = $name;
                }
                
            }
            $i++;
        }

        //echo "<pre>"; print_r($nominees);die;
        //$nominees = array_combine($input['type'],$input['name']);
        if (!empty($nominees)) {
            $i = 0;
            foreach ($nominees as $key => $value) {
                $new_array[$i][$key] = $value;
                $i++;
            }
            $input['nominee'] = serialize($new_array);
            //echo "<pre>";print_r($input);die;
        }
        else{
            $input['nominee'] = '';
        }
        

        $nominee = Nominee::updateOrCreate(
            ['vendor_id' => $input['member_id']],
            ['vendor_id' => $input['member_id'], 'nominee' => $input['nominee']]
        );
        return redirect()->route('member-verification');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nominee $nominee)
    {
        //$nominee->delete();
        //return redirect()->route('nominee.index');
        
    }

}
