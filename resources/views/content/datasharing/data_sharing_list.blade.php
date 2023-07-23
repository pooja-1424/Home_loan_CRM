@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span>Data Sharing Rule Management</h4>

    <!-- Data Sharing  -->
    @if(session()->has('success'))
        <div class="alert alert-info" role="alert">
        <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif

    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0">Data Sharing Group List</h5>
                    <small class="text-muted float-end">
                        <a href="{{ route('createDataSharingGroups') }}" class="btn btn-primary" role="button">Create Sharing Group</a>
                    </small>
                </div>
                <div class="card-body">
                    @php
                        $i = 0;
                        // echo '<pre><h1>data</h1></hr>'; print_r($data); echo '</pre>';
                    @endphp
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>sr no</th>
                                    <th>contact of</th>
                                    <th>can be Accessed by</th>
                                    {{-- <th>Group Members</th> --}}
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                                                
                                @forelse ($data_sharing_groups as $dkey=>$data_sharing_group)
                                {{-- @foreach ($data_sharing_groups as $dkey=>$data_sharing_group) --}}
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>
                                            @foreach ($data_sharing_group->data_sharing_rules as $data_sharing_rules)
                                                {{ (isset($data_sharing_rules)) ? App\Models\data_share\data_sharing_group::find($data_sharing_rules->can_access_to_group_id)->name : ''; }}
                                                @if( !$loop->last) , @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $data_sharing_group->name }}</td>
                                        {{-- <td>{{ $data_sharing_group->users }}</td> --}}
                                        
                                        {{-- @foreach ($data_sharing_group->usersData as $user)
                                            <td>{{ $user->firstname." ".$user->lastname }}</td>
                                        @endforeach --}}
                                        {{-- <td><a href="{{ route('data-share.manage_members', $data_sharing_group) }}" title="Manage Members" class="btn btn-showid1"><i class="fa fa-gear"></a></td> --}}
                                        {{-- <td><a class="btn btn-editid1" href="{{route('data-share.edit', $data_sharing_group)}}"><i class="fa fa-pencil"></i></a></td>  --}}
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="3"><h4> No Data Found !</h4></td>
                                </tr>
                                @endforelse
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
