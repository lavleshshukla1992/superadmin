<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VendingCollection;
use App\Models\Vending;

class VendinAPIController extends Controller
{
    public function index()
    {
        $vending = Vending::all();
        return response()->json(['status_code' => 200,'success' => true,"message" => "Vending  List Loaded successfully", 'data'=>new VendingCollection($vending)]);
    }
}
