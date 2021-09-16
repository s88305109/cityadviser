<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('region')->insert([
            [ 'region_id' => '63000', 'area' => '北部', 'title' => '臺北市', 'sort' => 0 ],
            [ 'region_id' => '64000', 'area' => '南部', 'title' => '高雄市', 'sort' => 1 ],
            [ 'region_id' => '65000', 'area' => '北部', 'title' => '新北市', 'sort' => 2 ],
            [ 'region_id' => '66000', 'area' => '中部', 'title' => '臺中市', 'sort' => 3 ],
            [ 'region_id' => '67000', 'area' => '南部', 'title' => '臺南市', 'sort' => 4 ],
            [ 'region_id' => '68000', 'area' => '北部', 'title' => '桃園市', 'sort' => 5 ],
            [ 'region_id' => '10002', 'area' => '東部', 'title' => '宜蘭縣', 'sort' => 6 ],
            [ 'region_id' => '10004', 'area' => '北部', 'title' => '新竹縣', 'sort' => 7 ],
            [ 'region_id' => '10005', 'area' => '中部', 'title' => '苗栗縣', 'sort' => 8 ],
            [ 'region_id' => '10007', 'area' => '中部', 'title' => '彰化縣', 'sort' => 9 ],
            [ 'region_id' => '10008', 'area' => '中部', 'title' => '南投縣', 'sort' => 10 ],
            [ 'region_id' => '10009', 'area' => '中部', 'title' => '雲林縣', 'sort' => 11 ],
            [ 'region_id' => '10010', 'area' => '南部', 'title' => '嘉義縣', 'sort' => 12 ],
            [ 'region_id' => '10013', 'area' => '南部', 'title' => '屏東縣', 'sort' => 13 ],
            [ 'region_id' => '10014', 'area' => '東部', 'title' => '臺東縣', 'sort' => 14 ],
            [ 'region_id' => '10015', 'area' => '東部', 'title' => '花蓮縣', 'sort' => 15 ],
            [ 'region_id' => '10016', 'area' => '離島', 'title' => '澎湖縣', 'sort' => 16 ],
            [ 'region_id' => '10017', 'area' => '北部', 'title' => '基隆市', 'sort' => 17 ],
            [ 'region_id' => '10018', 'area' => '北部', 'title' => '新竹市', 'sort' => 18 ],
            [ 'region_id' => '10020', 'area' => '北部', 'title' => '嘉義市', 'sort' => 19 ],
            [ 'region_id' => '09007', 'area' => '離島', 'title' => '連江縣', 'sort' => 20 ],
            [ 'region_id' => '09020', 'area' => '離島', 'title' => '金門縣', 'sort' => 21 ]
        ]);
    }
}
