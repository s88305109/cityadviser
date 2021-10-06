<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Secretary;
use App\Models\Company;

class SecretaryController extends Controller
{
    public static function getEventLabel()
    {
        $label[1][0] = 'bg-secondary';    // 總公司 > 已處理
        $label[1][1] = 'bg-primary';      // 總公司 > 未處理 > 沒有期限
        $label[1][2] = 'bg-danger';       // 總公司 > 未處理 > 有期限
        $label[2][0] = 'bg-secondary';    // 分公司 > 已處理
        $label[2][1] = 'bg-primary';      // 分公司 > 未處理 > 沒有期限
        $label[2][2] = 'bg-danger';       // 分公司 > 未處理 > 有期限

        return $label;
    }

    // 主頁
    public function index(Request $request)
    {
        $state   = (! empty($request->state)) ? $request->state : 'wait';
        $status  = ($state == 'processed') ? 1 : 0;
        $events  = Secretary::getEvents($status, 10, 0);
        $company = Company::find(Auth::user()->company_id);
        $label   = self::getEventLabel();    

        return view('secretary.index', [
            'state'  => $state, 
            'events' => $events,
            'type'   => $company->type,
            'label'  => $label
        ]);
    }

    public function more(Request $request)
    {
        $state   = (! empty($request->state)) ? $request->state : 'wait';
        $status  = ($state == 'processed') ? 1 : 0;
        $events  = Secretary::getEvents($status, 10, $request->page);
        $company = Company::find(Auth::user()->company_id);
        $label   = self::getEventLabel();

        return view('secretary.each', [
            'events' => $events,
            'type'   => $company->type,
            'label'  => $label
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

    // 全部處理
    public function processAll(Request $request)
    {
        Secretary::where('user_id', Auth::id())->where('status', 0)->update(['watch' => 1, 'status' => 1]);

        return redirect('/secretary');
    }

}
