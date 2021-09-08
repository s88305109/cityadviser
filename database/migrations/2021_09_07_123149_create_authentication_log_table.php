<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthenticationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authentication_log', function (Blueprint $table) {
            $table->id('log_id')->comment('LOG ID');
            $table->integer('user_id')->index()->comment('使用者ID');
            $table->string('action', 32)->comment('動作');
            $table->datetime('log_time')->index()->comment('紀錄時間');
        });

        DB::statement("ALTER TABLE `authentication_log` comment '使用者登入驗證紀錄'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authentication_log');
    }
}
