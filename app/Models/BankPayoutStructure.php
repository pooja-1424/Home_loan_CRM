<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankPayoutStructure extends Model
{
    public $timestamps = false;
    public $primaryKey = 'bank_payout_id';
    protected $table = 'bank_payout_structures';
    protected $fillable = [
        'payout_id',
        'type_of_condition',
        'rate',
        'amount',
        ];
    public function bank_payouts()
    {
        return $this->belongsTo(BankPayout::class, 'payout_id');
    }
}
