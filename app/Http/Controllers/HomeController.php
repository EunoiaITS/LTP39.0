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
        $bill = $clients = $users = '';
        $count = 0;
        $total_veh = 0;
        $total_sale = 0;
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
                    $users = User::whereIn('id',$req_clients)->paginate(10);
                }else{
                    $users = User::where('role','client')->paginate(10);
                }
                foreach ($users as $u){
                    $client = Clients::where('user_id',$u->id)
                        ->first();
                    $cio = CheckInOut::where('client_id',$client->id)->get();
                    foreach ($cio as $c){
                        if($c->receipt_id == null){
                            $count++;
                        }
                    }
                    $vcio = VIPCheckInOut::where('client_id',$client->id)->get();
                    foreach ($vcio as $c){
                        if($c->receipt_id == null){
                            $count++;
                        }
                    }
                    $vc = VehicleCategory::where('client_id',$client->id)->get();
                    foreach ($vc as $v){
                        $ps = ParkingSetting::where('vehicle_id',$v->id)->get();
                        foreach ($ps as $p){
                            $total_veh += $p->amount;
                        }
                    }
                }
            }elseif(Auth::user()->role == 'client' || Auth::user()->role == 'manager'){
                $page = 'pages.client.dashboard';
                $js = 'pages.client.js.dashboard-js';
                $id = Auth::id();
                $client = Clients::where('user_id',$id)->first();
                $cio = CheckInOut::where('client_id',$client->id)->get();
                foreach ($cio as $c){
                    if($c->receipt_id == null){
                        $count++;
                    }
                }
                $vcio = VIPCheckInOut::where('client_id',$client->id)->get();
                foreach ($vcio as $c){
                    if($c->receipt_id == null){
                        $count++;
                    }
                }
                $vc = VehicleCategory::where('client_id',$client->id)->get();
                foreach ($vc as $v){
                    $ps = ParkingSetting::where('vehicle_id',$v->id)->get();
                    foreach ($ps as $p){
                        $total_veh += $p->amount;
                    }
                }
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
            'count' => $count,
            'total' => $total_veh,
            'bill' => $bill,
            'clients' => $clients,
            'sale' => $total_sale
        ]);
    }
}
