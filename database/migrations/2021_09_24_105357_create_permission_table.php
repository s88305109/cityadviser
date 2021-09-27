<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission', function (Blueprint $table) {
            $table->id('permission_id')->comment('權限資料ID');
            $table->integer('job_id')->nullable()->index()->comment('職位ID');
            $table->integer('user_id')->nullable()->index()->comment('使用者ID');
            $table->string('permission', 64)->index()->comment('權限名稱');
            $table->string('action')->comment('進階操作權限');
            $table->dateTime('created_at', $precision = 0)->nullable()->comment('資料建立時間');
            $table->dateTime('updated_at', $precision = 0)->nullable()->comment('最後更新時間');
        });

        DB::statement("ALTER TABLE `permission` comment '系統權限資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission');
    }
}
