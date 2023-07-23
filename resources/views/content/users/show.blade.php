@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
<form action="" method="POST">    
    <div class="cotainer" style="background-color: white;padding-bottom:35px;">
        {{-- <div class="tab">
            <input type="button" class="btn btn-primary" onclick="openCity(event, 'contact')" id="defaultOpen" value="Details">
            <input type="button" class="btn btn-primary" onclick="openCity(event, 'sanction')" value="Sanction"> --}}
            {{-- <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button> --}}
          {{-- </div> --}}

<div class="tabcontent" id="contact" style="display:block;">
 <div class="row">
    <div class="col-lg-12 margin-tb">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h2 class="mb-0">User Details</h2>
        <small class="text-muted float-end">
            <a href="{{ route('users.index') }}" class="btn btn-primary" role="button">Back</a>
        </small>
    </div><br><br>                 
 </div>
</div>

  <div class="row">
     <div class="col-sm-1"></div>        
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>First Name:</strong>
                {{ $user->firstname }}
            </div>
        </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Last Name:</strong>
                {{ $user->lastname }}
            </div>
         </div>   
     <div class="col-sm-1"></div>
</div><br>
   
<div class="row">
     <div class="col-sm-1"></div>        
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Mobile No:</strong>
                {{ $user->mobile_no }}
            </div>
        </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Primary Email:</strong>
                {{ $user->email }}
            </div>
         </div>   
     <div class="col-sm-1"></div>
</div><br>

<div class="row">
     <div class="col-sm-1"></div>        
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Password:</strong>
                ************************
                {{-- {{ $user->password }} --}}
            </div>
        </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Date of Birth:</strong>
                {{ $user->date_of_birth }}
            </div>
         </div>   
     <div class="col-sm-1"></div>
</div><br>

<div class="row">
     <div class="col-sm-1"></div>        
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Pan No:</strong>
                {{ $user->pan_no }}
            </div>
        </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Qualification:</strong>
                {{ $user->qualification }}
            </div>
         </div>   
     <div class="col-sm-1"></div>
</div><br>

<div class="row">
     <div class="col-sm-1"></div>        
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Marital Status:</strong>
                {{ $user->marital_status }}
            </div>
        </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Joining Date:</strong>
                {{ $user->joining_date }}
            </div>
         </div>   
     <div class="col-sm-1"></div>
</div><br>

<div class="row">
     <div class="col-sm-1"></div>        
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Experience in year:</strong>
                {{ $user->experience_in_year }}
            </div>
        </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Last Package:</strong>
                {{ $user->last_package }}
            </div>
         </div>   
     <div class="col-sm-1"></div>
</div><br>

<div class="row">
     <div class="col-sm-1"></div>        
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Designation:</strong>
                {{ $user->designation }}
            </div>
        </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Permanent Address:</strong>
                {{ $user->permanant_address }}
            </div>
         </div>   
     <div class="col-sm-1"></div>
</div><br>

<div class="row">
    <div class="col-sm-1"></div>        
       <div class="col-sm-4">        
           <div class="form-group">
               <strong>Current Address:</strong>
               {{ $user->current_address }}
           </div>
       </div>    
       <div class="col-sm-4">
           <div class="form-group">
               <strong>Home contact no:</strong>
               {{ $user->home_contactno }}
           </div>
        </div>   
    <div class="col-sm-1"></div>
</div><br>

<div class="row">
    <div class="col-sm-1"></div>        
       <div class="col-sm-4">        
           <div class="form-group">
               <strong>Resignation Date:</strong>
               {{ $user->resignation_date }}
           </div>
       </div>    
       <div class="col-sm-4">
           <div class="form-group">
               <strong>Status Id:</strong>
               {{ $user->status_id }}
           </div>
        </div>   
    <div class="col-sm-1"></div>
</div><br>
    <div class="row">   
        <div class="col-sm-1"></div>      
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Experience in months:</strong>
                {{ $user->experience_in_months }}
            </div>
            </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Previous company name</strong>
                {{ $user->privious_company_contactname }}
            </div>
        </div>   
        <div class="col-sm-1"></div>
    </div><br>
    <div class="row">   
        <div class="col-sm-1"></div>      
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Previous company contact:</strong>
                {{ $user->privious_company_contact }}
            </div>
            </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>source:</strong>
                {{ $user->source }}
            </div>
        </div>   
        <div class="col-sm-1"></div>
    </div><br>

    <div class="row">   
        <div class="col-sm-1"></div>      
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Source By:</strong>
                {{ $user->source_by }}
            </div>
            </div>    
        <div class="col-sm-4">
            <div class="form-group">
                <strong>Remark by HR:</strong>
                {{ $user->remark_by_HR }}
            </div>
        </div>   
        <div class="col-sm-1"></div>
    </div><br>    
  </div>
</div>
</div>
</form>
@endsection
{{-- End Show Form --}}
