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
        $marketPlace = MarketPlace::paginate();
        $meta = [
            'first_page' => $marketPlace->url(1),
            'last_page' => $marketPlace->url($marketPlace->lastPage()),
            'prev_page_url' =>$marketPlace->previousPageUrl(),
            'per_page' => $marketPlace->perPage(),
            'total_items' => $marketPlace->total(),
            'total_pages' => $marketPlace->lastPage()
        ];
        return response()->json(['status_code' => 200,'success' => true,"message" => "Marketplace  List Loaded successfully",'meta'=> $meta, 'data'=>new MarketPlaceCollection($marketPlace)]);
    }
}
