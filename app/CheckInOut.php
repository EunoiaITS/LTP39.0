<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CheckInOut extends Model
{
    protected $fillable = [
        'ticket_id', 'client_id', 'vehicle_reg', 'fair', 'vip_id'
    ];

    protected $rules = array(
        'client_id'  => 'required',
        'vehicle_reg' => 'required'
    );

    protected $table = 'check_in_out';

    protected $errors;

    public function validate($data)
    {
        $valid = Validator::make($data, $this->rules);
        if ($valid->fails())
        {
            $this->errors = $valid->errors();
            return false;
        }
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function vehicleType(){
        return $this->hasOne('App\VehicleCategory', 'id', 'vehicle_type');
    }

    public function createdBy(){
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function updatedBy(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }

}
