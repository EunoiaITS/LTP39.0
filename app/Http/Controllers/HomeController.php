<?php

namespace App\Http\Controllers;

use App\VehicleCategory;
use Illuminate\Http\Request;
use Auth;
use App\Clients;
use App\CompanyBillingSettings;
use App\CheckInOut;
use App\VIPCheckInOut;
use App\ParkingSetting;
use App\User;
use App\Managers;

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
    public function index(Request $request)
    {
        $page = 'pages.home.index';
        $js = 'pages.owner.js.dashboard-js';
        $bill = $clients = $users = $client = '';
        $total_sale = 0;
        $count_cli = 0;
        $total_veh_cli = 0;
        $all_clients = User::where('role','client')->get();
        if(Auth::user()){
            if(Auth::user()->role == 'owner' || Auth::user()->role == 'dev'){
                $page = 'pages.owner.dashboard';
                $js = 'pages.owner.js.dashboard-js';
                $clients = Clients::all()->count();
                $bill = 0;
                $cbs = CompanyBillingSettings::all();
                foreach ($cbs as $c){
                    $bill += $c->billing_amount;
                }
                if(isset($request->clients)){
                    $req_clients = explode(',',$request->clients);
                    $users = User::whereIn('id',$req_clients)->paginate(9);
                }else{
                    $users = User::where('role','client')->paginate(9);
                }
                foreach ($users as $u){
                    $count = 0;
                    $total_veh = 0;
                    $client = Clients::where('user_id',$u->id)
                            ->first();
                    $cio = CheckInOut::where('client_id',$client->user_id)->get();
                    foreach ($cio as $c){
                        if($c->receipt_id === null){
                            $count++;
                        }
                    }
                    $vcio = VIPCheckInOut::where('client_id',$client->user_id)->get();
                    foreach ($vcio as $c){
                        if($c->receipt_id === null){
                            $count++;
                        }
                    }
                    $u->occupied = $count;
                    $ps = ParkingSetting::where('client_id',$client->user_id)->get();
                    foreach ($ps as $p){
                        $total_veh += $p->amount;
                    }
                    $u->total = $total_veh;
                }
            }elseif(Auth::user()->role == 'client' || Auth::user()->role == 'manager'){
                $page = 'pages.client.dashboard';
                $js = 'pages.client.js.dashboard-js';
                $id = Auth::id();
                if(Auth::user()->role == 'manager'){
                    $mngr = Managers::where('user_id', Auth::id())->first();
                    $id = $mngr->client_id;
                }
                $client = Clients::where('user_id',$id)->first();
                $cio = CheckInOut::where('client_id',$id)->get();
                foreach ($cio as $c){
                    if($c->receipt_id === null){
                        $count_cli++;
                    }
                }
                $vcio = VIPCheckInOut::where('client_id',$id)->get();
                foreach ($vcio as $c){
                    if($c->receipt_id === null){
                        $count_cli++;
                    }
                }
                $client->occupied = $count_cli;
                $ps = ParkingSetting::where('client_id',$id)->get();
                foreach ($ps as $p){
                    $total_veh_cli += $p->amount;
                }
                $client->total = $total_veh_cli;
                $cio = CheckInOut::where('client_id',$id)->get();
                foreach ($cio as $cb){
                    $total_sale += $cb->fair;
                }
            }
        }else{
            $page = 'pages.home.index';
        }
        return view($page,[
            'js' => $js,
            'users' => $users,
            'bill' => $bill,
            'clients' => $clients,
            'client' => $client,
            'sale' => $total_sale,
            'all_clients' => $all_clients
        ]);
    }
}
