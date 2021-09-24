<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $primaryKey = 'company_id';

    public function region()
    {
        return $this->hasOne(Region::class, 'region_id', 'company_city');
    }

    public static function getAreaRecord($area = '北部')
    {
        $companys = Company::join('region', 'company_city', '=', 'region.region_id')
                ->where('company.type', 2)
                ->where('region.area', $area)
                ->orderBy('company.sort', 'desc')
                ->get();

        return $companys;
    }

}
