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
                <input type="button" class="tablinks active" onclick="openCity(event, 'payout')" id="defaultOpen"
                    value="Payout Details">
                {{-- <input type="button" class="tablinks" onclick="openCity(event, 'contact')" value="Client Details">
                <input type="button" class="tablinks" onclick="openCity(event, 'sanction')" value="Sanction">
                <input type="button" class="tablinks" onclick="openCity(event, 'comment')" value="Comment"> --}}
            </div>

            <div class="container" style="background-color: white;padding-bottom:35px;">
                <div class="tabcontent" id="payout" style="display:block;">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="mb-0">Payout Details</h2>
                                <small class="text-muted float-end">
                                    <a href="{{ route('payouts.index') }}" class="btn btn-primary" role="button">Back</a>
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
                                        <strong>Bank Name:</strong>
                                        {{ $data->bank_name }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Start Date:</strong>
                                        {{ $data->start_date }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>End Date:</strong>
                                        {{ $data->end_date }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Minimum Loan:</strong>
                                        {{ $data->min_loan }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Maximum Loan:</strong>
                                        {{ $data->max_loan }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Loan Type:</strong>
                                        {{ $data->loan_type }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Frequency:</strong>
                                        {{ $data->frequency }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Rate Of Commission:</strong>
                                        {{ $data->rate_of_commission }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>                                
                            </div><br>
                            
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Incentive Releasestate:</strong>
                                        {{ $data->incentive_releasestte }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Condition:</strong>
                                        {{ $data->condition }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>                                
                            </div><br>
                            
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Cutout Statement:</strong>
                                        {{ $data->cutout_statement }}
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Extra Payout:</strong>
                                        {{ $data->extra_payout }}
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>                                
                            </div><br>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <strong>Remark:</strong>
                                        {{ $data->remark }}
                                    </div>
                                </div>                                                              
                            </div><br>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endsection
   