@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Update Sanction</h4>
    @if(session()->has('danger'))
                        <div class="alert alert-danger" role="alert">
                        <strong>{{ session()->get('danger') }}</strong>
                        </div>
                    @endif

    <!-- Add sanction form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
           
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Sanction Details</h5> <small class="text-muted float-end">Merged input group</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('sanction.update',$Sanction->sanction_id) }}" method="post">
                        
                        @csrf
                        @method('put')                        
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="Client Id">Client Name<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                <select class="form-control" name="client_id" value="{{ old('client_id') }}" onChange="selectedData(value)">                                       
                                        <option value="{{ $Sanction->client_id }}">{{$value->fname}}</option>
                                        @foreach($list as $cList)                                           
                                        <option  value="{{ $cList->client_id }}" @if(old('client_id') == $cList->fname) selected="selected" @endif>{{ $cList->fname }}</option>
                                        @endforeach
                                   </select>
                                   
                                </div>
                                @error('client_id')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>

                            <label class="col-sm-2 form-label" for="Date">Login Date<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                    
                                    <input type="date" name="login_date" id="login_date" value="{{ $Sanction->login_date }}" class="form-control phone-mask"  placeholder="Login Date"/>
                                </div>
                                @error('login_date')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div>

                        <div class="row mb-3">

                        <label class="col-sm-2 form-label" for="Date">Pick Up Date<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                    
                                    <input type="date" name="pick_up_date" id="pick_up_date" value="{{ $Sanction->pick_up_date }}" class="form-control phone-mask"  placeholder="Pick Up Date"/>
                                </div>
                                @error('pick_up_date')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                
                            </div>
                            <label class="col-sm-2 form-label" for="Amount">Loan Amount<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    
                                    <input type="number" name="loan_amount" id="loan_amount" value="{{ $Sanction->loan_amount }}" class="form-control phone-mask"  placeholder="Loan Amount" />
                                </div>
                                @error('loan_amount')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Bank Name<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <select class="form-control" name="bank_name" >                                        
                                        <option value="{{ $Sanction->bank_name }}">{{$Sanction->bank_name}}</option>
                                        @foreach(App\Models\Bankname::all() as $list)
                                         <option class="option">{{$list->bank_name}}</option>
                                        @endforeach
                                        
                                   </select>                                
                                </div>
                                @error('bank_name')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 form-label" for="Requirements">Requirements</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                <textarea class="form-control" name="requirements" id="requirements" placeholder="Enter Requirements" rows="3">{{ $Sanction->requirements }}</textarea>
                                </div>
                                @error('requirements')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                               
                            </div>
                        </div>
                        <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="Status1">Status<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                <select class="form-control" name="status" id="status" value="{{ old('status') }}" id ="fileNumber">
                                        <option value="{{ $Sanction->status }}"value="{{ old('status') }}">{{ $Sanction->status }}</option>
                                        <option value="disb-from-another-bank" {{old('status')=="disb-from-another-bank"?'selected':''}}>Disb From Another Bank</option>
                                        <option value="Sanctioned" {{old('status')=="Sanctioned"?'selected':''}}>Sanctioned</option>
                                        <option value="Partial_Disbursed" {{old('status')=="Partial_Disbursed"?'selected':''}}>Partial Disbursed</option>
                                        <option value="Final_Disbursement" {{old('status')=="Final_Disbursement"?'selected':''}}>Final Disbursement</option>
                                        <option value="In_Process" {{old('status')=="In_Process"?'selected':''}}>In Process</option>
                                        <option value="Cancelled" {{old('status')=="Cancelled"?'selected':''}}>Cancelled</option>
                                        <option value="Reject" {{old('status')=="Reject"?'selected':''}}>Reject</option>
                                        <option value="Not_Disbursed" {{old('status')=="Not_Disbursed"?'selected':''}}>Not Disbursed</option>
                                    </select>
                                </div>
                                @error('status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        <label class="col-sm-2 form-label" for="Sanction Date">Sanction Date</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="date" name="sanction_date" id="sanction_date" value="{{ $Sanction->sanction_date }}" class="form-control"  placeholder="Sanction Date" />
                                </div>
                                @error('sanction_date')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>
                        </div>
                        <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="Amount">Sanction Loan Amount</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                    
                                    <input type="number" name="sanction_loan_amt" id="sanction_loan_amt" value="{{ $Sanction->sanction_loan_amt }}" class="form-control"  placeholder="Sanction Loan Amount" />
                                </div>
                                @error('sanction_loan_amt')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>
                            <label class="col-sm-2 form-label" for="Sanction Requirements">Sanction Requirements</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                
                                    <textarea class="form-control" name="sanction_requirements" id="sanction_requirements" placeholder="Sanction Requirements" rows="3">{{ $Sanction->sanction_requirements }}</textarea>
                                </div>
                                @error('sanction_requirements')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                               
                            </div>
                        </div>

                        <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="Date">Expiry Date</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="date" name="expiry_date" id="expiry_date" value="{{ $Sanction->expiry_date }}" class="form-control"  placeholder="Expiry Date" />
                                </div>
                                @error('expiry_date')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>
                        <label class="col-sm-2 form-label" for="Date">File Number</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="file_number" id="file_number" value="{{ $Sanction->file_number }}" class="form-control"  placeholder="File Number"/>
                                </div>
                                @error('file_number')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>
                            </div>
                        <div class="row mb-3" style="display:none;">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Status</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <select class="form-control" name="sanction_status" value="{{ old('sanction_status') }}">
                                    <option class="option">{{$Sanction->sanction_status}}</option>                                    
                                    </select>                                 
                               </div>
                                @error('sanction_status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>  
                        </div>   
                     
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a class="btn btn-info" href="{{ route('sanction.index')}}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
