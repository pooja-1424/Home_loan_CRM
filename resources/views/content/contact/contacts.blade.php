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
                        @can('contact-create')
                            <a href="{{ route('contacts.create') }}" class="btn btn-primary" role="button">Add Contact</a>
                        @endcan
                    </small>
                </div>
    
                <form method="post" action="{{ route('filterContact') }}">
                    @csrf
                    {{-- <input type="search" id="search" name="search" class="form-control" placeholder="Search User"> --}}
                    {{-- <button type="submit">Search</button> --}}
                    
                <div class="row mb-0 pt-2 card- d-flex align-items-center justify-content-between">
                        
                        <div class="col-sm-2" class="filterBox">
                          <div class="input-group input-group-merge mb-3 ">
                            <label for="filter1"><b>Name</b></label>
                          </div>
                            <input type="text" class="form-control list" name="filter1" value="{{ (isset($request->filter1)) ? $request->filter1 : '' }}">
                        </div>
                        
                        <div class="col-sm-2">
                          <div class="input-group input-group-merge mb-3">
                            <label for="filter2"><b>Contact</b></label>
                          </div>
                            <input type="number" class="form-control list" name="filter2"  value="{{ (isset($request->filter2)) ? $request->filter2 : '' }}">
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-3">
                              <label for="filter3"><b>Team Leader</b></label>
                            </div>
                              <input type="text" class="form-control list" name="filter3" value="{{ (isset($request->filter3)) ? $request->filter2  : '' }}">
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group input-group-merge mb-0">
                              <label for="filter4"><b>Interested Bank</b></label>
                            </div>
                            
                            <select class="form-control list" name="Interested_bank[]" multiple data-placeholder="Select an option" value="">
                                @foreach(App\Models\Bankname::all() as $cList => $label)
                                    <option value="{{ $label->bank_name }}" {{ in_array($label->bank_name, old('Interested_bank', [])) ? 'selected' : '' }}>
                                        {{ $label->bank_name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        <div class="col-sm-2">
                             <button type="submit" class="btn btn-primary list">Search</button>                                        
                    </div>
                </div>
                </form>
                <div class="card-body">
                    <h5 class="card-header">User List</h5>
                    <div class="table-responsive text-nowrap">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                         @endif
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Client Status</th>
                                    <th>Sr. No.</th>   
                                    <th>Name</th>                                 
                                    <th>Email</th>                                    
                                    <th>Contact</th>                                                                
                                    <th>Type Of Loan</th>
                                    <th>Interested bank</th> 
                                    <th>Team Leader</th>
                                    <th>Lead Source</th>
                                    <th>Assign To</th>
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $i = 0;
                                @endphp

                                @if (isset($data))
                                @forelse ($data as $contact)
                                <tr>     
                                    <td>                                                                   
                                        @can('contact-delete')
                                            <a href="javascript:void(0)" id="status{{$contact->client_id}}" title='@php echo ($contact->client_status==0) ? "Inactive" : "Active"; @endphp' onclick="status('{{ $contact->client_id }}','{{ $contact->client_status }}', 'changestatus')">
                                                <div class="switchToggle"> 
                                                    <input type="checkbox"   id="switch{{$contact->client_id }}" {{ $contact->client_status ? 'checked' : '' }}>
                                                    <label for="switch{{$contact->client_id  }}">Toggle</label>
                                                </div>     
                                            </a>                             
                                        @endcan
                                                                           
                                    </td>                                
                                    <td>{{ ++$i }}</td> 
                                    <td>{{ $contact->fname.' '. $contact->lname }}</td>                     
                                    <td>{{ $contact->email1 }}</td>
                                    <td>{{ $contact->mobile1 }}</td>                                 
                                    <td>{{ $contact->Type_of_Loan }}</td>
                                    <td>{{ $contact->Interested_bank }}</td>
                                    <td>{{ $contact->Team_Leader }}</td>
                                    <td>{{ $contact->Lead_source}}</td>                                                                                                                                       
                                    <td>{{ $contact->Assigned_To}}</td>                                                                                                                                       
                                    <td>
                                        <a class="btn btn-show" href="{{ route('contacts.show',[$contact->client_id])}}"><i class="fa fa-eye"></i></a>
                                    </td> 
                                    <td>
                                        @can('contact-edit')
                                            <a class="btn btn-edit" href="{{ route('contacts.edit',$contact->client_id)}}"><i class="fa fa-pencil"></i></a>
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
                </form>                  
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
