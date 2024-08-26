<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('profile_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('avatar')->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->dateTime('birthday')->nullable();
            $table->integer('score')->default(0);
            $table->integer('point_kimto')->default(0);
            $table->integer('point_mochi')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}