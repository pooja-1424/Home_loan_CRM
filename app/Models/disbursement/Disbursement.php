<?php

namespace App\Models\disbursement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'disb_id';
    protected $table = 'tbl_hldisbursement';
    protected $fillable = [
        'client_id',
        'sanction_id',
        'disb_date',
        'disb_amt',
        'LRT_amt',       
        'pending_disb' ,
        'sanction_file',
        'bank_name',
        'status',
        'disbursement_status',
       ];
       public function  tbl_hlclient()
       {
           return $this->belongsTo('App\Models\contact\Contact','disb_id');           
       }
       
       public function tbl_hlcomments()
       {
        return $this->hasMany('App\Models\comment\Comment', 'disb_id' );
       }
       public function tbl_hlsanction()
       {
           return $this->belongsTo('App\models\sanction\Sanction','sanction_id');
       }
       
}
