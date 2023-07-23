<?php

namespace App\Models\comment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'tbl_hlcomments';
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'comment_id',
        'comments',
        'sanction_id',
        'client_id',
        'disb_id',
        'created_by',
        'updated_by'
    ];

    public function tbl_hlclient()
    {
        return $this->belongsTo('App\Models\contact\Contact','sanction_id');
    }

    public function tbl_hldisbursement()
    {
        return $this->belongsTo('App\Models\disbursement\Disbursement','disb_id');
    }

    public function tbl_hlsanction()
    {
        return $this->belongsTo('App\models\disbursement\Disbursement','disb_id');
    }
}
