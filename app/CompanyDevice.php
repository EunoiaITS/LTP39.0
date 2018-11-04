<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CompanyDevice extends Model
{
    protected $rules = array(
        'device_id'  => 'required|unique:company_device',
        'factory_id'  => 'required|unique:company_device',
    );

    protected $errors;

    protected $table = 'company_device';

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
