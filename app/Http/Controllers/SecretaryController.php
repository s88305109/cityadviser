<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Secretary;

class SecretaryController extends Controller
{
    // 主頁
    public function index(Request $request)
    {
        $state  = (! empty($request->state)) ? $request->state : 'active';
        $status = ($state == 'processed') ? 1 : 0;
        $events = Secretary::where('user_id', Auth::id())->where('status', $status)->orderByRaw('ISNULL(deadline), deadline ASC')->get();

        return view('secretary.index', [
            'state' => $state, 
            'events' => $events
        ]);
    }

    public function watch(Request $request)
    {
        $event = Secretary::find($request->input('id'));

        if (empty($request->input('id')) || empty($event) || $event->user_id != Auth::id()) {
            return response()->json([
                'status'  => 'fail', 
                'message' => __('查無資料'), 
                'code'    => 40000
            ], 400);
        }

        $event->watch = 1;
        $event->save();

        return response()->json([
            'status'  => 'success', 
            'message' => '', 
            'code'    => 20000
        ], 200);
    }

}
