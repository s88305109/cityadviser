<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region', function (Blueprint $table) {
            $table->string('region_id', 5)->primary()->comment('省縣市代碼');
            $table->string('area', 20)->index()->comment('地區');
            $table->string('title', 20)->comment('縣市名稱');
            $table->integer('sort')->comment('排序');
            $table->dateTime('created_at', $precision = 0)->nullable()->comment('資料建立時間');
            $table->dateTime('updated_at', $precision = 0)->nullable()->comment('最後更新時間');
        });

        DB::statement("ALTER TABLE `region` comment '行政區劃資料'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region');
    }
}
