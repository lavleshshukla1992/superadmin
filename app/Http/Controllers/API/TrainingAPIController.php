<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrainingAPICollection;
use App\Http\Resources\TrainingAPIResource;
use App\Models\Training;

class TrainingAPIController extends Controller
{
    public function getTrainingList()
    {
        $training = Training::whereNotNull('training_end_at')->get();
        return response()->json(['status_code' => 200,'success' => true,"message" => "Training history List Loaded successfully", 'data'=>new TrainingAPICollection($training)]);
    }

    public function getTrainingDetail(Training $training)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Training Detail Loaded successfully", 'data'=>new TrainingAPIResource($training)]);
    }

    public function liveTrainingList()
    {
        $training = Training::whereNull('training_end_at')->get();
        return response()->json(['status_code' => 200,'success' => true,"message" => "Live Training List Loaded successfully", 'data'=>new TrainingAPICollection($training)]);   
    }

    public function storeTraining(Request $request)
    {
        
        $input = $request->all();
        if ($request->hasFile('cover_image')) 
        {
            $coverImage = $request->file('cover_image');
            $coverImageName = time().$coverImage->getClientOriginalName();
            $coverImage->move('uploads', $coverImageName); 
            $input['cover_image'] = $coverImageName;
        }

        $training = Training::create($input);
        return response()->json(['success' => true,'training_id' => $training->id, 'message' => 'Training created successfully']);

    }

    public function updateTraining(Request $request,Training $training)
    {
        
        $input = $request->all();
        if ($request->hasFile('cover_image')) 
        {
            $coverImage = $request->file('cover_image');
            $coverImageName = time().$coverImage->getClientOriginalName();
            $coverImage->move('uploads', $coverImageName); 
            $input['cover_image'] = $coverImageName;
        }

        $training->fill($input);
        $training->save();
        return response()->json(['success' => true,'training_id' => $training->id, 'message' => 'Training updated successfully']);

    }

    public function deleteTraining(Training $training)
    {
        $training->delete();
        return response()->json(['success' => true, 'message' => 'Training deleted successfully']);
    }
}
