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
            $table->string('user_number', 60)->unique()->comment('使用者帳號');
            $table->string('user_password', 60)->comment('使用者密碼');
            $table->datetime('login_time')->nullable()->comment('使用者最後登入時間');
            $table->datetime('sign_out_time')->nullable()->comment('使用者最後登出時間');
            $table->string('name')->default('')->comment('姓名');
            $table->string('id_card')->default('')->comment('身份證');
            $table->string('phone_number')->default('')->comment('手機號碼');
            $table->string('email')->default('')->comment('信箱');
            $table->date('date_employment')->nullable()->comment('到職日期');
            $table->date('date_resignation')->nullable()->comment('離職日期');
            $table->string('reason', 100)->nullable()->comment('離職原因');
            $table->tinyInteger('gender_type')->default(0)->comment('性別0=女;1=男');
            $table->string('counties_city_type', 5)->default('')->comment('縣市ID(對應資料表region)');
            $table->integer('company_id')->default(0)->index()->comment('所屬公司ID(對應資料表company)');
            $table->integer('job_id')->default(0)->comment('職位ID(對應資料表job)');
            $table->string('staff_code', 32)->nullable()->unique()->comment('員工編號');
            $table->datetime('disable_period')->nullable()->comment('議價功能關閉期限');
            $table->string('label_order')->nullable()->comment('初始畫面頁籤');
            $table->tinyInteger('representative')->default(0)->index()->comment('是否為公司負責人0=否;1=是');
            $table->tinyInteger('admin')->default(0)->comment('管理者權限');
            $table->tinyInteger('status')->default(0)->comment('帳號狀態');
            $table->dateTime('created_at', $precision = 0)->nullable()->comment('資料建立時間');
            $table->dateTime('updated_at', $precision = 0)->nullable()->comment('最後更新時間');
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
