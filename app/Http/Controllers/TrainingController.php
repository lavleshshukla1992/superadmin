<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\Training;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $trainings = Training::select(['id','name','training_start_at','training_end_at','user_id'])
        // ->toBase()->get();
        $trainings = Training::select(
            'trainings.id',
            'trainings.name',
            'trainings.training_start_at',
            'trainings.training_end_at',
            'trainings.created_at',
            'users.name as user_id',
        )
        ->leftJoin('users as users', 'trainings.user_id', '=', 'users.id')
        ->toBase()->get();
        //echo "<pre>";print_r($trainings);die;
        $trainings = !is_null($trainings) ? json_decode(json_encode($trainings),true): [];
        return view('backend.pages.training.index',compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.training.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingRequest $request)
    {
        $input = $request->all();
        $media = $request->file('cover_image');
        $input['training_start_at'] = now();        
        if (! is_null($media)) 
        {
            $mediaName = time().$media->getClientOriginalName();
            $media->move('uploads', $mediaName);
            $input['cover_image'] = $mediaName;
        }
        $input['gender'] = !empty($input['gender'])?implode(',',$input['gender']):'';
        $input['social_category'] = !empty($input['social_category'])?implode(',',$input['social_category']):'';
        $input['educational_qualification'] = !empty($input['educational_qualification'])?implode(',',$input['educational_qualification']):'';
        $input['type_of_vending'] = !empty($input['type_of_vending'])?implode(',',$input['type_of_vending']):'';
        $input['type_of_marketplace'] = !empty($input['type_of_marketplace'])?implode(',',$input['type_of_marketplace']):'';
        $input['state_id'] = !empty($input['state_id'])?implode(',',$input['state_id']):'';
        $input['district_id'] = !empty($input['district_id'])?implode(',',$input['district_id']):'';
        $input['municipality_id'] = !empty($input['municipality_id'])?implode(',',$input['municipality_id']):'';
        $input['training_end_at'] = date('Y-m-d');

       // echo"<pre>";print_r($input);die;
        Training::create($input);
        return redirect()->route('training.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        return view('backend.pages.training.detail',compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        return view('backend.pages.training.edit',compact('training'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingRequest  $request
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingRequest $request, Training $training)
    {
       // $training->fill($request->all());
        $input = $request->all();
        $input['gender'] = !empty($input['gender'])?implode(',',$input['gender']):'';
        $input['social_category'] = !empty($input['social_category'])?implode(',',$input['social_category']):'';
        $input['educational_qualification'] = !empty($input['educational_qualification'])?implode(',',$input['educational_qualification']):'';
        $input['type_of_vending'] = !empty($input['type_of_vending'])?implode(',',$input['type_of_vending']):'';
        $input['type_of_marketplace'] = !empty($input['type_of_marketplace'])?implode(',',$input['type_of_marketplace']):'';
        $input['state_id'] = !empty($input['state_id'])?implode(',',$input['state_id']):'';
        $input['district_id'] = !empty($input['district_id'])?implode(',',$input['district_id']):'';
        $input['municipality_id'] = !empty($input['municipality_id'])?implode(',',$input['municipality_id']):'';
        
        $training->fill($input);
        $training->save();
        
       // $training->save();
        return redirect()->route('training.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        $training->delete();
        return redirect()->route('training.index');
    }
}
