@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
{{-- Show Form --}}
<form action="" method="POST">
    <div class="cotainer" style="background-color: white;padding-bottom:35px;">
         <div class="row">
              <div class="col-lg-12 margin-tb">
                  <div class="pull-left">
                       <h2> Role Details</h2>
                    </div>                   
                 <div class="pull-right">
                    <a class="btn btn-info" href="{{ route('role.index')}}"> Back</a>
               </div>
         </div>
    </div>

  <div class="row">
     <div class="col-sm-1"></div>        
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>ID:</strong>
                {{ $role->id }}
            </div>
        </div>    
        <div class="row">   
            <div class="col-sm-1"></div>      
            <div class="col-sm-4">        
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $role->name }}
                </div>
             </div>                      
         </div><br>
         <div class="row">   
            <div class="col-sm-1"></div>      
            <div class="col-sm-4">        
                <div class="form-group">
                    <strong>Slug:</strong>
                    {{ $role->slug }}
                </div>
             </div>                      
         </div>
    <div class="row">   
        <div class="col-sm-1"></div>      
        <div class="col-sm-4">        
            <div class="form-group">
                <strong>Status:</strong>
                {{ $role->status }}
            </div>
         </div>                      
     </div>
</form>
@endsection
{{-- End Form --}}
