<?php

namespace App\Http\Controllers\data_share;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\data_share\data_sharing_group;
use App\Models\data_share\data_sharing_rule;
use App\Models\data_share\data_sharing_point;
use DB;
use Auth;

class DataShareController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:data-share-group-list|data-share-group-create|data-share-group-edit|data-share-group-delete', ['only' => ['index','store']]);
        $this->middleware('permission:data-share-group-create', ['only' => ['create','store']]);
        $this->middleware('permission:data-share-group-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:data-share-group-delete', ['only' => ['destroy']]);
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data_sharing_groups = data_sharing_group::with('data_sharing_rules')->paginate(10);//->get();
        foreach ($data_sharing_groups as $key => $dataVal) {
            $userData = User::select('firstname', 'lastname')->whereIn('user_id', json_decode($dataVal->users))->get();
            // dd($userData);
            $data_sharing_groups[$key]->usersData = $userData;
        }
        // dd($data_sharing_groups);

        // dd(data_sharing_group::find($data_sharing_groups[0]->data_sharing_rules->can_access_to_group_id)->name);
        // dd($data_sharing_groups[0]->data_sharing_rules->can_access_to_group_id);
        // $mydata = (isset($data_sharing_groups[2]->data_sharing_rules)) ? App\Models\data_share\data_sharing_group::find($data_sharing_group->data_sharing_rules->can_access_to_group_id)->name : '';
        // $mydata = (isset($data_sharing_groups[2]->data_sharing_rules)) ? data_sharing_group::find($data_sharing_groups[]->data_sharing_rules->can_access_to_group_id)->name : '';
        // dd($data_sharing_groups[5]->data_sharing_rules);
        
        // dd($data_sharing_groups);
        return view('content.datasharing.index', compact('data_sharing_groups'))
        ->with('i', ($request->input('page', 1) - 1) * 10);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('content.datasharing.create', compact('users'));
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
            'name' => 'required',
            'users' => 'required|array|min:1'
        ]);

        $data_sharing_group = new data_sharing_group();
        $data_sharing_group->name = $request->name;
        $data_sharing_group->users = json_encode($request->users);
        $data_sharing_group->save();

        return redirect()->route('data-share.index')
        ->with('success', 'Data Sharing Group created successfully.');
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::all();
        $data = data_sharing_group::findOrFail($id);
        return view('content.datasharing.edit', compact('data', 'users'));
    }

    public function addUpdateDataSharingPointUsers(array $data, $id)
    {
        // $data_sharing_group = data_sharing_group::findOrFail($id);
        // $dataSharing = data_sharing_point::whereIn('user_id', json_decode($data_sharing_group->users))->delete();
        
        $data_sharing_rule = data_sharing_rule::where('group_id', $id)->get();
        // $data_sharing_rule = data_sharing_point::whereJsonContains('data_sharing_rules_id', $id)->toSql();
        // dd($id);
        foreach ($data_sharing_rule as $dskey => $dsVal) {
            $dsrData = ["can_access_to_group_id" => $dsVal->can_access_to_group_id, "group_id"=>$dsVal->group_id];
            
            $this->addOrUpdateSharingPoints($dsrData, $dsVal);
            // $group_user_id = json_decode(data_sharing_group::find($dsVal->group_id)->users);
            // foreach ($group_user_id as $gkey => $user_id) {
                //     dd($user_id);
                // }
            }
            // dd($data_sharing_rule);
        return true;
    }

    public function updateHigherAccessOfSharingUser(array $data, $id)
    {
        // dd($data);
        $dataSharing = data_sharing_point::where('group_id', $id)->get();
        foreach ($dataSharing as $dskey => $dsval) {
            if(in_array($dsval->user_id,$data['users']))
            {
                dd($data);
            }
            else
            {
                dd($dsval->user_id);
            }
            
        }
        $getSharingPointUser = data_sharing_point::where('group_id', $id)->first();
        $getSharingPointUser->user_id = json_decode($data['users']);
        dd($getSharingPointUser);
        $getSharingPointUser->save();
        return true;
    }

    public function updateSharingPointAccessUsersId(array $data, $id)
    {

        //create array column to data_sharing_rule_id and store all matching array in json formate
        $getDataSharingRuleId = data_sharing_rule::where('can_access_to_group_id', $id)->get();
        foreach ($getDataSharingRuleId as $dsrkey => $dsrVal) {
            $dataSharingPointUsers = data_sharing_point::whereJsonContains('data_sharing_rules_id', $dsrVal->id)->get();
            foreach ($dataSharingPointUsers as $dspkey => $dspVal) {
                $group_user_id = json_decode(data_sharing_group::find($id)->users);
               
                $diff1 = array_diff(json_decode($dspVal->can_be_access_users_id), $group_user_id);
                $newDataSharingPointUsers = array_merge($diff1, $data['users']);
                $dspVal->update(["can_be_access_users_id" => json_encode($newDataSharingPointUsers)]);
            }
        }
        return true;
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
        $request->validate([
            'name' => 'required',
            'users' => 'required'
        ]);

        /* update Data Sharing point can_be_access_users_id */
        $getDataSharingRuleId = data_sharing_rule::where('can_access_to_group_id', $id)->get();
        if(!$getDataSharingRuleId->isEmpty()) $this->updateSharingPointAccessUsersId($request->all(), $id);
        
        /* to delete the all users from data_sharing_point having related group  */
        $data_sharing_group = data_sharing_group::findOrFail($id);
        $dataSharing = data_sharing_point::whereIn('user_id', json_decode($data_sharing_group->users))->where('group_id', $id)->get();
        if(!$dataSharing->isEmpty()) data_sharing_point::whereIn('user_id', json_decode($data_sharing_group->users))->delete();
        //$dataSharing = data_sharing_point::whereIn('user_id', json_decode($data_sharing_group->users))->delete();
        
        /* to update users in group */
        $data_sharing_group = data_sharing_group::findOrFail($id);
        $data_sharing_group->update($request->all());
        
        /* to insert the newly updated group users in data_sharing_point table */
        $data_sharing_rule = data_sharing_rule::where('group_id', $id)->get();
        // dd($getDataSharingRuleId);
        if(!$data_sharing_rule->isEmpty()) $this->addUpdateDataSharingPointUsers($request->all(), $id);

        return redirect()->route('data-share.index')
        ->with('success', 'Data Share Group Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function manage_members(Request $request)
    {
        /* check the user have access to sharing rules list */
        $user = User::find(Auth::user()->user_id);
        if ($user->hasPermissionTo('sharing-rule-list')) { 
            $data_sharing_groups = data_sharing_group::with('data_sharing_rules')->paginate(10);
            return view('content.datasharing.data_sharing_list', compact('data_sharing_groups'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
        }
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }
    
    public function createDataSharingGroups()
    {
        /* TO CHECK THE USER HAS ACCESS TO CREATE SHARING RULES */
        $user = User::find(Auth::user()->user_id);
        if ($user->hasPermissionTo('sharing-rule-create')) { 
            $all_data_sharing_groups = data_sharing_group::all();
            return view('content.datasharing.manage_members', compact('all_data_sharing_groups'));
            // ->with('success', 'Data Share Group Successfully Updated!');
        }
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }

    public function addOrUpdateRules(array $data)
    {
        /* one group can assign amy groups to share the data thats why comment the below line */
        // $dataRule = data_sharing_rule::firstOrNew(['group_id' => $data['group_id']]);
        
        $dataRule = new data_sharing_rule;
        $dataRule->group_id = $data['group_id'];
        $dataRule->can_access_to_group_id = $data['can_access_to_group_id'];
        $dataRule->save();
        return $dataRule;
    }

    public function addOrUpdateSharingPoints(array $data, $dataSharingRule)
    {
        $group_user_id = json_decode(data_sharing_group::find($data['group_id'])->users);
        
        foreach ($group_user_id as $gkey => $user_id) {
            $dataSharing = data_sharing_point::firstOrNew(['user_id' => $user_id]);
            
            if(isset($dataSharing->can_be_access_users_id))
            {
                $lastData = data_sharing_point::where('user_id', $user_id)->value('can_be_access_users_id');
                $lastDataArray = json_decode($lastData, true) ?? [];
                $newDataValue = json_decode(data_sharing_group::find($data['can_access_to_group_id'])->users) ?? [];
                
                foreach ($newDataValue as $nkey => $nVal) {
                    if (!in_array($nVal, $lastDataArray)) {
                        $lastDataArray[] = $nVal;
                    }
                }

                /* to add json array for data_sharing_rules_id */
                $lastSharingRulesData = data_sharing_point::where('user_id', $user_id)->value('data_sharing_rules_id');
                $lastSharingRulesDataArray = json_decode($lastSharingRulesData, true) ?? [];
                $newSharingRulesDataValue = array($dataSharingRule->id);//json_decode(data_sharing_rule::find($data['group_id'])) ?? [];
                
                foreach ($newSharingRulesDataValue as $nkey => $nsrVal) {
                    if (!in_array($nsrVal, $lastSharingRulesDataArray)) {
                        $lastSharingRulesDataArray[] = $nsrVal;
                    }
                }

                $dataSharing->data_sharing_rules_id = json_encode($lastSharingRulesDataArray);//$dataSharingRule->id;
                $dataSharing->user_id = $user_id;
                $dataSharing->can_be_access_users_id = json_encode($lastDataArray);
                $dataSharing->save();
            }
            else
            {
                // $dataSharing->can_be_access_users_id = "'".data_sharing_group::find($data['can_access_to_group_id'])->users."'";
                $dataSharing->group_id = $data['group_id'];
                $dataSharing->data_sharing_rules_id = json_encode(array($dataSharingRule->id));
                $dataSharing->user_id = $user_id;
                $dataSharing->can_be_access_users_id = data_sharing_group::find($data['can_access_to_group_id'])->users;
                $dataSharing->save();
            }
        }
        return $dataSharing;
    }

    public function add_sharing_rule(Request $request)
    {
        // $can_access_to_group_id = data_sharing_group::where('id', $request->can_access_to_group_id)->first();
        $request->validate([
            'group_id' => 'required',
            'can_access_to_group_id' => 'required|different:group_id'
        ]);

        $check_rule_exists = DB::table('data_sharing_rules')->where('group_id', $request->group_id)->where('can_access_to_group_id', $request->can_access_to_group_id)->exists();
        if ($check_rule_exists) {
            return back()->with('error', 'The same combination of group has already exists.');
        }

        $dataRule = $this->addOrUpdateRules($request->all());
        $this->addOrUpdateSharingPoints($request->all(), $dataRule);

        /* add users for specific group in data_sharing_point to get all accessible users to user after login */
        
        return redirect()->route('manage_members')
        ->with('success', 'Data Share Group Successfully Added!');
    }
    
    public function groupFilter(Request $request)
    {
        $filterGroup = $request->input('filterGroup');
        
        if (!is_null($filterGroup)) {
            $data_sharing_groups = data_sharing_group::where('name', 'like' ,'%' .  $filterGroup . '%')->paginate(10);
        }
        else $data_sharing_groups = data_sharing_group::orderBy('id','DESC')->paginate(10); 
        
        foreach ($data_sharing_groups as $key => $dataVal) {
            $userData = User::select('firstname', 'lastname')->whereIn('user_id', json_decode($dataVal->users))->get();
            $data_sharing_groups[$key]->usersData = $userData;
        }
        return view('content.datasharing.index', compact('data_sharing_groups','request'));
        
    }
}
