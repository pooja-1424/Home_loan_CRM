@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Update Payout</h4>
    @if(session()->has('danger'))
                        <div class="alert alert-danger" role="alert">
                        <strong>{{ session()->get('danger') }}</strong>
                        </div>
                    @endif
    <!-- Add Sanction form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Payout Details</h5> <small class="text-muted float-end">Merged input group</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('payouts.update',$bankdata->payout_id) }}" method="POST">
                        @csrf    
                        @method('PUT')                             
                         <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" >Bank Name<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                     
                                    <select class="form-control" name="bank_name[]" multiple data-placeholder="Select an Option">
                                           @foreach(App\Models\Bankname::all() as $cList => $label)
                                            <option value="{{ $label->bank_name }}" {{ in_array($label->bank_name, old('bank_name', explode(',', $bankdata->bank_name))) ? 'selected' : '' }}>
                                                {{ $label->bank_name }}
                                            </option>
                                        @endforeach
                                    </select>   
                                </div>
                                @error('bank_name')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                       
                            <label class="col-sm-2 form-label">Start Date<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="date" name="start_date" id="start_date" value="{{ $bankdata->start_date }}" class="form-control"  placeholder="Start Date"/>
                                </div>
                                @error('start_date')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 form-label">End Date<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="date" name="end_date" id="end_date" value="{{$bankdata->end_date}}" class="form-control"  placeholder="End Date"/>
                                </div>
                                @error('end_date')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>

                            <label class="col-sm-2 form-label" for="Amount"> Minimum Loan Amount<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                    
                                    <input type="number" name="min_loan" id="min_loan" value="{{ $bankdata->min_loan }}" class="form-control"  placeholder=" Minimum Loan Amount"/>
                                </div>
                                @error('min_loan')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="Amount"> Maximum Loan Amount<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                    
                                    <input type="number" name="max_loan" id="max_loan" value="{{ $bankdata->max_loan }}" class="form-control"  placeholder="Maximum Loan Amount"/>
                                </div>
                                @error('max_loan')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>

                            <label class="col-sm-2 form-label" for="Requirements">Loan Type</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                
                                    <select class="form-control" name="loan_type" value="{{ old('loan_type') }}" >
                                        <option value="{{$bankdata->loan_type }}">{{$bankdata->loan_type }}</option>
                                        <option value="{{ old('loan_type') }}">Select Status</option>
                                        <option value="Home_Loan" {{old('loan_type')=="Home_Loan"?'selected':''}}>Home Loan</option>
                                        <option value="Take_Over" {{old('loan_type')=="Take_Over"?'selected':''}}>Take Over</option>
                                        <option value="Mortage_Loan" {{old('loan_type')=="Mortage_Loan"?'selected':''}}>Mortage Loan</option>
                                        <option value="Any" {{old('loan_type')=="Any"?'selected':''}}>Any</option>
                                    </select>     
                                </div>
                                @error('loan_type')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                               
                            </div>
                        </div>
                        <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="Status">Frequency<span class="required-field"></span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="frequency" id="frequency" value="{{$bankdata->frequency }}" class="form-control"  placeholder="Frequency" />                                       
                                </div>
                                @error('frequency')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                               
                            </div>
                        <label class="col-sm-2 form-label" for="Date">Rate Of Commission</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <input type="numeric" name="rate_of_commission" id="rate_of_commission" value="{{ number_format($bankdata->rate_of_commission * 100, 2) }}%" class="form-control"  placeholder="Rate Of Commission" />
                                </div>
                                @error('rate_of_commission')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>
                        </div>
                        <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="Amount">Incentive Releasestate</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                    
                                    <input type="text" name="incentive_releasestte" id="incentive_releasestte" value="{{ $bankdata->incentive_releasestte}}" class="form-control"  placeholder="Incentive Releasestate">
                                </div>
                                @error('incentive_releasestte')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror                                
                            </div>
                        </div>
                        <div class="row alignb" style="border:1px solid rgb(186, 183, 183);padding-top:25px;padding-bottom:25px;border-radius:10px;"> 
                            <div class="col-sm-3">
                                <label>Type of condition</label>
                                <select class="form-control dynamic" id="type-select" name="condition[]" multiple onchange="Condition(Array.from(this.selectedOptions, option => option.value));">
                                    @foreach(['cutout_statement', 'extra_payout', 'remark'] as $optionValue)
                                        <option value="{{ $optionValue }}" {{ in_array($optionValue, explode(',', $bankdata->condition)) ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $optionValue)) }}
                                        </option>
                                    @endforeach
                                </select>                                                               
                            </div>
                            <div class="col-sm-3" id="type1-conditions" >
                                <label>Cutout Statement</label>
                                <select class="form-control" name="cutout_statement" value="{{ old('cutout_statement') }}" >
                                    <option value="{{ $bankdata->cutout_statement }}">{{ $bankdata->cutout_statement }}</option>
                                    <option value="Max Payout Restricted to 10 Lacs" {{ old('cutout_statement') == "Max Payout Restricted to 10 Lacs" ? 'selected' : '' }}>Max Payout Restricted to 10 Lacs</option>
                                    <option value="Payment to DSA on Minimum 20% of Sanction Amount" {{ old('cutout_statement') == "Payment to DSA on Minimum 20% of Sanction Amount" ? 'selected' : '' }}>Payment to DSA on Minimum 20% of Sanction Amount</option>
                                  </select>
                            </div>
                            <div class="col-sm-3" id="type2-conditions" >
                                <label>Extra Payout</label>
                                <select class="form-control" name="extra_payout" value="{{ old('extra_payout') }}" >
                                    <option value="{{ $bankdata->extra_payout }}">{{ $bankdata->extra_payout }}</option>
                                    <option value="For individual Proposal of 1cr & above, additional 0.10% would br paid over and above payout till MAximum 0.80% + Taxes" {{ old('extra_payout') == "For individual Proposal of 1cr & above, additional 0.10% would br paid over and above payout till MAximum 0.80% + Taxes" ? 'selected' : '' }}>For individual Proposal of 1cr & above, additional 0.10% would br paid over and above payout till MAximum 0.80% + Taxes</option>
                                    <option value="Payment to DSA on Minimum 20% of Sanction Amount" {{ old('extra_payout') == "Payment to DSA on Minimum 20% of Sanction Amount" ? 'selected' : '' }}>Payment to DSA on Minimum 20% of Sanction Amount</option>
                                  </select>
                            </div>
                            <div class="col-sm-3" id="type3-conditions">
                                <label>Remark</label>
                                <select class="form-control" name="remark" value="{{ old('remark') }}" >
                                    <option value="{{ $bankdata->remark }}">{{ $bankdata->remark }}</option>
                                    <option value="INdividual Proposal Above 6 cr should be avoid in SBI" {{ old('remark') == "INdividual Proposal Above 6 cr should be avoid in SBI" ? 'selected' : '' }}>INdividual Proposal Above 6 cr should be avoid in SBI</option>
                                    <option value="Take Over Proposal Above 10.5 cr should be avoid in SBI" {{ old('remark') == "Take Over Proposal Above 10.5 cr should be avoid in SBI" ? 'selected' : '' }}>Take Over Proposal Above 10.5 cr should be avoid in SBI</option>
                                    <option value="Invidividual Home Loan case Above 10 cr Should be avoided" {{ old('remark') == "Invidividual Home Loan case Above 10 cr Should be avoided" ? 'selected' : '' }}>Invidividual Home Loan case Above 10 cr Should be avoided</option>
                                    <option value="Invidividual Take Over Loan case Above 10 cr Should be avoided" {{ old('remark') == "Invidividual Take Over Loan case Above 10 cr Should be avoided" ? 'selected' : '' }}>Invidividual Take Over Loan case Above 10 cr Should be avoided</option>
                                    <option value="Invidividual MOrtage Loan case Above 10 cr Should be avoided" {{ old('remark') == "Invidividual MOrtage Loan case Above 10 cr Should be avoided" ? 'selected' : '' }}>Invidividual MOrtage Loan case Above 10 cr Should be avoided</option>
                                  </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a class="btn btn-info" href="{{ route('payouts.index')}}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

