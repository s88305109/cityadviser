<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_setting', function (Blueprint $table) {
            $table->string('system', 255)->comment('系統模組');
            $table->text('system_desc')->comment('系統模組描述');
            $table->string('code', 255)->primary()->comment('參數名稱');
            $table->text('code_desc')->comment('參數名稱描述');
            $table->text('value')->comment('參數值');
        });

        DB::statement("ALTER TABLE `system_setting` comment '系統設定參數'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_setting');
    }
}
