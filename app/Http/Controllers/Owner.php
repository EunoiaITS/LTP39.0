<?php

namespace App\Http\Controllers;



use App\CheckInOut;
use App\Clients;
use App\CompanyDevice;
use App\CompanyBillingSettings;
use App\CompanyPayment;
use App\Managers;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class Owner extends Controller
{

    public function dashboard(){
        $page = 'pages.client.dashboard';
        if(Auth::user()->role == 'owner' || Auth::user()->role == 'dev'){
            $page = 'pages.owner.dashboard';
        }
        return view($page);
    }
    /**
     * CreateClient - function for creating clients
     * param - request - takes all the post request data
     */
    public function createClient(Request $request){
        if($request->isMethod('post')){
            $errors = array();
            if($request->password != $request->repass){
                $errors[] = 'Password didn\'t match.';
            }

            $user = new User();
            $client = new Clients();

            if(!$user->validate($request->all())){
                $user_e = $user->errors();
                foreach ($user_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(!$client->validate($request->all())){
                $client_e = $client->errors();
                foreach ($client_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(empty($errors)){
                $year = date('Y');
                $type = '';
                $name = '';
                if($request->client_type == 'park'){
                    $type = '01';
                }else{
                    $type = '02';
                }
                $name_array = explode(' ',$request->name);
                if(isset($name_array[0]) && isset($name_array[1])){
                    $name = $name_array[0][0].$name_array[1][0];
                    $name1 = $name_array[0][0].$name_array[0][1].$name_array[1][0];
                    $client_id = $name.$type.$year;
                    $client_id1 = $name1.$type.$year;
                }else{
                    $name = $name_array[0][0].$name_array[0][1];
                    $client_id = $name.$type.$year;
                }
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->role = 'client';
                $user->status = 'dev';

                if($user->save()){
                    $client->user_id = $user->id;
                    if(Clients::where('client_id',$client_id)->first()){
                        $client->client_id = $client_id1;
                    }else{
                        $client->client_id = $client_id;
                    }
                    $client->client_type = $request->client_type;
                    $client->phone = $request->phone;
                    if($request->hasFile('file')) {
                        $image = $request->file('file');
                        $name = str_slug($user->id).'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads/clients/payment_files');
                        $image->move($destinationPath, $name);
                        $client->payment_file = $name;
                    }
                    if($client->save()){
                        return redirect()
                            ->to('/create-client')
                            ->with('success', 'The client was created successfully!!');
                    }else{
                        User::destroy($user->id);
                        return redirect()
                            ->to('/create-client')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/create-client')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }else{
                return redirect()
                    ->to('/create-client')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
        return view('pages.owner.create-client',[
            'js' => 'pages.owner.js.create-client-js'
        ]);
    }

    /**
     * all clients - function to show all clients
     **/
    public function allClients(Request $request){
        $clients = Clients::where('client_type',$request->type)
            ->orderBy('id','desc')
            ->get();
        foreach($clients as $client){
            $client->data = User::find($client->user_id);
        }

        if($request->isMethod('post')){
            if($request->action == 'delete'){
                $client = Clients::where('user_id',$request->client_id)->first();
                if(User::destroy($client->user_id)){
                    Clients::destroy($client->id);
                    return redirect()
                        ->to('/clients-list')
                        ->with('success', 'The client was '.$request->action.'ed successfully!');
                }else{
                    return redirect()
                        ->to('/clients-list')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
            if($request->action == 'blocking'){
                $stat = User::find($request->client_id);
                $stat->status = $request->status;
                if($stat->save()){
                    return redirect()
                        ->to('/clients-list')
                        ->with('success', 'The client was '.$request->status.'ed successfully!');
                }else{
                    return redirect()
                        ->to('/clients-list')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }

        return view('pages.owner.clients-list', [
            'clients' => $clients,
            'type' => $request->type,
            'modal' => 'pages.owner.modals.client-list-modals',
            'js' => 'pages.owner.js.client-list-js'
        ]);
    }

    /*******************************************************
     * client details - function to show details of a client
     ******************************************************/
    public function clientDetails(Request $request){
        if(!isset($request->client_id)){
            abort(404);
        }

        $client = Clients::where('client_id', $request->client_id)->first();
        if(empty($client)){
            abort(404);
        }
        $client->data = User::find($client->user_id);
        $managers = Managers::where('client_id', $client->user_id)->get();
        foreach($managers as $manager){
            $manager->data = User::find($manager->user_id);
        }

        $devices = CompanyDevice::where('status', 'unassigned')->get();
        $assigned_devices = CompanyDevice::where('status', 'assigned')
            ->where('client_id', $client->id)
            ->get();

        if($request->isMethod('post')){
            /**
             * password reset section
             */
            if($request->action == 'pass'){
                $pass_e = array();
                if($request->password != $request->repass){
                    $pass_e[] = 'Password didn\'t match.';
                }
                if(empty($pass_e)){
                    $edit_pass = User::find($client->user_id);
                    $edit_pass->password = bcrypt($request->password);
                    if($edit_pass->save()){
                        return redirect()
                            ->to('/client-details?client_id='.$client->client_id)
                            ->with('success', 'Password was reset successfully!');
                    }else{
                        return redirect()
                            ->to('/client-details?client_id='.$client->client_id)
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }
                else{
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('errors', $pass_e);
                }
            }
            /**
             * edit client info section
             */
            if($request->action == 'edit-data'){
                $client = Clients::where('client_id', $request->client_id)->first();
                $client->phone = $request->phone;
                if($request->hasFile('file')) {
                    $image = $request->file('file');
                    $name = str_slug($client->user_id).'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/clients/payment_files');
                    $image->move($destinationPath, $name);
                    $client->payment_file = $name;
                }
                if($client->save()){
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('success', 'Info was edited successfully!');
                }else{
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
            /**
             * create managers section
             */
            if($request->action == 'crt-mngr'){
                $id = Auth::id();
                $mngr = new User();
                $mngr_data = new Managers();
                $errors_m = array();
                $lastMngId = sprintf('%03d', 1);
                $lastMng = Managers::where('client_id', $id)
                    ->orderBy('id', 'DESC')
                    ->first();
                if(!empty($lastMng) && (int)(substr($lastMng->manager_id, -3)) >= 1){
                    $lastMngId = sprintf('%03d', (int)(substr($lastMng->manager_id, -3)) + 1);
                }

                if($request->password != $request->repass){
                    $errors_m[] = 'Password didn\'t match.';
                }

                if(!$mngr->validate($request->all())){
                    $mngr_e = $mngr->errors();
                    foreach ($mngr_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors_m[] = $e;
                        }
                    }
                }

                if(!$mngr_data->validate($request->all())){
                    $mngr_data_e = $mngr_data->errors();
                    foreach ($mngr_data_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors_m[] = $e;
                        }
                    }
                }

                if(empty($errors_m)){
                    $mngr->name = $request->name;
                    $mngr->email = $request->email;
                    $mngr->password = bcrypt($request->password);
                    $mngr->role = $request->role;
                    $mngr->status = 'active';
                    if($mngr->save()){
                        $mngr_data->user_id = $mngr->id;
                        $mngr_data->client_id = $client->user_id;
                        $mngr_data->manager_id = 'Mng'.$lastMngId;
                        $mngr_data->phone = $request->phone;
                        if($mngr_data->save()){
                            return redirect()
                                ->to('/client-details?client_id='.$client->client_id)
                                ->with('success_m', 'Manager created successfully!');
                        }else{
                            User::destroy($mngr->id);
                            return redirect()
                                ->to('/client-details?client_id='.$client->client_id)
                                ->with('error_m', 'Something went wrong! Please try again!');
                        }
                    }else{
                        return redirect()
                            ->to('/client-details?client_id='.$client->client_id)
                            ->with('error_m', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('errors', $errors_m)
                        ->withInput();
                }
            }
            /**
             * edit managers section
             */
            if($request->action == 'edit-mngr'){
                $edit_e = array();
                if($request->password != $request->repass){
                    $edit_e[] = 'Password didn\'t match!';
                }
                if($request->password != null && strlen($request->password) < 6){
                    $edit_e[] = 'Password has to be at least 6 digits long!';
                }
                if(empty($edit_e)){
                    $edit_m = Managers::find($request->manager_id);
                    $edit_m->phone = $request->phone;
                    $edit_m->save();
                    $edit_u = User::find($edit_m->user_id);
                    $edit_u->name = $request->name;
                    if($request->password != null){
                        $edit_u->password = bcrypt($request->password);
                    }
                    $edit_u->save();
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('success_m', 'Manager edited successfully!');
                }else{
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('errors', $edit_e)
                        ->withInput();
                }
            }
            /**
             * delete managers section
             */
            if($request->action == 'delete-mngr'){
                $delete_m = Managers::find($request->manager_id);
                if(User::destroy($delete_m->user_id)){
                    Managers::destroy($request->manager_id);
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('success_m', 'Manager deleted successfully!');
                }else{
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('error_m', 'Something went wrong! Please try again!');
                }
            }
            /**
             * block managers section
             */
            if($request->action == 'stat-mngr'){
                $stat_m = Managers::find($request->manager_id);
                $stat = User::find($stat_m->user_id);
                $stat->status = $request->status;
                if($stat->save()){
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('success_m', 'The manager was '.$request->status.'ed successfully!');
                }else{
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('error_m', 'Something went wrong! Please try again!');
                }
            }
            /**
             * assign devices section
             */
            if($request->action == 'dev'){
                foreach($request->devices as $dev){
                    $assign = CompanyDevice::where('device_id', $dev)->first();
                    $assign->client_id = $client->id;
                    $assign->status = 'assigned';
                    $assign->save();
                }
                return redirect()
                    ->to('/client-details?client_id='.$client->client_id)
                    ->with('success_d', 'Devices were added successfully!');
            }
            /**
             * unassign devices section
             */
            if($request->action == 'remove'){
                $unassign = CompanyDevice::find($request->device_id);
                $unassign->client_id = null;
                $unassign->status = 'unassigned';
                $unassign->save();
                return redirect()
                    ->to('/client-details?client_id='.$client->client_id)
                    ->with('success_d', 'Device was removed successfully!');
            }
        }

        return view('pages.owner.client-details', [
            'client' => $client,
            'managers' => $managers,
            'devices' => $devices,
            'assigned' => $assigned_devices,
            'js' => 'pages.owner.js.client-details-js',
            'modal' => 'pages.owner.modals.client-details-modal'
        ]);
    }

    /**
     * CreateDevice - function for creating devices
     * param - request - takes all the post request data
     */
    public function createDevice(Request $request){
        $id = Auth::user()->id;
        $cd = new CompanyDevice();
        $lastDevId = sprintf('%03d', 1);
        $lastDev = CompanyDevice::orderBy('id', 'desc')
            ->first();
        if(!empty($lastDev) && (int)(substr($lastDev->device_id, -3)) >= 1){
            $lastDevId = sprintf('%03d', (int)(substr($lastDev->device_id, -3)) + 1);
        }
        if($request->isMethod('post')){
            $errors = array();
            if(!$cd->validate($request->all())){
                $cd_e = $cd->errors();
                foreach ($cd_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }
            if(empty($errors)){
                //dd($request->all());
                $cd->device_id = 'DEV'.$lastDevId;
                $cd->factory_id = $request->factory_id;
                $cd->charger_id = $request->charger_id;
                $cd->created_by = $id;
                $cd->modified_by = 'MOD';
                $cd->status = 'unassigned';
                if($cd->save()){
                    return redirect()
                        ->to('/create-device')
                        ->with('success', 'The device was created successfully!!');
                }else{
                    return redirect()
                        ->to('/create-device')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }else{
                return redirect()
                    ->to('/create-device')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
        return view('pages.owner.create-device');
    }


    /**
     * ManageDevice view,edit - function for managing devices
     * param - request - takes all the post request data
     */
    public function manageDevice(Request $request){
        $devices = CompanyDevice::orderBy('id','desc')->get();
        foreach($devices as $dv){
            $clients = Clients::where('id', $dv->client_id)->get();
            foreach ($clients as $client){
                $dv->client = $client->client_id;
                $user = User::find($client->user_id);
                $dv->name = $user->name;
            }
        }
        if($request->isMethod('post')){
            $cd = CompanyDevice::find($request->device_id);
            $cd->charger_id = $request->charger_id;
            if($cd->save()){
                return redirect()
                    ->to('/manage-device')
                    ->with('success', 'The device was edited successfully!!');
            }else{
                return redirect()
                    ->to('/manage-device')
                    ->with('error', 'Something went wrong! Please try again!');
            }
        }
        return view('pages.owner.manage-device',[
            'modal' => 'pages.owner.modals.manage-device-modal',
            'devices' => $devices
        ]);
    }


    /**
     * ManageDevice delete - function for managing devices
     * param - request - takes all the post request data
     */
    public function deleteDevice(Request $request){
        if($request->isMethod('post')){
            CompanyDevice::destroy($request->device_id);
            return redirect()
                ->to('/manage-device')
                ->with('success', 'Device deleted successfully!!');
        }else{
            return redirect()
                ->to('/manage-device')
                ->with('error', 'Method not allowed!!');
        }
    }

    /**
     * Billing Create - function for Create billing
     * param - request - takes all the post request data
     */
    public function createBilling(Request $request){
        $clients = Clients::all();
        $lastBillId = sprintf('%03d', 1);
        $lastBill = CompanyBillingSettings::orderBy('id', 'desc')
            ->first();
        if(!empty($lastBill) && (int)(substr($lastBill->billing_id, -3)) >= 1){
            $lastBillId = sprintf('%03d', (int)(substr($lastBill->billing_id, -3)) + 1);
        }
        foreach ($clients as $c){
            $cbs = CompanyBillingSettings::where('client_id',$c->client_id)->first();
            if(!$cbs){
                $user = User::find($c->user_id);
                $c->name = $user->name;
                $c->check = 'yes';
            }
        }
        if($request->isMethod('post')){
            $errors = array();
            $cb = new CompanyBillingSettings();
            if(!$cb->validate($request->all())){
                $cb_e = $cb->errors();
                foreach ($cb_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }
            if(empty($errors)){
                //dd($request->all());
                $cb->client_id = $request->client_id;
                $cb->billing_id = 'BILL'.$lastBillId;
                $cb->billing_term = $request->billing_term;
                $cb->billing_amount = $request->billing_amount;
                $cb->bill_start_date = date('Y-m-d',strtotime($request->bill_start_date));
                $cb->created_by = 'PIC';
                $cb->modified_by = 'MOD';
                $cb->auto_renew = $request->auto_renew;
                if($cb->save()){
                    $last_id = CompanyBillingSettings::orderBy('id', 'desc')->first();
                    $cp = new CompanyPayment();
                    if(!$cp->validate($request->all())){
                        $cp_e = $cp->errors();
                        foreach ($cp_e->messages() as $k => $v){
                            foreach ($v as $e){
                                $errors[] = $e;
                            }
                        }
                    }
                    $cp->billing_id = $last_id->id;
                    if($request->billing_term == '1'){
                        $cp->bill_due_date = date('Y-m-d',strtotime($request->bill_start_date . ' + 30 days'));
                    }elseif($request->billing_term == '2'){
                        $cp->bill_due_date = date('Y-m-d',strtotime($request->bill_start_date . ' + 60 days'));
                    }elseif($request->billing_term == '3'){
                        $cp->bill_due_date = date('Y-m-d',strtotime($request->bill_start_date . ' + 90 days'));
                    }elseif($request->billing_term == '4'){
                        $cp->bill_due_date = date('Y-m-d',strtotime($request->bill_start_date . ' + 120 days'));
                    }
                    $cp->status = 'unpaid';
                    $cp->save();
                    return redirect()
                        ->to('/create-billing')
                        ->with('success', 'The Billing was created successfully!!');
                }else{
                    return redirect()
                        ->to('/create-billing')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }else{
                return redirect()
                    ->to('/create-billing')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
        return view('pages.owner.create-billing',[
            'modal' => 'pages.owner.modals.create-billing-modal',
            'clients' => $clients,
            'js' => 'pages.owner.js.create-billing-js'
        ]);
    }

    /**
     * Manage Billing view,edit - function for manage billing
     * param - request - takes all the post request data
     */

    public function manageBilling(){
        $billing = CompanyBillingSettings::orderBy('bill_start_date','asc')->get();
        foreach ($billing as $b){
            $client = Clients::where('client_id',$b->client_id)->first();
            $user = User::find($client->user_id);
            $b->client = $user->name;
            $cbs = CompanyPayment::where('billing_id',$b->id)->get();
            foreach ($cbs as $c){
                $b->due_date = $c->bill_due_date;
            }
        }
        return view('pages.owner.manage-billing',[
            'modal' => 'pages.owner.modals.manage-billing-modal',
            'billing' => $billing
        ]);
    }

    /**
     * Manage Billing details - function for manage billing details
     * param - request - takes all the post request data
     */
    public function manageBillingDetails(Request $request){
        if(!isset($request->client_id)){
            abort(404);
        }
        $client = Clients::where('client_id', $request->client_id)->first();
        if(empty($client)){
            abort(404);
        }
        $data = new \stdClass();
        $user = User::find($client->user_id);
        $data->name = $user->name;
        $billing = CompanyBillingSettings::where('client_id',$request->client_id)->first();
        $data->time = $billing->billing_term;
        $data->amount = $billing->billing_amount;
        $data->auto_renew = $billing->auto_renew;
        $data->start_date = $billing->bill_start_date;

        $payment = CompanyPayment::all();
        foreach ($payment as $p){
            $cbs = CompanyBillingSettings::where('id',$p->billing_id)
                ->where('client_id',$request->client_id)->get();
            if($p->status == 'unpaid'){
                foreach ($cbs as $c){
                    $p->check = 'unpaid';
                    $p->bill_id = $c->billing_id;
                    $p->start_date = $c->bill_start_date;
                }
            }
            if($p->status == 'paid'){
                foreach ($cbs as $c){
                    $p->check = 'paid';
                    $p->bill_id = $c->billing_id;;
                }
            }
        }


        return view('pages.owner.manage-billing-details',[
            'modal' => 'pages.owner.modals.manage-billing-details-modal',
            'data' => $data,
            'billing' => $payment
        ]);
    }
    public function payment(Request $request){
        if($request->isMethod('post')){
            $pay = CompanyPayment::find($request->payment_id);
            $pay->transaction_id = $request->transaction_id;
            $pay->status = 'paid';
            if($pay->save()){
                return redirect()
                    ->to('/manage-billing')
                    ->with('success', 'The Transaction was added successfully!!');
            }else{
                return redirect()
                    ->to('/manage-billing')
                    ->with('error', 'The Transaction Can not be added!!');
            }
        }
    }

    /**
     * reports - function to show all the reports
    */
    public function reports(Request $request){
        $clients = User::where('role', 'client')
            ->get();
        foreach ($clients as $c){
            $cData = Clients::where('user_id', $c->id)->first();
            $c->type = $cData->client_type;
        }
        $daily = $weekly = $monthly = $yearly = 0;
        $data = CheckInOut::where('fair', '!=', null)
            ->get();
        foreach($data as $d){
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                $daily+=$d->fair;
            }
            if(date('W', strtotime($d->created_at)) == date('W')){
                $weekly+=$d->fair;
            }
            if(date('m', strtotime($d->created_at)) == date('m')){
                $monthly+=$d->fair;
            }
            if(date('Y', strtotime($d->created_at)) == date('Y')){
                $yearly+=$d->fair;
            }
        }
        $result = new Collection();
        $vc_selected = $type = $sDate = $eDate = null;
        $dates = array();
        if(isset($request->sDate) && isset($request->eDate)){
            $exS = explode('/', $request->sDate);
            $sDate = $exS[2].'-'.$exS[1].'-'.$exS[0];
            $exE = explode('/', $request->eDate);
            $eDate = $exE[2].'-'.$exE[1].'-'.$exE[0];
            if(date('Y-m-d', strtotime($eDate)) > date('Y-m-d', strtotime($sDate))){
                $period = new \DatePeriod(
                    new \DateTime($sDate),
                    new \DateInterval('P1D'),
                    new \DateTime($eDate)
                );
                $dates[] = $eDate;
            }else{
                $period = new \DatePeriod(
                    new \DateTime($eDate),
                    new \DateInterval('P1D'),
                    new \DateTime($sDate)
                );
                $dates[] = $sDate;
            }
            foreach ($period as $key => $value) {
                $dates[] = $value->format('Y-m-d');
            }
        }
        if(isset($request->vc) && !isset($request->type)){
            $vc_selected = $request->vc;
            $client = User::find($vc_selected);
            $client->details = Clients::where('user_id', $client->id)->first();
            $clData = CheckInOut::where('client_id', $vc_selected)
                ->where('fair', '!=', null)
                ->get();
            $cl_daily = $cl_weekly = $cl_monthly = $cl_yearly = $from_to = 0;
            foreach($clData as $cd){
                if(date('Y-m-d', strtotime($cd->created_at)) == date('Y-m-d')){
                    $cl_daily+=$cd->fair;
                }
                if(date('W', strtotime($cd->created_at)) == date('W')){
                    $cl_weekly+=$cd->fair;
                }
                if(date('m', strtotime($cd->created_at)) == date('m')){
                    $cl_monthly+=$cd->fair;
                }
                if(date('Y', strtotime($cd->created_at)) == date('Y')){
                    $cl_yearly+=$cd->fair;
                }
                if(isset($request->sDate) && isset($request->eDate)){
                    if(in_array(date('Y-m-d', strtotime($cd->created_at)), $dates) || in_array(date('Y-m-d', strtotime($cd->updated_at)), $dates)){
                        $from_to += $cd->fair;
                    }
                }
            }
            $client->daily = $cl_daily;
            $client->weekly = $cl_weekly;
            $client->monthly = $cl_monthly;
            $client->yearly = $cl_yearly;
            $client->from_to = $from_to;
            $result->push($client);
        }
        if(!isset($request->vc) && isset($request->type)){
            $type = $request->type;
            if($request->type == 'park'){
                foreach($clients as $client){
                    $client->details = Clients::where('user_id', $client->id)->first();
                    $clData = CheckInOut::where('client_id', $client->id)
                        ->where('fair', '!=', null)
                        ->get();
                    $cl_daily = $cl_weekly = $cl_monthly = $cl_yearly = $from_to = 0;
                    foreach($clData as $cd){
                        if(date('Y-m-d', strtotime($cd->created_at)) == date('Y-m-d')){
                            $cl_daily+=$cd->fair;
                        }
                        if(date('W', strtotime($cd->created_at)) == date('W')){
                            $cl_weekly+=$cd->fair;
                        }
                        if(date('m', strtotime($cd->created_at)) == date('m')){
                            $cl_monthly+=$cd->fair;
                        }
                        if(date('Y', strtotime($cd->created_at)) == date('Y')){
                            $cl_yearly+=$cd->fair;
                        }
                        if(isset($request->sDate) && isset($request->eDate)){
                            if(in_array(date('Y-m-d', strtotime($cd->created_at)), $dates) || in_array(date('Y-m-d', strtotime($cd->updated_at)), $dates)){
                                $from_to += $cd->fair;
                            }
                        }
                    }
                    $client->daily = $cl_daily;
                    $client->weekly = $cl_weekly;
                    $client->monthly = $cl_monthly;
                    $client->yearly = $cl_yearly;
                    $client->from_to = $from_to;
                    $result->push($client);
                }
            }
        }
        if(isset($request->vc) && isset($request->type)){
            $vc_selected = $request->vc;
            $type = $request->type;
            $client = User::find($vc_selected);
            $client->details = Clients::where('user_id', $client->id)->first();
            $clData = CheckInOut::where('client_id', $vc_selected)
                ->where('fair', '!=', null)
                ->get();
            $cl_daily = $cl_weekly = $cl_monthly = $cl_yearly = $from_to = 0;
            foreach($clData as $cd){
                if(date('Y-m-d', strtotime($cd->created_at)) == date('Y-m-d')){
                    $cl_daily+=$cd->fair;
                }
                if(date('W', strtotime($cd->created_at)) == date('W')){
                    $cl_weekly+=$cd->fair;
                }
                if(date('m', strtotime($cd->created_at)) == date('m')){
                    $cl_monthly+=$cd->fair;
                }
                if(date('Y', strtotime($cd->created_at)) == date('Y')){
                    $cl_yearly+=$cd->fair;
                }
                if(isset($request->sDate) && isset($request->eDate)){
                    if(in_array(date('Y-m-d', strtotime($cd->created_at)), $dates) || in_array(date('Y-m-d', strtotime($cd->updated_at)), $dates)){
                        $from_to += $cd->fair;
                    }
                }
            }
            $client->daily = $cl_daily;
            $client->weekly = $cl_weekly;
            $client->monthly = $cl_monthly;
            $client->yearly = $cl_yearly;
            $client->from_to = $from_to;
            $result->push($client);
        }
        if(isset($request->sDate) && isset($request->eDate) && !isset($request->vc) && !isset($request->type)){
            foreach($clients as $client){
                $client->details = Clients::where('user_id', $client->id)->first();
                $clData = CheckInOut::where('client_id', $client->id)
                    ->where('fair', '!=', null)
                    ->get();
                $cl_daily = $cl_weekly = $cl_monthly = $cl_yearly = $from_to = 0;
                foreach($clData as $cd){
                    if(date('Y-m-d', strtotime($cd->created_at)) == date('Y-m-d')){
                        $cl_daily+=$cd->fair;
                    }
                    if(date('W', strtotime($cd->created_at)) == date('W')){
                        $cl_weekly+=$cd->fair;
                    }
                    if(date('m', strtotime($cd->created_at)) == date('m')){
                        $cl_monthly+=$cd->fair;
                    }
                    if(date('Y', strtotime($cd->created_at)) == date('Y')){
                        $cl_yearly+=$cd->fair;
                    }
                    if(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($cd->created_at)), $dates) || in_array(date('Y-m-d', strtotime($cd->updated_at)), $dates)){
                            $from_to += $cd->fair;
                        }
                    }
                }
                $client->daily = $cl_daily;
                $client->weekly = $cl_weekly;
                $client->monthly = $cl_monthly;
                $client->yearly = $cl_yearly;
                $client->from_to = $from_to;
                $result->push($client);
            }
        }
        return view('pages.owner.reports', [
            'result' => $result,
            'clients' => $clients,
            'vc' => $vc_selected,
            'type' => $type,
            'sDate' => $sDate,
            'eDate' => $eDate,
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'yearly' => $yearly,
            'js' => 'pages.owner.js.reports-js'
        ]);
    }
    public function createAdvert(){
        return view('pages.owner.create-advert');
    }
}
