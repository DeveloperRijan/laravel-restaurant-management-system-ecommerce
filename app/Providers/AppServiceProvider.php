<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Models\FrontendUI;

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

        //share the assets public start path to all views always
        $publicAssetsPathStart = \Config::get("constants.PUBLIC.ASSETS_START_PATH");
        $frontendUIData = FrontendUI::first();

        View::share(['publicAssetsPathStart'=>$publicAssetsPathStart, 'frontendUIData'=>$frontendUIData]);
    }
}
