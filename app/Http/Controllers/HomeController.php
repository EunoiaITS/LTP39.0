<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'pages.home.index';
        if(Auth::user()){
            if(Auth::user()->role == 'owner' || Auth::user()->role == 'dev'){
                $page = 'pages.owner.dashboard';
            }elseif(Auth::user()->role == 'client' || Auth::user()->role == 'manager'){
                $page = 'pages.client.dashboard';
            }
        }else{
            $page = 'pages.home.index';
        }
        return view($page);
    }
}
