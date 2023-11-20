<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\VendorDetail;
use App\Models\Scheme;
use App\Models\Notice;
use App\Models\Traning;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\OTPService;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getUserInfo($user_id)
    {
        return VendorDetail::find($user_id);
    }


    public function getDbPropertyValue($table, $where = [], $select = '*', $type = 'first', $order_by_column = 'id', $order_by = 'DESC')
    {
        $query = DB::table($table)
            ->select($select);

        if (!empty($where)) {
            foreach ($where as $column => $value) {
                $query->where($column, $value);
            }
        }

        $result = $query->orderBy($order_by_column, $order_by)->$type();

        return $result;
    }

    public function addDemoGraphyNotification($parent_type, $parent_id)
    {
        $demography_info = null;

        if (in_array($parent_type, ['training', 'notice', 'scheme'])) {
            $demography_info = DB::table($parent_type . 's')->find($parent_id);
        }
        if (!$demography_info) {
            return false;
        }

        $state          = !empty($demography_info->state_id) ? explode(',', $demography_info->state_id) : '';
        $district       = !empty($demography_info->district_id) ? explode(',', $demography_info->district_id) : '';
        $municipality   = !empty($demography_info->municipality_id) ? explode(',', $demography_info->municipality_id) : '';

        //if (!empty($state) || !empty($district) || !empty($municipality)) {

        $vendorQuery = VendorDetail::query();

        if (!empty($state)) {
            $vendorQuery->whereIn('current_state', $state);
        }

        if (!empty($district)) {
            $vendorQuery->whereIn('current_district', $district);
        }
        if (!empty($municipality)) {
            $vendorQuery->whereIn('municipality_panchayat_current', $municipality);
        }

        $vendors = $vendorQuery->get();
        foreach ($vendors as $vendor) {
            $notification = new Notification();
            $notification->user_id = $vendor->id;
            $notification->title = 'You have One New  ' . ucfirst($parent_type);
            $notification->type = $parent_type;
            $notification->type_id = $parent_id;
            $notification->sent_at = Carbon::now();
            $notification->status = 1;
            $notification->save();

            OTPService::sendSMS($vendor->mobile_no, $notification->title);
        }
        // }
    }
    public function uploadFile(UploadedFile $file, $folder = null, $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        
        $destination = $folder . '/' . $name;

        $storage = Storage::disk('gcs');

        $storage->put($destination, file_get_contents($file));

        $publicUrl = $storage->url($destination);

        return $publicUrl;
    }
    public function deleteFile($path = null)
    {
        Storage::disk('gcs')->delete($path);
    }
}
