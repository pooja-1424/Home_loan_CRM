@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
{{-- Modal Start --}}
<div class="modal fade" id="disbmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
      <div class="modal-content display" >
        <div class="modal-header">
            <h5 class="mb-0" id="exampleModalLabel">Disbursement Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-right:-42px;"></button>
       </div><br>       
       <span class="error-container" id="pending_disbErrorContainer1"></span>      
      <div id="message" class="alert alert-success" style="display: none;"></div>
      <div id="messageError" class="alert alert-danger" style="display: none;"></div>
    <form action="" method="post" id="disbForm" enctype="multipart/form-data"   onload=" document.getElementById('disb').click(); " >
         @csrf 
         <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Client ID<span class="required">*</span></label><br><br>
            <div class="col-sm-4">
                <div class="input-group input-group-merge">                                    
                    <input type="hidden" name="client_id" value="{{ $data->client_id }}">
                    <input type="text" name="fname" id="fname" value="{{ $data->fname }}" class="form-control" placeholder="Client Name"/> 
              </div>
              <span class="text-danger error-container" id="client_idErrorContainer"></span>
            </div>
            <label class="col-sm-2 col-form-label " >Sanction File No<span class="required">*</span></label>
            <div class="col-sm-4">
                <div class="input-group input-group-merge"> 
                    <input type="hidden" id="old_sanction_id"   value="{{old('file_number') }}">  
                    <input type="hidden" id="new_sanction_id" name="sanction_id" value="{{ old('sanction_id') }}">                                  
                    <select class="form-control dynamicone" name="file_number" id="sanction_id"  onchange="fetchTextFieldData(this.value);" >                                                                              
                       <option>select</option>
                        @foreach ($disbdata as $cList)
                        <option value="{{ $cList->sanction_id }}">{{ $cList->file_number }}</option>  
                       @endforeach 
                    </select>
                </div>
                <span class="text-danger error-container" id="sanction_idErrorContainer"></span>
                {{ csrf_field() }}                              
            </div>            
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" >Disbursement Date<span class="required">*</span></label>
            <div class="col-sm-4">
                <div class="input-group input-group-merge ">                                   
                    <input type="date" name="disb_date" id="disb_date" value="{{ old('disb_date') }}" class="form-control error-msg2" placeholder="Disbursement Date"  />
                </div>
                <span class="text-danger error-container" id="disb_dateErrorContainer"></span> 
            </div>
            <label class="col-sm-2 col-form-label" >Bank Name</label>
            <div class="col-sm-4">
                <div class="input-group input-group-merge">  
                    <input type="text"  id="bank_name" name="bank_name"  value="{{ old('bank_name')}}" class="form-control readonly-textbox"  placeholder="Bank Name" readonly />
                </div>                                             
            </div>                         
        </div>

        <div class="row mb-3">                         
            <label class="col-sm-2 form-label" >Sanction Amount</label>
            <div class="col-sm-4">   
                <input type="text"  id="sanction_loan_amt" name="sanction_loan_amt"  value="{{ old('sanction_loan_amt')}}" class="form-control readonly-textbox"  placeholder="Sanction Amount" readonly />
                                         
            </div>
            <label class="col-sm-2 col-form-label" >Disbursement Amount<span class="required">*</span></label>
            <div class="col-sm-4">                               
                 <div class="input-group input-group-merge">                                                            
                     <input type="number" name="disb_amt" class="form-control error-msg3" id="disb_amt" placeholder="Disbursement Amount"  value="{{old('disb_amt') }}" data-field="disb_amt" oninput="calculate();updateStatus();"   />
                 </div>
                 <span class="text-danger error-container" id="disb_amtErrorContainer"></span>                               
            </div>    
        </div>

        <div class="row mb-3">          
            <label class="col-sm-2 form-label" >Partial Amount</label>
            <div class="col-sm-4">
                <div class="input-group input-group-merge">                                   
                    <input type="text" id="disb_partial_amount" name="disb_partial_amount"  value="{{ old('disb_partial_amount')}}" class="form-control readonly-textbox"  placeholder="Partial Amount" readonly />
                </div>
                <span id="errorText" style="color: red; display: none;"></span>                              
            </div>
            <label class="col-sm-2 form-label" for="basic-icon-default-phone">Pending Disbursement</label>
            <div class="col-sm-4">
                <div class="input-group input-group-merge">                                   
                    <input type="text"  id="pending_disb" name="pending_disb"  value="{{ old('pending_disb')}}" class="form-control readonly-textbox dynamic1"  placeholder="Pending Disbursement" readonly/>
                </div>
                <span class="text-danger error-container" id="pending_disbErrorContainer"></span>                                
            </div>      
        </div>

        <div class="row mb-3">                               
            <label class="col-sm-2 col-form-label" >Disbursement Status<span class="required">*</span></label>
            <div class="col-sm-4">                                                      
                  <select class="form-control" name="status" id="status" value="{{ old('status') }}" style="width:221px;left:13%;">                                        
                      <option value="{{ old('status') }}">Select Status</option>
                      <option  value="Partly_disbursed" {{ old('status') == "Partly_disbursed" ? 'selected' : '' }}>Partly Disbursed</option>
                      <option  value="Final_disbursment" {{ old('status') == "Final_disbursment" ? 'selected' : '' }}>Final Disbursment</option> 
                      <option  value="in-process" {{ old('status') == "in-process" ? 'selected' : '' }}>in-process</option> 
                      <option  value="Cancelled" {{ old('status') == "Cancelled" ? 'selected' : '' }}>Cancelled</option> 
                      <option  value="Reject" {{ old('status') == "Reject" ? 'selected' : '' }}>Reject</option> 
                      <option  value="Not_Disbursed" {{ old('status') == "Not_Disbursed" ? 'selected' : '' }}>Not Disbursed</option> 
                  </select>
                  <span class="text-danger error-container" id="statusErrorContainer" style="position: absolute;margin-top: 16%;left: 6%;"></span> 
          </div>          
                <label class="col-sm-2 form-label">Attachments</label>
                <div class="col-sm-4">
                    <div class="input-group input-group-merge">                                    
                        <input type="file" name="sanction_file" id="sanction_file" value="{{ old('sanction_file') }}" class="form-control phone-mask"  placeholder="Select File"  aria-describedby="basic-icon-default-phone2" />
                    </div>
                    @error('sanction_file')
                        <div style="color: red">{{ $message }}</div>
                    @enderror                               
                </div>
         </div>            
        
      <div class="row mb-3">
            <label class="col-sm-2 form-label" >Comments</label>
            <div class="col-sm-4">
                <div class="input-group input-group-merge">                                
                    <textarea class="form-control" name="comments" id="comments" placeholder="Enter Comments" rows="3">{{ old('comments') }}</textarea>
                </div>
                @error('comments')
                    <div style="color: red">{{ $message }}</div>
                @enderror                               
            </div>
            <label class="col-sm-2 form-label" >Description</label>
            <div class="col-sm-4">
                <div class="input-group input-group-merge">                                   
                    {{-- <input type="text" name="pending_disb" id="mobile_number" value="{{ old('pending_disb') }}" class="form-control phone-mask"  placeholder="Pending Disbursement" aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2" /> --}}
                  <textarea class="form-control" name="description" id="description" placeholder="Description" rows="3">{{ old('description') }}</textarea>
                </div>
                @error('description')
                    <div style="color: red">{{ $message }}</div>
                @enderror                               
            </div>
        </div>                                  
        <div class="row mb-3" style="display:none;">                            
            <label class="col-sm-2 col-form-label" >Status</label>
            <div class="col-sm-4">                                                      
            <select class="form-control" name="disbursement_status" value="1">
               <option  value="1" {{ old('disbursement_status') == "1" ? 'selected' : '' }}selected>Active</option> 
            </select>
                @error('disbursement_status')
                    <div style="color: red">{{ $message }}</div>
                @enderror
            </div>     
        </div>        
      <div class="row justify-content-end" style="padding-bottom:5%">
        <div class="col-sm-10">
          <button type="button" id="openModal" class="btn btn-info" onclick="addDisbursement()">Add</button>
          <a class="btn btn-info" href="{{ route('contacts.index')}}">Cancel</a>
        </div>
      </div>
    </form>
    </div>
    </div>
    </div>  
{{-- Modal End --}}

<form action="" method="POST" onload=" document.getElementById('defaultOpen').click(); " >
    <div class="sanctiondetails" style="background-color: white;padding-bottom:35px;">
        <div class="tab">
            <input type="button" class="tablinks active" onclick="openCity(event, 'sanction')" id="defaultOpen" value="Details">
            <input type="button" class="tablinks" onclick="openCity(event, 'contact')" value="Client Details">
            <input type="button" class="tablinks" onclick="openCity(event, 'disbursement')" value="Disbursement">
            <input type="button" class="tablinks" onclick="openCity(event, 'comment')" value="Comment">
       </div>
        <div class="tabcontent" id="sanction" style="display:block;">          
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                    <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="mb-0">Sanction Details</h2>
                       <small class="text-muted float-end">
                            <a href="{{ route('sanction.index') }}" class="btn btn-primary" role="button">Back</a>
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
                        {{ $sanction->login_date }}
                    </div>
                </div>
                <div class="col-sm-5">        
                    <div class="form-group">
                        <strong>Pick Up Date:</strong>
                        {{ $sanction->pick_up_date }}
                    </div>
                </div>        
            <div class="col-sm-1"></div>
        </div><br>

        <div class="row">
        <div class="col-sm-1"></div> 
                <div class="col-sm-5">
                    <div class="form-group">
                        <strong>Loan Amount:</strong>
                        {{ $sanction->loan_amount }}
                    </div>
                </div>           
                <div class="col-sm-5">        
                    <div class="form-group">
                        <strong>Bank Name:</strong>
                        {{ $sanction->bank_name }}
                    </div>
                </div>    
            <div class="col-sm-1"></div>
        </div><br>

        <div class="row">  
        <div class="col-sm-1"></div> 
                <div class="col-sm-5">
                    <div class="form-group">
                        <strong>Requirements:</strong>
                        {{ $sanction->requirements }}
                    </div>
                </div>         
                <div class="col-sm-5">        
                    <div class="form-group">
                        <strong>Status:</strong>
                        {{ $sanction->status }}
                    </div>
                </div> 
            <div class="col-sm-1"></div>
        </div><br>

        <div class="row"> 
        <div class="col-sm-1"></div> 
            <div class="col-sm-5">        
                    <div class="form-group">
                        <strong>Sanction Date:</strong>
                        {{ $sanction->sanction_date }}
                    </div>
                </div>  
                <div class="col-sm-5">
                    <div class="form-group">
                        <strong>Sanction Loan Amount:</strong>
                        {{ $sanction->sanction_loan_amt }}
                    </div>
                </div>       
            <div class="col-sm-1"></div>
        </div><br>

        <div class="row">
        <div class="col-sm-1"></div>
            <div class="col-sm-5">        
                    <div class="form-group">
                        <strong>Sanction Requirements:</strong>
                        {{ $sanction->sanction_requirements }}
                    </div>
                </div>          
                <div class="col-sm-5">        
                    <div class="form-group">
                        <strong>Expiry Date:</strong>
                        {{ $sanction->expiry_date }}
                    </div>
                </div>    
            <div class="col-sm-1"></div>
        </div><br>
        
        <div class="row">
        <div class="col-sm-1"></div>
            <div class="col-sm-5">
                    <div class="form-group">
                        <strong>File Number:</strong>
                        {{ $sanction->file_number }}
                    </div>
                </div> 
            <div class="col-sm-1"></div>
        </div><br>     
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
              <button type="button" id="myButton" onclick="addbtn({{ $sanction }})" class="btn btn-primary">add</button>
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
                    <span class="comment" style="color: {{ $comment->isImportant ? 'red' : 'black' }}">
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
            <div class="tabcontent" id="contact" style="display:none;">                  
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h2 class="mb-0">User Details</h2>
                       <small class="text-muted float-end">
                            <a href="{{ route('sanction.index') }}" class="btn btn-primary" role="button">Back</a>
                        </small>
                </div><br><br>                     
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1"></div>        
                    <div class="col-sm-4">        
                    <div class="form-group">
                            <strong>First Name:</strong>
                            {{ $data->fname }}
                        </div> 
                    </div>    
                    <div class="col-sm-4">
                    <div class="form-group">
                            <strong>Last Name:</strong>
                            {{ $data->lname }}
                        </div> 
                    </div>   
                <div class="col-sm-1"></div>
                </div><br>
                
                <div class="row">
                <div class="col-sm-1"></div>         
                    <div class="col-sm-4">        
                    <div class="form-group">
                            <strong>Mobile No:</strong>
                            {{ $data->mobile1 }}
                        </div> 
                    </div>    
                    <div class="col-sm-4">
                    <div class="form-group">
                            <strong>Alternate Mobile No:</strong>
                            {{ $data->mobile2 }}
                        </div>
                    </div>   
                <div class="col-sm-1"></div>
                </div><br>
                <div class="row">  
                    <div class="col-sm-1"></div>       
                    <div class="col-sm-4">        
                    <div class="form-group">
                            <strong>Primary Email:</strong>
                            {{ $data->email1 }}
                        </div>
                        </div>    
                    <div class="col-sm-4">
                    <div class="form-group">
                            <strong>Secondary Email:</strong>
                            {{ $data->email2 }}
                        </div>
                    </div>   
                    <div class="col-sm-1"></div>
                </div><br>
                <div class="row">   
                    <div class="col-sm-1"></div>      
                    <div class="col-sm-4">        
                    <div class="form-group">
                            <strong>Address:</strong>
                            {{ $data->address }}
                        </div>
                        </div>    
                    <div class="col-sm-4">
                    <div class="form-group">
                            <strong>City:</strong>
                            {{ $data->city }}
                        </div>
                    </div>   
                    <div class="col-sm-1"></div>
                </div><br>
                <div class="row">   
                    <div class="col-sm-1"></div>      
                    <div class="col-sm-4">        
                    <div class="form-group">
                            <strong>State:</strong>
                            {{ $data->state }}
                        </div>
                        </div>    
                    <div class="col-sm-4">
                    <div class="form-group">
                            <strong>Country:</strong>
                            {{ $data->country }}
                        </div>
                    </div>   
                    <div class="col-sm-1"></div>
                </div><br>
                <div class="row"> 
                    <div class="col-sm-1"></div>        
                    <div class="col-sm-4">        
                    <div class="form-group">
                            <strong>DOB:</strong>
                            {{ $data->date_of_birth }}
                        </div>
                        </div>    
                    </div><br><br>

            <h2 style="margin-left:30px;">Lead Details</h2><br>
            <div class="row">  
            <div class="col-sm-1"></div>       
            <div class="col-sm-4">        
                <div class="form-group">
                    <strong>Lead Status:</strong>
                    {{ $data->Lead_Status }}
                </div>
            </div>
                  
                <div class="col-sm-4">
                    <div class="form-group">
                        <strong>Lead Source:</strong>
                        {{ $data->Lead_source }}                
                    </div>
                </div>         
                <div class="col-sm-1"></div>
            </div><br> 
            <div class="row"> 
                <div class="col-sm-1"></div>        
                <div class="col-sm-4">        
                    <div class="form-group">
                        <strong>Tracking Status:</strong>
                        {{ $data->Tracking_Status }}
                    </div>
                    </div>
                        
                <div class="col-sm-4">
                    <div class="form-group">
                        <strong>Tracking Sub status:</strong>
                        {{ $data->Tracking_Status_Sub }}
                    </div>
                </div>   
                <div class="col-sm-1"></div>
            </div><br>  
            <div class="row"> 
                <div class="col-sm-1"></div>        
                <div class="col-sm-4">        
                    <div class="form-group">
                        <strong>Lead Source By Employees:</strong>
                        {{ $data->Lead_source_by_emp }}
                    </div>
                    </div>
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <strong>Team Leader:</strong>
                        {{ $data->Team_Leader }}
                    </div>
                </div>
            </div><br>
            <div class="row"> 
                <div class="col-sm-1"></div>        
                <div class="col-sm-4">        
                    <div class="form-group">
                        <strong>Lead Source Details:</strong>
                        {{ $data->lead_source_details }}
                    </div>
                    </div>
               
                <div class="col-sm-4">
                    <div class="form-group">
                        <strong>Backend Source:</strong>
                        {{ $data->Back_end_source }}
                    </div>
                </div>
            </div><br> 
            <div class="row"> 
                <div class="col-sm-1"></div>        
                <div class="col-sm-4">        
                    <div class="form-group">
                        <strong>Assigned To:</strong>
                        {{ $data->Assigned_To }}
                    </div>
                </div>
              
                <div class="col-sm-4">
                    <div class="form-group">
                        <strong>Closing By:</strong>
                        {{ $data->closing_by }}
                    </div>
                </div>   
            </div><br> 
            <div class="row">  
                <div class="col-sm-1"></div>       
                <div class="col-sm-4">        
                    <div class="form-group">
                        <strong>Lead Source SM:</strong>
                        {{ $data->lead_source_sm }}
                    </div>
                </div>
                    <div class="col-sm-4">        
                        <div class="form-group">
                            <strong>Lead Surce TL:</strong>
                            {{ $data->lead_source_TL }}
                        </div>
                    </div>
            </div><br><br>
            <h2 style="margin-left:30px;">Requirements</h2><br>
                <div class="row"> 
                    <div class="col-sm-1"></div>        
                    <div class="col-sm-4">        
                        <div class="form-group">
                            <strong>Type of Customer:</strong>
                            {{ $data->type_of_customer }}
                        </div>
                    </div>    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <strong>Interested Bank:</strong>
                            {{ $data->Interested_bank }}
                        </div>
                    </div>   
                </div><br>
                <div class="row"> 
                    <div class="col-sm-1"></div>        
                    <div class="col-sm-4">        
                        <div class="form-group">
                            <strong>Is Home Loan Required?:</strong>
                            {{ $data->is_homeloan_required }}
                        </div>
                        </div>     
                    <div class="col-sm-4">
                        <div class="form-group">
                            <strong>Current Residence At:</strong>
                            {{ $data->Current_Residence_At }}
                        </div>
                    </div>
                </div><br>
                <div class="row"> 
                    <div class="col-sm-1"></div>        
                    <div class="col-sm-4">        
                        <div class="form-group">
                            <strong>Property Phase Requirements:</strong>
                            {{ $data->property_phase_req }}
                        </div>
                        </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <strong>Property Address:</strong>
                            {{ $data->Porperty_Address }}
                        </div>
                    </div>   
                </div><br>
                <div class="row"> 
                    <div class="col-sm-1"></div>        
                    <div class="col-sm-4">        
                        <div class="form-group">
                            <strong>Property Value:</strong>
                            {{ $data->Property_Value }}
                        </div>
                    </div>
                   
                    <div class="col-sm-4">
                        <div class="form-group">
                            <strong>Is Property Finalised?:</strong>
                            {{ $data->is_proprty_final }}
                        </div>
                    </div>   
                </div><br>
                <div class="row"> 
                    <div class="col-sm-1"></div>        
                    <div class="col-sm-4">        
                        <div class="form-group">
                            <strong>Reference Take or Not?:</strong>
                            {{ $data->reference_take_or_not }}
                        </div>
                        </div>    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <strong>Reference:</strong>
                            {{ $data->Reference }}
                        </div>
                    </div>   
                    <div class="col-sm-1"></div>
                </div><br>
                <div class="row"> 
                    <div class="col-sm-1"></div>        
                    <div class="col-sm-4">        
                        <div class="form-group">
                            <strong>Profile:</strong>
                            {{ $data->profile }}
                        </div>
                        </div>    
            </div>            
        </div>
</div>

  <div class="container" style="background-color: white;padding-bottom:35px;">
     <div class="tabcontent" id="disbursement" style="display:none;"> 
            <small class="text-muted float-end">
                    {{-- <a href="{{ route('disbursements.create') }}" class="btn btn-primary" role="button"><i class="fa fa-plus" aria-hidden="true">&nbsp;&nbsp;Add</i></a> --}}
                    <button type="button" class="btn btn-primary" id="openModal1" data-bs-toggle="modal" data-bs-target="#disbmodal" role="button" >Add</button>  
                    <a href="{{ route('sanction.index') }}" class="btn btn-primary" role="button">Back</a>
                  
            </small>  
        <div class="card-body">
            <h5 class="card-header">Disbursement List</h5>
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
                            <th>Client Name</th>
                            <th>Disbursement Date</th>
                            <th>Disbursement Amount</th>
                            <th>Bank Name</th>
                            <th>Pending Disbursement</th>
                            <th>Status</th>
                            <th>Actions</th>                            
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $i = 0;
                        @endphp

                        @if (isset($data))
                        @forelse ($data->tbl_hldisbursement as $disbursement)
                        <tr>                             
                            <td>{{ ++$i }}</td>
                            <td>{{ $data->fname.'  '.$data->lname }}</td>
                            <td>{{ $disbursement->disb_date }}</td>                           
                            <td>{{ $disbursement->disb_amt }}</td>
                            <td>{{ $disbursement->bank_name }}</td>
                            <td>{{ $disbursement->pending_disb}}</td>  
                            <td>{{ $disbursement->status}}</td>
                            <td>
                                <a class="btn btn-showid" href="{{ route('disbursements.show',$disbursement->disb_id)}}"><i class="fa fa-eye"></i></a>
                            </td>
                            <td>
                                @can('disbursement-edit')
                                <a class="btn btn-editid" href="{{route('disbursements.edit',$disbursement->disb_id)}}"><i class="fa fa-pencil"></i></a>
                                @endcan
                            </td>                                       
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

    <div class="container" style="background-color: white;padding-bottom:35px;">
     <div class="tabcontent" id="comment" style="display:none;"> 
            <small class="text-muted float-end">
                <a href="{{ route('sanction.index') }}" class="btn btn-primary" role="button">Back</a>
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
                            {{-- <th>Sanction ID</th> --}}
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
                            {{-- <td>{{ $datalist->sanction_id }}</td> --}}
                            <td>{{ $datalist->created_at }}</td>
                            <td>{{ $datalist->updated_at }}</td>                                                         
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
</form>

@endsection
{{-- End Show Form --}}
