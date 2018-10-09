<?php

namespace App\Http\Controllers;

use App\CreateDevice;
use App\User;
use Illuminate\Http\Request;

class Owner extends Controller
{

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
            $request->role = 'dev';
            if(!$user->validate($request->all())){
                $user_e = $user->errors();
                foreach ($user_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(empty($errors)){
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->role = 'dev';
                $user->status = 'dev';
                $user->save();
//                if($request->hasFile('idc_picture')) {
//                    $image = $request->file('idc_picture');
//                    $name = str_slug($last_id->id).'.'.$image->getClientOriginalExtension();
//                    $destinationPath = public_path('/uploads/drivers/idc');
//                    $image->move($destinationPath, $name);
//                    $usd->idc_picture = $name;
//                    $usd->save();
//                }

                if($user->save()){
                    return redirect()
                        ->to('/create-client')
                        ->with('success', 'The client was created successfully!!');
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
        return view('pages.owner.create-client');
    }

    /**
     * CreateDevice - function for creating devices
     * param - request - takes all the post request data
     */
    public function createDevice(Request $request){
        if($request->isMethod('post')){
            $errors = array();
            $cd = new CreateDevice();
            if(!$cd->validate($data)){
                $cd_e = $cd->errors();
                foreach ($cd_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(empty($errors)){
                $cd->device_id = $request->device_id;
                $cd->factory_id = $request->factory_id;
                $cd->charger_id = $request->charger_id;
                $cd->created_by = 'PIC';
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
                    ->to('/create-client')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
        return view('pages.owner.create-device');
    }


    /**
     * ManageDevice - function for managing devices
     * param - request - takes all the post request data
     */
    public function manageDevice(){
        return view('pages.owner.manage-device');
    }
}
