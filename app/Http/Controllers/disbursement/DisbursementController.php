<?php

namespace App\Http\Controllers\disbursement;
use App\Services\DataStorageService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\sanction\Sanction;
use App\Models\disbursement\Disbursement;
use App\Models\contact\Contact;
use App\Models\comment\Comment;
use App\helpers\commentHelper as helper;
use App\Models\Home_loan_incentive;
use App\Models\TelecallerIncentive;
use App\Models\User;

class DisbursementController extends Controller
{
  protected $dataStorageService;   
   
    function __construct(DataStorageService $dataStorageService) 
  {
    $this->middleware('permission:disbursement-list|disbursement-create|disbursement-edit|disbursement-delete', ['only' => ['index','show']]);
    $this->middleware('permission:disbursement-create', ['only' => ['create','store']]);
    $this->middleware('permission:disbursement-edit', ['only' => ['edit','update']]);
    $this->middleware('permission:disbursement-delete', ['only' => ['destroy']]);
    $this->dataStorageService = $dataStorageService;
  }    

  public function disbFilterQuery($fields = [], $conditions = [], $joins = [])
  {
    $userData = session('can_be_access_users_id');
    // dd($userData);

    $query = DB::table('tbl_hlclients');
        // ->select('tbl_hldisbursement.*')
        // ->select('tbl_hlclients.*')


    /* Select specific fields */
    if(!empty($fields)) $query->select($fields);

    $query->join('users', 'tbl_hlclients.Assigned_To', '=', DB::raw("CONCAT(users.firstname, ' ', users.lastname)"));
        // ->join('tbl_hldisbursement', 'tbl_hlclients.client_id', '=', 'tbl_hldisbursement.client_id');

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
    // dd($query->toSql());
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
      $fields = ['tbl_hldisbursement.*'];
      // ->join('tbl_hldisbursement', 'tbl_hlclients.client_id', '=', 'tbl_hldisbursement.client_id');
      $joins = [
          ['table' => 'tbl_hldisbursement', 'column1' => 'tbl_hlclients.client_id', 'operator' => '=', 'column2' => 'tbl_hldisbursement.client_id']
      ];
      $results = $this->disbFilterQuery($fields, [], $joins);
      $data=$results->orderBy('disb_id','DESC')->paginate(10);
    }
    else
    {
      $data=Disbursement::orderBy('disb_id','DESC')->paginate(10);
    }
    $data = Disbursement::all();   
     
      $disb_id= $data->pluck('disb_id');
 
