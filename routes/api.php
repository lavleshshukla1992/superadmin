<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\API\OTPController;
use App\Http\Controllers\API\AdAPIController;
use App\Http\Controllers\PanchayatController;
use App\Http\Controllers\VendorApiController;
use App\Http\Controllers\API\AdminAPIController;
use App\Http\Controllers\API\LoginAPIController;
use App\Http\Controllers\API\AdminLoginAPIController;
use App\Http\Controllers\API\StateApiController;
use App\Http\Controllers\API\NoticeAPIController;
use App\Http\Controllers\API\SchemeAPIController;
use App\Http\Controllers\API\VendinAPIController;
use App\Http\Controllers\API\CountryApiController;
use App\Http\Controllers\API\PincodeAPIController;
use App\Http\Controllers\MemebershipController; //
use App\Http\Controllers\API\DistrictApiController;
use App\Http\Controllers\API\FeedbackAPIController;
use App\Http\Controllers\API\ComplaintTypeAPIController;
use App\Http\Controllers\API\SchemeApplyController;
use App\Http\Controllers\API\SettingsAPIController;
use App\Http\Controllers\API\TrainingAPIController;
use App\Http\Controllers\API\VendorDetailController;
use App\Http\Controllers\API\MembershipAPIController;
use App\Http\Controllers\API\MarketPlaceAPIController;
use App\Http\Controllers\API\NotificationAPIController;
use App\Http\Controllers\API\FeedbackConversationAPIController;
use App\Http\Controllers\API\CommonController;
use App\Http\Controllers\API\InformationAPIController;
use App\Http\Controllers\API\NomineeAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Scheme Application
Route::post('scheme-apply',[SchemeApplyController::class,'store']);
Route::post('user-scheme-history-list',[SchemeApplyController::class,'index']);
Route::post('user-applied-scheme-history-list',[SchemeApplyController::class,'userAppliedScheme']);
Route::post('applied-scheme',[SchemeApplyController::class,'appliedScheme']);

// user-scheme-history-list

// Feedback
//Route::post('complaint-type',[ComplaintTypeAPIController::class,'store']);
Route::get('complaint-type',[ComplaintTypeAPIController::class,'show']);
Route::post('new-feedback',[FeedbackAPIController::class,'store']);
//Route::get('feedback-history-user/{id}',[FeedbackAPIController::class,'userFeedbackHistory']);
Route::post('feedback-history-user',[FeedbackAPIController::class,'userFeedbackHistory']);
Route::post('feedback-history-all',[FeedbackAPIController::class,'allFeedbackHistory']);


// Feedback Conversation
Route::post('feedback-conversation',[FeedbackConversationAPIController::class,'store']);
Route::get('feedback-conversation-details/{feedbackConversation}',[FeedbackConversationAPIController::class,'show']);




// Route::get('/add-customer' , [ApiController::class,'addCustomer']);

Route::post('/panchayat-list' , [PanchayatController::class,'getList']);
Route::post('/convert-base64' , [CommonController::class,'convertIntoBase64']);


Route::post('district-list',[DistrictApiController::class,'index']);
// Vendor
Route::post('vendor-signup',[VendorDetailController::class,'store']);

// OTP
Route::post('send-otp',[OTPController::class,'sendOTP']);
Route::post('resend-otp',[OTPController::class,'reSendOTP']);
Route::post('verify-otp',[OTPController::class,'verifyOTP']);

// Pin code 
Route::post('pincode-list',[PincodeAPIController::class,'getPinCodeList']);

Route::post('login',[LoginAPIController::class,'login']); 
Route::post('logout',[LoginAPIController::class,'logout']);

Route::post('password-update',[LoginAPIController::class,'passwordUpdate']);

Route::post('admin-login',[AdminLoginAPIController::class,'login']); 
Route::post('admin-logout',[AdminLoginAPIController::class,'logout']);

Route::post('admin-password-update',[AdminLoginAPIController::class,'passwordUpdate']);


Route::get('countries',[CountryApiController::class,'index']);

Route::get('state-list',[StateApiController::class,'index']);





