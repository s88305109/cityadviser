<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job', function (Blueprint $table) {
            $table->id('job_id')->comment('職位ID');
            $table->tinyInteger('type')->comment('1=總公司;2=分公司');
            $table->string('job_title', 20)->comment('職稱');
            $table->integer('sort')->comment('排序');
            $table->tinyInteger('status')->comment('狀態');
            $table->dateTime('created_at', $precision = 0)->nullable()->comment('資料建立時間');
            $table->dateTime('updated_at', $precision = 0)->nullable()->comment('最後更新時間');
        });

        DB::statement("ALTER TABLE `job` comment '職位資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job');
    }
}
