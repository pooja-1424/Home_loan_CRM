<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $primaryKey = 'user_id';
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = [
        
        'user_id',
        'emp_code',
        'firstname',
        'middlename',
        'lastname',
        'nickname',
        'mobile_no',        
        'email',
        'password',
        'password_confirmation',
        'date_of_birth',
        'pan_no',
        'qualification',
        'marital_status',
        'joining_date',
        'experience_in_year',
        'last_package',
        'designation',
        'remember_token',
        'permanant_address',
        'current_address',
        'home_contactno',
        'resignation_date',
        'status_id',
        'experience_in_months',
        'privious_company_contactname',
        'privious_company_contact',
        'source',
        'source_by',
        'remark_by_HR',
        'user_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function groups()
    {
        return $this->belongsToMany('App\Models\group\Group', 'group_user', 'group_id', 'user_id');
    }

    public function data_sharing_point()
    {
        return $this->hasOne('App\Models\data_share\data_sharing_point', 'user_id');
    }

}
