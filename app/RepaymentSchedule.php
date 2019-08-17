<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepaymentSchedule extends Model
{
    protected $fillable = ['loan_id','date','payment_amount','principal','interest','balance'];
}
