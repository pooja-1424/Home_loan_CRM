<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelecallerIncentive extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'telecaller_incentive_id  ';
    protected $table = 'tbl_telecallerincentives';
    protected $fillable = [
    'from_date',
    'To_date',
    'disb_id',
    'client_id',
    'user_id',
    'incentive_value',
    'Count',
    ];
    
}
