<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class UpgradeController extends Controller
{
    public function index()
    {
        return view('upgrade');
    }





    public function pilot()
    {
        $user = auth()->user();
        $subscription = $user->subscription()->where('status', 'active')->first();
        if (!$subscription) {
            return redirect()->back();
        }


        $subscription->update([
            'plan' => 'Pilot', // new plan
            'monthly_limit' => 600, // update limit if needed
            'used_this_month' => 0,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'price' => 5.99
        ]);
        $limit = $subscription->monthly_limit;
        $planName = $subscription->plan;

        return redirect()->route('dashboard', $subscription->monthly_limit);
    }


    public function captain()
    {
        $user = auth()->user();
        $subscription = $user->subscription()->where('status', 'active')->first();
        if (!$subscription) {
            return redirect()->back();
        }


        $subscription->update([
            'plan' => 'Captain', // new plan
            'monthly_limit' => 0, // update limit if needed
            'used_this_month' => 0,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'price' => 19.99
        ]);

        return redirect()->route('dashboard', $subscription->monthly_limit);

    }
}
