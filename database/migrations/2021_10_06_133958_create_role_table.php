<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id('role_id')->comment('權限Id');
            $table->integer('parent')->nullable()->index()->comment('上層Id');
            $table->string('role')->default('')->comment('代號');
            $table->string('title')->default('')->comment('標題');
            $table->tinyInteger('type')->default(0)->comment('類型:1=總公司;2=分公司');
            $table->integer('sort')->default(0)->comment('排序');

            $table->unique(['type', 'role']);
        });

        DB::statement("ALTER TABLE `role` comment '權限資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
}
