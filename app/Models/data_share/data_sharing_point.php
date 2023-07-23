<?php

namespace App\Models\data_share;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_sharing_point extends Model
{
    use HasFactory;

    public $table = 'data_sharing_point';
    public $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'group_id',
        'can_be_access_users_id'
    ];

    public function data_sharing_rules()
    {
        return $this->belongsTo('App\Models\data_share\data_sharing_rule', 'id', 'group_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id');
    }
}
