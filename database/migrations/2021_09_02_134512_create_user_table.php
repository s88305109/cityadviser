<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('user_id')->comment('使用者唯一id');
            $table->string('user_uid', 16)->nullable()->unique()->comment('使用者識別碼');
            $table->string('user_number', 255)->index()->comment('使用者帳號');
            $table->string('user_password', 255)->comment('使用者密碼');
            $table->datetime('login_time')->nullable()->comment('使用者最後登入時間');
            $table->datetime('sign_out_time')->nullable()->comment('使用者最後登出時間');
            $table->tinyInteger('status')->comment('帳號狀態');
            $table->rememberToken()->comment('記住登入狀態');
        });

        DB::statement("ALTER TABLE `user` comment '使用者帳號資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
