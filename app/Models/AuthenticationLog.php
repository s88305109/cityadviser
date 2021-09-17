<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthenticationLog extends Model
{
    use HasFactory;

    protected $table = 'authentication_log';
    protected $primaryKey = 'log_id';

    public $timestamps = false;
}
