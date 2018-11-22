<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Maintenance extends Controller
{
    public function installPassport(Request $request){
        $call = \Artisan::call("passport:install --force");
        return $call;
    }
}
