<?php

namespace App\Models\role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'designations';
    protected $primarykey="designation_id";

    protected $fillable =[
        "designation_id",
        "designation",
        "boolean_value"
        
    ];
}
