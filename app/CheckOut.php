<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CheckOut extends Model
{
    protected $fillable = [
        'receipt_id', 'ticket_id', 'total_charge'
    ];

    protected $rules = array(
        'receipt_id'  => 'required',
        'ticket_id' => 'required',
        'total_charge' => 'required'
    );

    protected $errors;

    protected $table = 'check_out';

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
