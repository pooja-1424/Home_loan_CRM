<?php

namespace App\Models\sanction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanction extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'tbl_hlsanction';

    protected $primaryKey = 'sanction_id';

    protected $fillable = [
        'sanction_id',
        'client_id',
        'login_date',
        'pick_up_date',
        'loan_amount',
        'bank_name',
        'requirements',
        'status',
        'sanction_date',
        'sanction_loan_amt',
        'sanction_requirements',
        'expiry_date',
        'file_number',
        'sanction_status',
    ];
    public function  tbl_hlclient()
    {
        return $this->belongsTo('App\Models\contact\Contact','sanction_id');
       
    }
    public function tbl_hlcomments()
    {
     return $this->hasMany('App\Models\comment\Comment', 'sanction_id');
    }
    public function tbl_hldisbursement(){
        return $this->hasMany('App\Models\disbursement\Disbursement','client_id');
    }

}
