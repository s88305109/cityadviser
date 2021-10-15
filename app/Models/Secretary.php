<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Secretary extends Model
{
    use HasFactory;

    protected $table = 'secretary';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function getDeadlineAttribute($value)
    {
        return (is_null($value)) ? null : Carbon::parse($value)->diffForHumans();
    }

    // 取得當前登入者的小秘書事件
    public static function getEvents($status = 0, $per = 10, $page = 1)
    {
        $offset = ($page - 1) * $per;

        $events = Secretary::join('event', 'event.event', '=', 'secretary.event')
            ->select('secretary.*', 'event.title', 'event.content')
            ->where('user_id', Auth::id())
            ->where('status', $status)
            ->when($status == 1, function ($query) {
                return $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-14 days')));   // 已處理的事件只顯示14天內
            })
            ->orderByRaw('ISNULL(deadline), deadline ASC')
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($per)
            ->get();

        foreach($events as $key => $row) {
            if($row->status == 1)
                $events[$key]['index'] = 0;
            else if (empty($row->deadline))
                $events[$key]['index'] = 1;
            else
                $events[$key]['index'] = 2;
        }

        return $events;
    }

    // 建立事件
    public static function createEvent($user_id, $event, $parameter, $deadline = null, $item_id = null, $url = '')
    {
        $secretary = new Secretary();
        $secretary->user_id    = $user_id;
        $secretary->event      = $event;
        $secretary->parameter  = json_encode($parameter, JSON_UNESCAPED_UNICODE);
        $secretary->deadline   = $deadline;
        $secretary->item_id    = $item_id;
        $secretary->url        = $url;
        $secretary->created_at = date('Y-m-d H:i:s');
        $secretary->save();
    }

    // 取得未讀數量
    public static function getUnreadCount()
    {
        $count = Secretary::where('user_id', Auth::id())
            ->where('status', 0)
            ->where('watch', 0)
            ->count();

        return $count;
    }

    // 刪除已處理且超過14天的事件
    public static function removeExpire()
    {
        Secretary::where('user_id', Auth::id())
            ->where('status', 1)
            ->where('created_at', '<=', date('Y-m-d H:i:s', strtotime('-14 days')))
            ->delete();
    }

}
