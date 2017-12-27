<?php

namespace App\Providers;

use App\Http\Controllers\Admin\ConfigController;
use App\Model\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\LinkRepository;
use App\Repositories\TagRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //解决数据库迁移时报字段过长的错
        Schema::defaultStringLength(191);
        \Carbon\Carbon::setLocale('zh');
        Relation::morphMap([
            'articles'    => Article::class,
        ]);

        view()->composer('home/*', function(){
            //分类
            $categories = Cache::remember('home-category', config('blog.cache.common'), function () {
                return app(CategoryRepository::class)->all();
            });
            //标签
            $tags = Cache::remember('home-tag', config('blog.cache.common'), function () {
                return app(TagRepository::class)->all();
            });
            //推荐
            $recommend = Cache::remember('home-recommend', config('blog.cache.common'), function () {
                return app(ArticleRepository::class)->getRecommend();
            });
            //友链
            $links = Cache::remember('home-link', config('blog.cache.common'), function () {
                return app(LinkRepository::class)->getHomeLink();
            });
            //最新评论
            $comment = Cache::remember('home-comment', config('blog.cache.common'), function () {
                return app(CommentRepository::class)->getNewComment(20);
            });

            view()->share(compact('categories','tags', 'recommend', 'links', 'comment'));
        });

        //全局通用变量
        view()->composer('*', function () {
            //配置内容 已有缓存 此处不加
            $config = app(ConfigController::class)->getConfig();
            view()->share(compact('config'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
