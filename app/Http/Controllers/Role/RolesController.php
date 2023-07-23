<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\role\Role;
use DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_role = Role::get();
        return view('content.role.role',['user_role'=>  $user_role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {
        return view('content.role.add-role',compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  //dd($request->all());
        $request->validate([
       
          
            'name' => 'required',
            'slug' => 'required',
            //add status  
            'status' => 'required'        
        ]);
        

        $role = new Role;

        
        $role->name = $request->name;
        $role->slug = $request->slug;
        //add status
        $role->status = $request->status;

         $role->save();

        //  dd($role);
        return redirect('role')->withSuccess('New role added');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('content.role.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::where('id',$id)->first();
        
        return view('content.role.role_edit', ['Role'=> $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $Role)
    {
        $request->validate([
            'id' => 'required|unique:user_role|numeric',
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required',     
        ]);

        $Sanction->update($request->all());
        return redirect('role')->withSuccess('Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status_update($id)
    {
        //get status with the help of Id
        $role = DB::table('user_role')
              ->select('status')
              ->where('id','=', $id)
              ->first();
        
        //check user status
        if($role->status == '1') {
          $status = '0';
        } else {
          $status = '1';
        }

        //dd($status);
        //Update status 
        $values = array('status'=> $status);
        $role = DB::table('user_role')
             ->where('id','=', $id)
             ->update($values);

       session()->flash('msg','User status has been updated successfully.');
       return redirect('role');
    }
}