@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
   <!-- Add Disbursement form -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Disbursement Details</h5>
                    <small class="text-muted float-end">                       
                        @can('disbursement-create')
                            <a href="{{ route('disbursements.create') }}" class="btn btn-primary" role="button">Add Disbursement</a>
                        @endcan
                    </small>
                </div>
                <form method="post" action="{{ route('filterDisbursement') }}">
                    @csrf
                   
                    <div class="row mb-0 pt-2 card-header d-flex align-items-center justify-content-between">
                       
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter2"><b>Amount</b></label>
                            </div>
                             <input type="number" class="form-control" name="filter2" value="{{ (isset($request->filter2)) ? $request->filter2 : ''  }}">
                        </div>
                         
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter3"><b>Status</b></label>
                            </div>
                                <select class="form-control" name="filter3" value="{{ (isset($request->filter2)) ? $request->filter2 : ''   }}">
                                    <option value="{{ old('status') }}">Select Status</option>
                                    <option value="Partly_disbursed" {{old('status')=="Partly_disbursed"?'selected':''}}>Partly_disbursed</option>
                                    <option value="in-process" {{old('status')=="in-process"?'selected':''}}>in-process</option>
                                    <option value="Final_disbursment" {{old('status')=="Final_disbursment"?'selected':''}}>Final_disbursment</option>
                                    <option value="Cancelled" {{old('status')=="Cancelled"?'selected':''}}>Cancelled</option>
                                    <option value="Reject" {{old('status')=="Reject"?'selected':''}}>Reject</option>
                                    <option value="Not_Disbursed" {{old('status')=="Not_Disbursed"?'selected':''}}>Not_disbursed</option>
                                </select>
                            </div>
                            
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter4"><b>Bank Name</b></label>
                            </div>
                            <select class="form-control" name="filter4" multiple data-placeholder="Select an Option" value="{{ (isset($request->filter4)) ? $request->filter4 : '' }}">
                                @foreach(App\Models\Bankname::all() as $cList => $label)
                                    <option value="{{ $label->bank_name }}" {{ in_array($label->bank_name, old('filter4', [])) ? 'selected' : '' }}>
                                        {{ $label->bank_name }}
                                    </option>
                                @endforeach
                            </select>                               
                        </div>                 
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                                <label for="filter5"><b>Date</b></label>
                            </div>
                                <input type="date" class="form-control" name="filter5"  value="{{ (isset($request->filter5)) ? $request->filter5 : ''    }}">
                        </div>

                        <div class="col-sm-2 pt-3">
                             <button type="submit" class="btn btn-primary">Search</button>
                         </div>                        
                    </div>
                </form>  
               
                <div class="card-body">
                    <h5 class="card-header">Disbursement List</h5>
                    <div class="table-responsive text-nowrap">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>                        
                        @endif
                        @if ($message = Session::get('danger'))
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>                        
                        @endif
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Disbursement Status</th>
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

                                @if (isset($data1))
                                {{-- <td>{{ $data}}</td> --}}
                                @forelse ($data1 as $disbursement)
                                <tr>
                                    <td>                                                           
                                        @can('disbursement-delete')
                                            <a href="javascript:void(0)" id="status{{$disbursement->disb_id}}" title='@php echo ($disbursement->disbursement_status==0) ? "Inactive" : "Active"; @endphp' onclick="status('{{ $disbursement->disb_id }}','{{ $disbursement->disbursement_status }}','disbursementstatus')">
                                                <div class="switchToggle"> 
                                                    <input type="checkbox"   id="switch{{$disbursement->disb_id }}" {{ $disbursement->disbursement_status ? 'checked' : '' }}>
                                                    <label for="switch{{$disbursement->disb_id  }}">Toggle</label>
                                                </div>     
                                            </a>                             
                                        @endcan 
                                                                           
                                    </td>    
                                    <td>{{ ++$i }}</td>   
                                    <td>{{ $disbursement->fname . ' ' . $disbursement->lname }}</td>             
                                    <td>{{ $disbursement->disb_date }}</td>
                                    <td>{{ $disbursement->disb_amt }}</td>
                                    <td>{{ $disbursement->bank_name }}</td>
                                    <td>{{ $disbursement->pending_disb }}</td>
                                    <td>{{ $disbursement->status }}</td>                                                                   
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
                <div class="d-flex justify-content-center">
                    {{ $data1->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- End Form --}}
