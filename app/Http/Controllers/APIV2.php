<?php

namespace App\Http\Controllers;

use App\AdditionalSettings;
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
use Carbon\Carbon;
use Illuminate\Http\Request;

class APIV2 extends Controller
{
    private $apiToken;

    public function __construct(){
        $this->apiToken = uniqid(base64_encode(str_random(60)));
    }

    /**
     * login
    */
    public function login(Request $request){
        if($request->isMethod('post')){
            $user = User::where('email', $request->email)->first();
            if($user){
                if(password_verify($request->password, $user->password)){
                    $user->api_token = $this->apiToken;
                    if($user->save()){
                        $details = Employee::where('email', $user->email)->first();
                        $user->details = $details;
                        $user->client = User::find($details->client_id);
                        $vt = VehicleCategory::where('client_id', $details->client_id)->get();
                        foreach($vt as $v){
                            $v->parking_setting = ParkingSetting::where('vehicle_id', $v->id)->first();
                            $v->parking_rate = ParkingRate::where('vehicle_id', $v->id)->first();
                        }
                        $user->vehicle_types = $vt;
                        return response()
                            ->json([
                                'status' => 'true',
                                'message' => 'Login successful!',
                                'user' => $user
                            ], 200);
                    }else{
                        return response()
                            ->json([
                                'status' => 'false',
                                'message' => 'Something went wrong!'
                            ]);
                    }
                }else{
                    return response()
                        ->json([
                            'status' => 'false',
                            'message' => 'Wrong password!'
                        ]);
                }
            }else{
                return response()
                    ->json([
                        'status' => 'false',
                        'message' => 'User not found!'
                    ]);
            }
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $token = $request->_token;
        $user = User::where('api_token', $token)->first();
        if($user) {
            $user->api_token = null;
            if($user->save()) {
                return response()->json([
                    'status' => 'true',
                    'message' => 'User Logged Out',
                ]);
            }else{
                return response()->json([
                    'status' => 'false',
                    'message' => 'Something went wrong!',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'User not found!',
            ]);
        }
    }

    /**
    Check In api : Check in data coming from android
     **/
    public function checkIn(Request $request){
        if($request->isMethod('post')){
            $token = $request->_token;
            $user = User::where('api_token', $token)->first();
            if($user) {
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
                        return response()->json([
                            'status' => 'true',
                            'message' => 'Check In successfully added!',
                            'data' => $checkIn
                        ], 200);
                    }else{
                        return response()->json([
                            'status' => 'false',
                            'message' => 'Please Provide enough information!'
                        ], 422);
                    }
                }else{
                    return response()->json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!',
                        'errors' => $errors
                    ], 422);
                }
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'User not found!',
                ]);
            }
        }
    }

    /**
    Check out api : Check out data coming from android
     **/
    public function checkOut(Request $request){
        if($request->isMethod('post')){
            $token = $request->_token;
            $user = User::where('api_token', $token)->first();
            if($user) {
                $employee = Employee::where('email', $user->email)->first();
                $checkOut = null;
                if(isset($request->ticket_id)) {
                    $checkOut = CheckInOut::where('ticket_id', $request->ticket_id)->first();
                }
                if(isset($request->vehicle_reg)){
                    $checkOut = CheckInOut::where('vehicle_reg', $request->vehicle_reg)
                        ->orderBy('id', 'DESC')
                        ->first();
                }
                if(empty($checkOut) || $employee->client_id != $checkOut->client_id){
                    return response()->json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!'
                    ], 422);
                }
                if(!empty($checkOut) && $checkOut->fair == NULL){
                    $lastReceiptId = sprintf('%08d', 1);
                    $lastReceipt = CheckInOut::where('client_id', $checkOut->client_id)
                        ->where('receipt_id','!=',null)
                        ->orderBy('id', 'DESC')
                        ->first();
                    if(!empty($lastReceipt) && (int)(substr($lastReceipt->receipt_id, -8)) >= 1){
                        $lastReceiptId = sprintf('%08d', (int)(substr($lastReceipt->receipt_id, -8)) + 1);
                    }
                    $checkOut->updated_at = $request->check_out_time;
                    $checkOut->updated_by = $user->id;
                    $checkOut->receipt_id = $checkOut->client_id.$lastReceiptId;
                    $ci_time = $checkOut->created_at;
                    $co_time = $request->check_out_time;
                    $check_in = new \DateTime($ci_time);
                    $check_out = new \DateTime($co_time);
                    $diff = $check_in->diff($check_out);
                    $total_time = $diff->d.':'.$diff->h.':'.$diff->m;
                    $total_hour = $hours = $minutes = 0;
                    $rate = ParkingRate::where('vehicle_id', $checkOut->vehicle_type)->first();
                    $exDuration = ExemptedDuration::where('client_id', $checkOut->client_id)->first();
                    $exTime = ExemptedTime::where('client_id', $checkOut->client_id)->first();
                    $exFrom = $exTo = $exTimeFrom = $exTimeTo = null;
                    if(!empty($exTime)){
                        $exFrom = (int)$exTime->from;
                        $exTo = (int)$exTime->to;
                        $finalExF = $exTime->from;
                        $finalExT = $exTime->to;
                        if(substr($exTime->from, -2) == 'AM' && $exFrom == 12){
                            $finalExF = '00'.substr($exTime->from, 2);
                        }
                        if(substr($exTime->to, -2) == 'AM' && $exTo == 12){
                            $finalExT = '00'.substr($exTime->to, 2);
                        }
                        if(substr($exTime->from, -2) == 'PM' && $exFrom < 12){
                            $exFrom += 12;
                            $finalExF = $exFrom.substr($exTime->from, 2);
                        }
                        if(substr($exTime->to, -2) == 'PM' && $exTo < 12){
                            $exTo += 12;
                            $finalExT = $exTo.substr($exTime->to, 2);
                        }

                        while(date('Y-m-d', strtotime($ci_time)) != date('Y-m-d', strtotime($co_time))){
                            $lci_time = $ci_time;
                            $lco_time = date('Y-m-d H:i:s', strtotime(date('Y-m-d').' 23:59:59'));
                            $eF = date('Y-m-d', strtotime($lci_time)).' '.substr($finalExF, 0, -3).':00';
                            $eT = date('Y-m-d', strtotime($lci_time)).' '.substr($finalExT, 0, -3).':00';
                            $exTimeFrom = date('Y-m-d H:i:s', strtotime($eF));
                            $exTimeTo = date('Y-m-d H:i:s', strtotime($eT));
                            if(strtotime($lci_time) >= strtotime($eF) && strtotime($lco_time) <= strtotime($eT)){
                                $hours = $hours + 0;
                            }elseif(strtotime($lci_time) < strtotime($eF) && strtotime($lco_time) <= strtotime($eF)){
                                $check_in = new \DateTime($lci_time);
                                $check_out = new \DateTime($lco_time);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }elseif(strtotime($lci_time) < strtotime($eF) && strtotime($lco_time) > strtotime($eF) && strtotime($lco_time) <= strtotime($eT)){
                                $check_in = new \DateTime($lci_time);
                                $check_out = new \DateTime($exTimeFrom);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }elseif(strtotime($lci_time) >= strtotime($eF) && strtotime($lci_time) <= strtotime($eT) && strtotime($lco_time) > strtotime($eT)){
                                $check_in = new \DateTime($exTimeTo);
                                $check_out = new \DateTime($lco_time);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }elseif(strtotime($lci_time) > strtotime($eT) && strtotime($lco_time) > strtotime($eT)){
                                $check_in = new \DateTime($lci_time);
                                $check_out = new \DateTime($lco_time);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }elseif(strtotime($lci_time) < strtotime($eF) && strtotime($lco_time) > strtotime($eT)){
                                $check_in = new \DateTime($lci_time);
                                $check_out = new \DateTime($exTimeFrom);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                                $check_in = new \DateTime($exTimeTo);
                                $check_out = new \DateTime($lco_time);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }else{
                                $hours = $hours + 0;
                            }
                            $ci_time = date('Y-m-d', strtotime($lci_time." + 1 day")).'00:00:00';
                        }

                        $eF = date('Y-m-d', strtotime($ci_time)).' '.substr($finalExF, 0, -3).':00';
                        $eT = date('Y-m-d', strtotime($ci_time)).' '.substr($finalExT, 0, -3).':00';
                        $exTimeFrom = date('Y-m-d H:i:s', strtotime($eF));
                        $exTimeTo = date('Y-m-d H:i:s', strtotime($eT));

                        if(date('Y-m-d', strtotime($ci_time)) == date('Y-m-d', strtotime($co_time))){
                            if(strtotime($ci_time) >= strtotime($eF) && strtotime($co_time) <= strtotime($eT)){
                                $hours = $hours + 0;
                            }elseif(strtotime($ci_time) < strtotime($eF) && strtotime($co_time) <= strtotime($eF)){
                                $check_in = new \DateTime($ci_time);
                                $check_out = new \DateTime($co_time);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }elseif(strtotime($ci_time) < strtotime($eF) && strtotime($co_time) > strtotime($eF) && strtotime($co_time) <= strtotime($eT)){
                                $check_in = new \DateTime($ci_time);
                                $check_out = new \DateTime($exTimeFrom);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }elseif(strtotime($ci_time) >= strtotime($eF) && strtotime($ci_time) <= strtotime($eT) && strtotime($co_time) > strtotime($eT)){
                                $check_in = new \DateTime($exTimeTo);
                                $check_out = new \DateTime($co_time);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }elseif(strtotime($ci_time) > strtotime($eT) && strtotime($co_time) > strtotime($eT)){
                                $check_in = new \DateTime($ci_time);
                                $check_out = new \DateTime($co_time);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }elseif(strtotime($ci_time) < strtotime($eF) && strtotime($co_time) > strtotime($eT)){
                                $check_in = new \DateTime($ci_time);
                                $check_out = new \DateTime($exTimeFrom);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                                $check_in = new \DateTime($exTimeTo);
                                $check_out = new \DateTime($co_time);
                                $diff = $check_in->diff($check_out);
                                $hours = $hours + $diff->h;
                                if($diff->i != 0){
                                    $minutes = $minutes + $diff->i;
                                }
                            }else{
                                $hours = $hours + 0;
                            }
                        }
                    }else{
                        $hours = $diff->h;
                        if($diff->m != 0){
                            $minutes = $diff->m;
                        }
                    }

                    $minutes = $minutes + ($hours*60);
                    $base_fair = $sub_fair = $fair = 0;
                    $base_minutes = $rate->base_hour * 60;
                    if(!empty($exDuration)){
                        if(isset($exDuration->placement) && $exDuration->placement == 1){
                            if($minutes <= $base_minutes){
                                $fair = $rate->base_hour * $rate->base_rate;
                            }else{
                                $base_fair = $rate->base_hour * $rate->base_rate;
                                $minutes = $minutes - $base_minutes - $exDuration->duration;
                                $total_hour = round($minutes/60);
                                if(($minutes/60) - $total_hour > 0){
                                    $total_hour++;
                                }
                                $sub_fair = $total_hour * $rate->sub_rate;
                                $fair = $base_fair + $sub_fair;
                            }
                        }else{
                            if($minutes <= $base_minutes){
                                $fair = $rate->base_hour * $rate->base_rate;
                            }else{
                                $minutes = $minutes - $exDuration->duration;
                                $base_fair = $rate->base_hour * $rate->base_rate;
                                $minutes = $minutes - $base_minutes;
                                $total_hour = round($minutes/60);
                                if(($minutes/60) - $total_hour > 0){
                                    $total_hour++;
                                }
                                $sub_fair = $total_hour * $rate->sub_rate;
                                $fair = $base_fair + $sub_fair;
                            }
                        }
                    }else{
                        if($minutes <= $base_minutes){
                            $fair = $rate->base_hour * $rate->base_rate;
                        }else{
                            $base_fair = $rate->base_hour * $rate->base_rate;
                            $minutes = $minutes - $base_minutes;
                            $total_hour = round($minutes/60);
                            if(($minutes/60) - $total_hour > 0){
                                $total_hour++;
                            }
                            $sub_fair = $total_hour * $rate->sub_rate;
                            $fair = $base_fair + $sub_fair;
                        }
                    }
                    $checkOut->fair = $fair;
                    if($checkOut->save()){
                        $vehicle = VehicleCategory::find($checkOut->vehicle_type);
                        $settings = ParkingRate::where('vehicle_id', $checkOut->vehicle_type)
                            ->first();
                        $checkOut->vehicle_name = $vehicle->type_name;
                        $checkOut->vehicle_base_rate = $settings->base_rate;
                        $checkOut->vehicle_sub_rate = $settings->sub_rate;
                        $checkOut->total_hour = $total_time;
                        return response()->json([
                            'status' => 'true',
                            'message' => 'Checked out successfully!',
                            'data' => $checkOut
                        ], 200);
                    }else{
                        return response()->json([
                            'status' => 'false',
                            'message' => 'Please Provide enough information!'
                        ], 422);
                    }
                }else{
                    return response()->json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!'
                    ], 422);
                }
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'User not found!',
                ]);
            }
        }
    }

