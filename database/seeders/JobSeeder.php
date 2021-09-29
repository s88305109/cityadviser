<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::insert([
            [ 'type' => '1', 'job_title' => '董事長',     'status' => 1, 'sort' => 1,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '總經理',     'status' => 1, 'sort' => 2,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '副總經理',   'status' => 1, 'sort' => 3,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '營運長',     'status' => 1, 'sort' => 4,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '預估師',     'status' => 1, 'sort' => 5,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '副估價師',   'status' => 1, 'sort' => 6,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '主估價師',   'status' => 1, 'sort' => 7,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '財務長',     'status' => 1, 'sort' => 8,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '資訊長',     'status' => 1, 'sort' => 9,  'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '客服人員',   'status' => 1, 'sort' => 10, 'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '行政人員',   'status' => 1, 'sort' => 11, 'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '會計人員',   'status' => 1, 'sort' => 12, 'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '行銷總監',   'status' => 1, 'sort' => 13, 'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '1', 'job_title' => '通路區經理', 'status' => 1, 'sort' => 14, 'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '2', 'job_title' => '負責人',     'status' => 1, 'sort' => 15, 'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '2', 'job_title' => '員工',       'status' => 1, 'sort' => 16, 'created_at' => date('Y-m-d H:i:s') ],
            [ 'type' => '2', 'job_title' => '幹部',       'status' => 1, 'sort' => 17, 'created_at' => date('Y-m-d H:i:s') ]
        ]);
    }
}
