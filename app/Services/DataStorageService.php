<?php

namespace App\Services;
use App\Models\User;
use App\Models\TelecallerIncentive;
use App\Models\RealestatesmIncentives;
use App\Models\contact\Contact;
use App\Models\disbursement\Disbursement;
use App\Models\sanction\Sanction;
use App\Models\Home_loan_incentive;
use App\Services\DataStorageService;
class DataStorageService
{
    public function storeTelecallerData($data,$disb_id)
    {        
        
        $disb_date = $data['disb_date'];
        $startDate = new \DateTime($disb_date);
        
        /* Set the start date to the first day of the same month*/
        $startDate->modify('first day of this month');
        
        /* Get the last day of the month*/
        $endDate = clone $startDate;
        $endDate->modify('last day of this month');

        /* Format the dates */
        $formattedStartDate = $startDate->format('Y-m-d'); 
        $formattedEndDate = $endDate->format('Y-m-d');         
              
        $Assigned_to = Contact::select('Assigned_To')
        ->where('client_id', '=', $data['client_id'])
        ->get();    
        $decodedData = json_decode($Assigned_to);       
        foreach ($decodedData as $item) 
        {
            $assignedTo = $item->Assigned_To;              
            $names = explode(' ', $assignedTo);           
            $user = User::select('user_id')
                ->where('firstname', $names[0])
                ->where('lastname', $names[1])
                ->first();

            $formDate = date('Y-m-d', strtotime($formattedStartDate));    
            $toDate = date('Y-m-d', strtotime($formattedEndDate));

            $monthlyCount = TelecallerIncentive::where('user_id', $user->user_id)
            ->where('client_id', $data['client_id'])
            ->whereBetween('from_date', [$formDate, $toDate])
            ->count();
         /* Increment the count for each disbursement*/
             $currentCount = $monthlyCount + 1;           
                       
            $disbursement = new Disbursement();      
            if($disbursement->status=$data['status']=='first_disbursement')
            {
                $IncentiveValue=Home_loan_incentive::select('condition')
                ->get();          
                $telecallerIncentive = new TelecallerIncentive();
                $value=Home_loan_incentive::select('value')
                ->where('condition','=',$IncentiveValue[6]->condition)
                ->get();                 
                
                foreach($value as $incentiv_value1)
                {                     
                $baseIncentiveValue = $incentiv_value1->value; /* Initial incentive value*/
                $incrementAmount = $incentiv_value1->value;        
                $telecallerIncentive->from_date = $formDate;
                $telecallerIncentive->to_date = $toDate;
                $telecallerIncentive->user_id = $user->user_id;
                $telecallerIncentive->client_id = $data['client_id'];
                $telecallerIncentive->disb_id = $disb_id['disb_id'];
                $telecallerIncentive->incentive_value = $incentiveValue = $baseIncentiveValue + (($currentCount - 1) * $incrementAmount);/*calculate incentive value based on count*/
                $telecallerIncentive->Count = $currentCount;       
                $telecallerIncentive->save();
                }
            }           
            else
            {
                $IncentiveValue=Home_loan_incentive::select('condition')
                ->get();          
                $telecallerIncentive = new TelecallerIncentive();
                $value=Home_loan_incentive::select('value')
                ->where('condition','=',$IncentiveValue[6]->condition)
                ->get();  
                
                foreach($value as $incentiv_value1)
                {      
                $baseIncentiveValue = $incentiv_value1->value; /*Initial incentive value*/
                $incrementAmount = $incentiv_value1->value;     
                $telecallerIncentive->from_date = $formDate;
                $telecallerIncentive->to_date = $toDate;
                $telecallerIncentive->user_id = $user->user_id;
                $telecallerIncentive->client_id = $data['client_id'];
                $telecallerIncentive->disb_id = $disb_id['disb_id'];
                $telecallerIncentive->incentive_value = $incentiveValue = $baseIncentiveValue + (($currentCount - 1) * $incrementAmount);                  
                $telecallerIncentive->Count = $currentCount;
                $telecallerIncentive->save();
                }
            } 
          
        }
    }


