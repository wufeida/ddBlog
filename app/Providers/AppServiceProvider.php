<?php

namespace App\Providers;

use App\Model\Article;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        $categories = app(CategoryRepository::class)->all();
        $tags = app(TagRepository::class)->all();
        view()->share(compact('categories','tags'));
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
