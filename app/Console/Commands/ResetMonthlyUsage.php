<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

class ResetMonthlyUsage extends Command
{
    protected $signature = 'app:reset-monthly-usage';
    protected $description = 'Reset monthly usage for Pilot users based on their subscription start date';

    public function handle()
    {
        $now = Carbon::now();

        $pilotSubs = Subscription::where('plan', 'Pilot')
            ->where('status', 'active')
            ->get();


        foreach ($pilotSubs as $sub) {

            // Get the day of the month when this user started their subscription
            $startDay = $sub->starts_at->day;

            // Check if today is the reset day
            if ($now->day == $startDay) {
                $sub->used_this_month = 0;
                $sub->save();

                $this->info("Reset usage for user_id: {$sub->user_id}");
            }
        }
    }
}