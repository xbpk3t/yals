<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique('admin_permissions_name_unique');
            $table->string('slug', 50)->unique('admin_permissions_slug_unique');
            $table->string('http_method')->nullable();
            $table->text('http_path')->nullable();
            $table->timestamps(10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_permission');
    }
}
