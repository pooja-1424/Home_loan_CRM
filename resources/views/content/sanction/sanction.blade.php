@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
  <!-- Add Sanction form -->

    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">                   
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Sanction Details</h5>
                        <small class="text-muted float-end">                             
                            @can('sanction-create')
                            <a href="{{ route('sanction.create') }}" class="btn btn-primary" role="button">Add Sanction</a>
                            @endcan
                        </small>
                 </div>
                 <form method="post" action="{{ route('filterSanction') }}">
                    @csrf
                   
                    <div class="row mb-0 pt-2 card-header d-flex align-items-center justify-content-between">
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter3"><b>Bank Name</b></label>
                            </div>
                            <select class="form-control" name="filter3" multiple data-placeholder="Select an Option" value="{{ (isset($request->filter3)) ? $request->filter3 : '' }}">
                                @foreach(App\Models\Bankname::all() as $cList => $label)
                                    <option value="{{ $label->bank_name }}" {{ in_array($label->bank_name, old('filter3', [])) ? 'selected' : '' }}>
                                        {{ $label->bank_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                             <label for="filter2"><b>Status</b></label>
                            </div>
                             <select class="form-control" name="status" value="{{ (isset($request->filter2)) ? $request->filter2 : ''   }}">
                                <option value="{{ old('status') }}">Select Status</option>
                                <option value="Sanctioned" {{old('status')=="Sanctioned"?'selected':''}}>Sanctioned</option>
                                <option value="Partial_Disbursed" {{old('status')=="Partial_Disbursed"?'selected':''}}>Partial Disbursed</option>
                                <option value="In_Process" {{old('status')=="In_Process"?'selected':''}}>In Process</option>
                                <option value="Full_Disbursed" {{old('status')=="Full_Disbursed"?'selected':''}}>Full Disbursed</option>
                                <option value="Cancelled" {{old('status')=="Cancelled"?'selected':''}}>Cancelled</option>
                                <option value="Reject" {{old('status')=="Reject"?'selected':''}}>Reject</option>
                                <option value="Not_Disbursed" {{old('status')=="Not_Disbursed"?'selected':''}}>Not Disbursed</option>
                            </select>    
                            </div>
                        

                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter4"><b>File No.</b></label>
                            </div>
                             <input type="text" class="form-control" name="filter4" value="{{ (isset($request->filter4)) ? $request->filter4 : ''  }}">
                        </div>

                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter6"><b>Expiry Date</b></label>
                            </div>
                             <input type="date" class="form-control" name="filter6" value="{{ (isset($request->filter6)) ? $request->filter6 : ''  }}">
                        </div>

                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter1"><b>Amount</b></label>
                            </div>
                            <input type="number" class="form-control" name="filter1" value="{{ (isset($request->filter1)) ? $request->filter1 : '' }}">
                        </div>

                        <div class="col-sm-2 pt-3">
                             <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        
                    </div>
                </form> 
                                 
                <div class="card-body">
                    <h5 class="card-header">Sanction List</h5>

                    <div class="table-responsive text-nowrap">
                    @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                        <strong>{{ session()->get('success') }}</strong>
                        </div>
                    @endif
                    @if(session()->has('danger'))
                        <div class="alert alert-danger" role="alert">
                        <strong>{{ session()->get('danger') }}</strong>
                        </div>
                    @endif
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Sanction Status</th>
                                    <th>Sr. No.</th>
                                    <th>Client Name</th>
                                    <th>File No.</th>
                                    <th>Bank Name</th>
                                    <th>Requirements</th>
                                    <th>Status</th>
                                    <th>Expiry Date</th>
                                    <th>Loan Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            
                                @php
                                    $i = 0;
                                   
                                @endphp

                                @if (isset($sanctionData))
                                @forelse ($sanctionData as $Sanction)
                                @php
                                    $loanAmountWord = App\helpers\commentHelper::int_to_wordsbyts($Sanction->loan_amount);
                                @endphp
                                <tr>
                                    <td>                                                                 
                                        @can('sanction-delete')
                                        <a href="javascript:void(0)" id="status{{$Sanction->sanction_id}}" title='@php echo ($Sanction->sanction_status==0) ? "Inactive" : "Active"; @endphp' onclick="status('{{ $Sanction->sanction_id }}','{{ $Sanction->sanction_status }}','sanctionstatus')">
                                            <div class="switchToggle"> 
                                                <input type="checkbox"   id="switch{{$Sanction->sanction_id }}" {{ $Sanction->sanction_status ? 'checked' : '' }}>
                                                 <label for="switch{{$Sanction->sanction_id }}">Toggle</label>
                                            </div>     
                                        </a>                             
                                        @endcan            
                                    </td> 
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $Sanction->fname .' '.$Sanction->lname }}</td>
                                    <td>{{ $Sanction->file_number }}</td>
                                    <td>{{ $Sanction->bank_name }}</td>
                                    <td>{{ $Sanction->requirements }}</td>
                                    <td>{{ $Sanction->status }}</td>
                                    <td>{{ $Sanction->expiry_date }}</td>
                                    <td>{{ $Sanction->loan_amount }} ( {{ $loanAmountWord }})</td>
                                    <td>
                                        <a class="btn btn-showid1" href="{{ route('sanction.show',$Sanction->sanction_id) }}"><i class="fa fa-eye"></i></a>
                                    </td>
                                    <td>
                                    @can('sanction-edit')
                                        <a class="btn btn-editid1" href="{{route('sanction.edit',$Sanction->sanction_id)}}"><i class="fa fa-pencil"></i></a>
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
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
       
        </script>
@endsection

