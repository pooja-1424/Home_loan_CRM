@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Users List</h4>
    
   
    <!-- Add contact form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                @can('user-create')
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">User Details</h5>
                        <small class="text-muted float-end">
                            <a href="{{ route('users.create') }}" class="btn btn-primary" role="button">Add User</a>
                        </small>
                    </div>
                @endcan
                 <!-- Search input -->


                <form method="get" action="{{ route('userFilter') }}">
                    @csrf
                   
                    <div class="row mb-0 pt-2 card-header d-flex align-items-center justify-content-between">
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter1"><b>User Name</b></label>
                            </div>
                            <input type="text" class="form-control" name="filter1" value="{{ (isset($request->filter1)) ? $request->filter1 : '' }}">
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                             <label for="filter2"><b>Contact</b></label>
                            </div>
                             <input type="number" class="form-control" name="filter2" value="{{ (isset($request->filter2)) ? $request->filter2 : ''  }}">
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter3"><b>Joining Date</b></label>
                            </div>
                             <input type="date" class="form-control" name="filter3" value="{{ (isset($request->filter3)) ? $request->filter3 : ''  }}">
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter4"><b>Email Id</b></label>
                            </div>
                             <input type="text" class="form-control" name="filter4" value="{{ (isset($request->filter4)) ? $request->filter4 : ''  }}">
                        </div>
                        
                        <div class="col-sm-2 pt-3">
                             <button type="submit" class="btn btn-primary">Search User</button>
                        </div>
                        
                    </div>
                </form> 
                
                <div class="card-body">
                    <h5 class="card-header">Users List</h5>

                    <div class="table-responsive text-nowrap">

                        @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                        <strong>{{ session()->get('success') }}</strong>
                        </div>
                    @endif
                    
                   
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>User Status</th>
                                    <th>Sr. No.</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Joining Date</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="myTable" class="table-border-bottom-0">
                                @php
                                    $i = 0;
                                @endphp

                                @if (isset($data))
                                {{-- <tbody> --}}
                                @forelse ($data as $key => $user)
                                <tr>
                                    <td>  
                                        @can('user-delete')
                                            <a href="javascript:void(0)" id="status{{$user->user_id}}" title='@php echo ($user->user_status==0) ? "Inactive" : "Active"; @endphp' onclick="status('{{ $user->user_id }}','{{ $user->user_status }}','userstatusdata')">
                                                <div class="switchToggle"> 
                                                    <input type="checkbox"   id="switch{{$user->user_id}}" {{ $user->user_status ? 'checked' : '' }}>
                                                    <label for="switch{{$user->user_id }}">Toggle</label>
                                                </div>     
                                            </a>     
                                        @endcan
                                    </td>    
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile_no }}</td>
                                    <td>{{ $user->joining_date }}</td>
                                    <td>
                                        <a href="{{ route('users.show',$user->user_id) }}" class="btn btn-showid1" role="button"><i class="fa fa-eye"></i></a>
                                        
                                        {{-- <a class="btn btn-info" href="{{ route('users.edit',$user->user_id) }}"><i class="fa fa-pencil"></i></a> --}}
                                    </td>
                                </tr>
                                {{-- @endforeach --}}
                                @empty
                                    <tr>
                                    <td colspan="3"><h4> No Data Found !</h4></td>
                                    </tr>
                                @endforelse                                
                                @else
                                <tr>
                                    <td colspan="3"><h4> No Data Found !</h4></td>
                                </tr>
                                @endif

                            </tbody>
                            
                        </table>
                        
                    </div>
                    
                </div>
                <div class="d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
        
    </div>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
@endsection
