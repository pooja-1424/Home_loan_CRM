@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Add Team Leader</h4>
    
    <!-- Add Team Leader form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Group Name : {{ $group->teamname }}</h5> <small class="text-muted float-end"><a class="btn btn-info" href="{{ route('groups.manage_membership', $group)}}">Back</a></small>
                </div>
                <div class="card-body">
                    @php
                        // echo '<pre><h1>users</h1></hr>'; print_r($users); echo '</pre>';
                    @endphp
                    <form action="{{ route('groupLeader.store', $group) }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="basic-icon-default-fullname">Add Team Leader to {{ $group->name }}</label><br><br>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <select name="user_id" id="user_id" class="form-control">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->user_id }}">{{ $user->firstname." ".$user->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('name')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                    <a class="btn btn-info" href="{{ route('groups.index')}}">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
