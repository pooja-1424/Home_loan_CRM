<?php

namespace App\Models\group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupLeader extends Model
{
    use HasFactory;

    public $primaryKey = 'team_leader_id';
    protected $table = 'team_leaders';
    protected $fillable = [
        'team_id',
        'user_id',
        'from_date',
        'region_id',
        'team_leader_name'
    ];

    public function groups()
    {
        return $this->belongsTo('App\Models\group\Group', 'team_id');
    }
}
