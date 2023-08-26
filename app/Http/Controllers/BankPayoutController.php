<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankPayout;
use App\Models\BankPayoutStructure;
class BankPayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bankdata=BankPayout::orderBy('payout_id','DESC')->paginate(10);
        // dd($bankdata);
        return view('content.payout_structure.index',compact('bankdata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('content.payout_structure.add_payout');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'bank_name'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'min_loan'=>'required',
            'max_loan'=>'required',
            'loan_type'=>'required',
            'rate_of_commission'=>'required|regex:/^\d+(\.\d{1,2})?%$/',
        ],
        [
            'bank_name.required'=>'This field is required',
            'start_date.required'=>'This field is required',
            'end_date.required'=>'This field is required',
            'min_loan.required'=>'This field is required',
            'max_loan.required'=>'This field is required',
            'loan_type.required'=>'This field is required',
            'rate_of_commission.required'=>'This field is required',
            'rate_of_commission.regex'=>'Please enter percentage value,For Example.0.10%'
        ]);

        if($request->end_date)
        {
            if($request->end_date<=$request->start_date)
            {
                return redirect()->back()->withInput()
                ->withDanger('The End date must come after the start date.');                  
            }
        }
        if($request->max_loan)
        {
            if($request->max_loan<=$request->min_loan)
            {
                return redirect()->back()->withInput()
                ->withDanger('The maximum amount must be greater than the minimum amount.');                  
            }
        }
        $data['bank_name'] = isset($data['bank_name']) ? implode(',', $data['bank_name']) : null; // Store bank name 
        $data['condition'] = isset($data['condition']) ? implode(',', $data['condition']) : null; // Store bank name 
 
        $rateOfCommission = str_replace('%', '', $data['rate_of_commission']);
        $formattedRateOfCommission = number_format(floatval($rateOfCommission) / 100, 4, '.', '');      
        $data['rate_of_commission'] = $formattedRateOfCommission;    
        // Store the data   
       
            $bank_payout_structure = new BankPayoutStructure;
            $cutoutStatement = $request->cutout_statement;
            $extraPayout = $request->extra_payout;
            $remarkPayout = $request->remark;            

            /* Function to extract amount and extension*/
            function extractAmountAndExtension($string)
            {
                $cleanString = preg_replace('/[0-9,.]+%/', '', $string);
            
                $matches = [];
                preg_match('/([0-9,.]+)\s*(\w+)?/', $cleanString, $matches);
            
                if (count($matches) >= 2) 
                {
                    $amount = $matches[1];
                    $extension = isset($matches[2]) ? $matches[2] : '';
            
                    return [
                        'amount' => $amount,
                        'extension' => $extension
                    ];
                }
            
                return null; // Return null when no valid matches are found.
            }       
                        
            /* Function to extract rates from the statement*/
            function extractRates($string)
            {
                $matches = [];
                preg_match_all('/([0-9,.]+%)\s*(\w+)?/', $string, $matches);
            
                $rates = [];
                if (count($matches) >= 2) 
                {
                    foreach ($matches[1] as $index => $rate) 
                    {
                        $extension = isset($matches[2][$index]) ? $matches[2][$index] : null;
                        $rates[] = $rate;
                    }
                }
            
                return $rates;
            }
            /* Extract amount and extension from Cutout Statement*/
            $cutoutData = extractAmountAndExtension($cutoutStatement);
            $cutoutAmount =$cutoutData['amount'] ?? null;
            $cutoutExtension = $cutoutData['extension'] ?? null;
            
            /* Extract rates from Cutout Statement*/
            $cutoutRates = extractRates($cutoutStatement);
            
            /* Extract amount and extension from Extra Payout*/
            $extraData = extractAmountAndExtension($extraPayout);
            $extraAmount = $extraData['amount'] ?? null;
            $extraExtension = $extraData['extension'] ?? null;
            
            /*Extract rates from Extra Payout*/
            $extraRates = extractRates($extraPayout);
            
            /* Extract amount and extension from Remark*/
            $remarkData = extractAmountAndExtension($remarkPayout);
            $remarkAmount = $remarkData['amount'] ?? null;
            $remarkExtension = $remarkData['extension'] ?? null;
            
            /* Extract rates from Remark*/
            $remarkRates = extractRates($remarkPayout);
            
            /* Store the extracted values in the database*/
            function convertToNumber($amount, $extension)
            {
                $multipliers = [
                    'k' => 10000,
                    'Lacs' => 100000,
                    'cr' => 10000000,
                    
                ];            
                $cleanAmount = preg_replace('/[^0-9.]/', '', $amount);            
                if (isset($multipliers[$extension])) 
                {
                    $convertedAmount = floatval($cleanAmount) * $multipliers[$extension];
                } else
                {
                    $convertedAmount = floatval($cleanAmount);
                }
            
                return $convertedAmount;
            }                
            /*for type of condition*/           
            $selectedConditions = $request->input('condition', []);
            if (!in_array('cutout_statement', $selectedConditions)) 
            {
                unset($data['cutout_statement']);
            }
            if (!in_array('extra_payout', $selectedConditions)) 
            {
                unset($data['extra_payout']);
            }
            if (!in_array('remark', $selectedConditions)) 
            {
                unset($data['remark']);
            }            
            $bank_payout_structure->type_of_condition = json_encode($selectedConditions);            
         
            /*for rate*/           
            $rateArray = [
                        $cutoutRate =in_array('cutout_statement', $selectedConditions) ? $cutoutRates : 0,
                        $extraRate = in_array('extra_payout', $selectedConditions) ? $extraRates : 0,
                        $remarkRate = in_array('remark', $selectedConditions) ? $remarkRates : 0,
                    ];  
                    if (empty($cutoutRates)) {
                        $rateArray[0] = 0;
                    }
                    if (empty($extraRates)) {
                        $rateArray[1] = 0;
                    }
                    if (empty($remarkRates)) {
                        $rateArray[2] = 0;
                    }                            
            $bank_payout_structure->rate = json_encode($rateArray); 

            /*for Amount */
            $bank_payout_structure->amount = json_encode([
                in_array('cutout_statement', $selectedConditions) ? convertToNumber($cutoutAmount, $cutoutExtension) : 0,
                in_array('extra_payout', $selectedConditions) ? convertToNumber($extraAmount, $extraExtension) : 0,
                in_array('remark', $selectedConditions) ? convertToNumber($remarkAmount, $remarkExtension) : 0,
            ]);   
            // Save the data to the database
            $client=BankPayout::create($data);                       
            $client->bank_payout_structure()->save($bank_payout_structure);    

            //   $bankPayoutStructure = BankPayoutStructure::find($id); // Fetch the data from the database
            //     $amountData = json_decode($bankPayoutStructure->amount, true);               
            //     $cutoutAmount = $amountData[0];
            //     $extraAmount = $amountData[1];
            //     $remarkAmount = $amountData[2];             
            //     $totalAmount = $cutoutAmount + $extraAmount + $remarkAmount;              
            //     echo $totalAmount;


        return redirect()->route('payouts.index')->with('success', 'New Payout Added');
    }        


                  
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {     
        $data = BankPayout::findOrFail($id);         
        return view('content.payout_structure.show_payout', compact('data'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd
        $bankdata=BankPayout::findorfail($id);
    //    dd($bankdata);
        return view('content.payout_structure.edit',compact('bankdata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $request->validate([
            'bank_name'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'min_loan'=>'required',
            'max_loan'=>'required',
            'loan_type'=>'required',
            'rate_of_commission'=>'required|regex:/^\d+(\.\d{1,2})?%$/',
        ],
        [
            'bank_name.required'=>'This field is required',
            'start_date.required'=>'This field is required',
            'end_date.required'=>'This field is required',
            'min_loan.required'=>'This field is required',
            'max_loan.required'=>'This field is required',
            'loan_type.required'=>'This field is required',
            'rate_of_commission.required'=>'This field is required',
            'rate_of_commission.regex'=>'Please enter percentage value,For Example.0.10%'
        ]);

        if($request->end_date)
        {
            if($request->end_date<=$request->start_date)
            {
                return redirect()->back()->withInput()
                ->withDanger('The End date must come after the start date.');                  
            }
        }
        if($request->max_loan)
        {
            if($request->max_loan<=$request->min_loan)
            {
                return redirect()->back()->withInput()
                ->withDanger('The maximum amount must be greater than the minimum amount.');                  
            }
        }
        $data['bank_name'] = isset($data['bank_name']) ? implode(',', $data['bank_name']) : null; // Store bank name 
        $data['condition'] = isset($data['condition']) ? implode(',', $data['condition']) : null; // Store bank name 
 
        $rateOfCommission = str_replace('%', '', $data['rate_of_commission']);
        $formattedRateOfCommission = number_format(floatval($rateOfCommission) / 100, 4, '.', '');      
        $data['rate_of_commission'] = $formattedRateOfCommission;    
             // Store the data   
        $cutoutStatement = $request->cutout_statement;
        $extraPayout = $request->extra_payout;
        $remarkPayout = $request->remark;         
        $selectedConditions = $request->input('condition', []);

        $data['cutout_statement'] = in_array('cutout_statement', $selectedConditions) ? $cutoutStatement : null;
        $data['extra_payout'] = in_array('extra_payout', $selectedConditions) ? $extraPayout : null;
        $data['remark'] = in_array('remark', $selectedConditions) ? $remarkPayout: null;


        
        $bankpayout = BankPayout::findOrFail($id);
        $bankpayout->update($data);

        $bank_payout_structure = $bankpayout->bank_payout_structure ?: new BankPayoutStructure();
            $cutoutStatement = $request->cutout_statement;
            $extraPayout = $request->extra_payout;
            $remarkPayout = $request->remark;            

            /* Function to extract amount and extension*/
            function extractAmountAndExtension($string)
            {
                $cleanString = preg_replace('/[0-9,.]+%/', '', $string);
            
                $matches = [];
                preg_match('/([0-9,.]+)\s*(\w+)?/', $cleanString, $matches);
            
                if (count($matches) >= 2) 
                {
                    $amount = $matches[1];
                    $extension = isset($matches[2]) ? $matches[2] : '';
            
                    return [
                        'amount' => $amount,
                        'extension' => $extension
                    ];
                }
            
                return null; // Return null when no valid matches are found.
            }          
            
            
            /* Function to extract rates from the statement*/
            function extractRates($string)
            {
                $matches = [];
                preg_match_all('/([0-9,.]+%)\s*(\w+)?/', $string, $matches);
            
                $rates = [];
                if (count($matches) >= 2) 
                {
                    foreach ($matches[1] as $index => $rate) 
                    {
                        $extension = isset($matches[2][$index]) ? $matches[2][$index] : null;
                        $rates[] = $rate;
                    }
                }
            
                return $rates;
            }
            /* Extract amount and extension from Cutout Statement*/
            $cutoutData = extractAmountAndExtension($cutoutStatement);
            $cutoutAmount =$cutoutData['amount'] ?? null;
            $cutoutExtension = $cutoutData['extension'] ?? null;
            
            /* Extract rates from Cutout Statement*/
            $cutoutRates = extractRates($cutoutStatement);
            
            /* Extract amount and extension from Extra Payout*/
            $extraData = extractAmountAndExtension($extraPayout);
            $extraAmount = $extraData['amount'] ?? null;
            $extraExtension = $extraData['extension'] ?? null;
            
            /*Extract rates from Extra Payout*/
            $extraRates = extractRates($extraPayout);
            
            /* Extract amount and extension from Remark*/
            $remarkData = extractAmountAndExtension($remarkPayout);
            $remarkAmount = $remarkData['amount'] ?? null;
            $remarkExtension = $remarkData['extension'] ?? null;
            
            /* Extract rates from Remark*/
            $remarkRates = extractRates($remarkPayout);
            
            /* Store the extracted values in the database*/
            function convertToNumber($amount, $extension)
            {
                $multipliers = [
                    'k' => 10000,
                    'Lacs' => 100000,
                    'cr' => 10000000,                    
                ];
            
                $cleanAmount = preg_replace('/[^0-9.]/', '', $amount);
            
                if (isset($multipliers[$extension])) 
                {
                    $convertedAmount = floatval($cleanAmount) * $multipliers[$extension];
                } else 
                {
                    $convertedAmount = floatval($cleanAmount);
                }            
                return $convertedAmount;
            }            
            /*for type of condition*/           
            $selectedConditions = $request->input('condition', []);
            if (!in_array('cutout_statement', $selectedConditions)) 
            {
                unset($data['cutout_statement']);
            }
            if (!in_array('extra_payout', $selectedConditions)) 
            {
                unset($data['extra_payout']);
            }
            if (!in_array('remark', $selectedConditions)) 
            {
                unset($data['remark']);
            }            
            $bank_payout_structure->type_of_condition = json_encode($selectedConditions);            
         
            /*for rate*/           
            $rateArray = [
                        $cutoutRate =in_array('cutout_statement', $selectedConditions) ? $cutoutRates : 0,
                        $extraRate = in_array('extra_payout', $selectedConditions) ? $extraRates : 0,
                        $remarkRate = in_array('remark', $selectedConditions) ? $remarkRates : 0,
                    ];  
                    if (empty($cutoutRates)) {
                        $rateArray[0] = 0;
                    }
                    if (empty($extraRates)) {
                        $rateArray[1] = 0;
                    }
                    if (empty($remarkRates)) {
                        $rateArray[2] = 0;
                    }                            
            $bank_payout_structure->rate = json_encode($rateArray); 

            /*for Amount */
            $bank_payout_structure->amount = json_encode([
                in_array('cutout_statement', $selectedConditions) ? convertToNumber($cutoutAmount, $cutoutExtension) : 0,
                in_array('extra_payout', $selectedConditions) ? convertToNumber($extraAmount, $extraExtension) : 0,
                in_array('remark', $selectedConditions) ? convertToNumber($remarkAmount, $remarkExtension) : 0,
            ]);            
            $bank_payout_structure->save();        
            $bankpayout->bank_payout_structure()->save($bank_payout_structure);
 
    return redirect()->route('payouts.index')->with('success', 'Updated Successfully');
}       
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

