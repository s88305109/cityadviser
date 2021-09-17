<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id('company_id')->comment('公司ID');
            $table->tinyInteger('type')->comment('1=總公司;2=分公司');
            $table->string('company_name', 20)->comment('職稱');
            $table->integer('sort')->comment('排序');
            $table->tinyInteger('status')->comment('狀態');
            $table->dateTime('created_at', $precision = 0)->nullable()->comment('資料建立時間');
            $table->dateTime('updated_at', $precision = 0)->nullable()->comment('最後更新時間');
        });

        DB::statement("ALTER TABLE `company` comment '公司資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
