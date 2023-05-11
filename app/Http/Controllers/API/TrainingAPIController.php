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
        return response()->json(['status_code' => 200,'success' => true,"message" => "Training List Loaded successfully", 'data'=>new TrainingAPICollection(Training::all())]);
    }

    public function getTrainingDetail(Training $training)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Training Detail Loaded successfully", 'data'=>new TrainingAPIResource($training)]);
    }
}
