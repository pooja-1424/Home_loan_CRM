@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Update Role</h4>

    <!-- Add sanction form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
           
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Role Details</h5> <small class="text-muted float-end">Merged input group</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('role.update',$Role->id) }}" method="post">
                        
                        @csrf
                        @method('put')
                        
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                <textarea class="form-control" name="name" id="name" placeholder="Enter Name" rows="3">{{ $Role->name }}</textarea>
                                </div>
                                @error('name')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                               
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="slug">Slug</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                <textarea class="form-control" name="slug" id="slug" placeholder="Enter slug" rows="3">{{ $Role->slug }}</textarea>
                                </div>
                                @error('slug')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                               
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="Status">Status</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                <select class="form-select" name="status" id="status" aria-label="Default select example">
                                    
                                        <option>{{$Role->status}}</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        
                                    </select>
                                </div>
                                @error('status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div> --}}
                     
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a class="btn btn-info" href="{{ route('role.index')}}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
