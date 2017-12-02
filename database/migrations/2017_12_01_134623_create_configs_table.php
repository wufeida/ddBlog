<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('博客名称');
            $table->string('default_icon')->nullable()->comment('favicon.ico文件');
            $table->boolean('water_status')->default(true)->comment('水印开关');
            $table->string('water_text')->nullable()->comment('水印文字');
            $table->string('meta_title')->nullable()->comment('seo标题');
            $table->string('meta_keywords')->nullable()->comment('seo关键字');
            $table->string('meta_description')->nullable()->comment('seo描述');
            $table->string('article_title')->nullable()->comment('文章页标题');
            $table->string('article_description')->nullable()->comment('文章页描述');
            $table->integer('article_number')->unsigned()->comment('文章显示条数');
            $table->string('article_sort')->nullable()->comment('文章顺序 desc倒序 asc正序');
            $table->string('article_sortColumn')->nullable()->comment('文章排序字段');
            $table->boolean('footer_github_status')->default(true)->comment('底部github图标开关');
            $table->string('footer_github_url')->nullable()->comment('底部github图标地址');
            $table->boolean('footer_qq_status')->default(true)->comment('底部qq图标开关');
            $table->string('footer_qq_url')->nullable()->comment('底部qq图标地址');
            $table->string('license')->nullable()->comment('底部版权信息');
            $table->text('value')->nullable()->comment('配置项键值');
            $table->boolean('status')->default(true)->comment('配置项开关');
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
        Schema::dropIfExists('configs');
    }
}
