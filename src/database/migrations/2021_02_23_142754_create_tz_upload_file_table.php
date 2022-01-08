<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTzUploadFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tz_upload_file', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('filename')->nullable()->comment('文件名');
            $table->string('category')->nullable();
            $table->string('ext')->nullable()->comment('文件后缀');
            $table->string('url')->nullable()->comment('七牛云url');
            $table->string('size')->nullable()->comment('文件大小');
            $table->string('md5')->nullable();
            $table->string('mime_type')->nullable()->comment('文件mime_type');
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
        Schema::drop('tz_upload_file');
    }
}
