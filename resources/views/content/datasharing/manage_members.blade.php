@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 


<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Add Custom Rule</h4>

<!-- Data Sharing  -->
@if(session()->has('success'))
<div class="alert alert-success" role="alert">
<strong>{{ session()->get('success') }}</strong>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger" role="alert">
<strong>{{ session()->get('error') }}</strong>
</div>
@endif

<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                {{-- <h4 class="mb-0">Group Name : {{ $data_sharing_group->name }}</h4> <small class="text-muted float-end"><a class="btn btn-info" href="{{ route('data-share.index') }}">Back</a></small> --}}
            </div>

            <div class="card-body">
                
                <form action="{{ route('add_sharing_rule') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">contact of</label><br><br>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">
                                {{-- <input class="form-control" type="text" name="name" id="name" value="{{ $data_sharing_group->name }}" readonly> --}}
                                <select class="form-control" name="can_access_to_group_id">
                                    <option value="">Select</option>
                                    @foreach ($all_data_sharing_groups as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('can_access_to_group_id')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Can be accessed by</label><br><br>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">
                                <select class="form-control" name="group_id">
                                    <option value="">Select</option>
                                    @foreach ($all_data_sharing_groups as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('group_id')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a class="btn btn-info" href="{{ route('data-share.index')}}">Cancel</a>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
