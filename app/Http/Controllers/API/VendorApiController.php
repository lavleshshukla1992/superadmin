<?php
namespace App\Http\Controllers\API;

use App\Models\Vendor;
use App\Models\VendorDetail;
use Illuminate\Http\Request;
use App\Models\VendorDetails;
use App\Models\Settings;
use App\Services\VendorServices;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Requests\StoreVendorDetailsRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VendorApiController extends BaseController
{
    public function index()
    {
        $data = ['message' => 'Welcome to the API'];
        return response()->json($data);
    }

    public function addVendor(StoreVendorDetailsRequest $request)
    {
        $input = VendorServices::getVendorInput($request);
        $vendor = VendorDetail::create($input);
        $roleName = 'member';
        $setting = new Settings();
        $setting->user_id = $vendor->id;
        $setting->user_type = $roleName;
        $setting->save();
        return response()->json(['success' => true,'vendor_id' => $vendor->id, 'message' => 'Customer added successfully']);
    }

    // Add more methods to handle additional API endpoints
}
?>