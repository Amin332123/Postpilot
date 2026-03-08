<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Subscription;

class CaptionController extends Controller
{


    public function index()
    {

        $user = Auth::user();
        $subscription = $user->subscription()->where('status', 'active')->first();

        $used = $subscription ? $subscription->used_this_month : 0;
        $limit = $subscription ? $subscription->monthly_limit : 0;
        $planName = $subscription ? $subscription->plan : 'Free';

        // calculate percentage for progress bar
        $percentage = $limit > 0 ? round(($used / $limit) * 100) : 0;


        // pass to view
        return view('dashboard', compact('used', 'limit', 'planName', 'percentage'));
    }


    public function generate(Request $request)
    {
        // Validate input
        $request->validate([
            'description' => 'required|string|max:500',
            'tone' => 'required|string',
            'language' => 'required|string',
            'hashtags' => 'required|string'
        ]);

        // Fetch user's active subscription
        $subscription = Auth::user()->subscription()->where('status', 'active')->first();

        if (!$subscription) {
            return response()->json([
                'error' => 'No active subscription found. Please upgrade.',
                'caption' => null,
            ], 403);
        }

        // Check usage limit based on plan
        $plan = $subscription->plan;
        $used = $subscription->used_this_month;
        $limit = $subscription->monthly_limit;

        if ($plan === 'Free' && $used >= $limit && $limit != 0) {
            return response()->json([
                'error' => 'Free plan limit reached. Upgrade to Pilot or Captain to generate more captions.',
                'caption' => null,
                'plan' => 'Free'
            ], 403);
        }

        if ($plan === 'Pilot' && $used >= $limit && $limit != 0) {
            return response()->json([
                'error' => 'Pilot daily/monthly limit reached. Upgrade to Captain for unlimited captions.',
                'caption' => null,
                'plan' => 'Pilot',
            ], 403);
        }

        // Captain has no limits, so no check needed

        // Prepare prompt for OpenAI
        $prompt = "You are a professional social media copywriter and marketing expert.
Generate an **engaging, persuasive Instagram caption** for the given product or post description.

Rules:
1. Use the description: {$request->description} as inspiration.
2. Match the requested tone: {$request->tone} (professional, casual, funny, luxury, minimal).
3. Write the caption in the requested language: {$request->language}.
4. After the caption, insert **exactly two blank lines**, then provide **exactly 5 hashtags** only — no more, no less, no duplicates.
5. Include emojis naturally in the caption only. Hashtags can have minimal emojis if relevant.
6. Do NOT include any extra notes, explanations, or formatting.
7. Output format: 
<caption>
<#Hashtag1 #Hashtag2 #Hashtag3 #Hashtag4 #Hashtag5>
";

        // Call OpenAI API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json'
        ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.7
                ]);

        if ($response->failed()) {
            Log::error('OpenAI API Error: ' . $response->body());
            return response()->json([
                'error' => 'Failed to generate caption. Please try again.',
                'caption' => null,
            ], 500);
        }

        $data = $response->json();

        if (!isset($data['choices'][0]['message']['content'])) {
            Log::error('OpenAI API Response Error: ' . json_encode($data));
            return response()->json([
                'error' => 'Invalid response from AI service.',
                'caption' => null,
            ], 500);
        }

        $text = $data['choices'][0]['message']['content'];

        // Save to history
        History::create([
            'user_id' => Auth::id(),
            'user_input' => $request->description,
            'ai_output' => $text,
            'language' => $request->language,
            'tone' => $request->tone,
        ]);

        // Increment usage
        $subscription->used_this_month += 1;
        $subscription->save();




        $used = $subscription ? $subscription->used_this_month : 0;
        $limit = $subscription ? $subscription->monthly_limit : 0;
        $percentage = $limit > 0 ? round(($used / $limit) * 100) : 0;

        return response()->json([
            'caption' => $text,
            'hashtags' => null,
            'remaining' => $limit - $subscription->used_this_month,
            'plan' => $plan,
            'used' => $used,
            'limit' => $limit,
            'percentage' => $percentage
        ]);
    }
}