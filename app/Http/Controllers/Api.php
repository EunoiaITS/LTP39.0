<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\CheckInOut;
use App\CheckOut;
use App\Employee;
use App\ParkingRate;
use App\ParkingSetting;
use App\User;
use App\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class Api extends Controller
{

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'emp',
            'status' => ['unblock', 'active', 'dev', 'verified']
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('ParkingKori')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        $user = auth()->user();
        $details = Employee::where('email', $user->email)->first();
        $user->details = $details;
        $user->client = User::find($details->client_id);
        $vt = VehicleCategory::where('client_id', $details->client_id)->get();
        foreach($vt as $v){
            $v->parking_setting = ParkingSetting::where('vehicle_id', $v->id)->first();
            $v->parking_rate = ParkingRate::where('vehicle_id', $v->id)->first();
        }
        $user->vehicle_types = $vt;
        return response()->json(['user' => auth()->user()], 200);
    }

    /**
        Check In api : Check in data coming from android
     **/
    public function checkIn(Request $request){
        $checkIn = new CheckInOut();
        $errors = array();
        if($request->isMethod('post')){
            if(!$checkIn->validate($request->all())){
                $checkIn_e = $checkIn->errors();
                foreach ($checkIn_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }
        }
        if(empty($errors)){
            $checkIn->ticket_id = $request->ticket_id;
            $checkIn->client_id = $request->client_id;
            $checkIn->receipt_id = $request->receipt_id;
            $checkIn->vehicle_reg = $request->vehicle_reg;
            $checkIn->vehicle_type = $request->vehicle_type;
            $checkIn->created_by = $request->created_by;
            if($checkIn->save()){
                return Response::json([
                    'status' => 'true',
                    'message' => 'Check In successfully added!',
                    'data' => $checkIn
                ], 200);
            }else{
                return Response::json([
                    'status' => 'false',
                    'message' => 'Please Provide enough information!'
                ], 422);
            }
        }else{
            return Response::json([
                'status' => 'false',
                'message' => 'Please Provide enough information!',
                'errors' => $errors
            ], 422);
        }
    }

    /**
    Check out api : Check out data coming from android
     **/

    public function checkOut(Request $request){
        if($request->isMethod('post')){
            $checkOut = CheckInOut::where('ticket_id', $request->ticket_id)->first();
            if(isset($request->vehicle_reg)){
                $checkOut = CheckInOut::where('vehicle_reg', $request->vehicle_reg)->last();
            }
            if(!empty($checkOut)){
                $checkOut->updated_at = $request->check_out_time;
                $checkOut->updated_by = $request->employee;
                $check_in = new \DateTime($checkOut->created_at);
                $check_out = new \DateTime($request->check_out_time);
                $diff = $check_in->diff($check_out);

                $duration = $diff->h;
                $rate = ParkingRate::where('vehicle_id', $checkOut->vehicle_type)->first();
                $fair = 0;
                if($duration > $rate->base_hour){
                    $sub = ($duration - $rate->base_hour) * $rate->sub_rate;
                    if($diff->i != 0){
                        $sub = $sub + $rate->sub_rate;
                    }
                    $fair = $sub + $rate->base_rate;
                }else{
                    $fair = $rate->base_rate;
                    if($diff->i != 0){
                        $fair = $fair + $rate->sub_rate;
                    }
                }
                $checkOut->fair = $fair;
                if($checkOut->save()){
                    return Response::json([
                        'status' => 'true',
                        'message' => 'Checked out successfully!',
                        'data' => $checkOut
                    ], 200);
                }else{
                    return Response::json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!'
                    ], 422);
                }
            }else{
                return Response::json([
                    'status' => 'false',
                    'message' => 'Please Provide enough information!'
                ], 422);
            }
        }
    }
}
