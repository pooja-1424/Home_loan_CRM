<?php

namespace App\Models\data_share;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_sharing_group extends Model
{
    use HasFactory;

    public $primaryKey = 'id';
    protected $table = 'data_sharing_groups';
    protected $fillable = [
        'id',
        'name',
        'users',
    ];

    public function data_sharing_rules()
    {
        return $this->hasMany('App\Models\data_share\data_sharing_rule','group_id');
    }
}
