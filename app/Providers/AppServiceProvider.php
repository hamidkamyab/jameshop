<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator as PaginationPaginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Repositories\Brand\BrandRepositoryInterface',
            'App\Repositories\Brand\BrandRepository',
        );

        $this->app->bind(
            'App\Repositories\Category\CategoryRepositoryInterface',
            'App\Repositories\Category\CategoryRepository'
        );

        $this->app->bind(
            'App\Repositories\File\FileRepositoryInterface',
            'App\Repositories\File\FileRepository'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PaginationPaginator::useBootstrap();
    }
}
