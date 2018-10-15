<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class VipParking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vehicle_id', 'client_id', 'duration', 'fair', 'created_by', 'modified_by'
    ];

    protected $rules = array(
        'vehicle_id'  => 'required|exists:vehicle_categories,id',
        'duration'  => 'required|numeric',
        'fair'  => 'required',
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
