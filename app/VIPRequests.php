<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class VIPRequests extends Model
{
    protected $table = 'vip_requests';

    protected $rules = array(
        'client_id' => 'required',
        'car_reg' => 'required',
        'vipId'  => 'unique:vip_requests'
    );

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
