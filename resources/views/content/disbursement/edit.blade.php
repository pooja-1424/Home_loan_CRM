@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Update Disbursement</h4>

@if ($message = Session::get('danger'))
<div class="alert alert-danger">
    <p>{{ $message }}</p>
</div>                        
@endif

<!-- Update Disbursement form -->
<!--body-->
{{-- <div class="card-body"> --}}
<form action="{{ route('disbursements.update',$disbursement->disb_id) }}" method="post" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Disbursement Details</h5> <small class="text-muted float-end">Merged input group</small>
            </div>
            <div class="card-body">
                <form action="{{ route('disbursements.store') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Client Name<span class="required">*</span></label><br><br>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">                                    
                                <select class="form-control dynamic" name="client_id"  id="client_id" data-dependent="sanction_id" >
                                    <option value="{{ $disbursement->client_id }}" value="{{ old('client_id') }}">{{$disbdata->fname }}</option>
                                    @foreach ($cname as $cList)
                                        <option value="{{ $cList->client_id }}" @if(old('client_id') == $cList->client_id) selected="selected" @endif>{{ $cList->fname }}</option>  
                                    @endforeach 
                                </select>
                          </div>
                            @error('client_id')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Sanction File No<span class="required">*</span></label>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge"> 
                                <input type="hidden" id="old_sanction_id"   value="{{old('file_number') }}">  
                                <input type="hidden" id="new_sanction_id" name="sanction_id" value="{{ $disbursement->sanction_id }}">                                  
                                <select class="form-control readonly-textbox" name="file_number" id="sanction_id"  onchange="fetchTextFieldData(this.value);" >                                                                              
                                    <option value="{{ $disbursement->sanction_id }}" value="{{ old('client_id') }}">{{$sanctiondata->file_number }}</option>
                                    <option value="">select</option>
                                </select>
                            </div> 
                            {{ csrf_field() }}                               
                            @error('sanction_id')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" >Bank Name</label>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">  
                                <input type="text"  id="bank_name" name="bank_name"  value="{{ $disbursement->bank_name}}" class="form-control readonly-textbox"  placeholder="Bank Name" readonly />
                            </div> 
                            @error('bank_name')
                                <div style="color: red">{{ $message }}</div>
                            @enderror                               
                        </div> 
                        <label class="col-sm-2 col-form-label" >Disbursement Date<span class="required">*</span></label>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">                                   
                                <input type="date" name="disb_date" id="basic-icon-default-email" value="{{ $disbursement->disb_date }}" class="form-control" placeholder="Disbursement Date" aria-label="john.doe" aria-describedby="basic-icon-default-email2" />
                            </div>
                            @error('disb_date')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                                                
                    </div>

                    <div class="row mb-3">                         
                        <label class="col-sm-2 form-label" >Sanction Amount</label>
                        <div class="col-sm-4">   
                            <input type="text"  id="sanction_loan_amt" name="sanction_loan_amt"  value="{{ $sanctiondata->sanction_loan_amt}}" class="form-control readonly-textbox"  placeholder="Sanction Amount" readonly />
                            @error('sanction_loan_amt')
                                <div style="color: red">{{ $message }}</div>
                            @enderror                               
                        </div>
                        <label class="col-sm-2 col-form-label" >Disbursement Amount<span class="required">*</span></label>
                        <div class="col-sm-4">                               
                             <div class="input-group input-group-merge">                                                            
                                 <input type="number" name="disb_amt" value="{{$disbursement->disb_amt}}" class="form-control" id="disb_amt" placeholder="Disbursement Amount" data-field="disb_amt" oninput="calculateUpdate(this.value,{{$disbursement->disb_amt}});updateStatus();"   />
                             </div>
                            @error('disb_amt')
                                <div style="color: red">{{ $message }}</div>
                            @enderror                                
                        </div>    
                    </div>

                    <div class="row mb-3">          
                        <label class="col-sm-2 form-label" >Partial Amount</label>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">                                   
                                <input type="text" id="disb_partial_amount" name="disb_partial_amount"  value="{{ $sanctiondata->disb_partial_amount}}" class="form-control readonly-textbox"  placeholder="Partial Amount" readonly />
                            </div>
                            <span id="errorText" style="color: red; display: none;"></span>                              
                        </div>
                        <label class="col-sm-2 form-label" for="basic-icon-default-phone">LRT Amout</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                   
                                    <input type="text"  id="LRT_amt" name="LRT_amt"  value="{{ $disbursement->LRT_amt}}" class="form-control"  placeholder="LRT Amount"/>
                                </div>
                                @error('LRT_amt')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                               
                            </div> 
                        
                    </div>

                    <div class="row mb-3">
                      <label class="col-sm-2 form-label" for="basic-icon-default-phone">Pending Disbursement</label>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">                                   
                                <input type="text"  id="pending_disb" name="pending_disb"  value="{{ $disbursement->pending_disb}}" class="form-control readonly-textbox dynamic1"  placeholder="Pending Disbursement" readonly/>
                            </div>
                            @error('pending_disb')
                                <div style="color: red">{{ $message }}</div>
                            @enderror                               
                        </div>                               
                        <label class="col-sm-2 col-form-label" >Disbursement Status<span class="required">*</span></label>
                        <div class="col-sm-4">                                                      
                              <select class="form-control" name="status" id="status" value="{{ old('status') }}">                                        
                                  <option value="{{ $disbursement->status }}" value="{{ old('status') }}">{{$disbursement->status }}</option> 
                                  <option value="{{ old('status') }}">Select Status</option>
                                  <option  value="Partly_disbursed" {{ old('status') == "Partly_disbursed" ? 'selected' : '' }}>Partly Disbursed</option>
                                  <option  value="Final_disbursment" {{ old('status') == "Final_disbursment" ? 'selected' : '' }}>Final Disbursment</option> 
                                  <option  value="in-process" {{ old('status') == "in-process" ? 'selected' : '' }}>in-process</option> 
                                  <option  value="Cancelled" {{ old('status') == "Cancelled" ? 'selected' : '' }}>Cancelled</option> 
                                  <option  value="Reject" {{ old('status') == "Reject" ? 'selected' : '' }}>Reject</option> 
                                  <option  value="Not_Disbursed" {{ old('status') == "Not_Disbursed" ? 'selected' : '' }}>Not Disbursed</option> 
                              </select>
                                @error('status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                        </div>          
                            
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label">Attachments</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                    
                                    <input type="file" name="sanction_file" id="sanction_file" value="{{ $disbursement->sanction_file }}" class="form-control phone-mask" placeholder="Select File"  aria-describedby="basic-icon-default-phone2" />
                                </div>
                                @if ($disbursement->sanction_file)
                                    <span>{{ $disbursement->sanction_file }}</span>
                                @endif                               
                                @error('sanction_file')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        <label class="col-sm-2 form-label" >Description</label>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">                                   
                                {{-- <input type="text" name="pending_disb" id="mobile_number" value="{{ old('pending_disb') }}" class="form-control phone-mask"  placeholder="Pending Disbursement" aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2" /> --}}
                                <textarea class="form-control" name="description" id="description" placeholder="Description" rows="3">{{ isset($disbursement->description) ? $disbursement->description : old('description') }}</textarea>
                            </div>
                            @error('description')
                                <div style="color: red">{{ $message }}</div>
                            @enderror                               
                        </div>
                        {{-- <label class="col-sm-2 form-label" >Comments</label>
                        <div class="col-sm-4">
                            <div class="input-group input-group-merge">                                
                                <textarea class="form-control" name="comments" id="comments" placeholder="Enter Comments" rows="3">{{ old('comments') }}</textarea>
                            </div>
                            @error('comments')
                                <div style="color: red">{{ $message }}</div>
                            @enderror                               
                        </div> --}}
                        
                    </div>                                
                    <div class="row mb-3" style="display:none;">                            
                        <label class="col-sm-2 col-form-label" >Status</label>
                        <div class="col-sm-4">                                                      
                        <select class="form-control" name="disbursement_status" value="1">
                           <option  value="1" {{ old('disbursement_status') == "1" ? 'selected' : '' }}>Active</option> 
                        </select>
                            @error('disbursement_status')
                                <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>     
                    </div>   
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a class="btn btn-info" href="{{ route('disbursements.index')}}">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    </div>
</form>
</div>
@endsection
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
