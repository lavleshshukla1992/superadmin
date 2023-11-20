<?php

namespace App\Http\Controllers\API;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SettingCollection;
use Carbon\Carbon;
use App\Models\VendorDetail;

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
        $request->validate([
            'user_id' => 'required|integer|min:1',
        ]);

        $setting = Settings::where('user_id', $request->get('user_id'))->first();

        if(empty($setting->user_id)){
            $setting = new Settings();
        }
        if(!empty($request->get('user_id'))){
            $setting->user_id = $request->get('user_id');
        }
        
        if(!empty($request->get('language'))){
            $setting->language = $request->get('language');
        }
        
        if(!empty($request->get('text_size'))){
            $setting->text_size = $request->get('text_size');
        }
        
        if(!empty($request->get('notification'))){
            $setting->notification = $request->get('notification');
        }
        
        if(!empty($request->get('delete_account'))){
            $setting->delete_account = $request->get('delete_account');
        }

        $setting->user_type = $request->get('user_type')??'member';
        
        if(!empty($setting->delete_account) && $setting->delete_account=='Yes' && $setting->user_type=='member'){
            $setting->deleted_at = Carbon::now();
            $vendor = VendorDetail::where('id', $request->get('user_id'))->first();
            if(!empty($vendor->id)){
                $vendor->deleted_at = Carbon::now();
                $vendor->save();
            }
        }

        $setting->save();

        return response()->json(['success' => true,'setting_id' => $setting->id, 'message' => 'Settings created successfully!']);
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
