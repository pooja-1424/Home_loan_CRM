@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Permission List</h4>

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
                    <h5 class="mb-0">Permission Details</h5>
                        <small class="text-muted float-end">
                            @can('role-create')
                            <a href="{{ route('permissions.create') }}" class="btn btn-primary" role="button">Add Permission</a>
                            @endcan
                        </small>
                </div>
                
                <div class="card-body">
                    <h5 class="card-header">Permission List</h5>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            
                                @php
                                    $i = 0;
                                   
                                @endphp

                                @if (isset($permissions ))
                                @forelse ($permissions  as $permission)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>
                                    {{-- <a href="{{ route('permissions.show',$permission->id) }}" class="btn btn-showid1" role="button"><i class="fa fa-eye"></a> --}}
                                    <td><a class="btn btn-editid1" href="{{route('permissions.edit',$permission->id)}}"><i class="fa fa-pencil"></i></a></td> 
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
        {!! $permissions->render() !!}
    </div>
@endsection
