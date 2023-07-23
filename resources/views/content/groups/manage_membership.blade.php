@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Add Group</h4>

    <!-- Manage Members form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Group Name : {{ $group->teamname }}</h4> <small class="text-muted float-end"><a class="btn btn-info" href="{{ route('groups.addTl', $group)}}">Add Team Leader</a></small>
                </div>
                <div class="card-body">
                    <form action="{{ route('groups.addUser', $group) }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <h5 class="mb-0">Group Leader Name : {{ (isset($group->group_leaders[0]->team_leader_name) ?  $group->group_leaders[0]->team_leader_name : '') }}</h5> <small class="text-muted float-end"></small>
                        </div>

                        @if (!isset($group->group_leaders[0]->team_leader_name))
                            <div class="alert alert-danger" role="alert">
                                <strong>Please Add the Team Leader First!</strong>
                            </div>
                            <a class="btn btn-info" href="{{ route('groups.index')}}">Back</a>
                        @else

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Add Users</label><br><br>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select name="user_id" id="user_id" class="form-control">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->user_id }}">{{ $user->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('name')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>    

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                    <a class="btn btn-info" href="{{ route('groups.index')}}">Cancel</a>
                                </div>
                            </div>
                        @endif
                       
                    </form>
                    <br>
                    
                    @if (isset($group->group_leaders[0]->team_leader_name))
                        <div class="row">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Group Members</label><br><br>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select name="user_id" id="user_id" class="form-control">
                                            @foreach ($group->tbl_hlusers as $user)
                                            <option value="{{ $user->user_id }}">{{ $user->email }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
            
                            </div>
                        </div>

                        <form action="{{ route('groups.removeUser', $group) }}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Remove Users</label><br><br>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select name="user_id" id="user_id" class="form-control">
                                            @foreach ($group->tbl_hlusers as $user)
                                        
                                                <option value="{{ $user->user_id }}">{{ $user->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('name')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>                              
                        
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Remove</button>
                                    <a class="btn btn-info" href="{{ route('groups.index')}}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
{{-- End Form --}}
