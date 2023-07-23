@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span>Data Sharing Rule Management</h4>

    <!-- Data Sharing  -->
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
        <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif

    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0">Data Sharing Group List</h5>
                    @can('data-share-group-create')
                        <small class="text-muted float-end">
                            <a href="{{ route('data-share.create') }}" class="btn btn-primary" role="button">Add Group</a>
                        </small>
                    @endcan
                </div>

                <form method="post" action="{{ route('groupFilter') }}">
                    @csrf
                   
                    <div class="row mb-0 pt-2 card-header d-flex align-items-center justify-content-between">
                        <div class="col-sm-5">
                            <div class="input-group input-group-merge mb-1">
                                <label for="filterGroup"><b>Group</b></label>
                            </div>
                            <input type="text" class="form-control" name="filterGroup" value="{{ (isset($request->filterGroup)) ? $request->filterGroup : '' }}">
                                                                                    
                            {{-- <input type="text" class="form-control" name="filterGroup" value="{{ old('filterGroup', isset($request->filterGroup) ? $request->filterGroup : '') }}"> --}}
                        </div>
                        
                        <div class="col-sm-2 pt-4">
                             <button type="submit" class="btn btn-primary search" style="margin-left: -285%">Search Group</button>
                        </div>
                        
                    </div>
                </form> 

                <div class="card-body">
                    @php
                        $i = 0;
                        
                    @endphp
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>sr no</th>
                                    {{-- <th>contact of</th> --}}
                                    <th>Group</th>
                                    <th>Group Members</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                $i = 0;
                            @endphp

                            @if (isset($data_sharing_groups))
                            
                                @forelse ($data_sharing_groups as $dkey=>$data_sharing_group)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $data_sharing_group->name }}</td>
                                        {{-- <td>{{ $data_sharing_group->users }}</td> --}}
                                        <td>
                                            @foreach ($data_sharing_group->usersData as $user)
                                                {{ $user->firstname." ".$user->lastname }}

                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        {{-- <td><a href="{{ route('data-share.manage_members', $data_sharing_group) }}" title="Manage Members" class="btn btn-showid1"><i class="fa fa-gear"></a></td> --}}
                                        <td>
                                            @can('data-share-group-edit')
                                                <a class="btn btn-editid1" href="{{route('data-share.edit', $data_sharing_group)}}"><i class="fa fa-pencil"></i></a>
                                            @endcan
                                        </td> 
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
                <div class="d-flex justify-content-center">
                    {{ $data_sharing_groups->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
