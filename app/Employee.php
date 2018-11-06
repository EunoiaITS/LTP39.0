<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Employee extends Model
{
    protected $rules = array(
        'password' => 'required',
        'name' => 'required',
        'email' => 'required',
    );

    protected $errors;

    protected $table = 'employee';

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
