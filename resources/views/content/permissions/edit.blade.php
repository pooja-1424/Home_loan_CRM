@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Update Permission</h4>

    <!-- Add sanction form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
           
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Permission Details</h5> <small class="text-muted float-end">Merged input group</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('permissions.update',$permission->id) }}" method="post">
                        
                        @csrf
                        @method('patch')
                        
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                {{-- <textarea class="form-control" name="name" id="name" placeholder="Enter Name" rows="3">{{ $role->name }}</textarea> --}}
                                <input class="form-control" type="text" name="name" id="name" value="{{ $permission->name }}">
                                </div>
                                @error('name')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                               
                            </div>
                        </div>
                     
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a class="btn btn-info" href="{{ route('permissions.index')}}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
