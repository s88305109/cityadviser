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

    // 取得公司區域 (若該區域無公司資料則不返回)
    public static function getAreas($area = '北部')
    {
        $areas = ['北部', '中部', '南部', '東部', '離島'];

        foreach($areas as $key => $value) {
            if (Company::join('region', 'region.region_id', '=', 'company.company_city')->where('type', 2)->where('region.area', $value)->count() == 0)
                unset($areas[$key]);
        }

        return $areas;
    }

    // 取得區域內公司人數資料
    public static function getAreaRecord($area = '北部')
    {
        $companys = Company::join('region', 'company_city', '=', 'region.region_id')
                ->where('company.type', 2)
                ->where('region.area', $area)
                ->orderBy('company.sort', 'desc')
                ->get();

        foreach($companys as $key => $row) {
            $companys[$key]['count'] = User::getCompanyCount($row->company_id);
            $companys[$key]['principal_name'] = (! empty($row->principal)) ? User::where('user_id', $row->principal)->first()->name : null;
        }

        return $companys;
    }

}
