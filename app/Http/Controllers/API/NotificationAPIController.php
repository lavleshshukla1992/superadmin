<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;

class NotificationAPIController extends Controller
{
    public function getNotificationList()
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Notification List Loaded successfully", 'data'=>new NotificationCollection(Notification::all())]);
    }

    public function getNotificationDetail(Notification $notification)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Notification Detail Loaded successfully", 'data'=>new NotificationResource($notification)]);
    }
}
