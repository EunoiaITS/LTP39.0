<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ParkingRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vehicle_id', 'base_hour', 'base_rate', 'sub_rate', 'exmin_id', 'exhr_id', 'created_by', 'modified_by'
    ];

    protected $rules = array(
        'vehicle_id'  => 'required|exists:vehicle_categories,id',
        'base_hour'  => 'required',
        'base_rate'  => 'required',
        'sub_rate'  => 'required',
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
