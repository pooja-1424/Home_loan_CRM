@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Add Role</h4>

    <!-- Add Role form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- <h5 class="mb-0">User Details</h5> <small class="text-muted float-end">Merged input group</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label><br><br>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    {{-- <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span> --}}
                                    <input type="text" class="form-control" name="name" id="basic-icon-default-fullname" value="{{ old('name') }}" placeholder="Name" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('name')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            

                        {{-- <label class="col-sm-2 form-label" for="basic-icon-default-phone">Slug</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                   
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control phone-mask"  placeholder="Slug" aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2" />
                                </div>
                                @error('slug')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                               
                            </div> --}}
                        </div>

                        <div class="row mb-3">

                            {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Permission:</strong>
                                    <br/>
                                    @foreach($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br/>
                                    @endforeach
                                </div>
                            </div> --}}

                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Permissions</label>
                            <div class="col-sm-4">      
                                @foreach($permission as $value)
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $value->id }}" id="defaultCheck1" />
                                    <label class="form-check-label" for="defaultCheck1">
                                      {{ $value->name }}
                                    </label>
                                  </div>
                                @endforeach
                            </div>

                            {{-- <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Status</label>
                            <div class="col-sm-4">                                                      
                            <select class="form-control" name="status" value="{{ old('status') }}">
                                <option value="{{ old('status') }}">Select Status</option>
                                <option  value="1" {{ old('status') == "Active" ? 'selected' : '' }}>Active</option>
                                <option  value="0" {{ old('status') == "Inactive" ? 'selected' : '' }}>Inactive</option> 
                            </select>
                                @error('status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>      --}}
                        </div>                                     
                       
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <a class="btn btn-info" href="{{ route('roles.index')}}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- End Form --}}
