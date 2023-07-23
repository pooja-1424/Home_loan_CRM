@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Role List</h4>

    <!-- Add Sanction form -->

    @if(session()->has('success'))
        <div class="alert alert-info" role="alert">
        <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif


    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                   
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">User Details</h5>
                        <small class="text-muted float-end">
                            <a href="{{ route('role.create') }}" class="btn btn-primary" role="button">Add</a>
                        </small>
                </div>
                
                <div class="card-body">
                    <h5 class="card-header">Role List</h5>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            
                                @php
                                    $i = 0;
                                   
                                @endphp

                                @if (isset($user_role))
                                @forelse ($user_role as $Role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    {{-- <td>{{ $Role->role_id }}</td> --}}
                                    <td>{{ $Role->name }}</td>
                                    <td>{{ $Role->slug }}</td>
                                    {{-- <td>{{ $Role->status }}</td> --}}
                                    
                                    {{-- <td><input data-id="{{$Role->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $Role->status ? 'checked' : '' }}></td> --}}
                                    
                                    <td>  
                                        <a href="javascript:void(0)" id="status{{$Role->id}}" title='@php echo ($Role->status==0) ? "Inactive" : "Active"; @endphp' onclick="status('{{ $Role->id }}','{{ $Role->status }}')">
                                            <div class="switchToggle"> 
                                                <input type="checkbox"   id="switch{{$Role->id }}" {{ $Role->status ? 'checked' : '' }}>
                                                 <label for="switch{{$Role->id }}">Toggle</label>
                                            </div>     
                                        </a>                             
                                                                           
                                    </td> 
                                        
                                    <td>
                                    <a href="{{ route('role.show',$Role->id) }}" class="btn btn-showid1" role="button"><i class="fa fa-eye">View</a>
                                    <td><a class="btn btn-editid1" href="{{route('role.edit',$Role->id)}}"><i class="fa fa-pencil">Edit</i></a></td> 
                                    
                                    
                                    
                                    
                                    
                                    
                                    {{-- <td>                                       
                                        <form method="POST" action="{{ route('role.destroy',$Role->id)}}" id="mybtn">
                                               @csrf
                                              @method('DELETE')                                                           
                                                    <button type="submit" id="mybtn" class="btn btn-deleteid1" onclick="deleteConfirm(event)"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>   --}}
                                </tr>
                                    
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
            </div>
        </div>
    </div>    
@endsection
