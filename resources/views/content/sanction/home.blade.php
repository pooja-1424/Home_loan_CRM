@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Contact List</h4>

    <!-- Add contact form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">User Details</h5>
                    <small class="text-muted float-end">
                        <a href="{{ route('contact.add') }}" class="btn btn-primary" role="button">Add Contact</a>
                    </small>
                </div>
                <div class="card-body">
                    <h5 class="card-header">Contacts List</h5>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Sr. No.</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Country</th>
                                    <th>Labels</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $i = 0;
                                @endphp

                                @if (isset($data))
                                @forelse ($data as $contact)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->mobile_number }}</td>
                                    <td>{{ $contact->country }}</td>
                                    <td>
                                        {{-- <span class="badge bg-label-primary me-1">Active</span> --}}
                                        @php
                                            $labelData = json_decode($contact->lables, true);
                                            // var_dump($labelData);
                                        @endphp
                                        <ul>
                                            @isset($labelData)
                                                @forelse ($labelData as $Clabel)
                                                    @php
                                                        // print_r($Clabel);
                                                    @endphp
                                                    @if ($Clabel == 'Complete')
                                                        <li class="badge_label"><span class="badge bg-label-success me-1">{{ $Clabel }}</span></li>
                                                    @elseif ($Clabel == 'Working on')
                                                        <li class="badge_label"><span class="badge bg-label-primary me-1">{{ $Clabel }}</span></li>
                                                    @elseif ($Clabel == 'Cancelled')
                                                        <li class="badge_label"><span class="badge bg-label-danger me-1">{{ $Clabel }}</span></li>
                                                    @elseif ($Clabel == 'Hold')
                                                        <li class="badge_label"><span class="badge bg-label-info me-1">{{ $Clabel }}</span></li>
                                                    @else
                                                        <li class="badge_label"><span class="badge bg-label-dark me-1">{{ $Clabel }}</span></li>
                                                    @endif
                                                @empty
                                                    <li>"No Lables"</li>
                                                @endforelse
                                            @endisset
                                        </ul>
                                        {{-- <td>{{ $contact->lables }}</td> --}}
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
            </div>
        </div>
    </div>
@endsection

