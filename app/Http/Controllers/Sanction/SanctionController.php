<?php

namespace App\Http\Controllers\Sanction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\sanction\Sanction;
use App\Models\comment\Comment;
use DB;
use App\Models\contact\Contact;
use App\Models\disbursement\Disbursement;
use App\Models\Bankname;
use App\helpers\commentHelper as helper;
use Auth;

class SanctionController extends Controller
{   
    function __construct()
    {
        $this->middleware('permission:sanction-list|sanction-create|sanction-edit|sanction-delete', ['only' => ['index','store']]);
        $this->middleware('permission:sanction-create', ['only' => ['create','store']]);
        $this->middleware('permission:sanction-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sanction-delete', ['only' => ['destroy']]);
    }

    public function sanctionFilterQuery($fields = [], $conditions = [], $joins = [])
    {
        // dd(Auth::user()->getRoleNames());
        $userData = session('can_be_access_users_id');
        
        $query = DB::table('tbl_hlclients');
        
        /* Select specific fields */
        if(!empty($fields)) $query->select($fields);
        
        $query->join('users', 'tbl_hlclients.Assigned_To', '=', DB::raw("CONCAT(users.firstname, ' ', users.lastname)"));
       
        /* Apply dynamic joins*/
        if(!empty($joins))
        {
            foreach ($joins as $join) {
                $query->join($join['table'], $join['column1'], $join['operator'], $join['column2']);
            }
        }
        
        if(!empty($userData))
        {
            $query->whereIn('users.user_id', json_decode($userData));
        }
        else $query->where('users.user_id', Auth::user()->user_id);

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        return $query;
    }

     public function index()
     {
        /* restrict users to list data except admin and team leader  */
        if (!Auth::user()->hasRole(['Admin', 'team leader'])) // && $userId != Auth::id())
        {
            $joins = [
                ['table' => 'tbl_hlsanction', 'column1' => 'tbl_hlclients.client_id', 'operator' => '=', 'column2' => 'tbl_hlsanction.client_id']
            ];
            $fields = ['tbl_hlsanction.*'];
            $results = $this->sanctionFilterQuery($fields, [], $joins);
            $data=$results->orderBy('sanction_id','DESC')->paginate(10);
        }
        else
        {
            $data=Sanction::orderBy('sanction_id','DESC')->paginate(10);
        }
        $data=Sanction::orderBy('sanction_id','DESC')->paginate(10);
        $sanctionData = DB::table('tbl_hlsanction')
                    ->join('tbl_hlclients', 'tbl_hlclients.client_id', '=', 'tbl_hlsanction.client_id')
                    ->select('*')
                    ->orderBy('sanction_id', 'DESC')
                    ->get();
        
        return view('content.sanction.sanction',compact('data','sanctionData'));
     }

     public function create(Sanction $sanction, Request $request)
     {
         /* restrict users to create data except admin and team leader  */
         if (!Auth::user()->hasRole(['Admin', 'team leader'])) // && $userId != Auth::id())
        {
            $fields = ['tbl_hlclients.*'];
            $results = $this->sanctionFilterQuery($fields);
            $getResArr = $results->pluck('client_id')->toArray();
            $list = Contact::where('Tracking_Status_Sub', 'Pick_Up_Done')
            ->whereIn('client_id', $getResArr)
            ->get();
        }
        else
        {
            $list = Contact::where('Tracking_Status_Sub', 'Pick_Up_Done')->get();
        }
        
        $banklist = Bankname::all();
        return view('content.sanction.sanction_add',compact('sanction','list','banklist'));
     }

