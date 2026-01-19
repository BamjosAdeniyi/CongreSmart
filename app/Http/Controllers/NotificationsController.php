<?php

namespace App\Http\Controllers;

use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    /**
     * Get the count of unread notifications for the current user
     */
    public static function getUnreadCount()
    {
        if (!Auth::check()) return 0;
        $userId = Auth::id();

        // Count personal unread notifications
        $personalUnread = SystemNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        // Count global notifications that haven't been read by this user
        $globalUnread = SystemNotification::whereNull('user_id')
            ->whereDoesntHave('reads', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->count();

        return $personalUnread + $globalUnread;
    }

    public function index()
    {
        $userId = Auth::id();

        // Get notifications and manually filter/mark read status in the view or here
        // We need to fetch all relevant notifications
        $notifications = SystemNotification::where(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereNull('user_id');
            })
            ->with(['reads' => function($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Calculate stats
        $total = SystemNotification::where(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereNull('user_id');
            })->count();

        $unread = self::getUnreadCount();

        $today = SystemNotification::where(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereNull('user_id');
            })->whereDate('created_at', today())->count();

        $stats = compact('total', 'unread', 'today');

        return view('notifications.index', compact('notifications', 'stats'));
    }

    public function markAsRead(Request $request, $id)
    {
        $userId = Auth::id();
        $notification = SystemNotification::where('id', $id)
            ->where(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereNull('user_id');
            })
            ->firstOrFail();

        if ($notification->user_id) {
            // Personal notification
            $notification->update(['is_read' => true]);
        } else {
            // Global notification
            if (!$notification->reads()->where('user_id', $userId)->exists()) {
                $notification->reads()->attach($userId);
            }
        }

        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }

    public function markAllAsRead()
    {
        $userId = Auth::id();

        // 1. Mark all personal notifications as read
        SystemNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // 2. Mark all global notifications as read for this user
        $unreadGlobalNotifications = SystemNotification::whereNull('user_id')
            ->whereDoesntHave('reads', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->pluck('id');

        if ($unreadGlobalNotifications->isNotEmpty()) {
            $attachData = [];
            $now = now();
            foreach ($unreadGlobalNotifications as $notifId) {
                $attachData[$notifId] = ['read_at' => $now];
            }
            // Use syncWithoutDetaching to avoid duplicates if race conditions occur
            Auth::user()->readNotifications()->syncWithoutDetaching($attachData);
        }

        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    /**
     * Helper method to create a notification
     */
    public static function notify($title, $message, $type = 'info', $userId = null, $actionUrl = null)
    {
        return SystemNotification::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'user_id' => $userId,
            'action_url' => $actionUrl,
            'is_read' => false
        ]);
    }
}
