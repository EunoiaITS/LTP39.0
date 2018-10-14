<?php

namespace App\Http\Controllers;

use App\ExemptedDuration;
use App\ExemptedTime;
use App\ParkingRate;
use App\ParkingSetting;
use App\VAT;
use App\VehicleCategory;
use App\User;
use App\Employee;
use Illuminate\Http\Request;

class Client extends Controller
{
    /**
     * vehicleType - function for adding vehicle types
    */
    public function vehicleType(Request $request){
        $vehicle_types = VehicleCategory::all();
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
                    $vt->client_id = 5;
                    $vt->type_id = $request->type_id;
                    $vt->type_name = $request->type_name;
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
        $vt = VehicleCategory::all();
        $ps = ParkingSetting::all();
        foreach($ps as $p){
            $p->vehicle = VehicleCategory::find($p->vehicle_id);
        }
        if($request->isMethod('post')){
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
                    $assign->amount = $request->amount;
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
            'modal' => 'pages.client.modals.assign-parking-modals'
        ]);
    }

    /**
     * assignRate - function to assign rate for each vehicle category
     */
    public function assignRate(Request $request){
        $vt = VehicleCategory::all();
        $pr = ParkingRate::all();
        foreach($pr as $p){
            $p->vehicle = VehicleCategory::find($p->vehicle_id);
        }
        if($request->isMethod('post')){
            $errors = array();
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
            'modal' => 'pages.client.modals.assign-rate-modals'
        ]);
    }

    /**
     * exemptedDuration - function to assign exampted duration
     */
    public function exemptedDuration(Request $request){
        $exTime = ExemptedTime::where('client_id', 5)->first();
        $exDuration = ExemptedDuration::where('client_id', 5)->first();
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
                    $time->client_id = 5;
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
                    $time->client_id = 5;
                    $time->duration = $request->duration;
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
        if($request->isMethod('post')){
            $errors = array();
            if($request->password != $request->repass){
                $errors[] = 'Password didn\'t match.';
            }
            $emp = new Employee();

            if(!$emp->validate($request->all())){
                $emp_e = $emp->errors();
                foreach ($emp_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(empty($errors)){
                $emp->client_id = 2;
                $emp->employee_id = $request->employee_id;
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
            }else{
                return redirect()
                    ->to('/create-employee')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
        return view('pages.client.create-employee');
    }

    /**
     * manageEmployee - function to manage employee
     */

    public function manageEmployee(){
        $emp = Employee::all();
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
     * editPassword - function to edit employee password
     */

    public function editPassword(Request $request){
        if($request->isMethod('post')){
            if($request->password != $request->repass){
                $errors[] = 'Password didn\'t match.';
            }
            $emp = Employee::find($request->emp_id);
            $emp->password = bcrypt($request->password);
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
        $vat = VAT::where('client_id', 5)->first();
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
                    $vc->client_id = 5;
                    $vc->vat = $request->vat;
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

}