// Route::middleware('auth:sanctum')->group(function(){

    Route::get('feedback-detail/{feedback}',[FeedbackAPIController::class,'show']);


    Route::get('ads-list',[AdAPIController::class,'getActiveAds']);

    // Training
    //Route::get('training-list' , [TrainingAPIController::class,'getTrainingList']);
    Route::post('training-list' , [TrainingAPIController::class,'getTrainingList']);
    Route::post('global-training-list' , [TrainingAPIController::class,'getGlobalTrainingList']);
    Route::get('training-detail/{training}' , [TrainingAPIController::class,'getTrainingDetail']);
    //Route::get('live-training' , [TrainingAPIController::class,'liveTrainingList']);
    Route::post('live-training' , [TrainingAPIController::class,'liveTrainingList']);
    Route::post('update-training/{training}' , [TrainingAPIController::class,'updateTraining']);
    Route::post('add-training' , [TrainingAPIController::class,'storeTraining']);
    Route::post('delete-training/{training}' , [TrainingAPIController::class,'deleteTraining']);

    // Notification 
    Route::get('/notification-list' , [NotificationAPIController::class,'getNotificationList']);
    Route::get('/notification-detail/{notification}' , [NotificationAPIController::class,'getNotificationDetail']);
    //Route::post('/notification-update/{notification}' , [NotificationAPIController::class,'updateNotification']);
    Route::post('/notification-update' , [NotificationAPIController::class,'updateNotification']);
    Route::post('/delete-notification' , [NotificationAPIController::class,'updateUserNotification']);

    // Membership
    Route::get('membership-detail/{memebership}',[MemebershipController::class,'show']);
    Route::post('members-search',[MembershipAPIController::class,'search']);
    Route::post('apply-membership',[MemebershipController::class,'store']);
   // Route::get('membership-list',[MembershipAPIController::class,'index']); 
    Route::post('membership-list',[MembershipAPIController::class,'index']); 
    Route::post('member-social-category-wise',[MembershipAPIController::class,'socialCategoryWise']);
    Route::post('member-state-wise',[MembershipAPIController::class,'demographySpecific']);
    Route::post('member-gender-specific',[MembershipAPIController::class,'genderSpecific']);
    Route::post('member-dashboard-details',[MembershipAPIController::class,'memberDashboardDetail']);
    Route::post('member-age-specific',[MembershipAPIController::class,'memberAgeSpecific']);
    Route::post('educational-qualification-specific',[MembershipAPIController::class,'educationalQualification']);
    Route::post('vending-type-specific',[MembershipAPIController::class,'vendingTypeSpecific']);
    Route::post('marketplace-type-specific',[MembershipAPIController::class,'marketplaceTypeSpecific']);
    Route::post('marital-status-specific',[MembershipAPIController::class,'maritalStatusSpecific']);
    Route::post('member-dashboard-details-datewise',[MembershipAPIController::class,'datewiseData']);
    Route::post('update-member-status',[MembershipAPIController::class,'updateMemberStatus']);

    // Members list 



    // feedback-history-user/11




    Route::post('member-user-join-datewise',[MembershipAPIController::class,'memberJoinedDateWise']);



    // member-age-specific

    Route::get('vendor-profile/{vendorDetail}',[VendorDetailController::class,'show']);
    Route::get('vendor-list',[VendorDetailController::class,'index']);
    Route::post('vendor-profile-update/{vendorDetail}',[VendorDetailController::class,'update']);
    // Scheme
    Route::post('scheme-history-list',[SchemeAPIController::class,'index']);
    Route::post('global-scheme-history-list',[SchemeAPIController::class,'globalIndex']);
    Route::get('scheme-detail/{scheme}',[SchemeAPIController::class,'show']);
    Route::post('live-scheme',[SchemeAPIController::class,'liveScheme']);
    Route::post('add-scheme',[SchemeAPIController::class,'store']);
    Route::post('update-scheme/{scheme}',[SchemeAPIController::class,'update']);
    Route::post('delete-scheme/{scheme}',[SchemeAPIController::class,'destroy']);
    


    // Notice
    //Route::get('notice-history-list',[NoticeAPIController::class,'index']);
    Route::post('notice-history-list',[NoticeAPIController::class,'index']);
    Route::post('global-notice-history-list',[NoticeAPIController::class,'globalIndex']);
   // Route::get('notice-live-list',[NoticeAPIController::class,'liveNotice']);
    Route::post('notice-live-list',[NoticeAPIController::class,'liveNotice']);
    Route::post('add-notice',[NoticeAPIController::class,'store']);
    Route::get('notice-detail/{notice}',[NoticeAPIController::class,'show']);
    Route::post('update-notice/{notice}',[NoticeAPIController::class,'update']);
    Route::post('delete-notice/{notice}',[NoticeAPIController::class,'destroy']);
    
    
    // Settings
    Route::post('save-settings',[SettingsAPIController::class, 'store']);
    Route::post('update-settings/{settings}',[SettingsAPIController::class, 'store']);

    Route::get('vending-list',[VendinAPIController::class,'index']);
    Route::get('marketplace-list',[MarketPlaceAPIController::class,'index']);

    Route::get('admin-list',[AdminAPIController::class,'index']);
    Route::post('create-admin',[AdminAPIController::class,'store']);
    Route::get('admin-detail/{admin}',[AdminAPIController::class,'show']);
    Route::get('delete-admin/{admin}',[AdminAPIController::class,'destroy']);
    Route::post('update-admin/{admin}',[AdminAPIController::class,'update']);


    // Information
    Route::post('information-history-list',[InformationAPIController::class,'index']);
    Route::get('information-detail/{information}',[InformationAPIController::class,'show']);
    Route::post('create-information',[InformationAPIController::class,'store']);
    Route::post('update-information/{information}',[InformationAPIController::class,'update']);
    Route::post('delete-information/{information}',[InformationAPIController::class,'destroy']);

    //Nominee
    Route::post('update-nominee-details',[NomineeAPIController::class,'store']);
    //Route::post('update-nominee-details/{nominee}',[NomineeAPIController::class,'update']);
    Route::post('nominee-details',[NomineeAPIController::class,'show']);

// });