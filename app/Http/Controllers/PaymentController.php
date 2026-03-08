<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\User;

class PaymentController extends Controller
{

    public function checkout($plan)
    {

        if (!in_array($plan, ['Captain', 'Pilot'])) {
            abort(403);
        }

        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($plan == 'Pilot') {
            $checkout = env('PADDLE_CHECKOUT_PILOT');
        }

        if ($plan == 'Captain') {
            $checkout = env('PADDLE_CHECKOUT_CAPTAIN');
        }

        return redirect($checkout . '?email=' . $user->email);
    }



    public function webhook(Request $request)
    {

        $data = $request->all();

        if (!isset($data['data']['customer']['email'])) {
            return response()->json(['error' => 'email missing'], 400);
        }

        $email = $data['data']['customer']['email'];

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'user not found'], 404);
        }

        $subscription = $user->subscription;

        if (!$subscription) {
            return response()->json(['error' => 'subscription missing'], 404);
        }

        $product = $data['data']['items'][0]['product']['name'] ?? null;

        if ($product === 'Pilot') {

            $subscription->update([
                'plan' => 'Pilot',
                'monthly_limit' => 600,
                'used_this_month' => 0,
                'price' => 5.99,
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
                'status' => 'active'
            ]);

        }

        if ($product === 'Captain') {

            $subscription->update([
                'plan' => 'Captain',
                'monthly_limit' => null,
                'used_this_month' => 0,
                'price' => 19.99,
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
                'status' => 'active'
            ]);

        }

        return response()->json(['success' => true]);

    }

}