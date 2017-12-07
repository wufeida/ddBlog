<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->comment('分类id');
            $table->integer('user_id')->unsigned()->comment('用户id');
            $table->integer('last_user_id')->unsigned()->comment('最后修改用户id');
            $table->string('slug')->unique()->comment('url名');
            $table->string('title')->comment('标题');
            $table->string('subtitle')->comment('短标题');
            $table->text('content')->comment('内容');
            $table->string('page_image')->nullable()->comment('封面图片');
            $table->string('meta_description')->nullable()->comment('描述');
            $table->boolean('is_original')->default(false)->comment('是否原创');
            $table->boolean('is_draft')->default(false)->comment('是否草稿');
            $table->boolean('is_recommend')->default(false)->comment('是否推荐');
            $table->integer('sort')->nullable()->unsigned()->comment('排序');
            $table->integer('view_count')->unsigned()->default(0)->index()->comment('查看次数');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
            $table->boolean('flag')->default(false)->comment('markdown和富文本标记1：为markdown');
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
        Schema::dropIfExists('articles');
    }
}
