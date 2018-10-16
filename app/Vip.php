<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Vip extends Model
{
    protected $table = 'vip';

    protected $fillable = [
        'client_id', 'vip_id',
    ];

    protected $rules = array(
        'client_id'  => 'required',
        'vip_id'  => 'required'
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
