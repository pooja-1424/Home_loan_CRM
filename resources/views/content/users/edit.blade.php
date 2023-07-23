@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Update User</h4>

    <!-- update user form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">User Details</h5> <small class="text-muted float-end">Merged input group</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update',$user->user_id) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Emp Code<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="emp_code" id="emp_code" value="{{ $user->emp_code  }}" placeholder="Emp code" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('emp_code')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <label class="col-sm-2 col-form-label">First Name<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="firstname" id="firstname" value="{{ $user->firstname  }}" placeholder="first name"/>
                                </div>
                                @error('firstname')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">middlename</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="middlename" id="middlename" value="{{ $user->middlename  }}" placeholder="middlename" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('middlename')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        <label class="col-sm-2 col-form-label">lastname<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="lastname" id="lastname" value="{{ $user->lastname  }}" placeholder="last name"/>
                                </div>
                                @error('lastname')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">nickname</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="nickname" id="nickname" value="{{ $user->nickname  }}" placeholder="nick name" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('nickname')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Primary Email<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="text" name="email" id="basic-icon-default-email" value="{{$user->email }}" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2" />
                                   
                                </div>
                                @error('email')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                               
                            </div>
                        </div>
                            <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="basic-icon-default-phone">Mobile No<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="number" name="mobile_no" id="mobile_no" value="{{ $user->mobile_no  }}" class="form-control phone-mask" onblur="calNum()" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2" />
                                </div>
                                @error('mobile_no')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                
                            </div>
                            <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password" id="password" value="" placeholder="Enter password" />
                                    </div>
                                    @error('password')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" placeholder="Re-Enter password" />
                                    </div>
                                    @error('password_confirmation')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                            <label class="col-sm-2 col-form-label">Date Of Birth</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="date" class="form-control" name="date_of_birth" id="DOB" value="{{ $user->date_of_birth  }}" placeholder="DOB" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('DOB')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Pan No</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="pan_no" id="basic-icon-default-fullname" value="{{$user->pan_no }}" placeholder="Pan no" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('pan_no')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <label class="col-sm-2 col-form-label">qualification</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="qualification" id="qualification" value="{{ $user->qualification  }}" placeholder="qualification" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('qualification')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">marital status</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="marital_status" id="basic-icon-default-fullname" value="{{$user->marital_status }}"  placeholder="Marital Status" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('marital_status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <label class="col-sm-2 col-form-label">Date Of Joining<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="date" class="form-control" name="joining_date" id="DOJ" value="{{ $user->joining_date  }}" placeholder="DOJ" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('joining_date')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                          <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Experience In Year</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" name="experience_in_year" id="basic-icon-default-fullname" value="{{$user->experience_in_year }}" placeholder="experience in year"  aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('experience_in_year')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <label class="col-sm-2 col-form-label">Last Package</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                       <input type="text" class="form-control" name="last_package" id="basic-icon-default-fullname" value="{{$user->last_package }}" placeholder="last package"  aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('last_package')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Remember Token</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" name="remember_token" id="basic-icon-default-fullname" value="{{$user->remember_token }}" placeholder="remember token" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('remember_token')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <label class="col-sm-2 col-form-label">Permanant Address</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="permanant_address" id="permanant_address" value="{{ $user->permanant_address  }}" placeholder="Permanant address" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('permanant_address')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Current Address</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="current_address" id="current_address" value="{{ $user->current_address  }}" placeholder="Current address" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('current_address')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                       
                            <label class="col-sm-2 col-form-label">Home Contact No</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="number" class="form-control" name="home_contactno" id="home_contactno" value="{{ $user->home_contactno  }}" placeholder="home contact no" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('home_contactno')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                         
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Resignation Date</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="date" class="form-control" name="resignation_date" id="resignation_date" value="{{ $user->resignation_date  }}" placeholder="Resignation Date" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('resignation_date')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <label class="col-sm-2 col-form-label">status id</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="status_id" id="status_id" value="{{ $user->status_id  }}" placeholder="status id" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('status_id')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">experience in months</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="number" class="form-control" name="experience_in_months" id="experience_in_months" value="{{ $user->experience_in_months  }}" placeholder="experience in months" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('experience_in_months')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <label class="col-sm-2 col-form-label">Previous company name</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="privious_company_contactname" id="privious_company_contactname" value="{{ $user->privious_company_contactname  }}" placeholder="Previous company name" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('privious_company_contactname')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Previous company contact</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="number" class="form-control" name="privious_company_contact" id="privious_company_contact" value="{{ $user->privious_company_contact  }}" placeholder="Previous company contact" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('privious_company_contact')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <label class="col-sm-2 col-form-label">source</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                     <input type="text" class="form-control" name="source" id="source" value="{{ $user->source  }}" placeholder="source" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('source')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">source by</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                   <input type="text" class="form-control" name="source_by" id="source_by" value="{{ $user->source_by  }}" placeholder="source by" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('source_by')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        
                       <label class="col-sm-2 col-form-label">Designation</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="designation">
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" @php echo in_array($role, $userRole) ? "selected" : "" @endphp>
                                        {{ $role }}
                                    </option>
                                @endforeach                               
                            </select>
                        
                        </div>
                        </div>
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">remark by HR</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                         <input type="text" class="form-control" name="remark_by_HR" id="remark_by_HR" value="{{ $user->remark_by_HR  }}" placeholder="Remark by HR" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                    </div>
                                    @error('remark_by_HR')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                          </div>
                                <div class="row mb-3" style="display:none;">
                                    <label class="col-sm-2 col-form-label">User Status</label>
                                    <div class="col-sm-4">                                                      
                                    <select class="form-control" name="user_status" value="1">
                                       <option  value="1" {{ old('user_status') == "1" ? 'selected' : '' }}>Active</option> 
                                    </select>
                                        @error('user_status')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>     
                                </div>   
                       
                        <div class="row justify-content-end mb-5">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a class="btn btn-info" href="{{ route('users.index')}}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- End Form --}}
