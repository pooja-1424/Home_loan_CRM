@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Role List</h4>

    <!-- Add Sanction form -->

    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
        <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif


    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                   
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">User Details</h5>
                        <small class="text-muted float-end">
                            @can('role-create')
                            <a href="{{ route('roles.create') }}" class="btn btn-primary" role="button">Add Role</a>
                            @endcan
                        </small>
                </div>
                
                <div class="card-body">
                    <h5 class="card-header">Role List</h5>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Status</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    {{-- <th>Slug</th>
                                    <th>Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            
                                @php
                                    $i = 0;
                                   
                                @endphp

                                @if (isset($roles))
                                @forelse ($roles as $role)
                                <tr>
                                    <td>  
                                        @can('role-delete')
                                        <a href="javascript:void(0)" id="status{{$role->id}}" title='@php echo ($role->status==0) ? "Inactive" : "Active"; @endphp' onclick="status('{{ $role->id }}','{{ $role->status }}', 'status_update')">
                                            <div class="switchToggle"> 
                                                <input type="checkbox"   id="switch{{$role->id }}" {{ $role->status ? 'checked' : '' }}>
                                                 <label for="switch{{$role->id }}">Toggle</label>
                                            </div>     
                                        </a>                             
                                        @endcan                  
                                    </td> 
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                    <a href="{{ route('roles.show',$role->id) }}" class="btn btn-showid1" role="button"><i class="fa fa-eye"></a>
                                    @can('role-edit')
                                    <td><a class="btn btn-editid1" href="{{route('roles.edit',$role->id)}}"><i class="fa fa-pencil"></i></a></td> 
                                    @endcan
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
        {!! $roles->render() !!}
    </div>
@endsection
