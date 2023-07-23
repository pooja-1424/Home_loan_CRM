@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Update Data Share Group</h4>

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Group Details</h5> <small class="text-muted float-end">Merged input group</small>
            </div>
    
            <div class="card-body">
                <form action="{{ route('data-share.update',$data->id) }}" method="post">
                            
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="name">Group Name</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control" type="text" name="name" id="name" value="{{ $data->name }}">
                        </div>
                        @error('name')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="name">Group Members</label>
                        <div class="input-group input-group-merge">
                            <select class="form-control" name="users[]" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->user_id }}" @if(in_array($user->user_id, json_decode($data->users) ))
                                        selected
                                    @endif>{{ $user->firstname." ".$user->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('users')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-info" href="{{ route('data-share.index')}}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
