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
            $table->tinyInteger('type')->default(0)->comment('1=總公司;2=分公司');
            $table->string('company_name')->default('')->comment('公司名稱');
            $table->string('company_address')->default('')->comment('公司地址');
            $table->string('company_no', 8)->default('')->index()->comment('公司統一編號');
            $table->string('phone_number', 24)->default('')->comment('公司電話');
            $table->string('company_city', 5)->default('')->comment('縣市ID(對應資料表region)');
            $table->string('company_mail')->default('')->comment('信箱');
            $table->string('company_bank_id')->default('')->comment('公司銀行代號');
            $table->string('company_bank_account')->default('')->comment('公司銀行帳戶');
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(0)->comment('狀態');
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
