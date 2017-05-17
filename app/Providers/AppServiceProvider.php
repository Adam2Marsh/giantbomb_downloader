<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observer\VideoObserver;
use Validator;
use App\Video;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Video::observe(VideoObserver::class);

        Validator::extend('directory', 'App\Http\Requests\CustomValidator@validateDirectoryExists');
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
