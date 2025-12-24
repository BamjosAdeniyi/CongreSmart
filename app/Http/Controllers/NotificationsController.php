<?php

namespace App\Http\Controllers;

use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Get the count of unread notifications for the current user
     */
    public static function getUnreadCount()
    {
        if (!Auth::check()) return 0;

        return SystemNotification::where(function($q) {
                $q->where('user_id', Auth::id())
                  ->orWhereNull('user_id');
            })
            ->where('is_read', false)
            ->count();
    }

    public function index()
    {
        $notifications = SystemNotification::where(function($q) {
                $q->where('user_id', Auth::id())
                  ->orWhereNull('user_id');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => SystemNotification::where(function($q) {
                    $q->where('user_id', Auth::id())
                      ->orWhereNull('user_id');
                })->count(),
            'unread' => self::getUnreadCount(),
            'today' => SystemNotification::where(function($q) {
                    $q->where('user_id', Auth::id())
                      ->orWhereNull('user_id');
                })->whereDate('created_at', today())->count(),
        ];

        return view('notifications.index', compact('notifications', 'stats'));
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = SystemNotification::where('id', $id)
            ->where(function($q) {
                $q->where('user_id', Auth::id())
                  ->orWhereNull('user_id');
            })
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }

    public function markAllAsRead()
    {
        SystemNotification::where(function($q) {
                $q->where('user_id', Auth::id())
                  ->orWhereNull('user_id');
            })
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    /**
     * Helper method to create a notification
     */
    public static function notify($title, $message, $type = 'info', $userId = null, $actionUrl = null)
    {
        return SystemNotification::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'user_id' => $userId,
            'action_url' => $actionUrl
        ]);
    }
}