      $data1 = DB::table('tbl_hlclients')
      ->join('tbl_hldisbursement', 'tbl_hlclients.client_id', '=', 'tbl_hldisbursement.client_id')     
      ->select('*')
      ->whereIn('tbl_hldisbursement.disb_id', $disb_id)     
      ->orderBy('tbl_hldisbursement.disb_id', 'DESC')
      ->paginate(10);
      return view('content.disbursement.index',compact('data','data1'));
  }   

  public function create(Sanction $sanction, Request $request)
  {             
    $Data = Sanction::select('client_id')
            ->whereRaw(DB::raw("(`status` = 'Sanctioned' OR `status` = 'Partial_Disbursed')"));

    if (!Auth::user()->hasRole(['Admin', 'team leader']))
    {
      $fields = ['tbl_hlclients.*'];
      $joins = [
          ['table' => 'tbl_hldisbursement', 'column1' => 'tbl_hlclients.client_id', 'operator' => '=', 'column2' => 'tbl_hldisbursement.client_id']
      ];
      $results = $this->disbFilterQuery($fields);
      $getResArr = $results->pluck('client_id')->toArray();
      $Data->whereIn('client_id', $getResArr);
    }
    $Data = $Data->get();

      if($Data)
      {
       $cname = Contact::select('fname','client_id')
        ->whereIn('client_id',$Data)       
        ->get();
      }       
    return view('content.disbursement.add-disbursement',compact('Data','cname'));
  }

  public function store(Request $request, Disbursement $disbursement)
  {
      $pending_disb = $request->input('pending_disb');   

      $value1 = $request->input('disb_partial_amount');
      $value2 = $request->input('disb_amt');   
      $result = $value1 + $value2; /*calculate partial amount for sanction*/
      $model=new Disbursement();
      $data=$request->except('sanction_loan_amt','sanction_file','file_number','fname');
         $request->validate([
        'client_id'=>'required|max:255',
        'sanction_id'=>'required|max:255',
        'disb_date'=>'required',
        'disb_amt'=>'required',
        'bank_name'=>'required_if:status,==,Final_disbursment',
        'pending_disb'=>'required_if:status,==,Final_disbursment|gte:0',
        'status'=>'required',        
      ],
      [
        'client_id.required'=>'This field is required',
        'sanction_id.required'=>'This field is required',
        'disb_date.required'=>'This field is required',
        'disb_amt.required'=>'This field is required',
        'bank_name.required_if'=>'This field is required',
        'pending_disb.required_if'=>'This field is required',       
        'status.required'=>'This field is required', 
        'pending_disb.gte'=>'Amount must be greater than 0',            
     ]);  
      $sanction_expiry_date = Sanction::select('expiry_date')
        ->where('sanction_id', '=', $request->sanction_id)
        ->first(); /*Retrieve the first matching result*/

      $disb_date = $request->disb_date;
      if ($disb_date > $sanction_expiry_date->expiry_date) 
      {
        if ($request->ajax()){
          return response()->json([
              'success' => false,
              'message' => 'Disbursement not allowed. The sanction date has expired.',
          ]);
        }else {  
        return redirect()->back()->withDanger('Disbursement not allowed. The sanction date has expired');
        } 
      } 

      $sanction_date = Sanction::select('sanction_date')
      ->where('sanction_id', '=', $request->sanction_id)
      ->first(); /*Retrieve the first matching result*/

    $disb_date = $request->disb_date;
    if ($disb_date < $sanction_date->sanction_date) 
    {
      if ($request->ajax()){
        return response()->json([
            'success' => false,
            'message' => 'Please select a date after your sanction date as the disbursement date.',
        ]);
      }else {  
      return redirect()->back()->withDanger('Please select a date after your sanction date as the disbursement date.');
      } 
    }  
      $status=$request->status;      
      if($status=='Final_disbursment')/*check status is final disbursement and pending dibursement is complete or not*/
      {
      $status1=$request->pending_disb;
        if($status1!=0) {
          if ($request->ajax()){
            return response()->json([
                'success' => false,
                'message' => 'please complete your pending disbursement.',
            ]);
          }
        
       
        else {
          return redirect()->back()->with('danger', "please complete your pending disbursement");
              // return redirect()->route('disbursements.index')->with('danger', "please complete your pending disbursement");           
        }
      }
    }

      $Data = $request->client_id;
      $disb_data = Disbursement::select('status')
                ->where('client_id', '=', $Data)
                ->get();
 
    if ($disb_data->isEmpty())
    {   
     
        $model->client_id = $request->client_id;
        $model->sanction_id = $request->sanction_id;
        $model->disb_date = $request->disb_date;
        $model->disb_amt = $request->disb_amt;
        $model->LRT_amt = $request->LRT_amt;
        $model->bank_name = $request->bank_name;
        $model->pending_disb = $request->pending_disb;
        $model->status = $request->status;
        $model->disbursement_status = $request->disbursement_status;
        
        if ($request->hasFile('sanction_file')) 
        {
        $file = $request->file('sanction_file');
        $extension = $file->getClientOriginalExtension();
        $cname = Contact::select('fname', 'lname')->where('client_id', $request->client_id)->first();
        $uniqueFilename = time() . '.' . $extension;

        $folderName = 'disbursement_files/' . $cname->fname . '_' . $cname->lname; // Create a folder with client's first and last name
        $file->move($folderName, $uniqueFilename);

        $model->sanction_file = $uniqueFilename;
        }
        
        $disb_id = $model->save();
       
        /*store disb_id*/
        $tasks_controller = $this->dataStorageService->storeTelecallerData($request->all(),$model);
        $tasks_controller = $this->dataStorageService->storeSMData($request->all(),$model);
      
        /* For Update sanction partial amount and update disbursement pending amount*/
      $sandata= Sanction::where('sanction_id',$request->sanction_id)->update(['disb_partial_amount'=> $result ]);
      $sandata1= Disbursement::where('sanction_id',$request->sanction_id)->update(['pending_disb'=> $pending_disb ]);
      $sandata2= Disbursement::where('sanction_id',$request->client_id)->update(['status'=>$status]);
       
      $status=$request->status;
      /*update status in sanction table*/
      if ($status == 'Partly_disbursed') 
      {       
          $requestSanctionId = $request->sanction_id;
          DB::statement("UPDATE tbl_hlsanction SET `status` = 'Partial_Disbursed' WHERE `sanction_id` = ?", [$requestSanctionId]);
      }  
      if($status == 'Final_disbursment')
      {
          $requestSanctionId1 = $request->sanction_id;                    
          DB::statement("UPDATE tbl_hlsanction SET `status` = 'Final_Disbursement' WHERE `sanction_id` = ?", [$requestSanctionId1]);
      } 
      if ($status == 'in-process') 
      {       
          $requestSanctionId2 = $request->sanction_id;
          DB::statement("UPDATE tbl_hlsanction SET `status` = 'Sanctioned' WHERE `sanction_id` = ?", [$requestSanctionId2]);
      }                
      if($request->comments) Helper::addComment($model->disb_id, $request->comments, "disb");
      if ($request->ajax()){
        return response()->json([
            'success' => true,
            'message' => 'New Disbursement Added.',
        ]);
      }else {
      return redirect()->route('disbursements.index')->with('success', 'New Disbursement Added');
      }
    }
  else 
    {
        foreach ($disb_data as $data)
        {
          if ($data->status=='Final_disbursment') {
            if ($request->ajax()){
              return response()->json([
                  'success' => false,
                  'message' => 'Not allowed because status is already Final Disbursement.',
              ]);
          }
          
          else{                 
              return redirect()->route('disbursements.index')->with('danger', 'Not allowed because status is already Final Disbursement');
          }
        }  
      }   
        $model->client_id = $request->client_id;
        $model->sanction_id = $request->sanction_id;
        $model->disb_date = $request->disb_date;
        $model->disb_amt = $request->disb_amt;
        $model->LRT_amt = $request->LRT_amt;
        $model->bank_name = $request->bank_name;
        $model->pending_disb = $request->pending_disb;
        $model->status = $request->status;
        $model->disbursement_status = $request->disbursement_status;
        
        if ($request->hasFile('sanction_file')) 
        {
        $file = $request->file('sanction_file');
        $extension = $file->getClientOriginalExtension();
        $cname = Contact::select('fname', 'lname')->where('client_id', $request->client_id)->first();
        $uniqueFilename = time() . '.' . $extension;

        $folderName = 'disbursement_files/' . $cname->fname . '_' . $cname->lname; // Create a folder with client's first and last name
        $file->move($folderName, $uniqueFilename);

        $model->sanction_file = $uniqueFilename;
        }
        $model->LRT_amt = $request->LRT_amt;       
        $disb_id = $model->save();
        
        /*store disb_id*/
        $tasks_controller = $this->dataStorageService->storeTelecallerData($request->all(),$model);
        $tasks_controller = $this->dataStorageService->storeSMData($request->all(),$model);
        /* For Update sanction partial amount and update disbursement pending amount*/
        $sandata= Sanction::where('sanction_id',$request->sanction_id)->update(['disb_partial_amount'=> $result ]);
        $sandata1= Disbursement::where('sanction_id',$request->sanction_id)->update(['pending_disb'=> $pending_disb ]);
        $sandata2= Disbursement::where('sanction_id',$request->client_id)->update(['status'=>$status]);
       
        $status=$request->status;
        /*update status in sanction table*/
        if ($status == 'Partly_disbursed') 
        {       
            $requestSanctionId = $request->sanction_id;
            DB::statement("UPDATE tbl_hlsanction SET `status` = 'Partial_Disbursed' WHERE `sanction_id` = ?", [$requestSanctionId]);
        }  
        if($status == 'Final_disbursment')
        {
            $requestSanctionId1 = $request->sanction_id;             
            DB::statement("UPDATE tbl_hlsanction SET `status` = 'Final_Disbursement' WHERE `sanction_id` = ?", [$requestSanctionId1]);
        }
        if ($status == 'in-process') 
        {       
            $requestSanctionId2 = $request->sanction_id;
            DB::statement("UPDATE tbl_hlsanction SET `status` = 'Sanctioned' WHERE `sanction_id` = ?", [$requestSanctionId2]);
        }                           
                        
        if($request->comments) Helper::addComment($model->disb_id, $request->comments, "disb");
        if ($request->ajax()){
          return response()->json([
              'success' => true,
              'message' => 'New Disbursement Added.',
          ]);
        }else{
        return redirect()->route('disbursements.index')->with('success', 'New Disbursement Added');
        }
     }     
  }

   
  public function show(Disbursement $disbursement)
  {   
    /* restrict users to show data except admin and team leader */
    if (!Auth::user()->hasRole(['Admin', 'team leader']))
    {
      $fields = ['tbl_hlclients.*', 'tbl_hldisbursement.*'];
      $joins = [
          ['table' => 'tbl_hldisbursement', 'column1' => 'tbl_hlclients.client_id', 'operator' => '=', 'column2' => 'tbl_hldisbursement.client_id']
      ];
      $conditions = [
        'tbl_hlclients.client_id' => $disbursement->client_id
      ];
      
      $results = $this->disbFilterQuery($fields, $conditions, $joins);
      $showData = $results->first();

      if(!isset($showData->client_id))
      {
          abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
      }
    }

    $sanctiondata=Sanction::findorfail($disbursement->client_id);
    $data1=$sanctiondata->tbl_hldisbursement;        

      $data=Contact::findorfail($disbursement->client_id);
      $data1=$data->tbl_hlsanction;
      $data2=$data->tbl_hldisbursement;    
      $comData=Disbursement::findorfail($disbursement->disb_id);
      $comData1=$comData->tbl_hlcomments; 
      $comment = Comment::where('disb_id', $disbursement->disb_id)->orderBy('comment_id', 'desc')->get();
      return view('content.disbursement.show',compact('comData','data','disbursement','comment','sanctiondata'));
  }

  public function edit(Disbursement $disbursement,Sanction $sanction)  
  { 
    /* restrict users to edit data except admin and team leader */
    if (!Auth::user()->hasRole(['Admin', 'team leader']))
    {
      $fields = ['tbl_hlclients.*'];
      $joins = [
          ['table' => 'tbl_hldisbursement', 'column1' => 'tbl_hlclients.client_id', 'operator' => '=', 'column2' => 'tbl_hldisbursement.client_id']
      ];
      $conditions = [
        'tbl_hlclients.client_id' => $disbursement->client_id
      ];
      $results = $this->disbFilterQuery($fields, $conditions, $joins);
      $showData = $results->first();

      if(!isset($showData->client_id))
      {
          abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
      }
    }
      $sanctiondata=Sanction::findorfail($disbursement->sanction_id);
      $data1=$sanctiondata->tbl_hldisbursement;        

      $disbdata=Contact::findorfail($disbursement->client_id);
      $data1=$disbdata->tbl_hlsanction;
      $data2=$disbdata->tbl_hldisbursement;

      $Data = Sanction::select('client_id')
      ->where('status', '=', 'Sanctioned')       
      ->get();

          if($Data)
          {
          $cname = Contact::select('fname','client_id')
          ->whereIn('client_id',$Data)       
          ->get();
          }     
      return view('content.disbursement.edit',compact('disbursement','disbdata','cname','sanctiondata'));
  }

  public function update(Request $request, Disbursement $disbursement)
  {   
    if ($request->disb_date) 
    {
      $model = new Contact(); 
      
      $data = $request->all();
      $data['disb_id'] = $disbursement->disb_id; // Adding the primary key
      
      $tasks_controller = $this->dataStorageService->updateDate($data, $model); 
    }
      $pending_disb=$request->pending_disb;
      $sanction_id=$request->sanction_id;
      /*select disbursement Heighest ID*/
      $highestId = DB::table('tbl_hldisbursement')
      ->select('disb_id')
      ->orderBy('disb_id', 'desc')
      ->value('disb_id'); 

      $totalAmount = DB::table('tbl_hldisbursement')
      ->where('disb_id','<',$highestId)
      ->where('sanction_id','=',$sanction_id)
      ->sum('disb_amt'); 


      $value2 = $request->input('disb_amt');
      $result = $totalAmount + $value2; /*calculate sanction partial amount in sanction table.*/
     
      $model=new Disbursement();  
      $data=$request->except('sanction_loan_amt','sanction_file','file_number');    
      $request->validate([
      'client_id'=>'required|max:255',
      'sanction_id'=>'required',
      'disb_date'=>'required',
      'disb_amt'=>'required',
      'bank_name'=>'required_if:status,==,Final_disbursment',
      'pending_disb'=>'required_if:status,==,Final_disbursment|gte:0',
      'status'=>'required',        
    ],
    [
      'client_id.required'=>'This field is required',
      'sanction_id.required'=>'This field is required',
      'disb_date.required'=>'This field is required',
      'disb_amt.required'=>'This field is required',
      'bank_name.required_if'=>'This field is required',
      'pending_disb.required_if'=>'This field is required',       
      'status.required'=>'This field is required',
          
    ]);  
      $sanction_expiry_date = Sanction::select('expiry_date')
        ->where('sanction_id', '=', $request->sanction_id)
        ->first(); /*Retrieve the first matching result*/

      $disb_date = $request->disb_date;
      if ($disb_date > $sanction_expiry_date->expiry_date) 
      {
          return redirect()->back()->withDanger('Disbursement not allowed. The sanction date has expired');
      }

      $sanction_date = Sanction::select('sanction_date')
      ->where('sanction_id', '=', $request->sanction_id)
      ->first(); /*Retrieve the first matching result*/

    $disb_date = $request->disb_date;
    if ($disb_date < $sanction_date->sanction_date) 
    {        
      return redirect()->back()->withDanger('Please select a date after your sanction date as the disbursement date.');
    }  

      $status=$request->status;      
      if($status=='Final_disbursment')/*check status is final or pending disbursement complete or not.*/
      {
        $status1=$request->pending_disb;
          if($status1!=0)
          {
            return redirect()->back()->with('danger', "Kindly complete the processing of your pending disbursement.");
          }
      }  
      $Data = $request->client_id;
      $disb=$request->status;      
      $disb_data = Disbursement::select('status')/*select disbursement status*/
                  ->where('client_id', '=', $Data)
                  ->get();   

      if ($disb_data->isEmpty())
      {       
      $disbursement->client_id = $request->client_id;
      $disbursement->sanction_id = $request->sanction_id;
      $disbursement->disb_date = $request->disb_date;
      $disbursement->disb_amt = $request->disb_amt;
      $disbursement->LRT_amt = $request->LRT_amt;
      $disbursement->bank_name = $request->bank_name;
      $disbursement->pending_disb = $request->pending_disb;
      $disbursement->status = $request->status;
      $disbursement->description = $request->description;
      $disbursement->disbursement_status = $request->disbursement_status;

      if ($request->hasFile('sanction_file'))
      {
          $file = $request->file('sanction_file');
          $extension = $file->getClientOriginalExtension();
          $cname = Contact::select('fname', 'lname')->where('client_id', $request->client_id)->first();
          $uniqueFilename = time() . '.' . $extension;

          $folderName = 'disbursement_files/' . $cname->fname . '_' . $cname->lname; // Create a folder with client's first and last name
          $file->move($folderName, $uniqueFilename);

          $disbursement->sanction_file = $uniqueFilename;
      }
      $disbursement->update();  

        /* For Update calculated sanction partial amount and disbursement pending amount*/
        $sandata= Sanction::where('sanction_id',$request->sanction_id)->update(['disb_partial_amount'=> $result ]);
        $sandata1= Disbursement::where('sanction_id',$request->sanction_id)->update(['pending_disb'=> $pending_disb ],['status'=>$disb]);
        $sandata2= Disbursement::where('sanction_id',$request->client_id)->update(['status'=>$disb]);
          
        $status=$request->status;
          if ($status == 'Partly_disbursed') /*update sanction status in sanction table.*/
          {       
              $requestSanctionId = $request->sanction_id;
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Partial_Disbursed' WHERE `sanction_id` = ?", [$requestSanctionId]);
          }  
          if($status == 'Final_disbursment')/*update sanction status in sanction table.*/
          {
              $requestSanctionId1 = $request->sanction_id;                    
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Final_Disbursement' WHERE `sanction_id` = ?", [$requestSanctionId1]);
          } 
          if ($status == 'in-process') 
          {       
              $requestSanctionId2 = $request->sanction_id;
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Sanctioned' WHERE `sanction_id` = ?", [$requestSanctionId2]);
          } 
          // if($request->comments) Helper::addComment($disbursement->disb_id, $request->comments, "disb");
        return redirect()->route('disbursements.index')->with('success', 'Updated successfully');
      } 
      else if($disb!='Final_disbursment')
      {       
        $disbursement->client_id = $request->client_id;
        $disbursement->sanction_id = $request->sanction_id;
        $disbursement->disb_date = $request->disb_date;
        $disbursement->disb_amt = $request->disb_amt;
        $disbursement->LRT_amt = $request->LRT_amt;
        $disbursement->bank_name = $request->bank_name;
        $disbursement->pending_disb = $request->pending_disb;
        $disbursement->status = $request->status;
        $disbursement->description = $request->description;
        $disbursement->disbursement_status = $request->disbursement_status;
        
        if ($request->hasFile('sanction_file'))
        {
            $file = $request->file('sanction_file');
            $extension = $file->getClientOriginalExtension();
            $cname = Contact::select('fname', 'lname')->where('client_id', $request->client_id)->first();
            $uniqueFilename = time() . '.' . $extension;
        
            $folderName = 'disbursement_files/' . $cname->fname . '_' . $cname->lname; // Create a folder with client's first and last name
            $file->move($folderName, $uniqueFilename);
        
            $disbursement->sanction_file =$uniqueFilename;
        }
        
        $disbursement->update();        
                
        /*For Update sanction partial amount and update disbursement pending amount*/
        $sandata= Sanction::where('sanction_id',$request->sanction_id)->update(['disb_partial_amount'=> $result ]);
        $sandata1= Disbursement::where('sanction_id',$request->sanction_id)->update(['pending_disb'=> $pending_disb ],['status'=>$disb]);
        $sandata2= Disbursement::where('sanction_id',$request->client_id)->update(['status'=>$disb]);
        $status=$request->status;
          if ($status == 'Partly_disbursed') /*update sanction status in sanction table.*/
          {       
              $requestSanctionId = $request->sanction_id;
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Partial_Disbursed' WHERE `sanction_id` = ?", [$requestSanctionId]);
          }  
          if($status == 'Final_disbursment') /*update sanction status in sanction table.*/
          {
              $requestSanctionId1 = $request->sanction_id;                    
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Final_Disbursement' WHERE `sanction_id` = ?", [$requestSanctionId1]);
          }
          if ($status == 'in-process') 
          {       
              $requestSanctionId2 = $request->sanction_id;
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Sanctioned' WHERE `sanction_id` = ?", [$requestSanctionId2]);
          } 
          // if($request->comments) Helper::addComment($disbursement->disb_id, $request->comments, "disb");
        return redirect()->route('disbursements.index')->with('success', 'Updated Successfully');
      }
      else 
      {
        foreach ($disb_data as $data)
          {
            if ($data->status=='Final_disbursment') /*check disbursement is final or not if its final then not allowed.*/
            {                 
                return redirect()->route('disbursements.index')->with('danger', 'Not allowed because status is already Final Disbursement');
            }                  
          }           
          
          $disbursement->client_id = $request->client_id;
          $disbursement->sanction_id = $request->sanction_id;
          $disbursement->disb_date = $request->disb_date;
          $disbursement->disb_amt = $request->disb_amt;
          $disbursement->LRT_amt = $request->LRT_amt;
          $disbursement->bank_name = $request->bank_name;
          $disbursement->pending_disb = $request->pending_disb;
          $disbursement->status = $request->status;
          $disbursement->disbursement_status = $request->disbursement_status;

          if ($request->hasFile('sanction_file')) 
          {
              $file = $request->file('sanction_file');
              $extension = $file->getClientOriginalExtension();
              $cname = Contact::select('fname', 'lname')->where('client_id', $request->client_id)->first();
              $uniqueFilename = time() . '.' . $extension;

              $folderName = 'disbursement_files/' . $cname->fname . '_' . $cname->lname; // Create a folder with client's first and last name
              $file->move($folderName, $uniqueFilename);

              $disbursement->sanction_file = $uniqueFilename;
          }
          $disbursement->update();

          $status=$request->status;                   
          /*For Update sanction partial amount and update disbursement pending amount*/
          $sandata= Sanction::where('sanction_id',$request->sanction_id)->update(['disb_partial_amount'=> $result ]);
          $sandata1= Disbursement::where('sanction_id',$request->sanction_id)->update(['pending_disb'=> $pending_disb ],['status'=>$disb]);
          $sandata2= Disbursement::where('sanction_id',$request->client_id)->update(['status'=>$disb]);
          // if($request->comments) Helper::addComment($disbursement->disb_id, $request->comments, "disb");    
          if ($status == 'Partly_disbursed') /*update sanction status in sanction table.*/
          {       
              $requestSanctionId = $request->sanction_id;
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Partial_Disbursed' WHERE `sanction_id` = ?", [$requestSanctionId]);
          }  
          if($status == 'Final_disbursment')/*update sanction status in sanction table.*/
          {
              $requestSanctionId1 = $request->sanction_id;                    
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Final_Disbursement' WHERE `sanction_id` = ?", [$requestSanctionId1]);
          }
          if ($status == 'in-process') 
          {       
              $requestSanctionId2 = $request->sanction_id;
              DB::statement("UPDATE tbl_hlsanction SET `status` = 'Sanctioned' WHERE `sanction_id` = ?", [$requestSanctionId2]);
          }  

          return redirect()->route('disbursements.index')
                          ->with('success','Updated successfully');                       
      }  
  }

  public function addDisbursementComment(Request $request, Disbursement $disbursement)
  {
      
    if($request->cmt) Helper::addComment($request->disbursement['disb_id'],$request->cmt,"disb");
    $commentData = Comment::where('disb_id', $request->disbursement['disb_id'])->orderBy('comment_id', 'desc')->get();
    return response()->json(['disbursement' => $request->disbursement, 'comments' => $commentData]);
  }
    
    public function changestatus(Request $request)
    {     
       $id = $request->id;
        $status = $request->status;   
       DB::table('tbl_hldisbursement')->where('disb_id',$id)->update(['disbursement_status'=>$status]);
       $status="";
       $details=Disbursement::where('disb_id','=',$id)->get();
       foreach($details as $data)
       $status=$data->disbursement_status;
       
       return response()->json(
        [
          'success'=>true,
          'message'=>'updated',
          'status'=>$status
        ]
        );
    }
  
  function fetch(Request $request)
  {    
    
      $select = $request->get('select');
      $value = $request->get('value');
      $dependent = $request->get('dependent'); 
      $data = DB::table('tbl_hlsanction')
                              ->where($select, $value)
                              ->groupBy($dependent)
                              ->get();    
                                        
        $output = '<option value="" id="">select</option>';                
        foreach($data as $row)
        {                 
          $selected = (isset($request->old_sanction_id) && ($row->sanction_id == $request->old_sanction_id)) ? 'selected' : '';
          $output .= '<option value="' . $row->$dependent . '"' . $selected . '>' . $row->file_number . '</option>';
        }               
        return response()->json($output);          
  }
  public function filterDisbursement(Request $request)
  {
      $filter2 = $request->input('filter2');
      $filter3 = $request->input('filter3');
      $filter4 = $request->input('filter4');
      $filter5 = $request->input('filter5');


        if(!is_null($filter2) && !is_null($filter3) && !is_null($filter4) && !is_null($filter5))
        {
            $data = Disbursement::where('disb_amt', 'like' ,'%' . $filter2 . '%')
                                ->where('status', 'like' ,'%' . $filter3 . '%')
                                ->where('bank_name', 'like' ,'%' . $filter4 . '%')
                                ->where('disb_date', 'like' ,'%' . $filter5 . '%')
                                ->paginate(10);
        }
        $query = [];

        if (!is_null($filter2)) {
            $query[] = ['disb_amt', '=', $filter2];
        }
        if (!is_null($filter3)) {
            $query[] = ['status', '=', $filter3];
        }
        if (!is_null($filter4)) {
          $query[] = ['bank_name', '=', $filter4];
        }
        if (!is_null($filter5)) {
          $query[] = ['disb_date', '=', $filter5];
        }
        
        $data = Disbursement::orderBy('disb_id','DESC')->where($query)->paginate(10);
        return view('content.disbursement.index',compact('data', 'request'));
    }

  public function fetchData($id)
  {      
    
     $data=Sanction::where('sanction_id',$id)->first();

     $data1 = Disbursement::select('pending_disb')
            ->where('sanction_id', '=', $data->sanction_id)
            ->get();      
     $response = ['data1' => $data1, 'data' => $data ];    
     return response()->json($response);
  }
   
}

