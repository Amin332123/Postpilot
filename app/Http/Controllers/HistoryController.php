<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;


class HistoryController extends Controller
{

    public function index()
    {
        $user = Auth()->user();
        $subscription = $user->subscription()->where('status', 'active')->first();

        $used = $subscription ? $subscription->used_this_month : 0;
        $limit = $subscription ? $subscription->monthly_limit : 0;
        $planName = $subscription ? $subscription->plan : 'Free';

        // calculate percentage for progress bar
        $percentage = $limit > 0 ? round(($used / $limit) * 100) : 0;
        $histories = History::where('user_id', auth()->id())->get();
        return view('history', compact('histories', 'used', 'limit', 'planName' , 'subscription' , 'percentage'));
    }



    public function destroy($id)
    {
        $history = History::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$history) {
            return response()->json([
                'message' => 'Record not found or unauthorized.',

            ], 404);
        }


        $history->delete();
        $historyNumber = History::where('user_id', auth()->id())->count();
        return response()->json([
            'message' => 'Message deleted successfully!',
            'numberofcards' => $historyNumber
        ], 200);

    }
}
