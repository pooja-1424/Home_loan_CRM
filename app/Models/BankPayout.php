<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankPayout extends Model
{
  
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'payout_id';
    protected $table = 'bank_payouts';
    protected $fillable = 
    ['bank_name',
     'start_date',
      'end_date', 
      'min_loan',
       'max_loan', 
       'loan_type',
        'frequency', 
        'rate_of_commission',
         'incentive_releasestte', 
         'condition', 'cutout_statement', 
         'extra_payout', 
         'remark'];

    public function bank_payout_structure()
{
    return $this->hasOne(BankPayoutStructure::class, 'payout_id');
}
}

