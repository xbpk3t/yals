<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTzUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tz_user', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('username');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('password')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps(6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tz_user');
    }
}
