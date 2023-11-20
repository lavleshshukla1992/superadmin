<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use Illuminate\Http\Request;
use App\Services\OTPService;

class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $schemes = Scheme::all('id','name','created_by','updated_by','start_at','end_at','status')->toArray();

       $schemes = Scheme::select(
            'schemes.id',
            'schemes.name',
            'schemes.start_at',
            'schemes.end_at',
            'schemes.apply_link',
            'schemes.status',
            'users_created.name as created_by',
            'users_updated.name as updated_by'
        )
        ->leftJoin('users as users_created', 'schemes.created_by', '=', 'users_created.id')
        ->leftJoin('users as users_updated', 'schemes.updated_by', '=', 'users_updated.id')
        ->get()
        ->toArray();
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
        $input = $request->all();
        if ($request->hasFile('scheme_image')) 
        {
            $media = $request->file('scheme_image');
            $mediaName = time().$media->getClientOriginalName();
            $media->move('uploads', $mediaName); 
            $input['scheme_image'] = $mediaName;
        }
        
        $input['gender'] = !empty($input['gender'])?implode(',',$input['gender']):'';
        $input['social_category'] = !empty($input['social_category'])?implode(',',$input['social_category']):'';
        $input['educational_qualification'] = !empty($input['educational_qualification'])?implode(',',$input['educational_qualification']):'';
        $input['type_of_vending'] = !empty($input['type_of_vending'])?implode(',',$input['type_of_vending']):'';
        $input['type_of_marketplace'] = !empty($input['type_of_marketplace'])?implode(',',$input['type_of_marketplace']):'';
        $input['state_id'] = !empty($input['state_id'])?implode(',',$input['state_id']):'';
        $input['district_id'] = !empty($input['district_id'])?implode(',',$input['district_id']):'';
        $input['municipality_id'] = !empty($input['municipality_id'])?implode(',',$input['municipality_id']):'';

        Scheme::create($input);
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
        //echo"<pre>";print_r(compact('scheme'));die;
        return view('backend.pages.scheme.detail',compact('scheme'));
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
        $media = $request->file('media');
        $input = $request->all();
        if (! is_null($media)) 
        {
            $mediaName = time().$media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['media'] = $mediaName;
        }
        
        $input['gender'] = !empty($input['gender'])?implode(',',$input['gender']):'';
        $input['social_category'] = !empty($input['social_category'])?implode(',',$input['social_category']):'';
        $input['educational_qualification'] = !empty($input['educational_qualification'])?implode(',',$input['educational_qualification']):'';
        $input['type_of_vending'] = !empty($input['type_of_vending'])?implode(',',$input['type_of_vending']):'';
        $input['type_of_marketplace'] = !empty($input['type_of_marketplace'])?implode(',',$input['type_of_marketplace']):'';
        $input['state_id'] = !empty($input['state_id'])?implode(',',$input['state_id']):'';
        $input['district_id'] = !empty($input['district_id'])?implode(',',$input['district_id']):'';
        $input['municipality_id'] = !empty($input['municipality_id'])?implode(',',$input['municipality_id']):'';

        //echo"<pre>";print_r($input['municipality_id']);die;
        $scheme->fill($input);
        //$mobileNo = 7737600411;
        //$sms = 'This is testing.';
        //$sms_status = OTPService::sendSMS($mobileNo,$sms); var_dump($sms_status);die;
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
