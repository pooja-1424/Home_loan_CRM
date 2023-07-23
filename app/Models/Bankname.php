<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankname extends Model
{   public $timestamps = false;
    use HasFactory;
    
    protected $table = 'bank_details';
    public $primaryKey = 'bank_id';
    protected $fillable = [
        'bank_id',
        'bank_name',
    ];
}