//    public function checkOut(Request $request){
//        if($request->isMethod('post')){
//            $token = $request->_token;
//            $user = User::where('api_token', $token)->first();
//            if($user) {
//                $employee = Employee::where('email', $user->email)->first();
//                $checkOut = null;
//                if(isset($request->ticket_id)) {
//                    $checkOut = CheckInOut::where('ticket_id', $request->ticket_id)->first();
//                }
//                if(isset($request->vehicle_reg)){
//                    $checkOut = CheckInOut::where('vehicle_reg', $request->vehicle_reg)
//                        ->orderBy('id', 'DESC')
//                        ->first();
//                }
//                if(empty($checkOut) || $employee->client_id != $checkOut->client_id){
//                    return response()->json([
//                        'status' => 'false',
//                        'message' => 'Please Provide enough information!'
//                    ], 422);
//                }
//                if(!empty($checkOut) && $checkOut->fair == NULL){
//                    $lastReceiptId = sprintf('%08d', 1);
//                    $lastReceipt = CheckInOut::where('client_id', $checkOut->client_id)
//                        ->where('receipt_id','!=',null)
//                        ->orderBy('id', 'DESC')
//                        ->first();
//                    if(!empty($lastReceipt) && (int)(substr($lastReceipt->receipt_id, -8)) >= 1){
//                        $lastReceiptId = sprintf('%08d', (int)(substr($lastReceipt->receipt_id, -8)) + 1);
//                    }
//                    $checkOut->updated_at = $request->check_out_time;
//                    $checkOut->updated_by = $user->id;
//                    $checkOut->receipt_id = $checkOut->client_id.$lastReceiptId;
//                    $check_in = new \DateTime($checkOut->created_at);
//                    $check_out = new \DateTime($request->check_out_time);
//                    $diff = $check_in->diff($check_out);
//
//                    $duration = $diff->h;
//                    $rate = ParkingRate::where('vehicle_id', $checkOut->vehicle_type)->first();
//                    $exDuration = ExemptedDuration::where('client_id', $checkOut->client_id)->first();
//                    $exTime = ExemptedTime::where('client_id', $checkOut->client_id)->first();
//                    $exFrom = (int)$exTime->from;
//                    $exTo = (int)$exTime->to;
//                    if(substr($exTime->from, -2) == 'PM'){
//                        $exFrom += 12;
//                    }
//                    if(substr($exTime->to, -2) == 'PM'){
//                        $exTo += 12;
//                    }
//                    $fair = 0;
//                    $ci_time = (int)date('H A', strtotime($checkOut->created_at));
//                    $co_time = (int)date('H A', strtotime($request->check_out_time));
//                    if($ci_time >= $exFrom && $co_time > $exTo){
//                        $exDiff = $exTo - $exFrom;
//                        if($exDiff < 0){
//                            $exDiff = $exDiff + 12;
//                        }
//                        $duration = $duration - $exDiff;
//                    }
//                    if($duration >= $rate->base_hour){
//                        $sub = ($duration - $rate->base_hour) * $rate->sub_rate;
//                        if($diff->i != 0){
//                            $sub = $sub + $rate->sub_rate;
//                        }
//                        $fair = $sub + $rate->base_rate;
//                    }else{
//                        $fair = $rate->base_rate;
//                    }
//                    if(!empty($exDuration)){
//                        $total_minutes = ($duration * 60) + $diff->i;
//                        if($total_minutes <= $exDuration->duration){
//                            $fair = 0;
//                        }else{
//                            $total_minutes = $total_minutes - $exDuration->duration;
//                            $mins = $total_minutes % 60;
//                            $hours = (int)floor($total_minutes/60);
//                            if($hours >= $rate->base_hour){
//                                $sub = ($hours - $rate->base_hour) * $rate->sub_rate;
//                                if($mins != 0){
//                                    $sub = $sub + $rate->sub_rate;
//                                }
//                                $fair = $sub + $rate->base_rate;
//                            }else{
//                                $fair = $rate->base_rate;
//                            }
//                        }
//                    }
//                    if($ci_time >= $exFrom && $co_time <= $exTo){
//                        $fair = 0;
//                    }
//                    $checkOut->fair = $fair;
//                    if($checkOut->save()){
//                        $vehicle = VehicleCategory::find($checkOut->vehicle_type);
//                        $settings = ParkingRate::where('vehicle_id', $checkOut->vehicle_type)
//                            ->first();
//                        $checkOut->vehicle_name = $vehicle->type_name;
//                        $checkOut->vehicle_base_rate = $settings->base_rate;
//                        $checkOut->vehicle_sub_rate = $settings->sub_rate;
//                        $checkOut->total_hour = $diff->h;
//                        $checkOut->total_minute = $diff->i;
//                        return response()->json([
//                            'status' => 'true',
//                            'message' => 'Checked out successfully!',
//                            'data' => $checkOut
//                        ], 200);
//                    }else{
//                        return response()->json([
//                            'status' => 'false',
//                            'message' => 'Please Provide enough information!'
//                        ], 422);
//                    }
//                }else{
//                    return response()->json([
//                        'status' => 'false',
//                        'message' => 'Please Provide enough information!'
//                    ], 422);
//                }
//            } else {
//                return response()->json([
//                    'status' => 'false',
//                    'message' => 'User not found!',
//                ]);
//            }
//        }
//    }

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
            $token = $request->_token;
            $user = User::where('api_token', $token)->first();
            if($user) {
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
                        return response()->json([
                            'status' => 'true',
                            'message' => 'VIP registration was requested!',
                            'data' => $vip
                        ], 200);
                    }else{
                        return response()->json([
                            'status' => 'false',
                            'message' => 'Please Provide enough information!'
                        ], 422);
                    }
                }else{
                    return response()->json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!',
                        'errors' => $errors
                    ], 422);
                }
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'User not found!',
                ]);
            }
        }
    }

    // /**
    //  * vipCheckIn - function for VIP check in entry
    //  */
    // public function vipCheckIn(Request $request){
    //     if($request->isMethod('post')){
    //         $token = $request->_token;
    //         $user = User::where('api_token', $token)->first();
    //         if($user) {
    //             $employee = Employee::where('email', $user->email)->first();
    //             $vip = VIPRequests::where('vipId', $request->vip_id)->first();
    //             if(empty($vip) || strtotime($vip->time_duration) < strtotime('today midnight') || $vip->status != 'accepted'){
    //                 return response()->json([
    //                     'status' => 'false',
    //                     'message' => 'Please Provide enough information!'
    //                 ], 422);
    //             }
    //             $checkIn = new VIPCheckInOut();
    //             $errors = array();
    //             if(!$checkIn->validate($request->all())){
    //                 $checkIn_e = $checkIn->errors();
    //                 foreach ($checkIn_e->messages() as $k => $v){
    //                     foreach ($v as $e){
    //                         $errors[] = $e;
    //                     }
    //                 }
    //             }
    //             if($employee->client_id != $request->client_id){
    //                 $errors[] = 'Client submitted was mismatched!';
    //             }
    //             $prev = VIPCheckInOut::where('client_id', $request->client_id)
    //                 ->where('vip_id', $request->vip_id)
    //                 ->where('updated_by', '=', null)
    //                 ->orderBy('id', 'DESC')
    //                 ->first();
    //             if(!empty($prev)){
    //                 $errors[] = 'User already checked in!';
    //             }
    //             if($vip->client_id != $request->client_id || $vip->client_id != $employee->client_id){
    //                 $errors[] = 'Invalid VIP user for the client supplied!';
    //             }
    //             if(empty($errors)){
    //                 $lastTicketId = sprintf('%08d', 1);
    //                 $lastTicket = VIPCheckInOut::where('client_id', $request->client_id)
    //                     ->orderBy('id', 'DESC')
    //                     ->first();
    //                 if(!empty($lastTicket) && (int)(substr($lastTicket->ticket_id, -8)) >= 1){
    //                     $lastTicketId = sprintf('%08d', (int)(substr($lastTicket->ticket_id, -8)) + 1);
    //                 }
    //                 $client = Clients::where('user_id', $request->client_id)->first();
    //                 $checkIn->ticket_id = $client->client_id.$lastTicketId;
    //                 $checkIn->client_id = $request->client_id;
    //                 $checkIn->vip_id = $request->vip_id;
    //                 $checkIn->created_by = $request->created_by;
    //                 if($checkIn->save()){
    //                     return response()->json([
    //                         'status' => 'true',
    //                         'message' => 'Check In successfully added!',
    //                         'data' => $checkIn
    //                     ], 200);
    //                 }else{
    //                     return response()->json([
    //                         'status' => 'false',
    //                         'message' => 'Please Provide enough information!'
    //                     ], 422);
    //                 }
    //             }else{
    //                 return response()->json([
    //                     'status' => 'false',
    //                     'message' => 'Please Provide enough information!',
    //                     'errors' => $errors
    //                 ], 422);
    //             }
    //         } else {
    //             return response()->json([
    //                 'status' => 'false',
    //                 'message' => 'User not found!',
    //             ]);
    //         }
    //     }
    // }

    // /**
    //  * vipCheckOut - function for VIP check out entry
    //  */
    // public function vipCheckOut(Request $request){
    //     if($request->isMethod('post')){
    //         $token = $request->_token;
    //         $user = User::where('api_token', $token)->first();
    //         if($user) {
    //             $employee = Employee::where('email', $user->email)->first();
    //             $checkOut = VIPCheckInOut::where('vip_id', $request->vip_id)
    //                 ->orderBy('id', 'desc')
    //                 ->first();
    //             if($employee->client_id != $checkOut->client_id){
    //                 return response()->json([
    //                     'status' => 'false',
    //                     'message' => 'Please Provide enough information!'
    //                 ], 422);
    //             }
    //             if(!empty($checkOut) && $checkOut->receipt_id == NULL){
    //                 $lastReceiptId = sprintf('%08d', 1);
    //                 $lastReceipt = VIPCheckInOut::where('client_id', $checkOut->client_id)
    //                     ->where('receipt_id','!=',null)
    //                     ->orderBy('id', 'DESC')
    //                     ->first();
    //                 if(!empty($lastReceipt) && (int)(substr($lastReceipt->receipt_id, -8)) >= 1){
    //                     $lastReceiptId = sprintf('%08d', (int)(substr($lastReceipt->receipt_id, -8)) + 1);
    //                 }
    //                 $checkOut->updated_at = $request->check_out_time;
    //                 $checkOut->updated_by = $user->id;
    //                 $checkOut->receipt_id = 'VIP'.$checkOut->client_id.$lastReceiptId;
    //                 if($checkOut->save()){
    //                     return response()->json([
    //                         'status' => 'true',
    //                         'message' => 'Checked out successfully!',
    //                         'data' => $checkOut
    //                     ], 200);
    //                 }else{
    //                     return response()->json([
    //                         'status' => 'false',
    //                         'message' => 'Please Provide enough information!'
    //                     ], 422);
    //                 }
    //             }else{
    //                 return response()->json([
    //                     'status' => 'false',
    //                     'message' => 'Please Provide enough information!'
    //                 ], 422);
    //             }
    //         } else {
    //             return response()->json([
    //                 'status' => 'false',
    //                 'message' => 'User not found!',
    //             ]);
    //         }
    //     }
    // }
    
    /**
     * vipCheckIn - function for VIP check in entry
     */
    public function vipCheckIn(Request $request){
        if($request->isMethod('post')){
            $token = $request->_token;
            $user = User::where('api_token', $token)->first();
            if($user) {
                $employee = Employee::where('email', $user->email)->first();
                $vip = VIPRequests::where('vipId', $request->vip_id)->first();
                if(empty($vip) || strtotime($vip->time_duration) < strtotime('today midnight') || $vip->status != 'accepted'){
                    return response()->json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!'
                    ], 422);
                }
                $checkIn = new CheckInOut();
                $nReq = new Request();
                $nReq->setMethod('post');
                $nReq->request->add(['client_id' => $request->client_id]);
                $nReq->request->add(['vehicle_reg' => $vip->car_reg]);
                $errors = array();
                if(!$checkIn->validate($nReq->all())){
                    $checkIn_e = $checkIn->errors();
                    foreach ($checkIn_e->messages() as $k => $v){
                        foreach ($v as $e){
                            $errors[] = $e;
                        }
                    }
                }
                if($employee->client_id != $request->client_id){
                    $errors[] = 'Client submitted was mismatched!';
                }
                $prev = CheckInOut::where('client_id', $request->client_id)
                    ->where('vip_id', $request->vip_id)
                    ->where('updated_by', '=', null)
                    ->orderBy('id', 'DESC')
                    ->first();
                if(!empty($prev)){
                    $errors[] = 'User already checked in!';
                }
                if($vip->client_id != $request->client_id || $vip->client_id != $employee->client_id){
                    $errors[] = 'Invalid VIP user for the client supplied!';
                }
                if(empty($errors)){
                    $lastTicketId = sprintf('%08d', 1);
                    $lastTicket = CheckInOut::where('client_id', $request->client_id)
                        ->where('vip_id', '!=', 'null')
                        ->orderBy('id', 'DESC')
                        ->first();
                    if(!empty($lastTicket) && (int)(substr($lastTicket->ticket_id, -8)) >= 1){
                        $lastTicketId = sprintf('%08d', (int)(substr($lastTicket->ticket_id, -8)) + 1);
                    }
                    $client = Clients::where('user_id', $request->client_id)->first();
                    $checkIn->ticket_id = $client->client_id.$lastTicketId;
                    $checkIn->client_id = $request->client_id;
                    $checkIn->vehicle_reg = $vip->car_reg;
                    $checkIn->vehicle_type = $vip->vehicle_type;
                    $checkIn->vip_id = $request->vip_id;
                    $checkIn->created_by = $request->created_by;
                    if($checkIn->save()){
                        return response()->json([
                            'status' => 'true',
                            'message' => 'Check In successfully added!',
                            'data' => $checkIn
                        ], 200);
                    }else{
                        return response()->json([
                            'status' => 'false',
                            'message' => 'Please Provide enough information!'
                        ], 422);
                    }
                }else{
                    return response()->json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!',
                        'errors' => $errors
                    ], 422);
                }
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'User not found!',
                ]);
            }
        }
    }

    /**
     * vipCheckOut - function for VIP check out entry
     */
    public function vipCheckOut(Request $request){
        if($request->isMethod('post')){
            $token = $request->_token;
            $user = User::where('api_token', $token)->first();
            if($user) {
                $employee = Employee::where('email', $user->email)->first();
                $checkOut = CheckInOut::where('vip_id', $request->vip_id)
                    ->orderBy('id', 'desc')
                    ->first();
                if($employee->client_id != $checkOut->client_id){
                    return response()->json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!'
                    ], 422);
                }
                if(!empty($checkOut) && $checkOut->receipt_id == NULL){
                    $lastReceiptId = sprintf('%08d', 1);
                    $lastReceipt = CheckInOut::where('client_id', $checkOut->client_id)
                        ->where('vip_id', '!=', null)
                        ->where('receipt_id','!=',null)
                        ->orderBy('id', 'DESC')
                        ->first();
                    if(!empty($lastReceipt) && (int)(substr($lastReceipt->receipt_id, -8)) >= 1){
                        $lastReceiptId = sprintf('%08d', (int)(substr($lastReceipt->receipt_id, -8)) + 1);
                    }
                    $checkOut->updated_at = $request->check_out_time;
                    $checkOut->updated_by = $user->id;
                    $checkOut->receipt_id = 'VIP'.$checkOut->client_id.$lastReceiptId;
                    if($checkOut->save()){
                        return response()->json([
                            'status' => 'true',
                            'message' => 'Checked out successfully!',
                            'data' => $checkOut
                        ], 200);
                    }else{
                        return response()->json([
                            'status' => 'false',
                            'message' => 'Please Provide enough information!'
                        ], 422);
                    }
                }else{
                    return response()->json([
                        'status' => 'false',
                        'message' => 'Please Provide enough information!'
                    ], 422);
                }
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'User not found!',
                ]);
            }
        }
    }

    /**
     * reports - function for daily reports
    */
    public function reports(Request $request){
        if($request->isMethod('post')){
            $token = $request->_token;
            $user = User::where('api_token', $token)->first();
            if($user) {
                $vc = VehicleCategory::where('client_id', $request->client_id)
                    ->get();
                foreach($vc as $v){
                    $v->settings = ParkingSetting::where('vehicle_id', $v->id)
                        ->first();
                    $check_in = 0;
                    $cio = CheckInOut::where('receipt_id', '=', null)
                        ->where('vehicle_type', $v->id)
                        ->where('client_id', $request->client_id)
                        ->count();
                    $check_in = $cio;
                    $vcio = VIPCheckInOut::where('receipt_id', '=', null)
                        ->where('client_id', $request->client_id)
                        ->get();
                    foreach($vcio as $vv){
                        $vip = VIPRequests::where('vipId', $vv->vip_id)
                            ->first();
                        if($vip->vehicle_type == $v->id){
                            $check_in++;
                        }
                    }
                    $v->check_in = $check_in;
                }
                return response()->json([
                    'status' => 'true',
                    'report' => $vc,
                ]);
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'User not found!',
                ]);
            }
        }
    }

    /**
     * stats - function for check in/out statistics
     */
    public function stats(Request $request){
        if($request->isMethod('post')){
            $token = $request->_token;
            $user = User::where('api_token', $token)->first();
            if($user) {
                $emp = Employee::where('email', $user->email)->first();
                $check_in = $check_out = $income = 0;
                $cioData = CheckInOut::where('created_by', $user->id)
                    ->get();
                $vcioData = VIPCheckInOut::where('created_by', $user->id)
                    ->get();
                $reportTime = AdditionalSettings::where('client_id', $emp->client_id)
                    ->where('key', 'report_starts_from')
                    ->first();
                if(!empty($reportTime)){
                    $exFrom = (int)$reportTime->value;
                    $finalExF = $reportTime->value;
                    if(substr($reportTime->value, -2) == 'AM' && $exFrom == 12){
                        $finalExF = '00'.substr($reportTime->value, 2);
                    }
                    if(substr($reportTime->value, -2) == 'PM' && $exFrom < 12){
                        $exFrom += 12;
                        $finalExF = $exFrom.substr($reportTime->value, 2);
                    }
                    $times = explode(':', substr($finalExF, 0, 5));
                    $cioData = CheckInOut::where('created_by', $user->id)
                        ->where('updated_at', '>', Carbon::create(date('Y'), date('m'), date('d'), (int)$times[0], (int)$times[1], 0))
                        ->get();
                    $vcioData = VIPCheckInOut::where('created_by', $user->id)
                        ->where('updated_at', '>', Carbon::create(date('Y'), date('m'), date('d'), (int)$times[0], (int)$times[1], 0))
                        ->get();
                    foreach($cioData as $cd){
                        if($cd->receipt_id == null){
                            $check_in++;
                        }
                        if($cd->updated_by == $user->id && $cd->receipt_id != null){
                            $check_out++;
                            $income += $cd->fair;
                        }
                    }
                    foreach($vcioData as $vcd){
                        if($vcd->receipt_id == null && date('Y-m-d', strtotime($vcd->created_at)) == date('Y-m-d')){
                            $check_in++;
                        }
                        if($vcd->updated_by == $user->id && $vcd->receipt_id != null && date('Y-m-d', strtotime($vcd->updated_at)) == date('Y-m-d')){
                            $check_out++;
                        }
                    }
                }else{
                    foreach($cioData as $cd){
                        if($cd->receipt_id == null && date('Y-m-d', strtotime($cd->created_at)) == date('Y-m-d')){
                            $check_in++;
                        }
                        if($cd->updated_by == $user->id && $cd->receipt_id != null && date('Y-m-d', strtotime($cd->updated_at)) == date('Y-m-d')){
                            $check_out++;
                            $income += $cd->fair;
                        }
                    }
                    foreach($vcioData as $vcd){
                        if($vcd->receipt_id == null && date('Y-m-d', strtotime($vcd->created_at)) == date('Y-m-d')){
                            $check_in++;
                        }
                        if($vcd->updated_by == $user->id && $vcd->receipt_id != null && date('Y-m-d', strtotime($vcd->updated_at)) == date('Y-m-d')){
                            $check_out++;
                        }
                    }
                }
                return response()->json([
                    'status' => 'true',
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'income' => $income,
                ]);
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'User not found!',
                ]);
            }
        }
    }

}
