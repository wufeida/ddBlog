<?php

namespace App\Providers;

use App\Model\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\LinkRepository;
use App\Repositories\TagRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
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
        \Carbon\Carbon::setLocale('zh');
        Relation::morphMap([
            'articles'    => Article::class,
        ]);

        view()->composer('home/*', function(){
            //分类
            $categories = Cache::remember('home-category', 10080, function () {
                return app(CategoryRepository::class)->all();
            });
            //标签
            $tags = Cache::remember('home-tag', 10080, function () {
                return app(TagRepository::class)->all();
            });
            //推荐
            $recommend = Cache::remember('home-recommend', 10080, function () {
                return app(ArticleRepository::class)->getRecommend();
            });
            //友链
            $links = Cache::remember('home-link', 10080, function () {
                return app(LinkRepository::class)->all();
            });
            //最新评论
            $comment = Cache::remember('home-comment', 10080, function () {
                return app(CommentRepository::class)->getNewComment(20);
            });
            view()->share(compact('categories','tags', 'recommend', 'links', 'comment'));
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
