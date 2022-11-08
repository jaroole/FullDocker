<?php

namespace App\Providers;

use App\Telegram\Telegram;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
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
        $this->app->bind(Telegram::class,function(){
            return new Telegram(new Http());

        });
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('date',date('Y'));
        View::composer('user*',function($view)
        {
            $view->with('balance', 12345);
        });
    }
}
