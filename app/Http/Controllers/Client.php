<?php

namespace App\Http\Controllers;

use App\ParkingRate;
use App\ParkingSetting;
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
     * assignParking - function to assign parking for each vehicle category
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
        return view('pages.client.assign-rate', [
            'vt' => $vt,
            'pr' => $pr,
            'modal' => 'pages.client.modals.assign-rate-modals'
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
}
