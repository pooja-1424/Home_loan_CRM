<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\group\Group;
// use App\Models\group\GroupLeader;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $groups = Group::orderBy('team_id','DESC')->get();//paginate(10);
        // $groups->paginate(10);
        $groups = Group::orderBy('team_id','DESC')->paginate(10);
        // dd($groups); 
        return view('content.groups.index', compact('groups'))
        ->with('i', ($request->input('page', 1) - 1) * 10);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'teamname' => 'required',
        ]);

        $group = Group::create($request->all());

        return redirect()->route('groups.index')
            ->with('success', 'Group created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('content.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'teamname' => 'required',
        ]);

        $group->update($request->all());

        return redirect()->route('groups.index')
            ->with('success', 'Group updated successfully.');
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

    public function manageMembership(Group $group)
    {
        // dd(GroupLeader::all());
        $users = DB::table('users')->select('users.email','users.user_id')
        ->join('model_has_roles','model_has_roles.model_id','=','users.user_id')
        ->whereNotIn('model_has_roles.role_id',[1,4])
        ->orderBy('users.user_id','DESC')
        ->get();

        // $users = DB::table('users')->select('*')->orderBy('user_id','DESC')->get();
        return view('content.groups.manage_membership', compact('group', 'users'));
    }

    public function addUser(Request $request, Group $group)
    {
        $group->tbl_hlusers()->attach($request->user_id);
        return redirect()->route('groups.manage_membership', $group)
            ->with('success', 'Group updated successfully.');
    }

    public function removeUser(Request $request, Group $group)
    {
        $group->tbl_hlusers()->detach($request->user_id);
        return redirect()->route('groups.manage_membership', $group)
        ->with('success', 'Group updated successfully.');
        
        // Additional logic or response handling as needed
    }

    public function addTeamLeader(Group $group)
    {
        $users = DB::table('users')->select('*')
        // ->join('model_has_roles','model_has_roles.model_id','=','users.user_id')
        // ->whereIn('model_has_roles.role_id',[1,6])
        ->whereIn('users.designation',[1,6])
        ->orderBy('users.user_id','DESC')
        ->get();

        return view('content.groups.addTeamleader', compact('group','users'));
    }

}
