<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ExemptedTime extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'from', 'to',
    ];

    protected $rules = array(
        'from'  => 'required',
        'to'  => 'required',
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
