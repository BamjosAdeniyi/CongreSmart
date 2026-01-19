<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Http\Controllers\NotificationsController;
use Carbon\Carbon;

class CheckUpcomingBirthdays extends Command
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
    protected $description = 'Check for upcoming member birthdays and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for upcoming birthdays...');

        // Check for birthdays in exactly 5 days
        $targetDate = Carbon::today()->addDays(5);

        $upcomingBirthdays = Member::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [$targetDate->format('m-d')])
            ->where('membership_status', 'active')
            ->get();

        foreach ($upcomingBirthdays as $member) {
            $age = $member->date_of_birth->age + 1; // Age they will be turning
            $message = "{$member->full_name} will be turning {$age} on {$targetDate->format('l, F jS')}.";

            // Send global notification (visible to all admins/pastors/etc)
            NotificationsController::notify(
                'Upcoming Birthday Alert',
                $message,
                'info',
                null, // Global notification
                route('members.show', $member)
            );

            $this->info("Notification sent for {$member->full_name}");
        }

        // Check for birthdays TODAY
        $today = Carbon::today();
        $todaysBirthdays = Member::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [$today->format('m-d')])
            ->where('membership_status', 'active')
            ->get();

        foreach ($todaysBirthdays as $member) {
            $age = $member->date_of_birth->age;
            $message = "Happy Birthday! {$member->full_name} is turning {$age} today!";

            NotificationsController::notify(
                'Birthday Today!',
                $message,
                'success',
                null, // Global notification
                route('members.show', $member)
            );

            $this->info("Today's birthday notification sent for {$member->full_name}");
        }

        $this->info('Birthday check complete.');
    }
}
