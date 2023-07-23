<?php

namespace App\Models\contact;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'client_id';
    protected $table = 'tbl_hlclients';
    protected $fillable = [
        'fname',
        'lname',
        'mobile1',
        'mobile2',
        'email1',
        'email2',
        'address',
        'city',
        'state',
        'country',
        'date_of_birth',
        'rating',
        'Type_of_Loan',
        'Bank_name',
        'Lead_source',
        'Lead_Status',
        'lead_source_details',
        'Lead_Status',
        'Tracking_Status',
        'Tracking_Status_Sub', 
        'Follow_Up_Date',       
        'Team_Leader',
        'Assigned_To',
        'Interested_bank',
        'Back_end_source',
        'Lead_source_by_emp',
        'Loan_required.',
        'Current_Residence_At',
        'property_phase_req',
        'project_id',
        'Porperty_Address',
        'Property_Value',
        'Sourcing_Manager',
        'profile',
        'companyname',
        'is_proprty_final',
        'Reamrk',
        'type_of_customer',
        'is_homeloan_required',
        'reference_take_or_not',
        'Reference',
        'client_status', 
        'lead_source_sm',
        'lead_source_TL',   
        'closing_by',   

    ];

        public function tbl_hlsanction(){
            return $this->hasMany('App\Models\sanction\Sanction','client_id');
            
        }
        public function tbl_hldisbursement(){
            return $this->hasMany('App\Models\disbursement\Disbursement','client_id');
        }
        public function tbl_hlcomments(){
            return $this->hasMany('App\Models\comment\Comment','client_id');
        }
        public function tbl_hlsanctions(){
            return $this->belongsTo('App\models\sanction\Sanction','sanction_id');

}
}
