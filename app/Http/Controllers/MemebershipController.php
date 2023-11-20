<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pincode;
use App\Models\Memebership;
use App\Models\VendorDetail;
use Illuminate\Http\Request;
use App\Services\MembershipDashBoard;
use App\Http\Resources\MembershipResource;
use App\Http\Resources\VendorDetailCollection;
use App\Http\Resources\MembersearchAPICollection;

class MemebershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memeberships = Memebership::select(['id','validity_from','validity_to','membership_id','status'])->toBase()->get();
        $memeberships = !is_null($memeberships) ? json_decode(json_encode($memeberships),true) : [];
        return view('backend.pages.memberships.index',compact('memeberships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.memberships.create');
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
        $year = Carbon::now()->format('Y');
        $input['membership_id'] = "MEMB".$year.$input['user_id'] ?? '';
        $input['status'] = 'pending';

        $memebership = Memebership::create($input);
        return response()->json(['success' => true,'status_code' =>200 , 'message' => 'Membership Created Successfully','membership_id'=>$memebership->id]) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function show(Memebership $memebership)
    {
        return response()->json(['success' => true,'status_code' =>200 , 'message' => 'Membership detail loaded Successfully','data'=> new MembershipResource($memebership)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function edit(Memebership $memebership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memebership $memebership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memebership  $memebership
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memebership $memebership)
    {
        //
    }

    public function search(Request $request)
    {

        $multipleValues = [
            "social_category",
            "marital_status",
            "education_qualification",
            "type_of_vending",
            "type_of_marketplace",
            "total_years",
            "current_state",
            "current_district",
            "municipality_panchayat_current",
        ];
        $input = $request->all();
        if (is_array($input) && count($input) > 0) 
        {
            $vendor = VendorDetail::leftJoin('memeberships as m','m.user_id','=','vendor_details.id')
            ->leftJoin('states as s','s.id','=','vendor_details.current_state','vendor_details.created_at as date_of_joining');
            
            foreach ($input as $key => $value) 
            {
                if(!is_null($value) && strlen($value)  > 0)
                {
                    if($key == 'name')
                    {
                        $key = 'vendor_first_name';
                    }

                    if (in_array($key,$multipleValues)) 
                    {
                        $values = explode(',',$value);
                        $vendor = $vendor->whereIn($key,$values);
                    }
                    else
                    {
                        if($key!='page'){
                            $vendor = $vendor->where($key,'like','%'.$value);
                        }
                    }
                    
                }
            }            
            $vendor = $vendor
            ->select(['vendor_details.id','vendor_details.vendor_first_name as name','m.membership_id as membership_id','s.name as state'])
            ->paginate(10);

            $meta = [
                'first_page' => $vendor->url(1),
                'last_page' => $vendor->url($vendor->lastPage()),
                'prev_page_url' =>$vendor->previousPageUrl(),
                'per_page' => $vendor->perPage(),
                'total_items' => $vendor->total(),
                'total_pages' => $vendor->lastPage()
            ];
            return response()->json(['success' => true,'status_code' =>200 , 'message' => 'Membership search List loaded Successfully','meta'=> $meta,'data'=> new MembersearchAPICollection($vendor)]) ;

        }
    }

    public function membershipDashboard(Request $request)
    {

        //$fromDate = '2023-10-01'; //$request->get('from_date');
        //$toDate = '2023-10-13'; //$request->get('to_date');

        $filter = $request->get('filter');

        if (empty($filter)) {
            if (empty($request->get('from_date'))) {
                $fromDate = date('Y-m-d', strtotime('-1 month'));
            }
            else{
                $fromDate = $request->get('from_date');
            }

            if (empty($request->get('to_date'))) {
                $toDate = date('Y-m-d');
            }
            else{
                $toDate = $request->get('to_date');
            }

            
        }
        else {
            if ($filter == 'today') {
                $fromDate = date('Y-m-d');
                $toDate = date('Y-m-d');
            }
            else if ($filter == 'this_month') {
                $datestring = date('Y-m-d');
                // Converting string to date 
                $date = strtotime($datestring);
                // Last date of current month. 
                $lastdate = strtotime(date("Y-m-t", $date ));
                // Last Day of the month  
                $last_day = date("Y-m-d", $lastdate); 

                $fromDate = date('Y-m-01');
                $toDate = $last_day;
            }
            else if ($filter == 'last_month') {

                $fromDate = date('Y-m-d', strtotime('first day of last month'));
                $toDate = date('Y-m-d', strtotime('last day of last month'));
            }
        }
        

        if (!is_null($fromDate) && !is_null($toDate)) 
        {
            $genderSpecific = MembershipDashBoard::adminGenderSpecific($fromDate,$toDate);
            $memberJoinedDateWise = MembershipDashBoard::adminDateWise($fromDate,$toDate);
            $memberAgeSpecifc = MembershipDashBoard::adminMemberAgeSpecific($fromDate,$toDate); //echo "<pre>";print_r($memberAgeSpecifc);die;
            $socialCategory = MembershipDashBoard::adminMembershipCategories($fromDate,$toDate);
            $marketplaceSpecific = MembershipDashBoard::adminMarketplaceSpecific($fromDate,$toDate);
            
            $memberDashboard = MembershipDashBoard::memberDashboardDetail($fromDate,$toDate);

            $demographySpecific = MembershipDashBoard::adminDemographySpecific($fromDate,$toDate);

            $educationalQualification = MembershipDashBoard::adminmemberEducationalSepecific($fromDate,$toDate);


            return view('backend.pages.memberships.dashboard',compact('memberDashboard','memberJoinedDateWise','memberAgeSpecifc','genderSpecific','demographySpecific','marketplaceSpecific','socialCategory','educationalQualification','fromDate','toDate'), ['filter' => $filter]);


        }
        return view('backend.pages.memberships.dashboard');
    }

    public function membershipSearch(Request $request)  
    {
        $filters = $request->all();
        if( count($filters) > 0)
        {
            $multipleValues = [
                "gender",
                "social_category",
                "marital_status",
                "education_qualification",
                "type_of_vending",
                "type_of_marketplace",
                "total_years",
                "current_state",
                "current_district",
                "municipality_panchayat_current",
            ];
            $input = $request->all();
            unset($input['_token']);
            unset($input['age']);
            if (is_array($input) && count($input) > 0) 
            {
                $vendor = VendorDetail::leftJoin('memeberships as m','m.user_id','=','vendor_details.id')->whereNotNull('m.membership_id')
                ->leftJoin('states as s','s.id','=','vendor_details.current_state','vendor_details.created_at as date_of_joining')
                ->leftJoin('vendings as v','v.id','=','vendor_details.type_of_vending');
                
                foreach ($input as $key => $value) 
                {
                    if(!is_null($value) && !empty($value))
                    {
                        if($key == 'name')
                        {
                            $key = 'vendor_first_name';
                        }
                        
                        if (in_array($key,$multipleValues)) 
                        {
                         //   $values = explode(',',$value);
                            $vendor = $vendor->whereIn("vendor_details.".$key,$value);
                        }
                        else
                        {
                            // $vendor = $vendor->where("vendor_details.".$key,'like','%'.$value);
                        }
                        
                    }
                }            
                $memeberships = $vendor
                ->select(['vendor_details.id','vendor_details.vendor_first_name as name','m.membership_id as membership_id','m.id as memberID','s.name as state','vendor_details.created_at','v.name as vending_type'])->orderBy('created_at', 'DESC')->toBase()->get();
                
                $memeberships = !is_null( $memeberships) ?  json_decode(json_encode( $memeberships),true): $memeberships ;
                //echo"<pre>";print_r($memeberships);die;
                // dd($input,$filters,$memeberships);
                return view('backend.pages.memberships.search',compact('memeberships'));

                            
            }
        }
        return view('backend.pages.memberships.search');

    }
}
