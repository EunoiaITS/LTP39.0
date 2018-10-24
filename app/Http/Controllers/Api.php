<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\CheckOut;
use App\Employee;
use App\User;
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
            'status' => ['unblock', 'active', 'dev']
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
        return response()->json(['user' => auth()->user()], 200);
    }

    /**
        Check In api : Check in data coming from android
     **/
    public function checkIn(Request $request){
        $checkIn = new CheckIn();
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
            $checkIn->vehicle_type = $request->vehicle_type;
            $checkIn->vehicle_reg = $request->vehicle_reg;
            $checkIn->created_by = $request->created_by;
            if($checkIn->save()){
                return Response::json([
                    'status' => 'true',
                    'message' => 'Check In successfully added!'
                ], 200);
            }else{
                return Response::json([
                    'status' => 'false',
                    'message' => 'Please Provide enough information!'
                ], 422);
            }
        }
    }

    /**
    Check out api : Check out data coming from android
     **/

    public function checkOut(Request $request){
        $checkOut = new CheckOut();
        $errors = array();
        if($request->isMethod('post')){
            if(!$checkOut->validate($request->all())){
                $checkOut_e = $checkOut->errors();
                foreach ($checkOut_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }
        }
        if(empty($errors)){
            $checkOut->receipt_id = $request->receipt_id;
            $checkOut->ticket_id = $request->ticket_id;
            $checkOut->total_charge = $request->total_charge;
            $checkOut->created_by = $request->created_by;

            $checkIn = CheckIn::where('ticket_id',$request->ticket_id)->first();
            if(empty($checkIn)){
                return Response::json([
                    'status' => 'false',
                    'message' => 'Ticket Not Matched!'
                ], 422);
            }else{
                if($checkOut->save()){
                    return Response::json([
                        'status' => 'true',
                        'message' => 'Check Out successfully added!'
                    ], 200);
                }else{
                    return Response::json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!'
                    ], 422);
                }
            }
        }
    }
}
