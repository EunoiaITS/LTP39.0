<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreateDevice extends Model
{
    protected $rules = array(
        'factory_id'  => 'required',
        'charger_id'  => 'required'
    );

    protected $errors;

    protected $table = 'create_device';

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
