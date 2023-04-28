<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Ad;
use DB;

class AdController extends Controller
{
    public function index()
    {
        //$ads = Ad::all();
        $results = DB::table('ads_history')
            ->where('deleted', 0)
            ->get();
        $total_ads = 5;
        $ads = array();
        foreach ($results as $key => $val) {
            $ads[] = array(
                'id' => $val->id ?? '',
                'ad_sr_no' => $val->ad_sr_no ?? '',
                'ad_type' => $val->ad_type == 1 ? 'Google' : 'Private',
                'ad_status' => $val->ad_status == 1 ? 'Active' : 'Inactive',
                'google_script' => $val->google_script ?? '',
                'ad_name' => $val->ad_name ?? '',
                'ad_media' => $val->ad_media ?? '',
                'google_script' => $val->google_script ?? '',
                'ad_link' => $val->ad_link ?? '',
                'ad_from_dt' => date('d-M-Y h:i:sa', strtotime($val->ad_from_dt)),
                'ad_to_dt' => $val->ad_to_dt ?? '',
            );
            //  echo"<pre>";print_r($ads);die;
        }
        return view('backend.pages.ad.index', compact('ads'));
    }

    public function create()
    {
        $results = DB::table('ads')
            ->where('deleted', 0)
            ->get();
        $total_ads = 5;
        $ads = array();
        foreach ($results as $key => $val) {
            $ads[$val->ad_sr_no] = array(
                'id' => $val->id ?? '',
                'google_script' => $val->google_script ?? '',
                'ad_type' => $val->ad_type ?? '',
                'ad_name' => $val->ad_name ?? '',
                'ad_media' => $val->ad_media ?? '',
                'ad_link' => $val->ad_link ?? '',
            );
        }
        return view('backend.pages.ad.create', compact('total_ads', 'ads'));
    }

    public function store(Request $request)
    {
        $data = array();
        $userId = Auth::check() ? Auth::id() : true;
        // $file = $request->file('ads');
        // $file = $file[1]['ad_media']??'';
        // if ($file!='') {
        //     $fileName = $file->getClientOriginalName();
        //     $file->move('uploads', $fileName);
        // }
        // echo "<pre>";
        // print_r($fileName);
        // die;
        foreach ($request->input('ads') as $key => $val) {
            $file = $request->file('ads');
            $file = $file[$key]['ad_media']??'';
            if ($file!='') {
                $fileName = $file->getClientOriginalName();
                $file->move('uploads', $fileName);
            }
            $data = array(
                'uid' => $userId,
                'ad_sr_no' => $key,
                'ad_type' => $val['ad_type'] ?? '',
                'google_script' => $val['google_script'] ?? '',
                'ad_name' => $val['ad_name'] ?? '',
                'ad_media' => $fileName ?? '',
                'ad_link' => $val['ad_link'] ?? '',
                'ad_status' => $val['ad_status'] ?? '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $ad = DB::table('ads')->where('ad_sr_no', $key)->first('id');
            if (empty($ad->id)) {
                $id = DB::table('ads')->insertGetId($data);
                (new Ad)->insertIntoHistory($id, 'insert');
            } else {
                DB::table('ads')
                    ->where('id',  $ad->id)
                    ->update($data);
                (new Ad)->insertIntoHistory($ad->id, 'update');
            }
        }

        return redirect()->route('admin.ad.create')
            ->with('success', 'Ad saved successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $ad = Ad::findOrFail($id);
        return view('ads.edit', compact('ad'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        Ad::whereId($id)->update($validatedData);
        (new Ad)->insertIntoHistory($id, 'update ');

        return redirect()->route('ads.index')
            ->with('success', 'Ad updated successfully.');
    }

    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);
        (new Ad)->insertIntoHistory($id, 'delete ');
        $ad->delete();

        return redirect()->route('admin.ad.create')
            ->with('success', 'Ad deleted successfully.');
    }

    public function getAds()
    {
        
    }
}
