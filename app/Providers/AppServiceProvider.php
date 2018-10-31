<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Clients;
use App\CompanyBillingSettings;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        app('view')->composer('layout', function ($view) {
            $action = app('request')->route()->getAction();

            $controller = class_basename($action['controller']);

            list($controller, $action) = explode('@', $controller);

            $view->with(compact('controller', 'action'));
        });
        $clients = Clients::all()->count();
        View::share('clients',$clients);
        $bill = 0;
        $cbs = CompanyBillingSettings::all();
        foreach ($cbs as $c){
            $bill += $c->billing_amount;
        }
        View::share('bill',$bill);
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
