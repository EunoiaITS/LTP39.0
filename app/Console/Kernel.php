<?php

namespace App\Console;

use App\CompanyBillingSettings;
use App\CompanyPayment;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
//            $cp = CompanyPayment::all();
//            foreach ($cp as $c){
//                $cbs = CompanyBillingSettings::where('id',$c->billing_id)->get();
//                if(date('Y-m-d') > date('Y-m-d',strtotime($c->bill_due_date))){
//
//                }
//            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
