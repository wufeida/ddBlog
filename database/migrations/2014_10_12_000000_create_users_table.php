<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->text('avatar')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('status')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->string('password')->nullable();
            $table->tinyInteger('email_notify')->default(true)->index();
            $table->tinyInteger('type')->nullable();
            $table->string('openid');
            $table->string('login_ip');
            $table->integer('login_times');
            $table->string('description');
            $table->timestamp('last_time');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
