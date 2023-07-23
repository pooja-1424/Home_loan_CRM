@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 


    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span>Create Data Sharing Group</h4>

    <!-- Add data sharing group form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('data-share.store') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Group Name</label><br><br>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" name="name" id="basic-icon-default-fullname" value="{{ old('name') }}" placeholder="Name" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('name')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-users">Users</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="users[]" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->firstname." ".$user->lastname }}</option>
                                    @endforeach
                                </select>
                                @error('users')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <a class="btn btn-info" href="{{ route('data-share.index')}}">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
