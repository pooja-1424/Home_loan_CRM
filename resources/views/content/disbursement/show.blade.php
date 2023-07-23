@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    {{-- Show Form --}}
    <form action="" method="POST" onload="document.getElementById('defaultOpen').click();">
        <div class="disbdetails" style="background-color: white;padding-bottom:35px;">
            <div class="tab">
                <input type="button" class="tablinks active" onclick="openCity(event, 'disbursement')" id="defaultOpen"
                    value="Disbursement">
                <input type="button" class="tablinks" onclick="openCity(event, 'contact')" value="Client Details">
                <input type="button" class="tablinks" onclick="openCity(event, 'sanction')" value="Sanction">
                <input type="button" class="tablinks" onclick="openCity(event, 'comment')" value="Comment">
            </div>

            <div class="container" style="background-color: white;padding-bottom:35px;">
                <div class="tabcontent" id="disbursement" style="display:block;">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="mb-0">Disbursement Details</h2>
                                <small class="text-muted float-end">
                                    <a href="{{ route('disbursements.index') }}" class="btn btn-primary" role="button">Back</a>
                                </small>
                            </div><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-xs-12 margin-tb">                         
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Login Date:</strong>
                                        {{ $disbursement->disb_date }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Sanction Amount:</strong>
                                        {{ $sanctiondata->sanction_loan_amt }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Partial Amount:</strong>
                                        {{ $sanctiondata->disb_partial_amount }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Disbursement Amount:</strong>
                                        {{ $disbursement->disb_amt }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Bank Name:</strong>
                                        {{ $disbursement->bank_name }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>LRT Amount:</strong>
                                        {{ $disbursement->LRT_amt }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Status:</strong>
                                        {{ $disbursement->status }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Pending Disbursement:</strong>
                                        {{ $disbursement->pending_disb }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                                
                            </div><br>
                            <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        {{ $disbursement->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xs-12 margin-tb" style="margin-top:-40px; min-width:30px">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 mt-2">Comment:</h4>
                            </div>
                            <div class="card card-body commentbox">
                                <div class="row mb-3">
                                    <!-- <label class="col-sm-2 form-label" for="Requirements">Comments:</label> -->
                                    <div class="col-sm-12">
                                        <div>
                                            <h5 class="d-block font-weight-bold name mb-4">Leave a comment:</h5>
                                        </div>
                                        <div class="input-group input-group-merge">
                                            <textarea class="form-control" name="comments" id="cmt" placeholder="Comments" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-12">
                                        <button type="button" id="myButton" onclick="addbtnDisb({{ $disbursement }})"
                                            class="btn btn-primary">add</button>
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-start mt-4 mb-4">
                                    <span class="d-block font-weight-bold name">Comments</span>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="comments-list-container" class="text-justify mt-4">
                                                <ul id="comments-list"></ul>
                                            </div>
                                        </div>
                                        <div class="commentdisp">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    @foreach ($comment->sortByDesc('created_at') as $comment)
                                                <li class="commentList"><br>
                                                    <i class="fas fa-user-circle"></i>
                                                    {{ $comment->created_by }}
                                                    <br>
                                                    <span class="comment"
                                                        style="color: {{ $comment->isImportant ? 'red' : 'black' }}">
                                                        {{ $comment->comments }}
                                                    </span>
                                                    <br>
                                     
                                                    {{ $comment->created_at->format('Y-m-d  H:i') }}
                                                    <br><br>
                                                </li>
                                                <br>
                                                @endforeach
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="background-color: white;padding-bottom:35px;">
                <div class="tabcontent" id="sanction" style="display:none;">
                    <small class="text-muted float-end">
                        <a href="{{ route('disbursements.index') }}" class="btn btn-primary" role="button">Back</a>
                    </small>
                    <div class="card-body">
                        <h5 class="card-header">Sanction List</h5>
                        <div class="table-responsive text-nowrap">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>Sr. No.</th>                                        
                                        <th>Sanction Date</th>
                                        <th>Bank Name</th>
                                        <th>Requirements</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php
                                        $i = 0;
                                    @endphp

                                    @if (isset($data))
                                        @forelse ($data->tbl_hlsanction as $role)
                                            <tr>
                                                <td>{{ ++$i }}</td>                                               
                                                <td>{{ $role->sanction_date }}</td>
                                                <td>{{ $role->bank_name }}</td>
                                                <td>{{ $role->requirements }}</td>
                                                <td>{{ $role->status }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">
                                                    <h4> No Data Found !</h4>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="3">
                                                <h4> No Data Found !</h4>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="background-color: white;padding-bottom:35px;">
                <div class="tabcontent" id="contact" style="display:none;">
                    <div class="row">
                        <div class="col-lg-12 margin-tb cdetails">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="mb-0">User Details</h2>
                                <small class="text-muted float-end">
                                    <a href="{{ route('disbursements.index') }}" class="btn btn-primary"
                                        role="button">Back</a>
                                </small>
                            </div><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>First Name:</strong>
                                {{ $data->fname }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Last Name:</strong>
                                {{ $data->lname }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Mobile No:</strong>
                                {{ $data->mobile1 }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Alternate Mobile No:</strong>
                                {{ $data->mobile2 }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Primary Email:</strong>
                                {{ $data->email1 }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Secondary Email:</strong>
                                {{ $data->email2 }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Address:</strong>
                                {{ $data->address }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>City:</strong>
                                {{ $data->city }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>State:</strong>
                                {{ $data->state }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Country:</strong>
                                {{ $data->country }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>DOB:</strong>
                                {{ $data->date_of_birth }}
                            </div>
                        </div>                       
                    </div><br><br>

                    <h2 style="margin-left:30px;">Lead Details</h2><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Lead Status:</strong>
                                {{ $data->Lead_Status }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Lead Source:</strong>
                                {{ $data->Lead_source }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Tracking Status:</strong>
                                {{ $data->Tracking_Status }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Tracking Sub status:</strong>
                                {{ $data->Tracking_Status_Sub }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Lead Source By Employees:</strong>
                                {{ $data->Lead_source_by_emp }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Team Leader:</strong>
                                {{ $data->Team_Leader }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Lead Source Details:</strong>
                                {{ $data->lead_source_details }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Backend Source:</strong>
                                {{ $data->Back_end_source }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Assigned To:</strong>
                                {{ $data->Assigned_To }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Closing By:</strong>
                                {{ $data->closing_by }}
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Lead Source SM:</strong>
                                {{ $data->lead_source_sm }}
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <strong>Lead Surce TL:</strong>
                                {{ $data->lead_source_TL }}
                            </div>

                        </div><br><br>

                        <h2 style="margin-left:30px;">Requirements</h2><br>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Type of Customer:</strong>
                                    {{ $data->type_of_customer }}
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Interested Bank:</strong>
                                    {{ $data->Interested_bank }}
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Is Home Loan Required?:</strong>
                                    {{ $data->is_homeloan_required }}
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Current Residence At:</strong>
                                    {{ $data->Current_Residence_At }}
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Property Phase Requirements:</strong>
                                    {{ $data->property_phase_req }}
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Property Address:</strong>
                                    {{ $data->Porperty_Address }}
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Property Value:</strong>
                                    {{ $data->Property_Value }}
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Is Property Finalised?:</strong>
                                    {{ $data->is_proprty_final }}
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Reference Take or Not?:</strong>
                                    {{ $data->reference_take_or_not }}
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Reference:</strong>
                                    {{ $data->Reference }}
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <strong>Profile:</strong>
                                    {{ $data->profile }}
                                </div>
                            </div>
                        </div>
                    </div><br><br><br>

                    
                </div>
            </div>

            <div class="cotainer" style="background-color: white;padding-bottom:35px;">
                <div class="tabcontent" id="comment" style="display:none; margin-top: -87px;">
                    <small class="text-muted float-end">
                        <a href="{{ route('disbursements.index') }}" class="btn btn-primary"
                            role="button">Back</a>
                    </small>
                    <div class="card-body">
                        <h5 class="card-header">Comment</h5>
                        <div class="table-responsive text-nowrap">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>Sr. No.</th>
                                        <th>Comments</th>                                        
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @php
                                        $i = 0;
                                    @endphp

                                    @if (isset($comData))
                                        @forelse ($comData->tbl_hlcomments as $datalist)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $datalist->comments }}</td>                                              
                                                <td>{{ $datalist->created_at }}</td>
                                                <td>{{ $datalist->updated_at }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">
                                                    <h4> No Data Found !</h4>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="3">
                                                <h4> No Data Found !</h4>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
{{-- End Show Form --}}
