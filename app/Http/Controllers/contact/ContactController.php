<?php

namespace App\Http\Controllers\contact;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\contact\Contact;
use App\Models\sanction\Sanction;
use App\helpers\commentHelper as helper;
use App\Models\comment\Comment;
use Illuminate\Pagination\Paginator;
use App\Rules\MobileNumberValidator;
use App\Models\User;
use App\Models\Bankname;
use Auth;

class ContactController extends Controller
{
    public function __construct()
    {
      $this->middleware('permission:contact-list|contact-create|contact-edit|contact-delete', ['only' => ['index','store']]);
      $this->middleware('permission:contact-create', ['only' => ['create','store']]);
      $this->middleware('permission:contact-edit', ['only' => ['edit','update']]);
      $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
    }

    public function index(Contact $contact)
    {
      // dd(Auth::user()->getRoleNames());//team leader
      
      /* restrict users to list data except admin and team leader  */
      if (!Auth::user()->hasRole(['Admin', 'team leader'])) { // && $userId != Auth::id()) {
      
        $results = $this->dynamicQuery();
        $data = $results->orderBy('client_id','DESC')->paginate(10);      
      }
      else
      {
        $data=Contact::orderBy('client_id','DESC')->paginate(10); 
      }         
      // $data=Contact::orderBy('client_id','DESC')->paginate(10); 
      // dd($data);
      return view('content.contact.contacts',compact('data'));
    }
    public function create()
       {
       
        $property = DB::table('teams')
        ->select('team_id')
        ->where('teamname', 'like', '%RE%')
        ->pluck('team_id')
        ->toArray();         

        $property_username = DB::table('teamdetails')       
        ->join('users', 'users.user_id', '=', 'teamdetails.user_id')
        ->select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"))
        ->whereIn('teamdetails.team_id', $property) 
        ->where('teamdetails.status','=',1)        
        ->distinct()
        ->get();    

        $property_TL = DB::table('teamdetails')
        ->join('users','users.designation','=','teamdetails.designation_id')  
        ->join('team_leaders','team_leaders.user_id','=','users.user_id')     
        ->select('team_leaders.team_leader_name')
        ->whereIn('team_leaders.team_id', $property)
        ->where('team_leaders.status','=',1)         
        ->distinct()
        ->get();          

        $name = DB::table('teamdetails')
        ->join('users', 'teamdetails.user_id', '=', 'users.user_id')
        ->join('designations', 'users.designation', '=', 'designations.designation_id')
        ->select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"))
        ->whereIn('teamdetails.team_id',[14,25])
        ->where('teamdetails.status', '=', 1)
        ->whereIn('designations.designation', ['Tele Caller', 'Sales Manager']);
      
        
        /* restrict users to list data except admin and team leader */
        if (!Auth::user()->hasRole(['Admin', 'team leader']))
        {
          $userData = session('can_be_access_users_id');
          $userData = json_decode($userData, true);
          /* Add a new single value to the PHP array */
          // $userData[] = Auth::user()->user_id;
          
          if(!empty($userData))
          {
            $name->whereIn('users.user_id', $userData);
          }
          else $name->where('users.user_id', Auth::user()->user_id);
        }       
        $name = $name->get();
        
        $teamleader = DB::table('teamdetails')      
        ->select('team_leader_name')
        ->whereIn('team_id', [14, 25]) 
        ->whereIn('designation_id',[11,9,6])
        ->where('status', 1)
        ->distinct()
        ->get();  

    
        $users = DB::table('teamdetails')
        ->join('users', 'teamdetails.user_id', '=', 'users.user_id')
        ->join('designations', 'users.designation', '=', 'designations.designation_id')
        ->select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"))
        ->whereIn('teamdetails.team_id',[14,25])
        ->where('designations.designation','=','Sales Manager')
        ->where('users.status_id', '=', 1)
        ->get();         
              
      return view('content.contact.add-contacts',compact('name','teamleader','users','property_username','property_TL'));
    }
  
