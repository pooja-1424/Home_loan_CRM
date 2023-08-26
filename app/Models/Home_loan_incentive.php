<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home_loan_incentive extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'incentive_id ';
    protected $table = 'home_loan_incentive';
    protected $fillable = [
    'Designation',
    'Min_Loan_Value',
    'Max_Loan_Value',
    'applicable_LV',
    'Payut_Percentage',
    'value',
    'Condition',
    ];

}
