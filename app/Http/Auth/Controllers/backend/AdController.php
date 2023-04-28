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
        $ads = Ad::all();
        return view('backend.pages.ad.index', compact('ads'));
    }

    public function create()
    {
        $results = DB::table('ads')
              ->where('deleted', 0)
              ->get();
        $total_ads = 5;
        $ads = array();
      //  echo"<pre>";print_r($results);die;
        foreach ($results as $key=>$val) {
            $ads[$val->ad_sr_no] = array(
                'id'=>$val->id??'',
                'google_script'=>$val->google_script??'',
                'ad_type'=>$val->ad_type??'',
                'ad_name'=>$val->ad_name??'',
                'ad_title'=>$val->ad_title??'',
                'ad_media'=>$val->ad_media??'',
                'ad_link'=>$val->ad_link??'',
                'ad_from_dt'=>!empty($val->ad_from_dt)?date('d-M-Y',strtotime($val->ad_from_dt)):null,
                'ad_to_dt'=>!empty($val->ad_to_dt)?date('d-M-Y',strtotime($val->ad_to_dt)):null,
            );
        }
        return view('backend.pages.ad.create', compact('total_ads','ads'));
    }

    public function store(Request $request)
    {
        $data = array();
        $userId = Auth::check() ? Auth::id() : true;  
        foreach ($request->input('ads') as $key => $val) {
            $data = array(
                'uid'=>$userId,
                'ad_sr_no'=>$key,
                'ad_type'=>$val['ad_type']??'',
                'google_script'=>$val['google_script']??'',
                'ad_name'=>$val['ad_name']??'',
                'ad_title'=>$val['ad_title']??'',
                'ad_media'=>$val['ad_media']??'',
                'ad_link'=>$val['ad_link']??'',
                'ad_from_dt'=>!empty($val['ad_from_dt'])?date('Y-m-d H:i:s',strtotime($val['ad_from_dt'])):null,
                'ad_to_dt'=>!empty($val['ad_to_dt'])?date('Y-m-d H:i:s',strtotime($val['ad_to_dt'])):null,
                'ad_status'=>$val['ad_status']??'1',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            );
            DB::table('ads')->updateOrInsert(['ad_sr_no' => $key, 'deleted' => 0],$data);
        }

        return redirect()->route('admin.ad.index')
            ->with('success', 'Ad created successfully.');
    }

    public function show($id)
    {
        $ad = Ad::findOrFail($id);
        return view('backend.pages.ad.show', compact('total_admins', 'total_roles', 'total_permissions'));
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

        return redirect()->route('ads.index')
            ->with('success', 'Ad updated successfully.');
    }

    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);
        $ad->delete();

        return redirect()->route('ads.index')
            ->with('success', 'Ad deleted successfully.');
    }
}