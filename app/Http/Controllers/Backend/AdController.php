<?php

namespace App\Http\Controllers\Backend;

use DB;
use App\Services\AdsService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Ad;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class AdController extends Controller
{
    public function index()
    {
        //$ads = Ad::all();
        $results = DB::table('ads_history')
            ->where('deleted', 0)->orderBy('created_at', 'DESC')
            ->get();
        $total_ads = 5;
        $ads = array();
        foreach ($results as $key => $val) {
            $ads[] = array(
                'id' => $val->id ?? '',
                'ad_sr_no' => $val->ad_sr_no ?? '',
                'ad_type' => $val->ad_type == 1 ? 'Google' : 'Private',
                'ad_status' => is_null($val->deleted_at)? 'Active' : 'Completed',
                'google_script' => $val->google_script ?? '',
                'ad_name' => ( $val->ad_type == 1 ) ? 'Google Ad': $val->ad_name ?? '',
                'ad_media' => $val->ad_media ?? '',
                'google_script' => $val->google_script ?? '',
                'ad_link' => $val->ad_link ?? '',
                'ad_from_dt' => date('d-M-Y h:i:sa', strtotime($val->created_at)),
                'ad_to_dt' => $val->deleted_at ?? '',
            );
            //  echo"<pre>";print_r($ads);die;
        }
        return view('backend.pages.ad.index', compact('ads'));
    }

    public function create()
    {
        $results = DB::table('ads')
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
        foreach ($request->input('ads') as $key => $val) {
            $file = $request->file('ads');
            $file = $file[$key]['ad_media']??'';
            if ($file!='') {
                $fileName = $file->getClientOriginalName();
                $file->move('uploads', $fileName);
            }

            $name = $val['ad_type'] == 1 ? 'Google Ads' : $val['ad_name'] ;
            $data = array(
                'uid' => $userId,
                'ad_sr_no' => $key,
                'ad_type' => $val['ad_type'] ?? '',
                'google_script' => $val['google_script'] ?? '',
                'ad_name' => $name ?? '',
               // 'ad_media' => $fileName ?? '',
                'ad_link' => $val['ad_link'] ?? '',
                'ad_status' => $val['ad_status'] ?? '1',
                'created_at' => date('Y-m-d H:i:s'),
            );
            if(!empty($fileName)){
                $data['ad_media'] = $fileName;
            }
            $ad = DB::table('ads')->where('ad_sr_no', $key)->first('id');
            if (empty($ad->id)) {
                $id = DB::table('ads')->insertGetId($data);
                AdsService::prepareAdHistoryData($ad->id);
            } else {
                DB::table('ads')
                    ->where('id',  $ad->id)
                    ->update($data);   
                    AdsService::prepareAdHistoryData($ad->id);
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
