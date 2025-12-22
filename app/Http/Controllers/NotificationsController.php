<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Get the count of unread notifications for the current user
     */
    public static function getUnreadCount()
    {
        // For now, return sample data
        // TODO: Replace with database query when notifications table is implemented
        $sampleNotifications = [
            ['read' => false], // Welcome notification
            ['read' => false], // System maintenance
            ['read' => true],  // Member added
            ['read' => true],  // Financial report
        ];

        return count(array_filter($sampleNotifications, fn($n) => !$n['read']));
    }
    public function index()
    {
        // For now, we'll create some sample notifications
        // In a real application, these would come from a notifications table
        $notifications = [
            [
                'id' => 1,
                'title' => 'Welcome to CongreSmart',
                'message' => 'Your church management system is now active. Start by adding members and managing your Sabbath School classes.',
                'type' => 'info',
                'read' => false,
                'created_at' => now()->subDays(1),
            ],
            [
                'id' => 2,
                'title' => 'System Maintenance',
                'message' => 'Scheduled maintenance will occur this Sunday from 2:00 AM to 4:00 AM. The system will be unavailable during this time.',
                'type' => 'warning',
                'read' => false,
                'created_at' => now()->subDays(3),
            ],
            [
                'id' => 3,
                'title' => 'New Member Added',
                'message' => 'John Doe has been successfully added to the members database.',
                'type' => 'success',
                'read' => true,
                'created_at' => now()->subDays(5),
            ],
            [
                'id' => 4,
                'title' => 'Financial Report Ready',
                'message' => 'Your monthly financial report for November is now available in the Reports section.',
                'type' => 'info',
                'read' => true,
                'created_at' => now()->subDays(7),
            ],
        ];

        $stats = [
            'total' => count($notifications),
            'unread' => count(array_filter($notifications, fn($n) => !$n['read'])),
            'today' => count(array_filter($notifications, fn($n) => $n['created_at']->isToday())),
        ];

        return view('notifications.index', compact('notifications', 'stats'));
    }

    public function markAsRead(Request $request, $id)
    {
        // In a real application, this would update the database
        // For now, we'll just return a success response
        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }

    public function markAllAsRead()
    {
        // In a real application, this would update all notifications for the current user
        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }
}