<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
      $this->middleware('permission:user-create', ['only' => ['create','store']]);
      $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
      $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('user_id','DESC')->paginate(10);
        // dd(User::orderBy('user_id','DESC')->get());
        return view('content.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('content.users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'emp_code'=> 'required|unique:users|alpha_num|min:2|max:30',
            'firstname'=> 'required|regex:/^[a-zA-Z\s]+$/|min:2|max:20',
            'middlename'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:2|max:20',
            'lastname'=> 'required|regex:/^[a-zA-Z\s]+$/|min:3|max:20',
            'nickname'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:2|max:10',
            'mobile_no'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',        
            'email'=> 'required|email|unique:users|min:5|max:50',
            'password'=> 'required|min:5|max:10|confirmed',
            'password_confirmation'=> 'required|min:5|max:10',
            'pan_no'=> 'nullable|alpha_num|min:5|max:10',
            'qualification'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:2|max:20',
            'marital_status'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:5|max:10',
            'joining_date'=> 'required',
            'experience_in_year'=> 'nullable|numeric|digits_between:1,2',
            'last_package'=> 'nullable|numeric|min:0|max:100000000',
            'home_contactno'=> 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'experience_in_months'=> 'nullable|numeric|digits_between:1,2',
            'privious_company_contactname'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:3|max:20',
            'privious_company_contact'=> 'nullable|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'source'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:3|max:10',
            'source_by'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:3|max:10',
            'remark_by_HR'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:3|max:10',
            

            ]
           
            );
        
        $input = $request->all();
         $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('content.users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('content.users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $this->validate($request, [
            'emp_code'=> 'required|alpha_num|min:2|max:30',
            'firstname'=> 'required|regex:/^[a-zA-Z\s]+$/|min:2|max:20',
            'middlename'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:2|max:20',
            'lastname'=> 'required|regex:/^[a-zA-Z\s]+$/|min:3|max:20',
            'nickname'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:2|max:10',
            'mobile_no'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',        
            'email'=> 'required|email|min:5|max:50',
            'pan_no'=> 'nullable|alpha_num|min:5|max:10',
            'qualification'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:2|max:20',
            'marital_status'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:5|max:10',
            'joining_date'=> 'required',
            'experience_in_year'=> 'nullable|numeric|digits_between:1,2',
            'last_package'=> 'nullable|numeric|min:0|max:100000000',
            'home_contactno'=> 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'experience_in_months'=> 'nullable|numeric|digits_between:1,2',
            'privious_company_contactname'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:3|max:20',
            'privious_company_contact'=> 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'source'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:3|max:10',
            'source_by'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:3|max:10',
            'remark_by_HR'=> 'nullable|regex:/^[a-zA-Z\s]+$/|min:3|max:10',
             ]
        );

       
        $input = $request->all();
         $input['password'] = Hash::make($input['password']);

        $user = User::where('user_id', $user_id)->firstOrFail();
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$user_id)->delete();
        // dd( $user);
        $user->assignRole($request->input('designation'));
     
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
    public function changestatus(Request $request)
    {  
        $id = $request->id;
       $status = $request->status;       
       DB::table('users')->where('user_id',$id)->update([
        'user_status'=>$status
       ]);
       $status="";
       $details=User::where('user_id','=',$id)->get();
       foreach($details as $data)
       $status=$data->user_status;
       
       return response()->json(
        [
          'success'=>true,
          'message'=>'updated',
          'status'=>$status
        ]
        );
    }

    public function filterUser(Request $request)
    {
        $filter1 = $request->input('filter1');
        $filter2 = $request->input('filter2');
        $filter3 = $request->input('filter3');
        $filter4 = $request->input('filter4');
 
        if(!is_null($filter1) && !is_null($filter2) && !is_null($filter3) && !is_null($filter4))
        {
            $data = User::where('firstname', 'like' ,'%' . $filter1 . '%')
                                ->where('mobile_no', 'like' ,'%' . $filter2 . '%')
                                ->where('joining_date', 'like' ,'%' . $filter3 . '%')
                                ->where('email', 'like' ,'%' . $filter4 . '%')
                                ->get();
        }
        
                $query = [];

                if (!is_null($filter1)) {
                    $query[] = ['firstname', '=', $filter1];
                }
                if (!is_null($filter2)) {
                    $query[] = ['mobile_no', '=', $filter2];
                }
                if (!is_null($filter3)) {
                    $query[] = ['joining_date', '=', $filter3];
                }
                if (!is_null($filter4)) {
                    $query[] = ['email', '=', $filter4];
                }
                
                $data = User::orderBy('user_id','DESC')->where($query)->paginate(10);
                return view('content.users.index',compact('data', 'request'));
        
    }
    
}
