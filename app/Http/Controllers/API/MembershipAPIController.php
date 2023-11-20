<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MembershipAPIReseource;
use App\Http\Resources\MembershipAPICollection;
use App\Http\Resources\MemberSearchAPICollection;
use App\Http\Resources;
use App\Models\Memebership;
use App\Models\VendorDetail;
use App\Services\MembershipDashBoard;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

use App\Models\Notification;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Services\OTPService;

class MembershipAPIController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		$members = Memebership::from('memeberships as memeberships')
			->leftJoin('vendor_details as vd', 'vd.id', '=', 'memeberships.user_id')
			->leftJoin('states as s', 's.id', '=', 'vd.current_state')
			->select([
				'memeberships.id',
				'memeberships.user_id',
				'memeberships.membership_id',
				'memeberships.user_name as name',
				'memeberships.applied_for as applied_for',
				's.name as state',
				'memeberships.created_at as date',
				'memeberships.status as status'
			]);

		if (!empty($request->get('state_id'))) {
			$state_id = explode(',', $request->get('state_id'));
			$members->where('vd.current_state', $state_id);
		}
		
		if (!empty($request->get('district_id'))) {
			$district_id = explode(',', $request->get('district_id'));
			$members->where('vd.current_district', $district_id);
		}
		
		if (!empty($request->get('municipality_id'))) {
			$municipality_id = explode(',', $request->get('municipality_id'));
			$members->where('vd.municipality_panchayat_current', $municipality_id);
		}

		if ($request->get('applied_for')) {
			$applied_for = explode(',', $request->get('applied_for'));
			$members->whereIn('memeberships.applied_for', $applied_for);
		}

		if ($request->get('status')) {
			$status = explode(',', $request->get('status'));
			$members->whereIn('memeberships.status', $status);
		}

		$search_input = $request->get('search_input', '');
		if (!empty($search_input)) {
			$members->where(function ($query) use ($search_input) {
				$query->where('memeberships.user_name', 'LIKE', '%' . $search_input . '%');
			});
		}

		$members = $members->orderBy('date','DESC');

		$members = $members->paginate();


		$meta = [
			'first_page'    => $members->url(1),
			'last_page'     => $members->url($members->lastPage()),
			'prev_page_url' => $members->previousPageUrl(),
			'per_page'      => $members->perPage(),
			'total_items'   => $members->total(),
			'total_pages'   => $members->lastPage()
		];

		$members = $members->toBase();

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Membership  List Loaded successfully", 'meta' => $meta, 'data' => new MembershipAPICollection($members)]);
	}

	public function search(Request $request)
	{
		$input = $request->all();

		$members = Memebership::from('memeberships as memeberships')
			->leftJoin('vendor_details as vd', 'vd.id', '=', 'memeberships.user_id')
			->leftJoin('states as s', 's.id', '=', 'vd.current_state')
			->leftJoin('vendings as v', 'v.id', '=', 'vd.type_of_vending')
			->select([
				'memeberships.id',
				'memeberships.membership_id',
				'memeberships.user_id',
				'memeberships.user_name as name',
				'vd.date_of_birth',
				'v.name as vendor_type',
				'memeberships.applied_for as applied_for',
				's.name as state',
				'memeberships.created_at as date',
				'memeberships.status as status'
			]);

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
		foreach ($input as $key => $value) {
			if (!is_null($value) && strlen($value)  > 0) {
				if ($key == 'name') {
				}

				if (in_array($key, $multipleValues)) {
					$values = explode(',', $value);
					$members->whereIn($key, $values);
				} else {
					if ($key != 'page') {
						$members->where($key, 'like', '%' . $value);
					}
				}
			}
		}

		if ($request->get('user_id')) {
			$user_id = explode(',', $request->get('user_id'));
			$members->whereIn('user_id', $user_id);
		}

		if ($request->get('applied_for')) {
			$applied_for = explode(',', $request->get('applied_for'));
			$members->whereIn('applied_for', $applied_for);
		}

		if ($request->get('status')) {
			$status = explode(',', $request->get('status'));
			$members->whereIn('status', $status);
		}

		$search_input = $request->get('search_input', '');
		if (!empty($search_input)) {
			$members->where(function ($query) use ($search_input) {
				$query->where('name', 'LIKE', '%' . $search_input . '%');
			});
		}

		$members = $members->orderBy('name','ASC');
		$members = $members->paginate();

		$meta = [
			'first_page'    => $members->url(1),
			'last_page'     => $members->url($members->lastPage()),
			'prev_page_url' => $members->previousPageUrl(),
			'per_page'      => $members->perPage(),
			'total_items'   => $members->total(),
			'total_pages'   => $members->lastPage()
		];

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Membership  List Loaded successfully", 'meta' => $meta, 'data' => new MemberSearchAPICollection($members)]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function socialCategoryWise(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$socialCategoryWiseCount = MembershipDashBoard::getMembershipCategories($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Category wise members  Loaded successfully", 'data' => $socialCategoryWiseCount]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function demographySpecific(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$demographySpecific = MembershipDashBoard::demographySpecific($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "State Wise Date  Loaded Successfully", 'data' => $demographySpecific]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function genderSpecific(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$genderSpecific = MembershipDashBoard::genderSpecific($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Gender specific members  Loaded successfully", 'data' => $genderSpecific]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function memberJoinedDateWise(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$memberJoinedDateWise = MembershipDashBoard::memberJoinedDateWise($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Gender specific members  Loaded successfully", 'data' => $memberJoinedDateWise]);
	}

	/**
	 * Get the Member Dashboard common details.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function memberDashboardDetail(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$memberDashboard = MembershipDashBoard::memberDashboardDetail($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Member Dashboard Loaded successfully", 'data' => $memberDashboard]);
	}

	/**
	 * Get the Member Age specific details.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function memberAgeSpecific(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$memberAgeSpecifc = MembershipDashBoard::memberAgeSpecific($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Age Range  Data  Loaded successfully", 'data' => $memberAgeSpecifc]);
	}

	public function educationalQualification(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$educationalQualificationSpecific = MembershipDashBoard::memberEducationalSepecific($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Educational Qualification Wise Data  Loaded successfully", 'data' => $educationalQualificationSpecific]);
	}

	public function vendingTypeSpecific(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$vendingTypeSpecific = MembershipDashBoard::vendingTypeSpecific($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Vending Type Wise Data  Loaded successfully", 'data' => $vendingTypeSpecific]);
	}

	public function marketplaceTypeSpecific(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$marketplaceSpecific = MembershipDashBoard::marketplaceTypeSpecific($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Marketplace Type Wise Data  Loaded successfully", 'data' => $marketplaceSpecific]);
	}

	public function maritalStatusSpecific(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$maritalStatusSpecific = MembershipDashBoard::maritalStatusSpecific($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Marital Status Wise Data  Loaded successfully", 'data' => $maritalStatusSpecific]);
	}

	public function datewiseData(Request $request)
	{
		$fromDate = $request->get('from_date');
		$toDate   = $request->get('to_date');

		$dateWiseData = MembershipDashBoard::dateWiseData($fromDate, $toDate);

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Member Datewise Dashboard Loaded successfully", 'data' => $dateWiseData]);
	}

	public function updateMemberStatus(Request $request)
	{
		$userID = $request->get('user_id');
		$status = $request->get('status');
		$member = Memebership::where('user_id', $userID)->first();
		$vendor = VendorDetail::Find($userID);
		$vendor->status = $status;
		$vendor->save();

		$notification = new Notification();
		$notification->user_id = $vendor->id;
		if($status=='approved'){
		 $notification->title = 'Congratulations! Your profile has been approved';
		}else{
		 $notification->title = 'Your profile has been rejected. Please contact admin.';
		}
		$notification->type = 'VendorDetails';
		$notification->type_id = $vendor->id;
		$notification->sent_at = Carbon::now();
		$notification->status = 1;
		$notification->save();
    OTPService::sendSMS($vendor->mobile_no, $notification->title);

		if ($member instanceof Memebership) {

			$member->status = $status;
			$member->save();

			return response()->json(['status_code' => 200, 'success' => true, "message" => "Member status updated successfully"]);
		}

		return response()->json(['status_code' => 200, 'success' => true, "message" => "Member not found"]);
	}

	public function verification(Request $request)
	{
		$members = Memebership::leftJoin('vendor_details as vd', 'vd.id', '=', 'memeberships.user_id')->leftJoin('states as s', 's.id', '=', 'vd.current_state')->select(['memeberships.created_at', 'memeberships.applied_for', 'memeberships.status', 's.name as state', 'vd.vendor_first_name', 'vd.vendor_last_name', 'memeberships.id'])->orderBy('created_at', 'DESC')->get()->toArray();
		return view('backend.pages.memberships.verification', compact('members'));
	}
	public function memberDetail($id)
	{
		$member = Memebership::leftJoin('vendor_details as vd', 'vd.id', '=', 'memeberships.user_id')
			->leftJoin('states as s', 's.id', '=', 'vd.current_state')
			->where('memeberships.id', $id)
			->select(['vd.*', 'memeberships.created_at', 'memeberships.applied_for', 'memeberships.status', 'memeberships.user_id', 's.name as state'])
			->first();

		if ($member) {
			// The query returned a valid result, you can now safely call toArray()
			$member = $member->toArray();
		} else {
			// Handle the case where no matching record was found (optional)
			// For example, you could redirect to an error page or show a message.
			// For now, let's set $member to an empty array to avoid issues in the view.
			$member = [];
			die("Record Not Found");
		}
		return view('backend.pages.memberships.detail', compact('member'));
	}
	public function memberDetails($id)
	{
		$member = Memebership::leftJoin('vendor_details as vd', 'vd.id', '=', 'memeberships.user_id')
			->leftJoin('states as s', 's.id', '=', 'vd.current_state')
			->where('vd.id', $id)
			->select(['vd.*', 'memeberships.created_at', 'memeberships.applied_for', 'memeberships.status', 'memeberships.user_id', 's.name as state'])
			->first();

		if ($member) {
			// The query returned a valid result, you can now safely call toArray()
			$member = $member->toArray();
		} else {
			// Handle the case where no matching record was found (optional)
			// For example, you could redirect to an error page or show a message.
			// For now, let's set $member to an empty array to avoid issues in the view.
			$member = [];
			die("Record Not Found");
		}
		return view('backend.pages.memberships.detail', compact('member'));
	}
	public function memberPDF($id)
	{ $data = Memebership::where('user_id', $id)->first();
		$member = Memebership::leftJoin('vendor_details as vd', 'vd.id', '=', 'memeberships.user_id')->leftJoin('states as s', 's.id', '=', 'vd.current_state')->where('memeberships.id', $data->id)->select(['vd.*', 'memeberships.created_at', 'memeberships.applied_for', 'memeberships.status', 'memeberships.user_id', 's.name as state'])->first()->toArray();
		//$member = Memebership::leftJoin('vendor_details as vd', 'vd.id', '=', 'memeberships.user_id')->leftJoin('states as s', 's.id', '=', 'vd.current_state')->where('memeberships.id', $id)->select(['vd.*', 'memeberships.created_at', 'memeberships.applied_for', 'memeberships.status', 'memeberships.user_id', 's.name as state'])->first()->toArray();



		$pdf = new Dompdf();
		$pdf->set_option('chroot', public_path());
		// Render the view with Bootstrap styles applied
		$html = view('backend.pages.memberships.pdf', compact('member'))->render();

		// Load HTML content into DOMPDF
		$pdf->loadHtml($html);

		// (Optional) Set paper size and orientation
		$pdf->setPaper('A4', 'portrait');

		// Render the PDF
		$pdf->render();

		// Optionally, you can save the PDF to a file
		// $pdf->save(public_path('pdfs/membership_detail.pdf'));

		// Display the PDF in the browser
		return $pdf->stream('membership_detail.pdf');

		$pdf = new Dompdf();
		$pdf->loadHtml(View::make('backend.pages.memberships.pdf', compact('member'))->render());
		$pdf->setPaper('A4');
		$pdf->render();
		return $pdf->stream('vendor.pdf');
	}
	public function updateStatus(Request $request)
	{
		$userID    = $request->get('user_id');
		$status    = $request->get('status');
		$member_id = $request->get('member_id');
		$member    = Memebership::where('user_id', $userID)->first();
    $vendor = VendorDetail::Find($userID);
		$vendor->status = $status;
		$vendor->save();

		$notification = new Notification();
		$notification->user_id = $vendor->id;
		if($status=='approved'){
		 $notification->title = 'Congratulations! Your profile has been approved';
		}else{
		 $notification->title = 'Your profile has been rejected. Please contact admin.';
		}
		$notification->type = 'VendorDetails';
		$notification->type_id = $vendor->id;
		$notification->sent_at = Carbon::now();
		$notification->status = 1;
		$notification->save();
    OTPService::sendSMS($vendor->mobile_no, $notification->title);

		if ($member instanceof Memebership) {
			$member->status = $status;
			$member->save();
		}
		return redirect()->route('member-detail', ['id' => $member->id]);
	}
}