    public function storeSMData($data,$disb_id)
    {     
        $disb_date = $data['disb_date'];
        $startDate = new \DateTime($disb_date);
        
        /* Set the start date to the first day of the same month*/
        $startDate->modify('first day of this month');
        
        /* Get the last day of the month*/
        $endDate = clone $startDate;
        $endDate->modify('last day of this month');
        
        /* Format the dates */
        $formattedStartDate = $startDate->format('Y-m-d'); 
        $formattedEndDate = $endDate->format('Y-m-d');   
          
        $disb_date = $data['disb_date'];
        $LeadsourceSM = Contact::select('lead_source_sm')
        ->where('client_id', '=', $data['client_id'])
        ->get();   
        $LeadsourceTL = Contact::select('lead_source_TL')
        ->where('client_id', '=', $data['client_id'])
        ->get();   
            
        $decodedsmData = json_decode($LeadsourceSM);       
        foreach ($decodedsmData as $item) 
        {
            $LeadsourceSM = $item->lead_source_sm;              
            $names = explode(' ', $LeadsourceSM);           
            $user = User::select('user_id') /* get user_id */
                ->where('firstname', $names[0])
                ->where('lastname', $names[1])
                ->first();
              
        $decodedTLData = json_decode($LeadsourceTL);       
        foreach ($decodedTLData as $item) 
        {
            $LeadsourceTL = $item->lead_source_TL;              
            $names = explode(' ', $LeadsourceTL);           
            $userTL = User::select('user_id') /* get TL_user_id */
                ->where('firstname', $names[0])
                ->where('lastname', $names[1])
                ->first();
                
                $formDate = date('Y-m-d', strtotime($formattedStartDate));    
                $toDate = date('Y-m-d', strtotime($formattedEndDate)); 

                $monthlyCount = RealestatesmIncentives::where('sm_user_id', $user->user_id)
                ->where('client_id', $data['client_id'])
                ->whereBetween('from_date', [$formDate, $toDate])
                ->count();
             /* Increment the count for each disbursement*/
                 $currentCount = $monthlyCount + 1;  

            $disbursement = new Disbursement();      
            if($disbursement->status=$data['status']=='first_disbursement')
            {
                $IncentiveValue=Home_loan_incentive::select('condition')
                ->get();          
                $telecallerIncentive = new RealestatesmIncentives();
                $value=Home_loan_incentive::select('value')
                ->where('condition','=',$IncentiveValue[6]->condition)
                ->get();  
                
                foreach($value as $incentiv_value1)
                {     
                $baseIncentiveValue = $incentiv_value1->value; /* Initial incentive value */
                $incrementAmount = $incentiv_value1->value;         
                $telecallerIncentive->from_date = $formDate;
                $telecallerIncentive->to_date = $toDate;
                $telecallerIncentive->sm_user_id = $user->user_id;
                $telecallerIncentive->client_id = $data['client_id'];
                $telecallerIncentive->disb_id = $disb_id['disb_id'];
                $telecallerIncentive->sm_incentive_value = $incentiveValue = $baseIncentiveValue + (($currentCount - 1) * $incrementAmount);
                $telecallerIncentive->sm_Count = $currentCount;               
                $telecallerIncentive->TL_user_id=$userTL->user_id; 
                $telecallerIncentive->TL_incentive_value = $incentiveValue = ($baseIncentiveValue + (($currentCount - 1) * $incrementAmount)) / 2;
                $telecallerIncentive->TL_Count=$currentCount;  
                $telecallerIncentive->save();
                }
            }          
                else
                {
                    $IncentiveValue=Home_loan_incentive::select('condition')
                    ->get();          
                    $telecallerIncentive = new RealestatesmIncentives();
                    $value=Home_loan_incentive::select('value')
                    ->where('condition','=',$IncentiveValue[6]->condition)
                    ->get();  
                    
                    foreach($value as $incentiv_value1)
                    {        
                    $baseIncentiveValue = $incentiv_value1->value; /* Initial incentive value */
                    $incrementAmount = $incentiv_value1->value;      
                    $telecallerIncentive->from_date = $formDate;
                    $telecallerIncentive->to_date = $toDate;
                    $telecallerIncentive->sm_user_id = $user->user_id;
                    $telecallerIncentive->client_id = $data['client_id'];
                    $telecallerIncentive->disb_id = $disb_id['disb_id'];
                    $telecallerIncentive->sm_incentive_value = $incentiveValue = $baseIncentiveValue + (($currentCount - 1) * $incrementAmount);
                    $telecallerIncentive->sm_Count = $currentCount;
                    $telecallerIncentive->TL_user_id=$userTL->user_id;                    
                    $telecallerIncentive->TL_incentive_value = $incentiveValue = ($baseIncentiveValue + (($currentCount - 1) * $incrementAmount)) / 2;
                    $telecallerIncentive->TL_Count=$currentCount;    
                    $telecallerIncentive->save();
                    }
                }   
            }
        }
    }   

    public function updateTelecallerData($data,$request)
    {
        /* update telecaller user */
        $assignedto = $data['Assigned_To'];              
        $names = explode(' ', $assignedto);           
        $user = User::select('user_id')
            ->where('firstname', $names[0])
            ->where('lastname', $names[1])
            ->first();

            $clientIds = $data['mobile1'];
            $clientId=Contact::select('client_id')
            ->where('mobile1','=',$clientIds)
            ->get();
        foreach($clientId as $clientid)
        {           
            $telecallerData= TelecallerIncentive::where('client_id','=',$clientid->client_id)->update(['user_id'=> $user->user_id ]);
            
        }
    }

    public function updateSMData($data,$request)
    {
        /* update sales manager */
        $LeadsourceSM = $data['lead_source_sm'];              
        $names = explode(' ', $LeadsourceSM);           
        $user = User::select('user_id')
            ->where('firstname', $names[0])
            ->where('lastname', $names[1])
            ->first();

            $clientIds = $data['mobile1'];
            $clientId=Contact::select('client_id')
            ->where('mobile1','=',$clientIds)
            ->get();
        foreach($clientId as $clientid)
        {           
            $telecallerData= RealestatesmIncentives::where('client_id','=',$clientid->client_id)->update(['sm_user_id'=> $user->user_id ]);
            
        }
    }

