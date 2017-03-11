<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsAndRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('is_admin');
            $table->string('status');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('status');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('access', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('urls');
            $table->string('status');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('role_id');
            $table->timestamps();
        });

        Schema::create('role_access', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('access_id');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role');
        Schema::drop('user');
        Schema::drop('role_access');
        Schema::drop('user_role');
    }
}
