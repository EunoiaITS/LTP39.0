<?php

namespace App\Http\Controllers;

use App\CheckInOut;
use App\VIPCheckInOut;
use App\VIPRequests;
use Auth;
use App\Clients;
use App\ExemptedDuration;
use App\ExemptedTime;
use App\ParkingRate;
use App\ParkingSetting;
use App\VAT;
use App\VehicleCategory;
use App\User;
use App\Employee;
use App\Vip;
use App\VipParking;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Managers;
use Illuminate\Support\Facades\Hash;

class Client extends Controller
{

    public function dashboard(){
        $page = 'pages.client.dashboard';
        if(Auth::user()->role == 'owner' || Auth::user()->role == 'dev'){
            $page = 'pages.owner.dashboard';
        }
        return view($page);
    }

    /**
     * vehicleType - function for adding vehicle types
    */
    public function vehicleType(Request $request){
        $id = Auth::id();
        $lastVehId = sprintf('%03d', 1);
        $lastVeh = VehicleCategory::where('client_id', $id)
            ->orderBy('id', 'DESC')
            ->first();
        if(!empty($lastVeh) && (int)(substr($lastVeh->type_id, -3)) >= 1){
            $lastVehId = sprintf('%03d', (int)(substr($lastVeh->type_id, -3)) + 1);
        }
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $client = Clients::where('user_id',$id)->first();
        $vehicle_types = VehicleCategory::where('client_id', $id)->get();
        if($request->isMethod('post')){
            if($request->action == 'create'){
                $errors = array();
                $vt = new VehicleCategory();
                if(!$vt->validate($request->all())){
                    $vt_e = $vt->errors();
                    foreach ($vt_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors[] = $e;
                        }
                    }
                }
                if(empty($errors)){
                    $vt->client_id = $id;
                    $vt->type_id = $client->client_id.'VEH'.$lastVehId;
                    $vc = VehicleCategory::where('type_name',$request->type_name)
                        ->where('client_id',$id)->count();
                    if($vc == 0){
                        $vt->type_name = $request->type_name;
                    }else{
                        return redirect()
                            ->to('/settings/vehicle-types')
                            ->with('error', 'Category Already Exists !!');
                    }
                    if($vt->save()){
                        return redirect()
                            ->to('/settings/vehicle-types')
                            ->with('success', 'Vehicle category has created successfully!');
                    }else{
                        return redirect()
                            ->to('/settings/vehicle-types')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/settings/vehicle-types')
                        ->with('errors', $errors)
                        ->withInput();
                }
            }
            if($request->action == 'edit'){
                $type = VehicleCategory::find($request->vehicle_id);
                $type->type_id = $request->type_id;
                $type->type_name = $request->type_name;
                if($type->save()){
                    return redirect()
                        ->to('/settings/vehicle-types')
                        ->with('success', 'Vehicle category has updated successfully!');
                }else{
                    return redirect()
                        ->to('/settings/vehicle-types')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
            if($request->action == 'delete'){
                if(VehicleCategory::destroy($request->vehicle_id)){
                    return redirect()
                        ->to('/settings/vehicle-types')
                        ->with('success', 'Vehicle category has deleted successfully!');
                }else{
                    return redirect()
                        ->to('/settings/vehicle-types')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }
        return view('pages.client.vehicle-type', [
            'data' => $vehicle_types,
            'modal' => 'pages.client.modals.vehicle-type-modals'
        ]);
    }

    /**
     * assignParking - function to assign parking for each vehicle category
    */
    public function assignParking(Request $request){
        $id = Auth::id();
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $vt = VehicleCategory::where('client_id', $id)->get();
        $ps = new Collection();
        $check = new Collection();
        foreach($vt as $v){
            if(!ParkingSetting::where('vehicle_id', $v->id)->first()){
                $check->push($v);
            }
            $vps = ParkingSetting::where('vehicle_id', $v->id)->get();
            foreach($vps as $vp){
                $ps->push($vp);
            }
        }
        foreach($ps as $p){
            $p->vehicle = VehicleCategory::find($p->vehicle_id);
        }
        if($request->isMethod('post')){
            $lastApId = sprintf('%03d', 1);
            $lastAp = ParkingSetting::where('client_id', $id)
                ->orderBy('id','desc')
                ->first();
            $vc = VehicleCategory::find($request->vehicle_id);
            if(!empty($lastAp) && (int)(substr($lastAp->assign_parking_id, -3)) >= 1){
                $lastApId = sprintf('%03d', (int)(substr($lastAp->assign_parking_id, -3)) + 1);
            }
            $errors = array();
            if($request->action == 'assign'){
                $assign = new ParkingSetting();
                if(!$assign->validate($request->all())){
                    $assign_e = $assign->errors();
                    foreach ($assign_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors[] = $e;
                        }
                    }
                }
                if(empty($errors)){
                    $assign->vehicle_id = $request->vehicle_id;
                    $assign->client_id = $id;
                    $assign->amount = $request->amount;
                    $assign->assign_parking_id = $vc->type_id.'API'.$lastApId;
                    if($assign->save()){
                        return redirect()
                            ->to('/settings/assign-parking')
                            ->with('success', 'Parking setting was assigned!');
                    }else{
                        return redirect()
                            ->to('/settings/assign-parking')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/settings/assign-parking')
                        ->with('errors', $errors)
                        ->withInput();
                }
            }
            if($request->action == 'edit'){
                $type = ParkingSetting::find($request->setting_id);
                $type->amount = $request->amount;
                if($type->save()){
                    return redirect()
                        ->to('/settings/assign-parking')
                        ->with('success', 'Assign setting was updated successfully!');
                }else{
                    return redirect()
                        ->to('/settings/assign-parking')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
            if($request->action == 'delete'){
                if(ParkingSetting::destroy($request->setting_id)){
                    return redirect()
                        ->to('/settings/assign-parking')
                        ->with('success', 'Assign setting was deleted successfully!');
                }else{
                    return redirect()
                        ->to('/settings/assign-parking')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }
        return view('pages.client.assign-parking', [
            'vt' => $vt,
            'ps' => $ps,
            'check' => $check,
            'modal' => 'pages.client.modals.assign-parking-modals'
        ]);
    }

    /**
     * assignRate - function to assign rate for each vehicle category
     */
    public function assignRate(Request $request){
        $id = Auth::id();
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $vt = VehicleCategory::where('client_id', $id)->get();
        $check = new Collection();
        $pr = new Collection();
        foreach($vt as $v){
            if(!ParkingRate::where('vehicle_id', $v->id)->first()){
                $check->push($v);
            }
            $vpr = ParkingRate::where('vehicle_id', $v->id)->get();
            foreach($vpr as $vp){
                $pr->push($vp);
            }
        }
        foreach($pr as $p){
            $p->vehicle = VehicleCategory::find($p->vehicle_id);
        }
        if($request->isMethod('post')){
            $errors = array();
            $lastArId = sprintf('%03d', 1);
            $lastAr = ParkingRate::where('client_id', $id)
                ->orderBy('id','desc')
                ->first();
            $vc = VehicleCategory::find($request->vehicle_id);
            if(!empty($lastAr) && (int)(substr($lastAr->parking_rate_id, -3)) >= 1){
                $lastArId = sprintf('%03d', (int)(substr($lastAr->parking_rate_id, -3)) + 1);
            }
            if($request->action == 'create'){
                $assign = new ParkingRate();
                if(!$assign->validate($request->all())){
                    $assign_e = $assign->errors();
                    foreach ($assign_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors[] = $e;
                        }
                    }
                }
                if(empty($errors)){
                    $assign->client_id = $id;
                    $assign->parking_rate_id = $vc->type_id.'PRI'.$lastArId;
                    $assign->vehicle_id = $request->vehicle_id;
                    $assign->base_hour = $request->base_hour;
                    $assign->base_rate = $request->base_rate;
                    $assign->sub_rate = $request->sub_rate;
                    if($assign->save()){
                        return redirect()
                            ->to('/settings/assign-rate')
                            ->with('success', 'Parking rate setting was assigned!');
                    }else{
                        return redirect()
                            ->to('/settings/assign-rate')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/settings/assign-rate')
                        ->with('errors', $errors)
                        ->withInput();
                }
            }
            if($request->action == 'edit'){
                $assign = ParkingRate::find($request->rate_id);
                $assign->base_hour = $request->base_hour;
                $assign->base_rate = $request->base_rate;
                $assign->sub_rate = $request->sub_rate;
                if($assign->save()){
                    return redirect()
                        ->to('/settings/assign-rate')
                        ->with('success', 'Rate setting was updated successfully!');
                }else{
                    return redirect()
                        ->to('/settings/assign-rate')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
            if($request->action == 'delete'){
                if(ParkingRate::destroy($request->rate_id)){
                    return redirect()
                        ->to('/settings/assign-rate')
                        ->with('success', 'Rate setting was deleted successfully!');
                }else{
                    return redirect()
                        ->to('/settings/assign-rate')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }
        return view('pages.client.assign-rate', [
            'vt' => $vt,
            'pr' => $pr,
            'check' => $check,
            'modal' => 'pages.client.modals.assign-rate-modals'
        ]);
    }

    /**
     * exemptedDuration - function to assign exampted duration
     */
    public function exemptedDuration(Request $request){
        $id = Auth::id();
        $client = Clients::where('user_id',$id)->first();
        $lastExdId = sprintf('%03d', 1);
        $lastExd = ExemptedDuration::where('client_id', $id)
            ->orderBy('id', 'DESC')
            ->first();
        if(!empty($lastExd) && (int)(substr($lastExd->exempteddur_id, -3)) >= 1){
            $lastExdId = sprintf('%03d', (int)(substr($lastExd->exempteddur_id, -3)) + 1);
        }

        $lastExtId = sprintf('%03d', 1);
        $lastExt = ExemptedTime::where('client_id', $id)
            ->orderBy('id', 'DESC')
            ->first();
        if(!empty($lastExt) && (int)(substr($lastExt->exemptedtime_id, -3)) >= 1){
            $lastExtId = sprintf('%03d', (int)(substr($lastExt->exemptedtime_id, -3)) + 1);
        }
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $exTime = ExemptedTime::where('client_id', $id)->first();
        $exDuration = ExemptedDuration::where('client_id', $id)->first();
        if($request->isMethod('post')){
            if($request->action == 'time'){
                $errors = array();
                $time = new ExemptedTime();
                if(!$time->validate($request->all())){
                    $time_e = $time->errors();
                    foreach ($time_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors[] = $e;
                        }
                    }
                }
                if(empty($errors)){
                    $time->client_id = $id;
                    $time->from = $request->from;
                    $time->to = $request->to;
                    $time->exemptedtime_id = $client->client_id.'EXT'.$lastExtId;
                    if($time->save()){
                        return redirect()
                            ->to('/settings/exempted-setting')
                            ->with('success', 'Exempted time was saved!');
                    }else{
                        return redirect()
                            ->to('/settings/exempted-setting')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/settings/exempted-setting')
                        ->with('errors', $errors)
                        ->withInput();
                }
            }
            if($request->action == 'ex-time'){
                $time = ExemptedTime::find($request->time_id);
                $time->from = $request->from;
                $time->to = $request->to;
                if($time->save()){
                    return redirect()
                        ->to('/settings/exempted-setting')
                        ->with('success', 'Exempted time was saved!');
                }else{
                    return redirect()
                        ->to('/settings/exempted-setting')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
            if($request->action == 'duration'){
                $errors = array();
                $time = new ExemptedDuration();
                if(!$time->validate($request->all())){
                    $time_e = $time->errors();
                    foreach ($time_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors[] = $e;
                        }
                    }
                }
                if(empty($errors)){
                    $time->client_id = $id;
                    $time->duration = $request->duration;
                    $time->exempteddur_id = $client->client_id.'EXD'.$lastExdId;
                    if($time->save()){
                        return redirect()
                            ->to('/settings/exempted-setting')
                            ->with('success', 'Exempted duration was saved!');
                    }else{
                        return redirect()
                            ->to('/settings/exempted-setting')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/settings/exempted-setting')
                        ->with('errors', $errors)
                        ->withInput();
                }
            }
            if($request->action == 'ex-duration'){
                $duration = ExemptedDuration::find($request->duration_id);
                $duration->duration = $request->duration;
                if($duration->save()){
                    return redirect()
                        ->to('/settings/exempted-setting')
                        ->with('success', 'Exempted duration was saved!');
                }else{
                    return redirect()
                        ->to('/settings/exempted-setting')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }
        return view('pages.client.exempted-duration', [
            'exTime' => $exTime,
            'exDuration' => $exDuration,
            'js' => 'pages.client.js.exempted-duration-js',
            'modal' => 'pages.client.modals.exempted-duration-modals'
        ]);
    }

    /**
     * createEmployee - function to create employee
     */


    public function createEmployee(Request $request){
        $id = Auth::id();
        $lastEmpId = sprintf('%03d', 1);
        $lastEmp = Employee::where('client_id', $id)
            ->orderBy('id', 'DESC')
            ->first();
        if(!empty($lastEmp) && (int)(substr($lastEmp->employee_id, -3)) >= 1){
            $lastEmpId = sprintf('%03d', (int)(substr($lastEmp->employee_id, -3)) + 1);
        }
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $client = Clients::where('user_id',$id)->first();
        if($request->isMethod('post')){
            $errors = array();
            if($request->password != $request->repass){
                $errors[] = 'Password didn\'t match.';
            }
            $emp = new Employee();
            $user = new User();

            if(!$user->validate($request->all())){
                $user_e = $user->errors();
                foreach ($user_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(!$emp->validate($request->all())){
                $emp_e = $emp->errors();
                foreach ($emp_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(empty($errors)){
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->role = $request->role;
                $user->status = $request->status;
                if($user->save()){
                    $emp->client_id = $id;
                    $emp->employee_id = $client->client_id.'EMP'.$lastEmpId;
                    $emp->password = bcrypt($request->password);
                    $emp->phone = $request->phone;
                    $emp->name = $request->name;
                    $emp->email = $request->email;
                    $emp->status = 'unblock';
                    if($emp->save()){
                        return redirect()
                            ->to('/create-employee')
                            ->with('success', 'The employee was created successfully!!');
                    }else{
                        return redirect()
                            ->to('/create-employee')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }
            }else{
                return redirect()
                    ->to('/create-employee')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
        return view('pages.client.create-employee',[
            'client' => $client
        ]);
    }

    /**
     * manageEmployee - function to manage employee
     */

    public function manageEmployee(){
        $id = Auth::id();
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $emp = Employee::where('client_id', $id)->get();
        return view('pages.client.manage-employee',[
            'employees' => $emp,
            'modal' => 'pages.client.modals.manage-employee-modal',
        ]);
    }

    /**
     * editEmployee - function to edit employee
     */

    public function editEmployee(Request $request){
        if($request->isMethod('post')){
            $emp = Employee::find($request->emp_id);
            $emp->name = $request->name;
            $emp->phone = $request->phone;
            if($emp->save()){
                return redirect()
                    ->to('/manage-employee')
                    ->with('success', 'The details was changed successfully!!');
            }else{
                return redirect()
                    ->to('/manage-employee')
                    ->with('error', 'Something went wrong! Please try again!');
            }
        }
    }

    /**
     * editEmployee - function to edit employee
     */

    public function deleteEmployee(Request $request){
        if($request->isMethod('post')){
            if(Employee::destroy($request->emp_id)){
                return redirect()
                    ->to('/manage-employee')
                    ->with('success', 'The Employee was deleted successfully!!');
            }else{
                return redirect()
                    ->to('/manage-employee')
                    ->with('error', 'Something went wrong! Please try again!');
            }
        }
    }

    /**
     * editPassword - function to edit employee password
     */

    public function editPassword(Request $request){
        if($request->isMethod('post')){
            $emp = Employee::find($request->emp_id);
            $client = Clients::where('user_id',$emp->client_id)
                ->first();
            $user = User::where('id',$client->user_id)->first();
            if(Hash::check($request->old_password,$user->password) == false){
                $errors[] = 'Old Password didn\'t match.';
            }
            if($request->password != $request->repass){
                $errors[] = 'Password didn\'t match.';
            }
            if(empty($errors)){
                $emp->password = bcrypt($request->password);
                $user->password = bcrypt($request->password);
                if($emp->save()){
                    return redirect()
                        ->to('/manage-employee')
                        ->with('success', 'The password was changed successfully!!');
                }else{
                    return redirect()
                        ->to('/manage-employee')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }else{
                return redirect()
                    ->to('/manage-employee')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
    }

    /**
     * blocking - function to block/unblock employee
     */

    public function blocking(Request $request){
        if($request->isMethod('post')){
            $emp = Employee::find($request->emp_id);
            $emp->status = $request->status;
            if($emp->save()){
                return redirect()
                    ->to('/manage-employee')
                    ->with('success', 'The password was changed successfully!!');
            }else{
                return redirect()
                    ->to('/manage-employee')
                    ->with('error', 'Something went wrong! Please try again!');
            }
        }
    }

    /**
     * vat - function to save VAT settings
    */
    public function vat(Request $request){
        $id = Auth::id();
        $client = Clients::where('user_id',$id)->first();
        $lastVatId = sprintf('%03d', 1);
        $lastVat = VAT::where('client_id', $id)
            ->orderBy('id', 'DESC')
            ->first();
        if(!empty($lastVat) && (int)(substr($lastVat->vat_id, -3)) >= 1){
            $lastVatId = sprintf('%03d', (int)(substr($lastVat->vat_id, -3)) + 1);
        }
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $vat = VAT::where('client_id', $id)->first();
        if($request->isMethod('post')){
            if($request->action == 'create'){
                $errors = array();
                $vc = new VAT();
                if(!$vc->validate($request->all())){
                    $vc_e = $vc->errors();
                    foreach ($vc_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors[] = $e;
                        }
                    }
                }
                if(empty($errors)){
                    $vc->client_id = $id;
                    $vc->vat = $request->vat;
                    $vc->vat_id = $client->client_id.'VAT'.$lastVatId;
                    if($vc->save()){
                        return redirect()
                            ->to('/settings/vat')
                            ->with('success', 'VAT settings was saved!');
                    }else{
                        return redirect()
                            ->to('/settings/vat')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/settings/vat')
                        ->with('errors', $errors)
                        ->withInput();
                }
            }
            if($request->action == 'edit'){
                $ve = VAT::find($request->vat_id);
                $ve->vat = $request->vat;
                if($ve->save()){
                    return redirect()
                        ->to('/settings/vat')
                        ->with('success', 'VAT settings was saved!');
                }else{
                    return redirect()
                        ->to('/settings/vat')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }
        return view('pages.client.vat', [
            'vat' => $vat
        ]);
    }

    /**
     * vipParking - function to assign VIP parking settings
     */
    public function vipParking(Request $request){
        $id = Auth::id();
        $client = Clients::where('user_id',$id)->first();
        $lastVpId = sprintf('%03d', 1);
        $lastVp = VipParking::where('client_id', $id)
            ->orderBy('id', 'DESC')
            ->first();
        if(!empty($lastVp) && (int)(substr($lastVp->vip_parking_rate_id, -3)) >= 1){
            $lastVpId = sprintf('%03d', (int)(substr($lastVp->vip_parking_rate_id, -3)) + 1);
        }
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $vip = VipParking::where('client_id', $id)->get();
        foreach($vip as $v){
            $v->category = VehicleCategory::find($v->vehicle_id);
        }
        $vc = VehicleCategory::all();
        if($request->isMethod('post')){
            $errors = array();
            if($request->action == 'create'){
                $assign = new VipParking();
                if(!$assign->validate($request->all())){
                    $assign_e = $assign->errors();
                    foreach ($assign_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors[] = $e;
                        }
                    }
                }
                if(empty($errors)){
                    $assign->vehicle_id = $request->vehicle_id;
                    $assign->client_id = $id;
                    $assign->duration = $request->duration;
                    $assign->fair = $request->fair;
                    $assign->vip_parking_rate_id = $client->client_id.'VPK'.$lastVpId;
                    if($assign->save()){
                        return redirect()
                            ->to('/settings/vip-parking')
                            ->with('success', 'VIP parking rate setting was assigned!');
                    }else{
                        return redirect()
                            ->to('/settings/vip-parking')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/settings/vip-parking')
                        ->with('errors', $errors)
                        ->withInput();
                }
            }
            if($request->action == 'edit'){
                $assign = VipParking::find($request->vip_id);
                $assign->duration = $request->duration;
                $assign->fair = $request->fair;
                if($assign->save()){
                    return redirect()
                        ->to('/settings/vip-parking')
                        ->with('success', 'VIP parking setting was updated successfully!');
                }else{
                    return redirect()
                        ->to('/settings/vip-parking')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
            if($request->action == 'delete'){
                if(VipParking::destroy($request->vip_id)){
                    return redirect()
                        ->to('/settings/vip-parking')
                        ->with('success', 'VIP parking setting was deleted successfully!');
                }else{
                    return redirect()
                        ->to('/settings/vip-parking')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }
        return view('pages.client.vip-parking', [
            'vip' => $vip,
            'vc' => $vc,
            'modal' => 'pages.client.modals.vip-parking-modals'
        ]);
    }

    /**
     * vipRequests - all clients requested to get vip
     */

    public function vipRequests(Request $request)
    {
        $id = Auth::id();
        if (Auth::user()->role == 'manager') {
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $users = VIPRequests::where('client_id', $id)
            ->where('status', 'requested')
            ->get();
        foreach ($users as $u) {
            $u->req_by = User::find($u->requested_by);
        }
        if ($request->isMethod('post')) {
            if ($request->action == 'accept') {
                $req = VIPRequests::find($request->req_id);
                $req->price = $request->price;
                $req->status = 'accepted';
                $req->time_duration = date('d-M-Y', strtotime('+' . $request->time_duration . ' days'));
                $req->approved_by = $id;
                if ($req->save()) {
                    return redirect()
                        ->to('/vip-requests')
                        ->with('success', 'The VIP request was accepted successfully!');
                } else {
                    return redirect()
                        ->to('/vip-requests')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
            if($request->action == 'reject'){
                $req = VIPRequests::find($request->req_id);
                $req->status = 'rejected';
                $req->remark = $request->remark;
                $req->approved_by = $id;
                if($req->save()){
                    return redirect()
                        ->to('/vip-requests')
                        ->with('success', 'The VIP request was rejected successfully!');
                }else{
                    return redirect()
                        ->to('/vip-requests')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }
        return view('pages.client.vip-requests',[
            'users' => $users,
            'modal' => 'pages.client.modals.vip-requests-modal',
            'js' => 'pages.client.js.vip-requests-js',
        ]);
    }

    /**
     * vipList - all vip clients
     */

    public function vipList(){
        $id = Auth::id();
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $vips = VIPRequests::where('client_id', $id)
            ->where('status','accepted')
            ->get();
        foreach($vips as $u){
            $u->req_by = User::find($u->requested_by);
            $u->s_by = User::find($u->approved_by);
        }
        return view('pages.client.vip-list',[
            'vips' => $vips,
            'js' => 'pages.client.js.vip-list-js',
        ]);
    }

    /**
     * vipRejectList - all rejected vip clients list
     */
    public function vipRejectList(){
        $id = Auth::id();
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $vips = VIPRequests::where('client_id', $id)
            ->where('status','rejected')
            ->get();
        foreach($vips as $u){
            $u->req_by = User::find($u->requested_by);
            $u->s_by = User::find($u->approved_by);
        }
        return view('pages.client.vip-reject-list',[
            'vips' => $vips
        ]);
    }

    /**
 * vhReport - shows the reports based on vehicle categories
 */
    public function vhReport(Request $request){
        $id = Auth::id();
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $vc = VehicleCategory::where('client_id', $id)->get();
        $daily = $weekly = $monthly = $yearly = 0;
        $last_daily = $last_weekly = $last_monthly = $last_yearly = 0;
        $data = CheckInOut::where('client_id', $id)->get();
        $vipData = VIPCheckInOut::where('client_id', $id)->get();
        foreach($data as $d){
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                $daily++;
            }
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d', strtotime("-1 days"))){
                $last_daily++;
            }
            if(date('W', strtotime($d->created_at)) == date('W')){
                $weekly++;
            }
            if(date('W', strtotime($d->created_at)) == (date('W') - 1)){
                $last_weekly++;
            }
            if(date('m', strtotime($d->created_at)) == date('m')){
                $monthly++;
            }
            if((date('m') - 1) == 1){
                if(date('m', strtotime($d->created_at)) == 12){
                    $last_monthly++;
                }
            }else{
                if(date('m', strtotime($d->created_at)) == (date('m') - 1)){
                    $last_monthly++;
                }
            }
            if(date('Y', strtotime($d->created_at)) == date('Y')){
                $yearly++;
            }
            if(date('Y', strtotime($d->created_at)) == (date('Y') - 1)){
                $last_yearly++;
            }
        }
        foreach($vipData as $d){
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                $daily++;
            }
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d', strtotime("-1 days"))){
                $last_daily++;
            }
            if(date('W', strtotime($d->created_at)) == date('W')){
                $weekly++;
            }
            if(date('W', strtotime($d->created_at)) == (date('W') - 1)){
                $last_weekly++;
            }
            if(date('m', strtotime($d->created_at)) == date('m')){
                $monthly++;
            }
            if((date('m') - 1) == 1){
                if(date('m', strtotime($d->created_at)) == 12){
                    $last_monthly++;
                }
            }else{
                if(date('m', strtotime($d->created_at)) == (date('m') - 1)){
                    $last_monthly++;
                }
            }
            if(date('Y', strtotime($d->created_at)) == date('Y')){
                $yearly++;
            }
            if(date('Y', strtotime($d->created_at)) == (date('Y') - 1)){
                $last_yearly++;
            }
        }
        $result = new Collection();
        $vc_selected = $type = $duration = $sDate = $eDate = null;
        if(isset($request->duration)){
            $duration = $request->duration;
        }
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
            $cio = CheckInOut::where('client_id', $id)
                ->where('vehicle_type', $request->vc)
                ->get();
            if($request->vc == 'all'){
                $cio = CheckInOut::where('client_id', $id)
                    ->get();
            }
            foreach($cio as $cc){
                $cc->v_type = VehicleCategory::find($cc->vehicle_type);
                $cc->req_by = User::find($cc->created_by);
                if($cc->updated_by != null){
                    $cc->co_by = User::find($cc->updated_by);
                }
                if($duration != null){
                    if($duration == 'd'){
                        if(date('Y-m-d', strtotime($cc->created_at)) == date('Y-m-d')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'w'){
                        if(date('W', strtotime($cc->created_at)) == date('W')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'm'){
                        if(date('m', strtotime($cc->created_at)) == date('m')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'y'){
                        if(date('Y', strtotime($cc->created_at)) == date('Y')){
                            $result->push($cc);
                        }
                    }
                }elseif(isset($request->sDate) && isset($request->eDate)){
                    if(in_array(date('Y-m-d', strtotime($cc->created_at)), $dates) || in_array(date('Y-m-d', strtotime($cc->updated_at)), $dates)){
                        $result->push($cc);
                    }
                }else{
                    $result->push($cc);
                }
            }
            $vcio = VIPCheckInOut::where('client_id', $id)
                ->get();
            foreach($vcio as $vcc){
                $vip = VIPRequests::where('vipId', $vcc->vip_id)->first();
                $vcc->v_type = VehicleCategory::find($vip->vehicle_type);
                $vcc->req_by = User::find($vcc->created_by);
                $vcc->vehicle_reg = $vip->car_reg;
                if($vcc->updated_by != null){
                    $vcc->co_by = User::find($vcc->updated_by);
                }
                if($vip->vehicle_type == $vc_selected){
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($vcc->created_at)) == date('Y-m-d')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($vcc->created_at)) == date('W')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($vcc->created_at)) == date('m')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($vcc->created_at)) == date('Y')){
                                $result->push($vcc);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($vcc->created_at)), $dates) || in_array(date('Y-m-d', strtotime($vcc->updated_at)), $dates)){
                            $result->push($vcc);
                        }
                    }else{
                        $result->push($vcc);
                    }
                }
                if($vc_selected == 'all'){
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($vcc->created_at)) == date('Y-m-d')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($vcc->created_at)) == date('W')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($vcc->created_at)) == date('m')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($vcc->created_at)) == date('Y')){
                                $result->push($vcc);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($vcc->created_at)), $dates) || in_array(date('Y-m-d', strtotime($vcc->updated_at)), $dates)){
                            $result->push($vcc);
                        }
                    }else{
                        $result->push($vcc);
                    }
                }
            }
        }
        if(isset($request->type) && !isset($request->vc)){
            $type = $request->type;
            if($type == 1){
                $results = CheckInOut::where('client_id', $id)
                    ->where('fair', '=', null)
                    ->get();
                foreach($results as $r){
                    $r->v_type = VehicleCategory::find($r->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
            if($type == 2){
                $results = CheckInOut::where('client_id', $id)
                    ->where('fair', '!=', null)
                    ->get();
                foreach($results as $r){
                    $r->v_type = VehicleCategory::find($r->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->co_by = User::find($r->updated_by);
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
            if($type == 3){
                $results = VIPCheckInOut::where('client_id', $id)
                    ->where('receipt_id', '=', null)
                    ->get();
                foreach($results as $r){
                    $vip = VIPRequests::where('vipId', $r->vip_id)->first();
                    $r->v_type = VehicleCategory::find($vip->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->vehicle_reg = $vip->car_reg;
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
            if($type == 4){
                $results = VIPCheckInOut::where('client_id', $id)
                    ->where('receipt_id', '!=', null)
                    ->get();
                foreach($results as $r){
                    $vip = VIPRequests::where('vipId', $r->vip_id)->first();
                    $r->v_type = VehicleCategory::find($vip->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->vehicle_reg = $vip->car_reg;
                    $r->co_by = User::find($r->updated_by);
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
        }
        if(isset($request->vc) && isset($request->type)){
            $type = $request->type;
            $vc_selected = $request->vc;
            if($type == 1){
                $results = CheckInOut::where('client_id', $id)
                    ->where('vehicle_type', $request->vc)
                    ->where('fair', '=', null)
                    ->get();
                if($request->vc == 'all'){
                    $results = CheckInOut::where('client_id', $id)
                        ->where('fair', '=', null)
                        ->get();
                }
                foreach($results as $r){
                    $r->v_type = VehicleCategory::find($r->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
            if($type == 2){
                $results = CheckInOut::where('client_id', $id)
                    ->where('fair', '!=', null)
                    ->where('vehicle_type', $request->vc)
                    ->get();
                if($request->vc == 'all'){
                    $results = CheckInOut::where('client_id', $id)
                        ->where('fair', '!=', null)
                        ->get();
                }
                foreach($results as $r){
                    $r->v_type = VehicleCategory::find($r->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->co_by = User::find($r->updated_by);
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
            if($type == 3){
                $results = VIPCheckInOut::where('client_id', $id)
                    ->where('receipt_id', '=', null)
                    ->get();
                foreach($results as $r){
                    $vip = VIPRequests::where('vipId', $r->vip_id)->first();
                    $r->v_type = VehicleCategory::find($vip->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->vehicle_reg = $vip->car_reg;
                    if($vip->vehicle_type == $vc_selected){
                        if($duration != null){
                            if($duration == 'd'){
                                if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'w'){
                                if(date('W', strtotime($r->created_at)) == date('W')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'm'){
                                if(date('m', strtotime($r->created_at)) == date('m')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'y'){
                                if(date('Y', strtotime($r->created_at)) == date('Y')){
                                    $result->push($r);
                                }
                            }
                        }elseif(isset($request->sDate) && isset($request->eDate)){
                            if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                                $result->push($r);
                            }
                        }else{
                            $result->push($r);
                        }
                    }
                    if($vc_selected == 'all'){
                        if($duration != null){
                            if($duration == 'd'){
                                if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'w'){
                                if(date('W', strtotime($r->created_at)) == date('W')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'm'){
                                if(date('m', strtotime($r->created_at)) == date('m')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'y'){
                                if(date('Y', strtotime($r->created_at)) == date('Y')){
                                    $result->push($r);
                                }
                            }
                        }elseif(isset($request->sDate) && isset($request->eDate)){
                            if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                                $result->push($r);
                            }
                        }else{
                            $result->push($r);
                        }
                    }
                }
            }
            if($type == 4){
                $results = VIPCheckInOut::where('client_id', $id)
                    ->where('receipt_id', '!=', null)
                    ->get();
                foreach($results as $r){
                    $vip = VIPRequests::where('vipId', $r->vip_id)->first();
                    $r->v_type = VehicleCategory::find($vip->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->vehicle_reg = $vip->car_reg;
                    $r->co_by = User::find($r->updated_by);
                    if($vip->vehicle_type == $vc_selected){
                        if($duration != null){
                            if($duration == 'd'){
                                if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'w'){
                                if(date('W', strtotime($r->created_at)) == date('W')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'm'){
                                if(date('m', strtotime($r->created_at)) == date('m')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'y'){
                                if(date('Y', strtotime($r->created_at)) == date('Y')){
                                    $result->push($r);
                                }
                            }
                        }elseif(isset($request->sDate) && isset($request->eDate)){
                            if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                                $result->push($r);
                            }
                        }else{
                            $result->push($r);
                        }
                    }
                    if($vc_selected == 'all'){
                        if($duration != null){
                            if($duration == 'd'){
                                if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'w'){
                                if(date('W', strtotime($r->created_at)) == date('W')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'm'){
                                if(date('m', strtotime($r->created_at)) == date('m')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'y'){
                                if(date('Y', strtotime($r->created_at)) == date('Y')){
                                    $result->push($r);
                                }
                            }
                        }elseif(isset($request->sDate) && isset($request->eDate)){
                            if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                                $result->push($r);
                            }
                        }else{
                            $result->push($r);
                        }
                    }
                }
            }
        }
        if(isset($request->duration) && !isset($request->vc) && !isset($request->type)){
            $duration = $request->duration;
            if($duration == 'd'){
                foreach($data as $d){
                    if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
                foreach($vipData as $d){
                    if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                        $d->v_type = VehicleCategory::find($vip->vehicle_type);
                        $d->vehicle_reg = $vip->car_reg;
                        $result->push($d);
                    }
                }
            }
            if($duration == 'w'){
                foreach($data as $d){
                    if(date('W', strtotime($d->created_at)) == date('W')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
                foreach($vipData as $d){
                    if(date('W', strtotime($d->created_at)) == date('W')){
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                        $d->v_type = VehicleCategory::find($vip->vehicle_type);
                        $d->vehicle_reg = $vip->car_reg;
                        $result->push($d);
                    }
                }
            }
            if($duration == 'm'){
                foreach($data as $d){
                    if(date('m', strtotime($d->created_at)) == date('m')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
                foreach($vipData as $d){
                    if(date('m', strtotime($d->created_at)) == date('m')){
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                        $d->v_type = VehicleCategory::find($vip->vehicle_type);
                        $d->vehicle_reg = $vip->car_reg;
                        $result->push($d);
                    }
                }
            }
            if($duration == 'y'){
                foreach($data as $d){
                    if(date('Y', strtotime($d->created_at)) == date('Y')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
                foreach($vipData as $d){
                    if(date('Y', strtotime($d->created_at)) == date('Y')){
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                        $d->v_type = VehicleCategory::find($vip->vehicle_type);
                        $d->vehicle_reg = $vip->car_reg;
                        $result->push($d);
                    }
                }
            }
        }
        if(isset($request->eDate) && isset($request->sDate) && !isset($request->vc) && !isset($request->type)){
            foreach($data as $d){
                $d->v_type = VehicleCategory::find($d->vehicle_type);
                $d->req_by = User::find($d->created_by);
                if($d->updated_by != null){
                    $d->co_by = User::find($d->updated_by);
                }
                if(in_array(date('Y-m-d', strtotime($d->created_at)), $dates) || in_array(date('Y-m-d', strtotime($d->updated_at)), $dates)){
                    $result->push($d);
                }
            }
            foreach($vipData as $d){
                $d->req_by = User::find($d->created_by);
                if($d->updated_by != null){
                    $d->co_by = User::find($d->updated_by);
                }
                $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                $d->v_type = VehicleCategory::find($vip->vehicle_type);
                $d->vehicle_reg = $vip->car_reg;
                if(in_array(date('Y-m-d', strtotime($d->created_at)), $dates) || in_array(date('Y-m-d', strtotime($d->updated_at)), $dates)){
                    $result->push($d);
                }
            }
        }
        return view('pages.client.vh-report', [
            'result' => $result,
            'vc' => $vc,
            'vc_selected' => $vc_selected,
            'type' => $type,
            'duration' => $duration,
            'sDate' => $sDate,
            'eDate' => $eDate,
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'yearly' => $yearly,
            'last_daily' => $last_daily,
            'last_weekly' => $last_weekly,
            'last_monthly' => $last_monthly,
            'last_yearly' => $last_yearly,
            'js' => 'pages.client.js.vh-report-js'
        ]);
    }

    /**
     * vhReport - shows the reports based on vehicle categories
     */
    public function uiReport(Request $request){
        $id = Auth::id();
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $employees = Employee::where('client_id', $id)->get();
        foreach($employees as $e){
            $e->details = User::where('email', $e->email)
                ->first();
        }
        $daily = $weekly = $monthly = $yearly = 0;
        $last_daily = $last_weekly = $last_monthly = $last_yearly = 0;
        $data = CheckInOut::where('client_id', $id)
            ->where('fair', '!=', null)
            ->get();
        foreach($data as $d){
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                $daily+=$d->fair;
            }
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d', strtotime("-1 days"))){
                $last_daily+=$d->fair;
            }
            if(date('W', strtotime($d->created_at)) == date('W')){
                $weekly+=$d->fair;
            }
            if(date('W', strtotime($d->created_at)) == (date('W') - 1)){
                $last_weekly+=$d->fair;
            }
            if(date('m', strtotime($d->created_at)) == date('m')){
                $monthly+=$d->fair;
            }
            if((date('m') - 1) == 1){
                if(date('m', strtotime($d->created_at)) == 12){
                    $last_monthly+=$d->fair;
                }
            }else{
                if(date('m', strtotime($d->created_at)) == (date('m') - 1)){
                    $last_monthly+=$d->fair;
                }
            }
            if(date('Y', strtotime($d->created_at)) == date('Y')){
                $yearly+=$d->fair;
            }
            if(date('Y', strtotime($d->created_at)) == (date('Y') - 1)){
                $last_yearly+=$d->fair;
            }
        }
        $result = new Collection();
        $emp = $duration = $sDate = $eDate = null;
        if(isset($request->duration)){
            $duration = $request->duration;
        }
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
        if(isset($request->emp)){
            $emp = $request->emp;
            $cio = CheckInOut::where('client_id', $id)
                ->where('created_by', $emp)
                ->where('fair', '!=', null)
                ->get();
            if($emp == 'all'){
                $cio = CheckInOut::where('client_id', $id)
                    ->where('fair', '!=', null)
                    ->get();
            }
            foreach($cio as $cc){
                $cc->v_type = VehicleCategory::find($cc->vehicle_type);
                $cc->req_by = User::find($cc->created_by);
                if($cc->updated_by != null){
                    $cc->co_by = User::find($cc->updated_by);
                }
                if($duration != null){
                    if($duration == 'd'){
                        if(date('Y-m-d', strtotime($cc->created_at)) == date('Y-m-d')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'w'){
                        if(date('W', strtotime($cc->created_at)) == date('W')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'm'){
                        if(date('m', strtotime($cc->created_at)) == date('m')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'y'){
                        if(date('Y', strtotime($cc->created_at)) == date('Y')){
                            $result->push($cc);
                        }
                    }
                }elseif(isset($request->sDate) && isset($request->eDate)){
                    if(in_array(date('Y-m-d', strtotime($cc->created_at)), $dates) || in_array(date('Y-m-d', strtotime($cc->updated_at)), $dates)){
                        $result->push($cc);
                    }
                }else{
                    $result->push($cc);
                }
            }
        }
        if(isset($request->duration) && !isset($request->emp)){
            $duration = $request->duration;
            if($duration == 'd'){
                foreach($data as $d){
                    if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
            }
            if($duration == 'w'){
                foreach($data as $d){
                    if(date('W', strtotime($d->created_at)) == date('W')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
            }
            if($duration == 'm'){
                foreach($data as $d){
                    if(date('m', strtotime($d->created_at)) == date('m')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
            }
            if($duration == 'y'){
                foreach($data as $d){
                    if(date('Y', strtotime($d->created_at)) == date('Y')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
            }
        }
        if(isset($request->eDate) && isset($request->sDate) && !isset($request->emp)){
            foreach($data as $d){
                $d->v_type = VehicleCategory::find($d->vehicle_type);
                $d->req_by = User::find($d->created_by);
                if($d->updated_by != null){
                    $d->co_by = User::find($d->updated_by);
                }
                if(in_array(date('Y-m-d', strtotime($d->created_at)), $dates) || in_array(date('Y-m-d', strtotime($d->updated_at)), $dates)){
                    $result->push($d);
                }
            }
        }
        return view('pages.client.ui-report', [
            'result' => $result,
            'employees' => $employees,
            'emp' => $emp,
            'duration' => $duration,
            'sDate' => $sDate,
            'eDate' => $eDate,
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'yearly' => $yearly,
            'last_daily' => $last_daily,
            'last_weekly' => $last_weekly,
            'last_monthly' => $last_monthly,
            'last_yearly' => $last_yearly,
            'js' => 'pages.client.js.ui-report-js'
        ]);
    }

    /**
     * vhReport - shows the reports based on vehicle categories
     */
    public function salesReport(Request $request){
        $id = Auth::id();
        if(Auth::user()->role == 'manager'){
            $mngr = Managers::where('user_id', Auth::id())->first();
            $id = $mngr->client_id;
        }
        $vc = VehicleCategory::where('client_id', $id)->get();
        $daily = $weekly = $monthly = $yearly = 0;
        $last_daily = $last_weekly = $last_monthly = $last_yearly = 0;
        $data = CheckInOut::where('client_id', $id)
            ->where('fair', '!=', null)
            ->get();
        $vipData = VIPCheckInOut::where('client_id', $id)
            ->where('receipt_id', '!=', null)
            ->get();
        foreach($data as $d){
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                $daily+=$d->fair;
            }
            if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d', strtotime("-1 days"))){
                $last_daily+=$d->fair;
            }
            if(date('W', strtotime($d->created_at)) == date('W')){
                $weekly+=$d->fair;
            }
            if(date('W', strtotime($d->created_at)) == (date('W') - 1)){
                $last_weekly+=$d->fair;
            }
            if(date('m', strtotime($d->created_at)) == date('m')){
                $monthly+=$d->fair;
            }
            if((date('m') - 1) == 1){
                if(date('m', strtotime($d->created_at)) == 12){
                    $last_monthly+=$d->fair;
                }
            }else{
                if(date('m', strtotime($d->created_at)) == (date('m') - 1)){
                    $last_monthly+=$d->fair;
                }
            }
            if(date('Y', strtotime($d->created_at)) == date('Y')){
                $yearly+=$d->fair;
            }
            if(date('Y', strtotime($d->created_at)) == (date('Y') - 1)){
                $last_yearly+=$d->fair;
            }
        }
        $result = new Collection();
        $vc_selected = $type = $duration = $sDate = $eDate = null;
        if(isset($request->duration)){
            $duration = $request->duration;
        }
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
            $cio = CheckInOut::where('client_id', $id)
                ->where('vehicle_type', $request->vc)
                ->where('fair', '!=', null)
                ->get();
            if($request->vc == 'all'){
                $cio = CheckInOut::where('client_id', $id)
                    ->where('fair', '!=', null)
                    ->get();
            }
            foreach($cio as $cc){
                $cc->v_type = VehicleCategory::find($cc->vehicle_type);
                $cc->req_by = User::find($cc->created_by);
                if($cc->updated_by != null){
                    $cc->co_by = User::find($cc->updated_by);
                }
                if($duration != null){
                    if($duration == 'd'){
                        if(date('Y-m-d', strtotime($cc->created_at)) == date('Y-m-d')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'w'){
                        if(date('W', strtotime($cc->created_at)) == date('W')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'm'){
                        if(date('m', strtotime($cc->created_at)) == date('m')){
                            $result->push($cc);
                        }
                    }
                    if($duration == 'y'){
                        if(date('Y', strtotime($cc->created_at)) == date('Y')){
                            $result->push($cc);
                        }
                    }
                }elseif(isset($request->sDate) && isset($request->eDate)){
                    if(in_array(date('Y-m-d', strtotime($cc->created_at)), $dates) || in_array(date('Y-m-d', strtotime($cc->updated_at)), $dates)){
                        $result->push($cc);
                    }
                }else{
                    $result->push($cc);
                }
            }
            $vcio = VIPCheckInOut::where('client_id', $id)
                ->where('receipt_id', '!=', null)
                ->get();
            foreach($vcio as $vcc){
                $vip = VIPRequests::where('vipId', $vcc->vip_id)->first();
                if($vip->vehicle_type == $vc_selected){
                    $vcc->v_type = VehicleCategory::find($vc_selected);
                    $vcc->req_by = User::find($vcc->created_by);
                    $vcc->vehicle_reg = $vip->car_reg;
                    if($vcc->updated_by != null){
                        $vcc->co_by = User::find($vcc->updated_by);
                    }
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($vcc->created_at)) == date('Y-m-d')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($vcc->created_at)) == date('W')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($vcc->created_at)) == date('m')){
                                $result->push($vcc);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($vcc->created_at)) == date('Y')){
                                $result->push($vcc);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($vcc->created_at)), $dates) || in_array(date('Y-m-d', strtotime($vcc->updated_at)), $dates)){
                            $result->push($vcc);
                        }
                    }else{
                        $result->push($vcc);
                    }
                }
            }
        }
        if(isset($request->type) && !isset($request->vc)){
            $type = $request->type;
            if($type == 2){
                $results = CheckInOut::where('client_id', $id)
                    ->where('fair', '!=', null)
                    ->get();
                foreach($results as $r){
                    $r->v_type = VehicleCategory::find($r->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->co_by = User::find($r->updated_by);
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
            if($type == 4){
                $results = VIPCheckInOut::where('client_id', $id)
                    ->where('receipt_id', '!=', null)
                    ->get();
                foreach($results as $r){
                    $vip = VIPRequests::where('vipId', $r->vip_id)->first();
                    $r->v_type = VehicleCategory::find($vip->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->vehicle_reg = $vip->car_reg;
                    $r->co_by = User::find($r->updated_by);
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
        }
        if(isset($request->vc) && isset($request->type)){
            $type = $request->type;
            $vc_selected = $request->vc;
            if($type == 2){
                $results = CheckInOut::where('client_id', $id)
                    ->where('fair', '!=', null)
                    ->where('vehicle_type', $request->vc)
                    ->get();
                if($request->vc == 'all'){
                    $results = CheckInOut::where('client_id', $id)
                        ->where('fair', '!=', null)
                        ->get();
                }
                foreach($results as $r){
                    $r->v_type = VehicleCategory::find($r->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->co_by = User::find($r->updated_by);
                    if($duration != null){
                        if($duration == 'd'){
                            if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'w'){
                            if(date('W', strtotime($r->created_at)) == date('W')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'm'){
                            if(date('m', strtotime($r->created_at)) == date('m')){
                                $result->push($r);
                            }
                        }
                        if($duration == 'y'){
                            if(date('Y', strtotime($r->created_at)) == date('Y')){
                                $result->push($r);
                            }
                        }
                    }elseif(isset($request->sDate) && isset($request->eDate)){
                        if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                            $result->push($r);
                        }
                    }else{
                        $result->push($r);
                    }
                }
            }
            if($type == 4){
                $results = VIPCheckInOut::where('client_id', $id)
                    ->where('receipt_id', '!=', null)
                    ->get();
                foreach($results as $r){
                    $vip = VIPRequests::where('vipId', $r->vip_id)->first();
                    $r->v_type = VehicleCategory::find($vip->vehicle_type);
                    $r->req_by = User::find($r->created_by);
                    $r->vehicle_reg = $vip->car_reg;
                    $r->co_by = User::find($r->updated_by);
                    if($vip->vehicle_type == $vc_selected){
                        if($duration != null){
                            if($duration == 'd'){
                                if(date('Y-m-d', strtotime($r->created_at)) == date('Y-m-d')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'w'){
                                if(date('W', strtotime($r->created_at)) == date('W')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'm'){
                                if(date('m', strtotime($r->created_at)) == date('m')){
                                    $result->push($r);
                                }
                            }
                            if($duration == 'y'){
                                if(date('Y', strtotime($r->created_at)) == date('Y')){
                                    $result->push($r);
                                }
                            }
                        }elseif(isset($request->sDate) && isset($request->eDate)){
                            if(in_array(date('Y-m-d', strtotime($r->created_at)), $dates) || in_array(date('Y-m-d', strtotime($r->updated_at)), $dates)){
                                $result->push($r);
                            }
                        }else{
                            $result->push($r);
                        }
                    }
                }
            }
        }
        if(isset($request->duration) && !isset($request->vc) && !isset($request->type)){
            $duration = $request->duration;
            if($duration == 'd'){
                foreach($data as $d){
                    if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
                foreach($vipData as $d){
                    if(date('Y-m-d', strtotime($d->created_at)) == date('Y-m-d')){
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                        $d->v_type = VehicleCategory::find($vip->vehicle_type);
                        $d->vehicle_reg = $vip->car_reg;
                        $result->push($d);
                    }
                }
            }
            if($duration == 'w'){
                foreach($data as $d){
                    if(date('W', strtotime($d->created_at)) == date('W')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
                foreach($vipData as $d){
                    if(date('W', strtotime($d->created_at)) == date('W')){
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                        $d->v_type = VehicleCategory::find($vip->vehicle_type);
                        $d->vehicle_reg = $vip->car_reg;
                        $result->push($d);
                    }
                }
            }
            if($duration == 'm'){
                foreach($data as $d){
                    if(date('m', strtotime($d->created_at)) == date('m')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
                foreach($vipData as $d){
                    if(date('m', strtotime($d->created_at)) == date('m')){
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                        $d->v_type = VehicleCategory::find($vip->vehicle_type);
                        $d->vehicle_reg = $vip->car_reg;
                        $result->push($d);
                    }
                }
            }
            if($duration == 'y'){
                foreach($data as $d){
                    if(date('Y', strtotime($d->created_at)) == date('Y')){
                        $d->v_type = VehicleCategory::find($d->vehicle_type);
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $result->push($d);
                    }
                }
                foreach($vipData as $d){
                    if(date('Y', strtotime($d->created_at)) == date('Y')){
                        $d->req_by = User::find($d->created_by);
                        if($d->updated_by != null){
                            $d->co_by = User::find($d->updated_by);
                        }
                        $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                        $d->v_type = VehicleCategory::find($vip->vehicle_type);
                        $d->vehicle_reg = $vip->car_reg;
                        $result->push($d);
                    }
                }
            }
        }
        if(isset($request->eDate) && isset($request->sDate) && !isset($request->vc) && !isset($request->type)){
            foreach($data as $d){
                $d->v_type = VehicleCategory::find($d->vehicle_type);
                $d->req_by = User::find($d->created_by);
                if($d->updated_by != null){
                    $d->co_by = User::find($d->updated_by);
                }
                if(in_array(date('Y-m-d', strtotime($d->created_at)), $dates) || in_array(date('Y-m-d', strtotime($d->updated_at)), $dates)){
                    $result->push($d);
                }
            }
            foreach($vipData as $d){
                $d->req_by = User::find($d->created_by);
                if($d->updated_by != null){
                    $d->co_by = User::find($d->updated_by);
                }
                $vip = VIPRequests::where('vipId', $d->vip_id)->first();
                $d->v_type = VehicleCategory::find($vip->vehicle_type);
                $d->vehicle_reg = $vip->car_reg;
                if(in_array(date('Y-m-d', strtotime($d->created_at)), $dates) || in_array(date('Y-m-d', strtotime($d->updated_at)), $dates)){
                    $result->push($d);
                }
            }
        }
        return view('pages.client.sales-report', [
            'result' => $result,
            'vc' => $vc,
            'vc_selected' => $vc_selected,
            'type' => $type,
            'duration' => $duration,
            'sDate' => $sDate,
            'eDate' => $eDate,
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'yearly' => $yearly,
            'last_daily' => $last_daily,
            'last_weekly' => $last_weekly,
            'last_monthly' => $last_monthly,
            'last_yearly' => $last_yearly,
            'js' => 'pages.client.js.sales-report-js'
        ]);
    }

    /**
     * vhReport - shows the reports based on vehicle categories
     */
    public function ticketReport(Request $request){
        return view('pages.client.ticket-report');
    }

    /**
     * vhReport - shows the reports based on vehicle categories
     */
    public function receiptReport(Request $request){
        return view('pages.client.receipt-report');
    }
}
