<?php

namespace App\Http\Controllers\API;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SettingCollection;

class SettingsAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Setting List Loaded successfully", 'data'=>new SettingCollection(Settings::all())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = Settings::create($request->all());
        return response()->json(['success' => true,'setting_id' => $setting->id, 'message' => 'Settings created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Settings Detail Loaded successfully", 'data'=>new SettingResource($settings)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        $settings->fill($request->all());
        $settings->save();
        return response()->json(['status_code' => 200,'success' => true,"message" => "Settings Detail updated successfully", 'data'=>new SettingResource($settings)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        $settings->delete();
        return response()->json(['status_code' => 200,'success' => true,"message" => "Settings Deleted successfully"]);

    }
}
