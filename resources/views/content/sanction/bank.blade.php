@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 


<!-- Modal for add bank-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Bank</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="#" method="POST" id="Register">
            @csrf
            <div class="modal-body">
            
                <div class="modal-footer">
                    <div class="row">
                            <label class="label1" >Add Bank<span class="required-field"></span></label><br>
                          <div class="col-lg-12">
                            <div class="input-group bank_add">
                                {{-- <label for="addbank">Add Bank</label> --}}
                                <input type="text" name="bank_name" id="bank_name" class="form-control bank1" placeholder="Bank Name">
                            </div>
                            
                            <span class="text-danger" id="bank_nameError"></span>
                            
                                @error('bank_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                          </div>   
                    </div>
                            <div>   
                                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" id="submitForm" class="btn btn-primary" onclick="storeData()">Add</button>
                            </div>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>

  {{-- End modal for add bank--}}
   
  {{-- Modal for update bank --}}
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Bank</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="updateForm" action="{{ url('update-bank')}}" method="POST">
            @csrf
            
            @method('PUT')
            <input type="hidden" name="b_id" id="b_id">
                <div class="modal-body">        
                    <div class="modal-footer">
                        <div class="row">
                            <label class="label2" >Edit Bank<span class="required-field"></span></label><br>
                                <div class="col-lg-12">
                                        <div class="input-group bank_add">
                                            <input type="text" name="update_bank_name" id="update_bank_name" class="form-control bank2" value="{{ old('update_bank_name') }}">
                                        </div>
                                        <span class="text-danger" id="update_bank_nameError"></span>
                                        {{-- <div> --}}
                                        @error('update_bank_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                        </div>
                            <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="updateData()">Update</button>
                            </div>
                    </div>
                </div>
        </form>
      </div>
    </div>
</div>
{{-- End of Update Modal --}}

 
<!-- Listing Page -->
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Bank List</h4>
    
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Bank Details</h5>
                    @can('bank-create')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" role="button">Add Bank</a>
                    @endcan
                    </div>
                    

                <div class="card-body">
                    <h5 class="card-header">Bank List</h5>

                    <div class="table-responsive text-nowrap">
                       
                            @if(session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                <strong>{{ session()->get('success') }}</strong>
                                </div>
                            @endif
                       </div>
                   
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Sr. No.</th>
                                    <th>Bank Name</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="myTable" class="table-border-bottom-0">
                                @php
                                    $i = 0;
                                @endphp

                                @if (isset($data))
                                
                                @forelse ($data as $user) 
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->bank_name }}</td>
                                    <td>
                                        @can('bank-edit')
                                            <button type="button" class="btn btn-info editbtn" onclick="editbtn({{$user->bank_id}})" data-bs-toggle="modal" data-bs-target="#editModal" value="{{$user->bank_id}}"><i class="fa fa-pencil"></i></button> 
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
@endsection



