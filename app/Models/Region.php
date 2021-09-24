<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'region';
    protected $primaryKey = 'region_id';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_city');
    }
}
