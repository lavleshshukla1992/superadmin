<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Backend\AdminsController;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminAPICollection;
use App\Http\Resources\AdminAPIResource;
use App\Http\Requests\StoreAdminAPIRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Settings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function convertIntoBase64(Request $request)
    {
        $request->validate([
            'url' => ['required'],
        ]);

        $imageUrl = $request->input('url');
        $baseName = basename($imageUrl);
        $imagePath = public_path('uploads/'.$baseName);
        $imageContent = file_get_contents($imagePath);
        if ($imageContent !== false) {
            $base64Encoded = base64_encode($imageContent);
        } else {
            $base64Encoded =false;
        }

        return response()->json(['status_code' => 200,'success' => true,"message" => "file converted into base64 successfully",'data'=>$base64Encoded]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminAPIRequest $request)
    {
        $input = $request->all();
        if ($request->hasFile('profile_image')) 
        {
            $profileImage = $request->file('profile_image');
            $profileImageName = time().$profileImage->getClientOriginalName();
            $profileImage->move('uploads', $profileImageName); 
            $input['profile_image'] = $profileImageName;
        }
        if ($request->hasFile('identity_image')) 
        {
            $identityImage = $request->file('identity_image');
            $identityImageName = time().$identityImage->getClientOriginalName();
            $identityImage->move('uploads', $identityImageName); 
            $input['identity_image'] = $identityImageName;
        }
        $input['password'] = Hash::make($input['password']);
        $input['name'] = $input['first_name']??'';
        $input['name'] .= isset($input['last_name'])?' '.$input['last_name']:'';
        $admin = Admin::create($input);
        
        if ($request->user_type) {
            $admin->assignRole($request->user_type);
        }

        $role = $admin->roles->first();
        $roleName = $role->name ?? '';
        $setting = new Settings();
        $setting->user_id = $admin->id;
        $setting->user_type = $roleName;
        $setting->save();

        return response()->json(['success' => true,'admin_id' => $admin->id, 'message' => 'Admin added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Scheme Detail Loaded successfully", 'data'=>new AdminAPIResource($admin)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $input = $request->all();
        if ($request->hasFile('profile_image')) 
        {
            $profileImage = $request->file('profile_image');
            $profileImageName = time().$profileImage->getClientOriginalName();
            $profileImage->move('uploads', $profileImageName); 
            $input['profile_image'] = $profileImageName;
        }
        if ($request->hasFile('identity_image')) 
        {
            $identityImage = $request->file('identity_image');
            $identityImageName = time().$identityImage->getClientOriginalName();
            $identityImage->move('uploads', $identityImageName); 
            $input['identity_image'] = $identityImageName;
        }
        $admin->fill($input);
        $admin->save();
        return response()->json(['success' => true,'admin_id' => $admin->id, 'message' => 'Admin updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response()->json(['success' => true, 'message' => 'Admin deleted successfully']);

    }
}
