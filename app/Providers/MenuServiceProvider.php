<?php

namespace App\Providers;

use App\Repositories\Menu\MenuRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('client/*', function ($view) {
            $menuRepository = app(MenuRepository::class);
            $menus = $menuRepository->getActive(); // اینجا فرضاً که تمام داده‌های منو از جدول Menu خوانده می‌شوند
            $view->with('menus', $menus);
        });
    }
}
