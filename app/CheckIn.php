<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CheckIn extends Model
{
    protected $fillable = [
        'ticket_id', 'vehicle_type', 'vehicle_reg'
    ];

    protected $rules = array(
        'ticket_id'  => 'required',
        'vehicle_type' => 'required',
        'vehicle_reg' => 'required'
    );

    protected $table = 'check_in';

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
}
