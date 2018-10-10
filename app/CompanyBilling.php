<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CompanyBilling extends Model
{
    protected $rules = array(
        'billing_term'  => 'required',
        'billing_amount'  => 'required',
        'bill_start_date'  => 'required'
    );

    protected $errors;

    protected $table = 'company_billing';

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
