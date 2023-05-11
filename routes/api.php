<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\API\OTPController;
use App\Http\Controllers\API\AdAPIController;
use App\Http\Controllers\PanchayatController;
use App\Http\Controllers\VendorApiController;
use App\Http\Controllers\MemebershipController;
use App\Http\Controllers\API\LoginAPIController;
use App\Http\Controllers\API\StateApiController;
use App\Http\Controllers\API\SchemeAPIController;
use App\Http\Controllers\API\CountryApiController;
use App\Http\Controllers\API\PincodeAPIController;
use App\Http\Controllers\API\DistrictApiController;
use App\Http\Controllers\API\FeedbackAPIController;
use App\Http\Controllers\API\TrainingAPIController;
use App\Http\Controllers\API\VendorDetailController;
use App\Http\Controllers\API\NotificationAPIController;
use App\Http\Controllers\API\FeedbackConversationAPIController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
    //     return $request->user();
    // });
    
    // Route::post('/add-vendor' , [VendorApiController::class,'addVendor']);
Route::get('ads-list',[AdAPIController::class,'getActiveAds']);

Route::post('feedback-store',[FeedbackAPIController::class,'store']);
Route::get('feedback-detail/{feedback}',[FeedbackAPIController::class,'show']);

Route::post('feedback-conversation-store',[FeedbackConversationAPIController::class,'store']);
Route::get('feedback-conversation-details/{feedbackConversation}',[FeedbackConversationAPIController::class,'show']);

Route::get('/training-list' , [TrainingAPIController::class,'getTrainingList']);
Route::get('/training-detail/{training}' , [TrainingAPIController::class,'getTrainingDetail']);
Route::get('/live-training' , [TrainingAPIController::class,'getTrainingList']);



Route::get('/notification-list' , [NotificationAPIController::class,'getNotificationList']);
Route::get('/notification-detail/{notification}' , [NotificationAPIController::class,'getNotificationDetail']);



Route::get('/add-customer' , [ApiController::class,'addCustomer']);

Route::post('/panchayat-list' , [PanchayatController::class,'getList']);


// Route::apiResource('vendor-details',VendorDetailController::class);

Route::post('vendor-signup',[VendorDetailController::class,'store']);

Route::get('vendor-profile/{vendorDetail}',[VendorDetailController::class,'show']);

Route::get('vendor-list',[VendorDetailController::class,'index']);

Route::post('vendor-profile-update/{vendorDetail}',[VendorDetailController::class,'update']);

Route::post('send-otp',[OTPController::class,'sendOTP']);

Route::post('resend-otp',[OTPController::class,'reSendOTP']);

Route::post('verify-otp',[OTPController::class,'verifyOTP']);

Route::post('pincode-list',[PincodeAPIController::class,'getPinCodeList']);

Route::post('login',[LoginAPIController::class,'login']);
Route::post('password-update',[LoginAPIController::class,'passwordUpdate']);

Route::get('membership-detail/{memebership}',[MemebershipController::class,'show']);

Route::post('membership-store',[MemebershipController::class,'store']);


Route::apiResource('countries',CountryApiController::class)->only([
    'index', 'show'
]);

Route::get('state-list',[StateApiController::class,'index']);

Route::post('district-list',[DistrictApiController::class,'index']);

Route::get('scheme-list',[SchemeAPIController::class,'index']);
Route::get('scheme-detail/{scheme}',[SchemeAPIController::class,'show']);

Route::get('live-scheme',[SchemeAPIController::class,'index']);


// Route::apiResource('sub-categories',SubCategoryApiController::class)->only([
//     'index', 'show'
// ]);



