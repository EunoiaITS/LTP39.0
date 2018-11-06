<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Clients;
use App\User;
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
        $users = User::where('role','client')->get();
        View::share('users',$users);
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
