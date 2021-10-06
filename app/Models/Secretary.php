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

        $events = Secretary::where('user_id', Auth::id())
            ->where('status', $status)
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

    public static function createEvent($user_id, $event, $title, $content, $deadline = null, $item_id = null, $url = '')
    {
        $secretary = new Secretary();
        $secretary->user_id  = $user_id;
        $secretary->event    = $event;
        $secretary->title    = $title;
        $secretary->content  = $content;
        $secretary->deadline = $deadline;
        $secretary->item_id  = $item_id;
        $secretary->url      = $url;
        $secretary->save();
    }

}
