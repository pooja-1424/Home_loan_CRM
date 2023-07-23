<?php

namespace App\Models\data_share;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_sharing_rule extends Model
{
    use HasFactory;

    public $table = 'data_sharing_rules';
    protected $fillable = [
        'group_id',
        'can_access_to_group_id'
    ];

    public function data_sharing_groups()
    {
        return $this->belongsTo('App\Models\data_share\data_sharing_group', 'id');
    }
}
