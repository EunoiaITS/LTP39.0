<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CompanyPayment extends Model
{
    protected $rules = array(
    'billing_id'  => 'required',
    'bill_due_date'  => 'required',
    'paid' => 'required'
);

    protected $errors;

    protected $table = 'company_payment';

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
