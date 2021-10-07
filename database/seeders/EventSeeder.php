<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::insert([
            [ 'event' => 'roleAdd',  'title' => '組織管理', 'content' => '新增<strong>%s</strong>權限。' ],
            [ 'event' => 'roleAdd2', 'title' => '組織管理', 'content' => '新增<strong>%s</strong>的<strong>%s</strong>權限。' ],
            [ 'event' => 'roleDel',  'title' => '組織管理', 'content' => '移除<strong>%s</strong>權限。' ],
            [ 'event' => 'roleDel2', 'title' => '組織管理', 'content' => '移除<strong>%s</strong>的<strong>%s</strong>權限。' ],
        ]);
    }
}