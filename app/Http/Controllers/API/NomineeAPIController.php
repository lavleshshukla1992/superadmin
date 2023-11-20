<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Nominee;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NomineeResource;
use App\Http\Resources\ApiNomineeResource;
use App\Http\Resources\ApiNomineeCollection;
use Illuminate\Support\Facades\DB;

class NomineeAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'member_id' => 'required|integer|min:1',
        ]);

        $query = Nominee::query();

        $query->where('member_id', $request->get('member_id'));

        $query->orderByDesc('id');

        $data = $query->get();

        return response()->json(['status_code' => 200, 'success' => true, "message" => "Information List Loaded successfully", 'data' => new ApiInformationCollection($data)]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $input['nominee'] = serialize($input['nominee']);

        //$information = Nominee::create($input);
        $nominee = Nominee::updateOrCreate(
            ['vendor_id' => $input['member_id']],
            ['vendor_id' => $input['member_id'], 'nominee' => $input['nominee']]
        );

        if ($nominee->wasRecentlyCreated) {
            $msg = 'Nominee added successfully';
        } else {
            $msg = 'Nominee updated successfully';
        }

        return response()->json(['success' => true, 'nominee_id' => $nominee->id, 'message' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Nominee $nominee)
    {
        $request->validate([
            'member_id' => 'required|integer|min:1',
        ]);

        $nominee_info = Nominee::where('vendor_id', $request->get('member_id'))->first();

        if(empty($nominee_info)){
            return response()->json(['status_code' => 403, 'success' => false, "message" => "Member not exist",'data' =>[]]);
        }
        
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Nominee Detail Loaded successfully", 'data' => new ApiNomineeResource($nominee_info)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nominee $nominee)
    {
        print_r($nominee);
        die;
        //print_r($request->all());
        $nomineeId = $nominee->id;
        $vendor_id = $nominee->member_id;

        $input = $request->all();
        $input['nominee'] = serialize($input['nominee']);

        //DB::table('Nominees')->where('vendor_id',$nomineeId)->update(['nominee'=>'Updated title']);

        $nominee->fill($input);
        $nominee->save();

        return response()->json(['success' => true, 'nominee_id' => $nominee->id, 'message' => 'Nominee updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Request $request, Nominee $nominee)
    // {
    //     $informationId = $information->id;

    //     $informationApplied = Information::where('id', $informationId);

    //     /*$confirmed = $request->get('confirm_update');

    //     if ($informationApplied && $confirmed == 0) {
    //         return response()->json(['success' => true, 'information_id' => $information->id, 'message' => 'Are You sure you want to update the Information ?']);
    //     }*/

    //     $information->delete();
    //     return response()->json(['success' => true, 'message' => 'Information deleted successfully']);
    // }
}
