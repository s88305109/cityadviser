<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

}
