<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Repository;
use App\Models\Star;
use App\Observers\CommentObserver;
use App\Observers\RepositoryObserver;
use App\Observers\StarObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        \Illuminate\Pagination\Paginator::useBootstrap();
        // Repository::observe(RepositoryObserver::class);
        Comment::observe(CommentObserver::class);
        // Star::observe(StarObserver::class);
    }
}
