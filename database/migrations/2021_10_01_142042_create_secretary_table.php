<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecretaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secretary', function (Blueprint $table) {
            $table->id()->comment('事件Id');
            $table->integer('user_id')->index()->comment('使用者ID(對應資料表user)');
            $table->string('event', 32)->default('')->comment('事件類型');
            $table->string('title')->default('')->comment('標題');
            $table->string('content')->default('')->comment('內文');
            $table->datetime('deadline')->nullable()->comment('事件期限');
            $table->integer('item_id')->nullable()->comment('事件項目原資料Id');
            $table->string('url')->default('')->comment('目標連結');
            $table->tinyInteger('watch')->default(0)->comment('狀態0=未讀;1=已讀');
            $table->tinyInteger('status')->default(0)->comment('狀態0=未處理;1=已處理');
        });

        DB::statement("ALTER TABLE `secretary` comment '小秘書資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secretary');
    }
}
