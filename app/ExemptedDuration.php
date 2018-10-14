<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ExemptedDuration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'duration',
    ];

    protected $rules = array(
        'duration'  => 'required',
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
