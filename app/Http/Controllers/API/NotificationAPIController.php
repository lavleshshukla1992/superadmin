<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;

class NotificationAPIController extends Controller
{
    public function getNotificationList(Request $request)
    {
        $user_id = $request->get('user_id');
        $is_read = $request->get('user_id');

        $notificationQuery = Notification::query();

        if (!empty($user_id)) {
            $notificationQuery->where('user_id', $user_id);
        }
        
        if ($request->has('is_read')) {
            $is_read = filter_var($request->get('is_read'), FILTER_VALIDATE_BOOLEAN);
            $notificationQuery->where('is_read', $is_read);
        }

        $notification = $notificationQuery->orderByDesc('id')->paginate();

        $meta = [
            'first_page' => $notification->url(1),
            'last_page' => $notification->url($notification->lastPage()),
            'prev_page_url' =>$notification->previousPageUrl(),
            'per_page' => $notification->perPage(),
            'total_items' => $notification->total(),
            'total_pages' => $notification->lastPage()
        ];
        return response()->json(['status_code' => 200,'success' => true,"message" => "Notification List Loaded successfully",'meta'=> $meta , 'data'=>new NotificationCollection($notification)]);
    }

    public function getNotificationDetail(Notification $notification)
    {
        return response()->json(['status_code' => 200,'success' => true,"message" => "Notification Detail Loaded successfully", 'data'=>new NotificationResource($notification)]);
    }

    public function updateNotification(Request $request) 
    {   
        $request->validate([
            'user_id' => 'required|integer|min:1',
            'notification_id' => 'required|string', // Ensure notification_id is a string
        ]);
    
        $isRead = $request->get('is_read',false)?1:0;
        $user_id = $request->get('user_id');
        $notification_ids = explode(',', $request->get('notification_id'));
        Notification::where('user_id', $user_id)->whereIn('id', $notification_ids)->update(['is_read' => $isRead]);

        return response()->json(['status_code' => 200,'success' => true,"message" => "Notification updated successfully"]);
    }
    public function updateUserNotification(Request $request) 
    {
        $request->validate([
            'user_id' => 'required|integer|min:1',
        ]);

        $user_id = $request->get('user_id');
        
        Notification::where('user_id', $user_id)->update(['is_read' => 1]);

        return response()->json(['status_code' => 200,'success' => true,"message" => "Notification deleted successfully"]);
    }
}