    public function store(Request $request)
    {        
        $request->validate([
            
            'client_id' => 'required',
            'login_date' => 'required',
            'pick_up_date' => 'required',
            'loan_amount' => 'required|numeric',
            'bank_name' => 'required',
            'status' => 'required',
            'sanction_date' => 'required_if:status,==,Sanctioned',
            'sanction_loan_amt' => 'required_if:status,==,Sanctioned',
            'sanction_requirements' => 'required_if:status,==,Sanctioned',
            'expiry_date' => 'required_if:status,==,Sanctioned',
            'file_number' => 'required_if:status,==,Sanctioned',
             ],
            [
            'client_id.required'=>'This field is required',
            'login_date.required'=>'Login date is required',
            'pick_up_date.required'=>'Pick Up date is required',
            'loan_amount.required'=>'Loan amount is required',
            'bank_name.required'=>'Bank Name is required',
            'status.required'=>'Status is required',
            'sanction_date.required_if' => 'Sanction date is required',
            'sanction_loan_amt.required_if'=>'Sanction Loan Amount is required',
            'sanction_requirements.required_if'=>'Sanction requirements is required',
            'expiry_date.required_if'=>'Expiry Date is required',
            'file_number.required_if'=>'File Number is required',
            ]);

        /* pickup date must be earlier than the login date */
        $login_date = $request->login_date;
        $pick_up_date = $request->pick_up_date;
        $sanction_date = $request->sanction_date;
        // $expiry_date = $request->expiry_date;
        if($login_date<=$pick_up_date)
        {
            if ($request->ajax()){
                return response()->json([
                    'success' => false,
                    'message' => 'Pickup date must be earlier than the login date.',
                ]);
                }
                else{
                    return redirect()->back()->withInput()
             ->withDanger('Pickup date must be earlier than the login date.');
                }
        }
        /* sanction date must come after the pick-up and login dates */
        if($request->sanction_date){
            if(($sanction_date<=$login_date) && ($sanction_date<=$pick_up_date))
            {
                if ($request->ajax()){
                    return response()->json([
                        'success' => false,
                        'message' => 'The sanction date must come after the pickup dates and login dates.',
                    ]);
                    } else{
                        return redirect()->back()->withInput()
                ->withDanger('The sanction date must come after the pickup dates and login dates.');
                    } 
                
            }
        /* sanction date must come after the login dates */
        if($sanction_date<=$login_date)
        { 
            if ($request->ajax()){
                return response()->json([
                    'success' => false,
                    'message' => 'The sanction date must come after the login dates.',
                ]);
                }
            else{
                     return redirect()->back()->withInput()
            ->withDanger('The sanction date must come after the login dates.');  
                }
        }
    }
         /* check sanction loan amount may not be greater than loan amount */
        $loan_amount = $request->loan_amount;
        $sanction_loan_amount = $request->sanction_loan_amt;
        if($loan_amount<$sanction_loan_amount)
        {
            if ($request->ajax()){
                return response()->json([
                    'success' => false,
                    'message' => 'Sanction amount may not be greater than loan amount.',
                ]);
                }
            else{
            return redirect()->back()->withInput()
            ->withDanger('Sanction amount may not be greater than loan amount.');  
        }
    }

        /* existence of file number with same bank name */
        if ((Sanction::where('file_number', '=', $request->file_number)
            ->where('bank_name', '=', $request->bank_name)->exists()) && ($request->file_number!='' && $request->bank_name != '')){
                if ($request->ajax()){
                    return response()->json([
                        'success' => false,
                        'message' => 'File number already exist.',
                    ]);
                    }
                else{
                    return redirect()->back()->withInput()->withDanger('File number already exist.');
                    }
        }

        $sanction = Sanction::create($request->all()); 
	    if($request->comments) Helper::addComment($sanction->sanction_id,$request->comments, "sanction");
        if ($request->ajax()){
                return response()->json([
                    'success' => true,
                    'message' => 'New Sanction added',
                ]);
                }else{
                    return redirect('sanction')->withSuccess('New Sanction added');
                }
        }

