<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealestatesmIncentives extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'resm_incentives_id   ';
    protected $table = 'tbl_resmincentives';
    protected $fillable = [
    'from_date',
    'To_date',
    'disb_id',
    'client_id',
    'sm_user_id',
    'sm_incentive_value',
    'sm_Count',
    'TL_user_id',
    'TL_incentive_value',
    'TL_Count',
    ];
}