    public function store(Request $request)
    {
      $con_cmt = $request->comment;
      $data=$request->except('comments');

      $request->validate([
        'fname'=>'required|regex:/^[a-zA-Z]+$/u|max:255',
        'lname'=>'required|regex:/^[a-zA-Z]+$/u|max:255',        
        'mobile1'=>['required','unique:tbl_hlclients', new MobileNumberValidator],              
        'Type_of_Loan'=>'required',
        'Team_Leader'=>'required|',
        'Lead_Status'=>'required',
        'Lead_source'=>'required',
        'Tracking_Status'=>'required',
        'Tracking_Status_Sub'=>'required',
        'Assigned_To'=>'required',             
        'lead_source_details'=>'required',
        'Property_Phase_Requirement'=>'',       
      ],
      [
        'fname.required'=>'This Field is required',
        'lname.required'=>'This Field is required',            
        'mobile1.required'=>'This Field is required',       
        'Type_of_Loan.required'=>'This Field is required',
        'Team_Leader.required'=>'This Field is required',
        'Lead_Status.required'=>'This Field is required', 
        'Lead_source.required'=>'This Field is required',  
        'Tracking_Status.required'=>'This Field is required',  
        'Tracking_Status_Sub.required'=>'This Field is required',
        'Assigned_To.required'=>'This Field is required',
        'lead_source_details.required'=>'This Field is required',
        'Property_Phase_Requirement.required'=>'This Field is required',
        'fname.regex'=>'The Format is Invalid',
        'lname.regex'=>'The Format is Invalid',
        'Team_Leader.regex'=>'The Format is Invalid', 
      ]); 
     
      // $data = $request->all();
      $data['Interested_bank'] = isset($data['Interested_bank']) ? implode(',', $data['Interested_bank']) : null;//store bank name 
      $client = Contact::create($data);
          
      if($con_cmt) Helper::addComment($client->client_id,$con_cmt, "client");

      return redirect()->route('contacts.index')
                      ->with('success','New Contact Added');      
    }

    public function show(Contact $contact,Sanction $sanction)
    {
    
      /* restrict users to show data except admin and team leader  */
      if (!Auth::user()->hasRole(['Admin', 'team leader'])) {
        $conditions = [
            'tbl_hlclients.client_id' => $contact->client_id
        ];
        $results = $this->dynamicQuery($conditions);
        $showData = $results->first();
      
        if(!isset($showData->client_id))
        {
          abort(403, 'The User is Unauthorized to Access');   
        }
      }

      $data=Contact::findorfail($contact->client_id);
      $data1=$data->tbl_hlsanction;
      $data2=$data->tbl_hldisbursement;     
      $comData=Contact::findorfail($contact->client_id);
      $comData1=$comData->tbl_hlcomments;
      $comment = Comment::where('client_id', $contact->client_id)->orderBy('comment_id', 'desc')->get();
     
      $cname = Sanction::select('file_number','sanction_id','client_id')
        ->where('client_id',$data->client_id)       
        ->get();
      
 
      $list = Contact::select('fname')
        ->where('client_id',$data->client_id)       
        ->get();
    
      // $list = Contact::where('Tracking_Status_Sub', 'Pick_Up_Done')->get();
      $banklist = Bankname::all();
     
      return view('content.contact.show',compact('comData','data','comment','cname','list','banklist'));
    }
   
