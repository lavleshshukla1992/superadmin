<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\API\OTPController;
use App\Http\Controllers\VendorApiController;
use App\Http\Controllers\API\StateApiController;
use App\Http\Controllers\API\PincodeAPIController;
use App\Http\Controllers\API\DistrictApiController;
use App\Http\Controllers\API\VendorDetailController;

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

Route::get('/add-customer' , [ApiController::class,'addCustomer']);

// Route::apiResource('vendor-details',VendorDetailController::class);

Route::post('vendor-signup',[VendorDetailController::class,'store']);

Route::get('vendor-profile/{vendorDetail}',[VendorDetailController::class,'show']);

Route::get('vendor-list',[VendorDetailController::class,'index']);

Route::post('vendor-profile-update/{vendorDetail}',[VendorDetailController::class,'update']);

Route::post('send-otp',[OTPController::class,'sendOTP']);

Route::post('resend-otp',[OTPController::class,'reSendOTP']);

Route::post('verify-otp',[OTPController::class,'verifyOTP']);

Route::post('pincode-list',[PincodeAPIController::class,'getPinCodeList']);


Route::apiResource('countries',CountryApiController::class)->only([
    'index', 'show'
]);

Route::get('state-list',[StateApiController::class,'index']);

Route::post('district-list',[DistrictApiController::class,'index']);


Route::apiResource('categories',CategoryApiController::class)->only([
    'index', 'show'
]);

Route::apiResource('sub-categories',SubCategoryApiController::class)->only([
    'index', 'show'
]);

Route::get('ads-list',AdAPIController::class);
