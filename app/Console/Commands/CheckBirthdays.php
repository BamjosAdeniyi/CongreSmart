<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Http\Controllers\NotificationsController;
use Carbon\Carbon;

class CheckBirthdays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:check-birthdays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for upcoming birthdays and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $fiveDaysFromNow = $today->copy()->addDays(5);

        // Find members with birthdays in 5 days
        $upcomingBirthdays = Member::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [$fiveDaysFromNow->format('m-d')])
            ->where('membership_status', 'active')
            ->get();

        foreach ($upcomingBirthdays as $member) {
            $this->sendBirthdayNotification($member, 'upcoming');
        }

        // Find members with birthdays today
        $todaysBirthdays = Member::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [$today->format('m-d')])
            ->where('membership_status', 'active')
            ->get();

        foreach ($todaysBirthdays as $member) {
            $this->sendBirthdayNotification($member, 'today');
        }

        $this->info('Birthday checks completed.');
    }

    private function sendBirthdayNotification($member, $type)
    {
        $title = $type === 'today' ? 'Happy Birthday!' : 'Upcoming Birthday Alert';
        $message = $type === 'today'
            ? "Today is {$member->full_name}'s birthday! Let's celebrate them."
            : "{$member->full_name}'s birthday is coming up in 5 days on " . Carbon::parse($member->date_of_birth)->format('M d') . ".";

        $notificationType = $type === 'today' ? 'success' : 'info';

        // Notify relevant roles (Pastor, Clerk, Welfare, Superintendent)
        // In a real app, you might want to target specific users, but for now we'll create a general notification
        // or target specific roles if the notification system supports it.
        // Since our NotificationsController::notify creates a record, we can assign it to null (global) or specific users.

        // For now, let's create a global notification that will be visible to admins/staff
        NotificationsController::notify(
            $title,
            $message,
            $notificationType,
            null, // null for global/admin visibility
            route('members.show', $member)
        );
    }
}
