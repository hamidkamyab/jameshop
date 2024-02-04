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

        $this->app->bind(
            'App\Repositories\AttributeGroup\AttributeGroupRepositoryInterface',
            'App\Repositories\AttributeGroup\AttributeGroupRepository'
        );

        $this->app->bind(
            'App\Repositories\AttributeValue\AttributeValueRepositoryInterface',
            'App\Repositories\AttributeValue\AttributeValueRepository'
        );

        $this->app->bind(
            'App\Repositories\Menu\MenuRepositoryInterface',
            'App\Repositories\Menu\MenuRepository'
        );

        $this->app->bind(
            'App\Repositories\BestMenu\BestMenuRepositoryInterface',
            'App\Repositories\BestMenu\BestMenuRepository'
        );

        $this->app->bind(
            'App\Repositories\Color\ColorRepositoryInterface',
            'App\Repositories\Color\ColorRepository'
        );

        $this->app->bind(
            'App\Repositories\Size\SizeRepositoryInterface',
            'App\Repositories\Size\SizeRepository'
        );

        $this->app->bind(
            'App\Repositories\Product\ProductRepositoryInterface',
            'App\Repositories\Product\ProductRepository'
        );

        $this->app->bind(
            'App\Repositories\Slider\SliderRepositoryInterface',
            'App\Repositories\Slider\SliderRepository'
        );

        $this->app->bind(
            'App\Repositories\Amazing\AmazingRepositoryInterface',
            'App\Repositories\Amazing\AmazingRepository'
        );

        $this->app->bind(
            'App\Repositories\Style\StyleRepositoryInterface',
            'App\Repositories\Style\StyleRepository'
        );

        $this->app->bind(
            'App\Repositories\Category_Tab\CategoryTabRepositoryInterface',
            'App\Repositories\Category_Tab\CategoryTabRepository'
        );

        $this->app->bind(
            'App\Repositories\Beauty\BeautyRepositoryInterface',
            'App\Repositories\Beauty\BeautyRepository'
        );

        $this->app->bind(
            'App\Repositories\Country\CountryRepositoryInterface',
            'App\Repositories\Country\CountryRepository'
        );

        $this->app->bind(
            'App\Repositories\TopBrand\TopBrandRepositoryInterface',
            'App\Repositories\TopBrand\TopBrandRepository'
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
