<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Setting\SettingRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
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
        View::composer('client/*',function($view){
            $settingRepository = app(SettingRepository::class);
            $data = $settingRepository->getAll();
            $settings = overwriteSetting($data);
            if($settings['Setting_GiftCat'] != null){
                $catRepository = app(CategoryRepository::class);
                $category = $catRepository->getById($settings['Setting_GiftCat']);
                $settings['Gift'] =$category;
            }
            $view->with('settings',$settings);
        });
    }
}
