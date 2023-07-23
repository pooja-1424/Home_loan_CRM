<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\group\Group;
use App\Models\group\GroupLeader;
use App\Models\User;

class GroupLeaderController extends Controller
{
    public function store(Request $request, Group $group)
    {

        $request->validate([
            'user_id' => 'required'
            // 'group_id' => 'required'
        ]);
        
        $user = User::where('user_id', $request->user_id)->first();
        // dd($request->all());
        $groupLeader = new GroupLeader();
        $groupLeader->user_id = $request->user_id;
        $groupLeader->team_id = $group->team_id;
        $groupLeader->team_leader_name = $user->firstname." ".$user->lastname;
        $groupLeader->from_date = date("Y-m-d");
        $groupLeader->status = 1;
        // dd($groupLeader);
        $groupLeader->save();
        
        return redirect()->route('groups.index')
            ->with('success', 'Team Leader Added successfully.');
    }
}