    public function updateTLData($data,$request)
    {
       /* update TL */
        $LeadsourceTL = $data['lead_source_TL'];                   
        $names = explode(' ', $LeadsourceTL);           
        $user = User::select('user_id')
            ->where('firstname', $names[0])
            ->where('lastname', $names[1])
            ->first();
            $clientIds = $data['mobile1'];
            $clientId=Contact::select('client_id')
            ->where('mobile1','=',$clientIds)
            ->get();
        foreach($clientId as $clientid)
        {           
            $telecallerData= RealestatesmIncentives::where('client_id','=',$clientid->client_id)->update(['TL_user_id'=> $user->user_id ]);
            
        }
    }

    public function updateDate($data,$request)
    {
        /* update date in disbursement */
        $disb_date = $data['disb_date'];
        $startDate = new \DateTime($disb_date);
        
        /* Set the start date to the first day of the same month */
        $startDate->modify('first day of this month');
        
        /* Get the last day of the month */
        $endDate = clone $startDate;
        $endDate->modify('last day of this month');

        /* Format the dates */
        $formattedStartDate = $startDate->format('Y-m-d'); 
        $formattedEndDate = $endDate->format('Y-m-d');    

        $formDate = date('Y-m-d', strtotime($formattedStartDate));    
        $toDate = date('Y-m-d', strtotime($formattedEndDate));     
     
        $disbursementRecords = Disbursement::all();

        foreach ($disbursementRecords as $record) 
        {
        $startDate = $record->formDate;
        $endDate = $record->toDate;
        
        $startMonth = (int) date('m', strtotime($formDate));
        $endMonth = (int) date('m', strtotime($toDate));
        
        $disbursementCount = 0;

        for ($month = $startMonth; $month <= $endMonth; $month++) 
        {
        $monthlyCount = TelecallerIncentive::where('from_date', '<=', $toDate)
            ->where('To_date', '>=', $formDate)
            ->whereMonth('from_date', $month)
            ->whereMonth('To_date', $month)
            ->where('client_id','=',$data['client_id'])
            ->count();        
            $currentCount = $monthlyCount;  /* datewise counting */
      
        $IncentiveValue=Home_loan_incentive::select('condition')
        ->get();          
        $telecallerIncentive = new TelecallerIncentive();
        $value=Home_loan_incentive::select('value')
        ->where('condition','=',$IncentiveValue[6]->condition)
        ->get();                 
        
        foreach($value as $incentiv_value1)
        {                     
        $baseIncentiveValue = $incentiv_value1->value; /* Initial incentive value */
        $incrementAmount = $incentiv_value1->value;  
           
        $telecallerIncentive->incentive_value = $incentiveValue = $baseIncentiveValue + (($currentCount - 1) * $incrementAmount);/* calculated incentive value */
        $telecallerIncentive->Count = $currentCount;       
        
        /* update telecaller data with incentive calculation */
        $telecallerData = TelecallerIncentive::where('disb_id', '=', $data['disb_id'])
        ->update([
            'from_date' => $formDate,
            'To_date' => $toDate, 
            'incentive_value' =>$telecallerIncentive->incentive_value,
            'Count'=>$telecallerIncentive->Count
                  
        ]);       

        $IncentiveValue=Home_loan_incentive::select('condition')
        ->get();          
        $telecallerIncentive = new RealestatesmIncentives();
        $value=Home_loan_incentive::select('value')
        ->where('condition','=',$IncentiveValue[6]->condition)
        ->get();  
        
        foreach($value as $incentiv_value1)
        {        
        $baseIncentiveValue = $incentiv_value1->value; /* Initial incentive value */
        $incrementAmount = $incentiv_value1->value;    
      
        $telecallerIncentive->sm_incentive_value = $incentiveValue = $baseIncentiveValue + (($currentCount - 1) * $incrementAmount);
        $telecallerIncentive->sm_Count = $currentCount;
                      
        $telecallerIncentive->TL_incentive_value = $incentiveValue = ($baseIncentiveValue + (($currentCount - 1) * $incrementAmount)) / 2;
        $telecallerIncentive->TL_Count=$currentCount;  

        /* update Real-Estate telecaller & TL data with incentive calculation */
         $telecallerData = RealestatesmIncentives::where('disb_id', '=', $data['disb_id'])
        ->update([
            'from_date' => $formDate,
            'To_date' => $toDate,
            'sm_incentive_value' =>$telecallerIncentive->sm_incentive_value,
            'sm_Count'=>$telecallerIncentive->sm_Count,
            'TL_incentive_value'=>$telecallerIncentive->TL_incentive_value,
            'TL_Count'=>$telecallerIncentive->TL_Count
        ]);
        }   
        }
        }
        }   
    }
}