    public function edit(Contact $contact, Sanction $sanction)
    {
      /* restrict users to edit other users data except admin and team leader  */
      if (!Auth::user()->hasRole(['Admin', 'team leader'])) {
        $conditions = [
            'tbl_hlclients.client_id' => $contact->client_id
        ];
        $results = $this->dynamicQuery($conditions);
        $showData = $results->first();
      
        if(!isset($showData->client_id))
        {
          abort(403, 'The User is Unauthorized to Access');   
        }
      }
    
      $property = DB::table('teams')
      ->select('team_id')
      ->where('teamname', 'like', '%RE%')
      ->pluck('team_id')
      ->toArray();         

      $property_username = DB::table('teamdetails')       
      ->join('users', 'users.user_id', '=', 'teamdetails.user_id')
      ->select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"))
      ->whereIn('teamdetails.team_id', $property) 
      ->where('teamdetails.status','=',1)        
      ->distinct()
      ->get();    

      $property_TL = DB::table('teamdetails')
      ->join('users','users.designation','=','teamdetails.designation_id')  
      ->join('team_leaders','team_leaders.user_id','=','users.user_id')     
      ->select('team_leaders.team_leader_name')
      ->whereIn('team_leaders.team_id', $property)
      ->where('team_leaders.status','=',1)         
      ->distinct()
      ->get(); 
       

      $name = DB::table('teamdetails')
      ->join('users', 'teamdetails.user_id', '=', 'users.user_id')
      ->join('designations', 'users.designation', '=', 'designations.designation_id')
      ->select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"))
      ->whereIn('teamdetails.team_id',[14,25])
      ->where('teamdetails.status', '=', 1)
      ->whereIn('designations.designation', ['Tele Caller', 'Sales Manager'])
      ->distinct()
      ->get();

      $teamleader = DB::table('teamdetails')      
        ->select('team_leader_name')
        ->whereIn('team_id', [14, 25]) 
        ->whereIn('designation_id',[11,9,6])
        ->where('status', 1)
        ->distinct()
        ->get();  
  
      $users = DB::table('teamdetails')
      ->join('users', 'teamdetails.user_id', '=', 'users.user_id')
      ->join('designations', 'users.designation', '=', 'designations.designation_id')
      ->select(DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS full_name"))
      ->whereIn('teamdetails.team_id',[14,25])
      ->where('designations.designation','=','Sales Manager')
      ->where('users.status_id', '=', 1)
      ->get(); 
        return view('content.contact.edit',compact('contact','name','teamleader','users','property_TL','property_username'));
    }

    public function update(Request $request, Contact $contact)
    {
      $request->validate
       ([
        'fname'=>'required|regex:/^[a-zA-Z]+$/u|max:255',
        'lname'=>'required|regex:/^[a-zA-Z]+$/u|max:255',        
        'mobile1'=>['required',new MobileNumberValidator],            
        'Type_of_Loan'=>'required',
        'Team_Leader'=>'required|',
        'Lead_Status'=>'required',
        'Lead_source'=>'required',
        'Tracking_Status'=>'required',
        'Tracking_Status_Sub'=>'required',
        'Assigned_To'=>'required',
            
        'lead_source_details'=>'required',
        'Property_Phase_Requirement'=>'',

      ],
      [
        'fname.required'=>'First Name is required',
        'lname.required'=>'Last Name is required',            
        'state.required'=>'State is requird',        
        'Type_of_Loan.required'=>'Type of Loan is required',
        'Team_Leader.required'=>'Team Leader is required',
        'Team_Leader.regex'=>'The Format is Invalid',     
        'fname.regex'=>'The Format is Invalid',
        'lname.regex'=>'The Format is Invalid',        
      ]);   
      $data = $request->all();
      $data['Interested_bank'] = isset($data['Interested_bank']) ? implode(',', $data['Interested_bank']) : null;//store bank name
        $contact->update($data);       
        return redirect()->route('contacts.index')
                        ->with('success','updated successfully');
    }  
  
    public function addContactComment(Request $request, Contact $contact)
    {
       if($request->cmt) Helper::addComment($request->contact['client_id'],$request->cmt,"client");
       $commentData = Comment::where('client_id', $request->contact['client_id'])->orderBy('comment_id', 'desc')->get();
       return response()->json(['contact' => $request->contact, 'comments' => $commentData]);
    }

   public function changestatus(Request $request)
   {     
        $id = $request->id;
        $status = $request->status;   
         DB::table('tbl_hlclients')->where('client_id',$id)->update([
          'client_status'=>$status
         ]);
         $status="";
         $details=Contact::where('client_id','=',$id)->get();
         foreach($details as $data)
         $status=$data->client_status;
         return response()->json(
          [
            'success'=>true,
            'message'=>'updated',                                           
            'status'=>$status
          ]
          );
      }
      
    public function filterContact(Request $request)
    {
        $filter1 = $request->input('filter1');
        $filter2 = $request->input('filter2');
        $filter3 = $request->input('filter3');
        // $filter4 = $request->input('Interested_bank');
        $filter4 = (($request->input('Interested_bank') != '')) ? implode(",", $request->input('Interested_bank')) : '';

        if(!is_null($filter1) && !is_null($filter2) && !is_null($filter3) && !is_null($filter4))
        {
            $data = Contact::where('fname', 'like' ,'%' . $filter1 . '%')
                             ->where('mobile1', 'like' ,'%' . $filter2 . '%')
                             ->where('Team_Leader', 'like' ,'%' . $filter3 . '%')
                             ->where('Interested_bank', 'like' ,'%' . $filter4 . '%')
                             ->get();
        }
        
        $query = [];

        if (!is_null($filter1)) {
          $query[] = ['fname', '=', $filter1];
      }
      if (!is_null($filter2)) {
          $query[] = ['mobile1', '=', $filter2];
      }
      if (!is_null($filter3)) {
          $query[] = ['Team_Leader', '=', $filter3];
      }
      if (!is_null($filter4)) {
        // $query[] = ['Interested_bank', '=', $filter4];
        $query[] = ['Interested_bank', 'like' ,'%' . $filter4 . '%'];
      }

      $data = Contact::orderBy('client_id','DESC')->where($query)->paginate(10);
      return view('content.contact.contacts',compact('data', 'request'));

  }

  public function getLeadSourceTL(Request $request)
  {
    $leadSourceSMName = explode(" ", $request->data);
    $leadSourceTL = DB::table('teamdetails')
     ->join('users','users.user_id','=','teamdetails.user_id')      
      ->select('team_leader_name')
      // ->whereIn('teamdetails.user_id', $property)
      ->where('users.lastname','=',$leadSourceSMName[1]) 
      ->where('teamdetails.status','=',1)        
      ->where('users.firstname','=',$leadSourceSMName[0])         
      ->distinct()
      ->get();
     
      return response()->json(['data'=>$leadSourceTL]);
   }

    public function getLeadSourceTLTeam(Request $request)
    {
      $leadSourceTLTeam = DB::table('teamdetails')
      ->join('users','users.user_id','=','teamdetails.user_id')      
      ->select('users.firstname', 'users.lastname')
       ->where('teamdetails.status','=',1) 
      ->where('teamdetails.team_leader_name', $request->data)
      ->get();
      // dd($leadSourceTLTeam);
      return response()->json(['data'=>$leadSourceTLTeam]);
    }

    public function getHomeloanTL(Request $request)
  {
    $assignedTo = explode(" ", $request->data);
    // dd($assignedTo);
    $homeloanTL = DB::table('teamdetails')
      ->join('users','users.user_id','=','teamdetails.user_id')      
      ->select('team_leader_name')
      ->where('teamdetails.status','=',1)
      ->where('users.lastname','=',$assignedTo[1])         

      ->where('users.firstname','=',$assignedTo[0])         
      ->distinct()
      ->get();
      // dd($homeloanTL);
      return response()->json(['data'=>$homeloanTL]);
   }

   public function getAssignedTo(Request $request)
   {
     $assignedTo = DB::table('teamdetails')
     ->join('users','users.user_id','=','teamdetails.user_id')      
     ->select('users.firstname', 'users.lastname')
     ->where('teamdetails.status','=',1)
     ->where('teamdetails.team_leader_name', $request->data)
     ->get();
   
     return response()->json(['data'=>$assignedTo]);
   }
   public function getClosingBy(Request $request)
   {
     $closingBY = DB::table('teamdetails')
     ->join('users','users.user_id','=','teamdetails.user_id')   
     ->join('designations', 'teamdetails.designation_id', '=', 'designations.designation_id')   
     ->select('users.firstname', 'users.lastname')
     ->where('designations.designation','=','Sales Manager')
     ->where('teamdetails.team_leader_name', $request->data)
     ->get();
    //  dd($closingBY);
     return response()->json(['data'=>$closingBY]);
   }
    public function dynamicQuery($conditions = [])
    {

      $userData = session('can_be_access_users_id');
        // $showData = DB::table('tbl_hlclients')
        // ->select('tbl_hlclients.*')
        // ->join('users', 'tbl_hlclients.Assigned_To', '=', DB::raw("CONCAT(users.firstname, ' ', users.lastname)"))
        // ->whereIn('users.user_id', json_decode($userData))
        // ->where('tbl_hlclients.client_id', $contact->client_id)
        // ->first();

        $query = $showData = DB::table('tbl_hlclients')
        ->select('tbl_hlclients.*')
        ->join('users', 'tbl_hlclients.Assigned_To', '=', DB::raw("CONCAT(users.firstname, ' ', users.lastname)"));

        if(!empty($userData))
        {
          $query->whereIn('users.user_id', json_decode($userData));
        }
        else $query->where('users.user_id', Auth::user()->user_id);

       foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        $results = $query;//->get();
        return $results;
    }

    public function membersByTL($teamLeaderId)
    {
        $teamMembers = Contact::where('user_id', $teamLeaderId)->get();

        return response()->json($teamMembers);
    }
}
