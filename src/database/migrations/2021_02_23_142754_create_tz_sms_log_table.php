<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTzSmsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tz_sms_log', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable()->comment('用户id');
            $table->string('mobile')->nullable();
            $table->string('content')->nullable()->comment('短信内容');
            $table->string('code')->nullable();
            $table->integer('type')->nullable()->comment('短信类型1注册2验证');
            $table->text('response')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tz_sms_log');
    }
}
