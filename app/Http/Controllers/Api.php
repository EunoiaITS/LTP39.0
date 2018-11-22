<?php

namespace App\Http\Controllers;


use App\CheckInOut;
use App\Clients;
use App\Employee;
use App\ExemptedDuration;
use App\ExemptedTime;
use App\ParkingRate;
use App\ParkingSetting;
use App\User;
use App\VehicleCategory;
use App\VIPCheckInOut;
use App\VIPRequests;
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
        if($request->isMethod('post')){
            $checkIn = new CheckInOut();
            $errors = array();
            if(!$checkIn->validate($request->all())){
                $checkIn_e = $checkIn->errors();
                foreach ($checkIn_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }
            if(empty($errors)){
                $lastTicketId = sprintf('%08d', 1);
                $lastTicket = CheckInOut::where('client_id', $request->client_id)
                    ->orderBy('id', 'DESC')
                    ->first();
                if(!empty($lastTicket) && (int)(substr($lastTicket->ticket_id, -8)) >= 1){
                    $lastTicketId = sprintf('%08d', (int)(substr($lastTicket->ticket_id, -8)) + 1);
                }
                $client = Clients::where('user_id', $request->client_id)->first();
                $checkIn->ticket_id = $client->client_id.$lastTicketId;
                $checkIn->client_id = $request->client_id;
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
    }

    /**
    Check out api : Check out data coming from android
     **/
    public function checkOut(Request $request){
        if($request->isMethod('post')){
            $checkOut = CheckInOut::where('ticket_id', $request->ticket_id)->first();
            if(isset($request->vehicle_reg)){
                $checkOut = CheckInOut::where('vehicle_reg', $request->vehicle_reg)
                    ->orderBy('id', 'DESC')
                    ->first();
            }
            if(!empty($checkOut) && $checkOut->fair == NULL){
                $checkOut->updated_at = $request->check_out_time;
                $checkOut->updated_by = $request->employee;
                $checkOut->receipt_id = $checkOut->client_id.$this->generateRandomString(16);
                $check_in = new \DateTime($checkOut->created_at);
                $check_out = new \DateTime($request->check_out_time);
                $diff = $check_in->diff($check_out);

                $duration = $diff->h;
                $rate = ParkingRate::where('vehicle_id', $checkOut->vehicle_type)->first();
                $exDuration = ExemptedDuration::where('client_id', $checkOut->client_id)->first();
                $exTime = ExemptedTime::where('client_id', $checkOut->client_id)->first();
                $exFrom = (int)$exTime->from;
                $exTo = (int)$exTime->to;
                if(substr($exTime->from, -2) == 'PM'){
                    $exFrom += 12;
                }
                if(substr($exTime->to, -2) == 'PM'){
                    $exTo += 12;
                }
                $fair = 0;
                $ci_time = (int)date('H A', strtotime($checkOut->created_at));
                $co_time = (int)date('H A', strtotime($request->check_out_time));
                if($ci_time >= $exFrom && $co_time > $exTo){
                    $exDiff = $exTo - $exFrom;
                    if($exDiff < 0){
                        $exDiff = $exDiff + 12;
                    }
                    $duration = $duration - $exDiff;
                }
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
                if($duration == 0 && $diff->i <= $exDuration->duration){
                    $fair = 0;
                }
                if($ci_time >= $exFrom && $co_time <= $exTo){
                    $fair = 0;
                }
                $checkOut->fair = $fair;
                if($checkOut->save()){
                    $checkOut->exFrom = $exFrom;
                    $checkOut->exTo = $exTo;
                    $checkOut->checkIn = $ci_time;
                    $checkOut->checkOut = $co_time;
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

    /**
     * random string generator - ALPHA-NUMERIC
    */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * vipRequest - function for VIP requests from mobile application
    */
    public function vipRequest(Request $request){
        if($request->isMethod('post')){
            $vip = new VIPRequests();
            $errors = array();
            if(!$vip->validate($request->all())){
                $vip_e = $vip->errors();
                foreach ($vip_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }
            if(empty($errors)){
                $lastvipId = sprintf('%03d', 1);
                $lastvip = VIPRequests::where('client_id', $request->client_id)
                    ->orderBy('id', 'DESC')
                    ->first();
                if(!empty($lastvip) && (int)(substr($lastvip->vipId, -3)) >= 1){
                    $lastvipId = sprintf('%03d', (int)(substr($lastvip->vipId, -3)) + 1);
                }
                $client = Clients::where('user_id', $request->client_id)->first();
                $vip->vipId = $client->client_id.'VIP'.$lastvipId;
                $vip->name = $request->name;
                $vip->vehicle_type = $request->vehicle_type;
                $vip->client_id = $request->client_id;
                $vip->car_reg = $request->car_reg;
                $vip->phone = $request->phone;
                $vip->purpose = $request->purpose;
                $vip->requested_by = $request->requested_by;
                $vip->status = 'requested';
                if($vip->save()){
                    return Response::json([
                        'status' => 'true',
                        'message' => 'VIP registration was requested!',
                        'data' => $vip
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
    }

    /**
 * vipCheckIn - function for VIP check in entry
 */
    public function vipCheckIn(Request $request){
        if($request->isMethod('post')){
            $vip = VIPRequests::where('vipId', $request->vip_id)->first();
            if(empty($vip) || strtotime($vip->time_duration) < strtotime('today midnight') || $vip->status != 'accepted'){
                return Response::json([
                    'status' => 'false',
                    'message' => 'Please Provide enough information!'
                ], 422);
            }
            $checkIn = new VIPCheckInOut();
            $errors = array();
            if(!$checkIn->validate($request->all())){
                $checkIn_e = $checkIn->errors();
                foreach ($checkIn_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }
            if(empty($errors)){
                $lastTicketId = sprintf('%08d', 1);
                $lastTicket = VIPCheckInOut::where('client_id', $request->client_id)
                    ->orderBy('id', 'DESC')
                    ->first();
                if(!empty($lastTicket) && (int)(substr($lastTicket->ticket_id, -8)) >= 1){
                    $lastTicketId = sprintf('%08d', (int)(substr($lastTicket->ticket_id, -8)) + 1);
                }
                $client = Clients::where('user_id', $request->client_id)->first();
                $checkIn->ticket_id = $client->client_id.$lastTicketId;
                $checkIn->client_id = $request->client_id;
                $checkIn->vip_id = $request->vip_id;
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
    }

    /**
     * vipCheckOut - function for VIP check out entry
     */
    public function vipCheckOut(Request $request){
        if($request->isMethod('post')){
            $checkOut = VIPCheckInOut::where('vip_id', $request->vip_id)
                ->orderBy('id', 'desc')
                ->first();
            if(!empty($checkOut) && $checkOut->receipt_id == NULL){
                $checkOut->updated_at = $request->check_out_time;
                $checkOut->updated_by = $request->employee;
                $checkOut->receipt_id = $checkOut->client_id.$this->generateRandomString(16);
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
