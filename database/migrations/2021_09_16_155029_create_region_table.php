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
