<?php

namespace App\Http\Controllers;

use App\VehicleCategory;
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
            //dd($request->all());
        }
        return view('pages.client.vehicle-type', [
            'data' => $vehicle_types,
            'modal' => 'pages.client.modals.vehicle-type-modals'
        ]);
    }
}