    public function show(Sanction $sanction)
    {
        // dd($sanction->sanction_id);
        /* restrict users to show data except admin and team leader  */
        if (!Auth::user()->hasRole(['Admin', 'team leader'])) {
            $fields = ['tbl_hlclients.*', 'tbl_hlsanction.*'];
            $joins = [
                ['table' => 'tbl_hlsanction', 'column1' => 'tbl_hlclients.client_id', 'operator' => '=', 'column2' => 'tbl_hlsanction.client_id']
            ];
            $conditions = [
                'tbl_hlclients.client_id' => $sanction->client_id
            ];
            $results = $this->sanctionFilterQuery($fields, $conditions, $joins);
            $showData = $results->first();
      
            if(!isset($showData->client_id))
            {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        $data=Contact::findorfail($sanction->client_id);
        $data1=$data->tbl_hlsanction;
        $data2=$data->tbl_hldisbursement;
        
        $comData=Sanction::findorfail($sanction->sanction_id);
        $comData1=$comData->tbl_hlcomments;

        $comment = Comment::where('sanction_id', $sanction->sanction_id)->orderBy('comment_id','desc')->get();
        
        $Data = Sanction::select('client_id')
        ->where('status', '=', 'Sanctioned')
        ->orWhere('status', '=', 'Partial_Disbursed')
        ->get();   
        if($Data)
        {
        $cname = Contact::select('fname','client_id')
          ->whereIn('client_id',$Data)       
          ->get();
        } 
        
        $disbdata = Sanction::select('file_number','sanction_id')
        ->where('client_id',$data->client_id)       
        ->get();      
        return view('content.sanction.show',compact('comData','data','sanction','comment','cname','disbdata'));
     
    } 
    
    public function edit(Sanction $sanction)
    {
        /* restrict users to edit data except admin and team leader */
        if (!Auth::user()->hasRole(['Admin', 'team leader']))
        {
            $fields = ['tbl_hlclients.*', 'tbl_hlsanction.*'];
            $joins = [
                ['table' => 'tbl_hlsanction', 'column1' => 'tbl_hlclients.client_id', 'operator' => '=', 'column2' => 'tbl_hlsanction.client_id']
            ];
            $conditions = [
                'tbl_hlclients.client_id' => $sanction->client_id
            ];
            $results = $this->sanctionFilterQuery($fields, $conditions, $joins);
            $getResArr = $results->pluck('client_id')->toArray();
            $list = Contact::where('Tracking_Status_Sub', 'Pick_Up_Done')
            ->whereIn('client_id', $getResArr)
            ->get();
            $showData = $results->first();
      
            if(!isset($showData->client_id))
            {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }
        else
        {
            $list = Contact::where('Tracking_Status_Sub', 'Pick_Up_Done')->get();
        }


        $Sanction = Sanction::where('sanction_id',$sanction->sanction_id)->first();

        $value=Contact::findorfail($Sanction->client_id);
        $value1=$value->tbl_hlsanction;
        $value2=$value->tbl_hldisbursement;
        
        return view('content.sanction.sanction_edit', compact('list','Sanction','value'));
       
    }

    public function update(Request $request, $sanction_id)
    {
        $request->validate([

            'client_id' => 'required',
            'login_date' => 'required',
            'pick_up_date' => 'required',
            'loan_amount' => 'required|numeric',
            'bank_name' => 'required',
            'status' => 'required',
            'sanction_date' => 'required_if:status,==,Sanctioned',
            'sanction_loan_amt' => 'required_if:status,==,Sanctioned',
            'sanction_requirements' => 'required_if:status,==,Sanctioned',
            'expiry_date' => 'required_if:status,==,Sanctioned',
            'file_number' => 'required_if:status,==,Sanctioned',
            ],
            [
            'client_id.required'=>'This field is required',
            'login_date.required'=>'Login date is required',
            'pick_up_date.required'=>'Pick Up date is required',
            'loan_amount.required'=>'Loan amount is required',
            'bank_name.required'=>'Bank Name is required',
            'status.required'=>'Status is required',
            'sanction_date.required_if' => 'Sanction date is required',
            'sanction_loan_amt.required_if'=>'Sanction Loan Amount is required',
            'sanction_requirements.required_if'=>'Sanction requirements is required',
            'expiry_date.required_if'=>'Expiry Date is required',
            'file_number.required_if'=>'File Number is required',
            ]);

        /* pickup date must be earlier than the login date */
        $login_date = $request->login_date;
        $pick_up_date = $request->pick_up_date;
        $sanction_date = $request->sanction_date;
        // $expiry_date = $request->expiry_date;
        if($login_date<=$pick_up_date)
        {
             return redirect()->back()->withInput()
             ->withDanger('Pickup date must be earlier than the login date.'); 
        }
        /* sanction date must come after the pick-up and login dates */
        if($request->sanction_date){
            if(($sanction_date<=$login_date) && ($sanction_date<=$pick_up_date))
            {
                return redirect()->back()->withInput()
                ->withDanger('The sanction date must come after the pickup dates and login dates.');  
            }
        /* sanction date must come after the login dates */
        if($sanction_date<=$login_date)
        {
            return redirect()->back()->withInput()
            ->withDanger('The sanction date must come after the login dates.');  
        }
    }
        /* check sanction loan amount may not be greater than loan amount */
        $loan_amount = $request->loan_amount;
        $sanction_loan_amount = $request->sanction_loan_amt;
        if($loan_amount<$sanction_loan_amount)
        {
            return redirect()->back()->withDanger('Sanction amount may not be greater than loan amount');   
        }

        $file = Sanction::findOrFail($sanction_id);
        
        if($request->file_number)
        {
            $fileNumber = DB::table('tbl_hlsanction')->where('file_number', '=', $request->file_number)
            ->where('bank_name', '=', $request->bank_name)
            ->whereNotIn('sanction_id', [$file->sanction_id])
            ->get();

            if($fileNumber->count() > 0)
            {
                return $request->validate([
                    'file_number' => 'required|unique:tbl_hlsanction'
                ]);
            }
        }
        else
        {
            $file = Sanction::find($sanction_id);
        }
        $file->update($request->all());
        return redirect('sanction')->withSuccess('Sanction updated successfully');	    
    }

    public function addSanctionsComment(Request $request, Sanction $sanction)
    {
       if($request->cmt) Helper::addComment($request->sanction['sanction_id'],$request->cmt,"sanction");
        $commentData = Comment::where('sanction_id', $request->sanction['sanction_id'])->orderBy('comment_id', 'desc')->get();
        return response()->json(['sanction' => $request->sanction, 'comments' => $commentData]);
    }

    public function changestatus(Request $request)
    {     
        $id = $request->id;
        $status = $request->status;   
       DB::table('tbl_hlsanction')->where('sanction_id',$id)->update([
        'sanction_status'=>$status
       ]);
       $status="";
       $details=Sanction::where('sanction_id','=',$id)->get();
       foreach($details as $data)
       $status=$data->sanction_status;
       
       return response()->json(
        [
          'success'=>true,
          'message'=>'updated',
          'status'=>$status
        ]
        );
    }

    public function filterSanction(Request $request)
    {
        $filter1 = $request->input('filter1');
        $status = $request->input('status');
        $filter3 = $request->input('filter3');
        $filter4 = $request->input('filter4');
        $filter6 = $request->input('filter6');
       
        if(!is_null($filter1) && !is_null($status) && !is_null($filter3) && !is_null($filter4) && !is_null($filter6))
        {
            $data = Sanction::where('loan_amount', 'like' ,'%' . $filter1 . '%')
                                ->where('status', 'like' ,'%' . $status . '%')
                                ->where('bank_name', 'like' ,'%' . $filter3 . '%')
                                ->where('file_number', 'like' ,'%' . $filter4 . '%')
                                ->where('expiry_date', 'like' ,'%' . $filter6 . '%')
                                ->get();
        }
        
                $query = [];

                if (!is_null($filter1)) {
                    $query[] = ['loan_amount', '=', $filter1];
                }
                if (!is_null($status)) {
                    $query[] = ['status', '=', $status];
                }
                if (!is_null($filter3)) {
                    $query[] = ['bank_name', '=', $filter3];
                }
                if (!is_null($filter4)) {
                    $query[] = ['file_number', '=', $filter4];
                }
                if (!is_null($filter6)) {
                    $query[] = ['expiry_date', '=', $filter6];
                }
                
                $data = Sanction::orderBy('sanction_id','DESC')->where($query)->paginate(10);
        return view('content.sanction.sanction',compact('data', 'request'));
        
        
    }
}
