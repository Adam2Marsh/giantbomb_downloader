<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observer\VideoObserver;
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
