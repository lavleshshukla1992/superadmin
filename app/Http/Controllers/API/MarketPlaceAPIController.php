<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarketPlaceCollection;
use App\Models\MarketPlace;

class MarketPlaceAPIController extends Controller
{
    public function index()
    {
        $marketPlace = MarketPlace::all();
        return response()->json(['status_code' => 200,'success' => true,"message" => "Marketplace  List Loaded successfully", 'data'=>new MarketPlaceCollection($marketPlace)]);
    }
}
