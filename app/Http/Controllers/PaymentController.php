<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;
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

        // 1. Log the data so you can see it in Render Logs if it fails
        Log::info('Paddle Webhook Data:', $data);

        // 2. Find the email (Paddle v2 nests this inside the 'customer' or 'details')
        $email = $data['data']['customer']['email']
            ?? $data['data']['details']['customer']['email']
            ?? null;

        if (!$email) {
            Log::error('Webhook Error: No email found in payload');
            return response()->json(['error' => 'Email missing'], 400);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::error("Webhook Error: User not found for email: $email");
            return response()->json(['error' => 'User not found'], 404);
        }

        // 3. Update the Plan
        $productName = $data['data']['items'][0]['product']['name'] ?? 'Unknown';
        $subscription = $user->subscription;

        if ($subscription) {
            $subscription->update([
                'plan' => $productName,
                'status' => 'active',
                'monthly_limit' => ($productName == 'Captain') ? 0 : 600,
                'price' => ($productName == 'Captain') ? 19.99 : 5.99,
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
            ]);

            Log::info("Success: Updated $email to $productName");
        }

        return response()->json(['success' => true]);
    }

}