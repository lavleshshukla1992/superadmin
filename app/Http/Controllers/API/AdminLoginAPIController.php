<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\AdminAPIResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginAPIController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'mobile_number' => ['required'],
            'password' => ['required'],
        ]);
        $mobilNumber = $request->get('mobile_number');
        $admin = Admin::where('mobile_no',$mobilNumber)->where('mobile_no',$mobilNumber)->select()->first();
        if ($admin instanceof admin) 
        {

            $admin = Admin::where('id',$admin->id)->get()->first();
            if (Hash::check($request->password, $admin->password)) {
                return  response()->json([
                    'status_code' => 200,
                    'success' => true,
                    "message" => "Logged In  successfully",
                    'data'=> new AdminAPIResource($admin),
                    'token' => $admin->createToken("Login")->plainTextToken
                ]);
            }
            return  response()->json(['status_code' => 200,'success' => true,"message" => "Please provide valid password"]);
        }

        return  response()->json(['status_code' => 200,'success' => true,"message" => "User does not exist"]);
    }
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'mobile_number' => ['required'],
            'password' => ['required'],
        ]);
        $mobilNumber = $request->get('mobile_number');
        $admin = Admin::where('mobile_no',$mobilNumber)->select()->first();

        if ($admin instanceof Admin) 
        {
            $admin->password = Hash::make($request->password);
            $admin->save();
            return  response()->json(['status_code' => 200,'success' => true,"message" => "Password updated  successfully"]);

        }

        return  response()->json(['status_code' => 200,'success' => true,"message" => "User does not exist"]);
    }

    public function logout(Request $request)
    {
        $mobilNumber = $request->get('mobile_number');
        $admin = admin::where('mobile_no',$mobilNumber)->select()->first();

        if ($admin instanceof Admin) 
        {
            $admin->tokens()->delete();
            return  response()->json([
                'status_code' => 200,
                'success' => true,
                "message" => "Logged Out  successfully",
            ]);
        }
        return  response()->json(['status_code' => 200,'success' => true,"message" => "User does not exist"]);
        
    }
}
