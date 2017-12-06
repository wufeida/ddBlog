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
            $table->string('name')->comment('用户名');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->text('avatar')->nullable()->comment('头像');
            $table->string('email')->nullable()->comment('邮箱');
            $table->tinyInteger('status')->default(true)->comment('状态');
            $table->boolean('is_admin')->default(false)->comment('是否管理员');
            $table->string('password')->nullable()->comment('密码');
            $table->tinyInteger('email_notify')->default(true)->index()->comment('邮箱通知开关');
            $table->tinyInteger('type')->nullable()->comment('登录类型1：qq2：微博3：github');
            $table->string('openid')->default('')->comment('第三方唯一id');
            $table->string('login_ip')->default('')->comment('最后登录ip');
            $table->integer('login_times')->default(0)->comment('登录次数');
            $table->string('description')->default('')->comment('描述');
            $table->timestamp('last_time')->nullable()->comment('最后登录时间');
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
