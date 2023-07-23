<?php

namespace App\Models\group;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $primaryKey = 'team_id';
    // protected $table = 'groups';
    protected $table = 'teams';
    protected $fillable = [
        'teamname'
    ];

    public function tbl_hlusers()
    {
        return $this->belongsToMany('App\Models\User', 'teamdetails', 'team_id', 'user_id');
    }

    public function group_leaders()
    {
        return $this->hasMany('App\Models\group\GroupLeader','team_id');
    }
}
