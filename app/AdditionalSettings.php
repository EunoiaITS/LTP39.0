<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AdditionalSettings extends Model
{
    protected $fillable = [
        'client_id', 'key', 'value', 'created_by', 'updated_by'
    ];

    protected $rules = array(
        'client_id'  => 'exists:users,id',
        'key' => 'required',
        'value' => 'required',
        'created_by'  => 'exists:users,id',
        'updated_by'  => 'exists:users,id'
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
