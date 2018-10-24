<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CheckInOut extends Model
{
    protected $fillable = [
        'ticket_id', 'client_id','receipt_id', 'vehicle_reg'
    ];

    protected $rules = array(
        'ticket_id'  => 'required',
        'client_id'  => 'required',
        'receipt_id' => 'required',
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
}
