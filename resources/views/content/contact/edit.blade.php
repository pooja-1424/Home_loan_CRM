@extends('layouts.master')
@section('css')
<!-- plugin css -->
<link href="{{URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content') 
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Horizon-</span> Update Contact</h4>

    <form action="{{ route('contacts.update',$contact->client_id) }}" method="post">
        @csrf
        @method('PUT')
        <!-- update contact form -->
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">User Details</h5> <small class="text-muted float-end">Merged input group</small>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">First Name<span class="required">*</span></label><br><br>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" name="fname" id="basic-icon-default-fullname" value="{{$contact->fname }}" placeholder="John Doe" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('fname')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Last Name<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" name="lname" id="basic-icon-default-fullname" value="{{ $contact->lname}}" placeholder="John Doe" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('lname')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
            
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Primary Email</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="text" name="email1" id="basic-icon-default-email" value="{{$contact->email1 }}" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2" />
                                </div>
                                @error('email1')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                <div class="form-text"> You can use letters, numbers & periods </div>
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Secondory Email</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="text" name="email2" id="basic-icon-default-email" value="{{ $contact->email2 }}" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2" />
                                </div>
                                @error('email2')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                <div class="form-text"> You can use letters, numbers & periods </div>
                            </div>
                        </div>
            
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="basic-icon-default-phone">Mobile No<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="text" name="mobile1" id="mobile_number" value="{{ $contact->mobile1 }}" class="form-control phone-mask"  placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2" />
                                </div>
                                @error('mobile1')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                <div class="form-text"> Please Enter <b>10</b>digit mobile number </div>
                            </div>
                            <label class="col-sm-2 form-label" for="basic-icon-default-phone">Alternate Mobile No </label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="text" name="mobile2" id="mobile_number" value="{{$contact->mobile2 }}" class="form-control phone-mask"  placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-icon-default-phone2" />
                                </div>
                                @error('mobile2')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                                <div class="form-text"> Please Enter <b>10</b>digit mobile number </div>
                            </div>
                        </div>
            
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Address</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    {{-- <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span> --}}
                                        <input type="text" class="form-control" name="address" id="address" value="{{ $contact->address }}" placeholder="Address" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('address')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">City</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    {{-- <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span> --}}
                                        <input type="text" class="form-control" name="city" id="city" value="{{ $contact->city }}" placeholder="India" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('city')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
            
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Country</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    {{-- <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>--}}
                                    
                                    <select class="form-control" name="country" value="{{ old('Type_of_Loan') }}" > 
                                            <option >{{ $contact->country}}</option>                                                                                                                                                             
                                            @foreach(App\Models\Country::all() as $cList=>$label)                                                                                 
                                            <option value="{{$label->country}}" {{old ('country') == $label->country? 'selected' : ''}}>{{$label->country}}</option>
                                            @endforeach
                                        </select>                               
                                </div>
                                @error('country')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">State</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                        <select class="form-control" name="state">
                                            <option>{{ $contact->state}}</option>                                                                                                                                                                
                                            @foreach(App\Models\Country::all() as $cList=>$label)                                                                                 
                                            <option value="{{$label->state}}" {{old ('state') == $label->state? 'selected' : ''}}>{{$label->state}}</option>
                                            @endforeach
                                        </select>  
                                    </div>
                                @error('state')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Date Of Birth</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                        <input type="date" class="form-control" name="date_of_birth" id="DOB" value="{{ $contact->date_of_birth }}" placeholder="DOB" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('date_of_birth')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>    
                                
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">  
                        <h3>Lead Details</h3>                
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Lead Status<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <select class="form-control" name="Lead_Status" value="{{ old('Lead_Status') }}">                                                                                                                                                           
                                            <option value="{{$contact->Lead_Status}}">{{$contact->Lead_Status }}</option>                                                                             
                                            <option  value="Hot_Lead"{{ old('Lead_Status') == "Hot_Lead" ? 'selected' : '' }}>Hot</option>
                                            <option  value="Warm_Lead"{{ old('Lead_Status') == "Warm_Lead" ? 'selected' : '' }}>Warm</option>
                                            <option  value="Cold_Lead"{{ old('Lead_Status') == "Cold_Lead" ? 'selected' : '' }}>Cold</option>                                     
                                    </select>  
                                </div>
                                @error('Lead_Status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Lead Source</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                        <select class="form-control" name="Lead_source" value="{{ old('Lead_source') }}">                                                                                                                                                           
                                        <option value="{{ $contact->Lead_source }}">{{ $contact->Lead_source }}</option>                                                                             
                                        <option  value="cold_call"{{ old('Lead_source') == "cold_call" ? 'selected' : '' }}>Cold Call</option>
                                        <option  value="Existing_customer"{{ old('Lead_source') == "Existing_customer" ? 'selected' : '' }}>Existing Customer</option>
                                        <option  value="self_generated"{{ old('Lead_source') == "self_generated" ? 'selected' : '' }}>Self Generated</option>                                     
                                        <option  value="employee"{{ old('Lead_source') == "employee" ? 'selected' : '' }}>Employee</option>
                                        <option  value="partner"{{ old('Lead_source') == "partner" ? 'selected' : '' }}>Partner</option>
                                        <option  value="public_relations"{{ old('Lead_source') == "public_relations" ? 'selected' : '' }}>Public Relations</option>                                     
                                        <option  value="Direct_mail"{{ old('Lead_source') == "Direct_mail" ? 'selected' : '' }}>Direct Mail</option>
                                        <option  value="conference"{{ old('Lead_source') == "conference" ? 'selected' : '' }}>Conference</option>
                                        <option  value="Trade_show"{{ old('Lead_source') == "Trade_show" ? 'selected' : '' }}>Trade Show</option>                                     
                                        <option  value="Website"{{ old('Lead_source') == "Website" ? 'selected' : '' }}>Website</option>
                                        <option  value="word_of_mouth"{{ old('Lead_source') == "word_of_mouth" ? 'selected' : '' }}>Word of Mouth</option>
                                        <option  value="HorizonFp_Sale"{{ old('Lead_source') == "HorizonFp_Sale" ? 'selected' : '' }}>HorizonFp Sale</option>
                                        <option  value="Trade_show"{{ old('Lead_source') == "Trade_show" ? 'selected' : '' }}>Other</option>                                     
                                        </select>  
                                </div>
                                @error('Lead_source')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Tracking Status<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                        <select class="form-control" name="Tracking_Status" value="{{ old('Tracking_Status') }}">                                                                                                                                                           
                                            <option value="{{$contact->Tracking_Status}}">{{ $contact->Tracking_Status }}</option>                                                                             
                                            <option  value="Hot_Lead"{{ old('Tracking_Status') == "Hot_Lead" ? 'selected' : '' }}>Hot Lead</option>
                                            <option  value="Fresh"{{ old('Tracking_Status') == "Fresh" ? 'selected' : '' }}>Fresh</option>
                                            <option  value="Follow_Up"{{ old('Tracking_Status') == "Follow_Up" ? 'selected' : '' }}>Follow Up</option>  
                                            <option  value="Plan_for_future"{{ old('Tracking_Status') == "Plan_for_future" ? 'selected' : '' }}>Plan For Future</option>
                                            <option  value="Not_Interested"{{ old('Tracking_Status') == "Not_Interested" ? 'selected' : '' }}>Not Interested</option>
                                            <option  value="Fake"{{ old('Tracking_Status') == "Fake" ? 'selected' : '' }}>Fake</option>   
                                            <option  value="Duplicate"{{ old('Tracking_Status') == "Duplicate" ? 'selected' : '' }}>Duplicate</option>
                                            <option  value="Other/CP/Broker"{{ old('Tracking_Status') == "Other/CP/Broker" ? 'selected' : '' }}>Other/CP/Broker</option>
                                            <option  value="Already_apply_for_HL"{{ old('Tracking_Status') == "Already_apply_for_HL" ? 'selected' : '' }}>Already Apply For HL</option>                                  
                                        </select>  
                                </div>
                                @error('Tracking_Status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Tracking Sub Status<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                        <select class="form-control" name="Tracking_Status_Sub" value="{{ old('Tracking_Status_Sub') }}">                                                                                                                                                           
                                        <option value="{{ $contact->Tracking_Status_Sub }}">{{$contact->Tracking_Status_Sub  }}</option>                                                                             
                                        <option  value="Follow_Up"{{ old('Tracking_Status_Sub') == "Follow_Up" ? 'selected' : '' }}>Follow Up</option>
                                        <option  value="Pick_Up_Done"{{ old('Tracking_Status_Sub') == "Pick_Up_Done" ? 'selected' : '' }}>Pick Up Done</option>
                                        <option  value="Partial_pick_up"{{ old('Tracking_Status_Sub') == "Partial_pick_up" ? 'selected' : '' }}>Partial Pick Up</option>  
                                        <option  value="Ringing"{{ old('Tracking_Status_Sub') == "Ringing" ? 'selected' : '' }}>Ringing</option>
                                        <option  value="Switch_off"{{ old('Tracking_Status_Sub') == "Switch_off" ? 'selected' : '' }}>Switch Off</option>
                                        </select>  
                                    </div>
                                @error('Tracking_Status_Sub')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Lead Source By Employees</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    {{-- <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span> --}}
                                        <input type="text" class="form-control" name="Lead_source_by_emp" id="Lead_source_by_emp" value="{{ $contact->Lead_source_by_emp}}" placeholder="Lead Source By Employee"  aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('Lead_source_by_emp')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Team Leader<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <select class="form-control" name="Team_Leader"  id="Team_Leader" value="{{ old('Team_Leader') }}" onchange="onHomeloanTL(this.value);OnHomeloanTlClosing(this.value);">                                                                                                                                                            
                                        <option value="{{$contact->Team_Leader}}">{{ $contact->Team_Leader }}</option>
                                            @foreach($teamleader as $item)
                                            @foreach($item as $value)
                                                <option value="{{$value}}" {{old('Team_Leader') == $value? 'selected' : ''}}>{{$value}}</option>
                                            @endforeach
                                            @endforeach       
                                    </select>                                       
                                </div>
                                @error('Team_Leader')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>                           
                        </div> 
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Lead Source Details<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    {{-- <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span> --}}
                                        <input type="text" class="form-control" name="lead_source_details" id="lead_source_details" value="{{ $contact->lead_source_details }}" placeholder="Lead Source Details"  aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                @error('lead_source_details')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>   

                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Backend Source</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge"> 
                                    <select class="form-control" name="Back_end_source" value="{{ old('Back_end_source') }}">                                                                                                                                                           
                                        <option value="{{ $contact->Back_end_source }}">{{ $contact->Back_end_source }}</option>                                                                             
                                        <option  value="ppc"{{ old('Back_end_source') == "ppc" ? 'selected' : '' }}>PPC</option>
                                        <option  value="facebook"{{ old('Back_end_source') == "facebook" ? 'selected' : '' }}>Facebook</option>
                                        <option  value="SEO"{{ old('Back_end_source') == "SEO" ? 'selected' : '' }}>SEO</option>  
                                        <option  value="Chat"{{ old('Back_end_source') == "Chat" ? 'selected' : '' }}>Chat</option>  
                                        <option  value="Google_SearchPartner"{{ old('Back_end_source') == "Google_SearchPartner" ? 'selected' : '' }}>Google Search Partner</option>  
                                        <option  value="Google_Display_Network"{{ old('Back_end_source') == "Google_Display_Network" ? 'selected' : '' }}>Google Display Network</option>  
                                        <option  value="webform"{{ old('Back_end_source') == "webform" ? 'selected' : '' }}>Webform</option>  
                                        <option  value="ig"{{ old('Back_end_source') == "ig" ? 'selected' : '' }}>ig</option>  
                                        <option  value="import"{{ old('Back_end_source') == "import" ? 'selected' : '' }}>Import</option>  
                                        <option  value="crm"{{ old('Back_end_source') == "crm" ? 'selected' : '' }}>CRM</option>  
                                        <option  value="youtube"{{ old('Back_end_source') == "youtube" ? 'selected' : '' }}>Youtube</option>  
                                        <option  value="FB_Adverts"{{ old('Back_end_source') == "FB_Adverts" ? 'selected' : '' }}>FB Adverts</option>  
                                        <option  value="Workflow"{{ old('Back_end_source') == "Workflow" ? 'selected' : '' }}>Workflow</option>  
                                        <option  value="housing_push_all"{{ old('Back_end_source') == "housing_push_all" ? 'selected' : '' }}>Housing Push All</option>  
                                        <option  value="Pre_Sales_Team"{{ old('Back_end_source') == "Pre_Sales_Team" ? 'selected' : '' }}>Pre Sales Team</option>  
                                        <option  value="webcall"{{ old('Back_end_source') == "webcall" ? 'selected' : '' }}>Webcall</option>  
                                        <option  value="99acres_api"{{ old('Back_end_source') == "99acres_api" ? 'selected' : '' }}>99acres api</option>  
                                        <option  value="whatsapp"{{ old('Back_end_source') == "whatsapp" ? 'selected' : '' }}>Whatsapp</option>  
                                        <option  value="LinkedIn"{{ old('Back_end_source') == "LinkedIn" ? 'selected' : '' }}>LinkedIn</option>  
                                        <option  value="SMS"{{ old('Back_end_source') == "SMS" ? 'selected' : '' }}>SMS</option>  
                                        <option  value="Email Marketing"{{ old('Back_end_source') == "Email Marketing" ? 'selected' : '' }}>Email Marketing</option>  
                                        <option  value="website_whatsapp"{{ old('Back_end_source') == "website_whatsapp" ? 'selected' : '' }}>Website Whatsapp</option>  
                                        <option  value="hoarding"{{ old('Back_end_source') == "hoarding" ? 'selected' : '' }}>Hoarding</option>  
                                        <option  value="Tele-Marketing"{{ old('Back_end_source') == "Tele-Marketing" ? 'selected' : '' }}>Tele Marketing</option>  
                                    </select>  
                                    </div>
                                @error('Back_end_source')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div> 
                        </div>   
                        <div class="row mb-3">                                                       
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Assigned To<span class="required">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <select class="form-control" name="Assigned_To" id="Assigned_To" value="{{ old('Assigned_To') }}" data-placeholder="Select an Option"  onchange="onAssignedTo(this.value)" >                                                                                                                                                           
                                        <option value="{{ $contact->Assigned_To }}">{{ $contact->Assigned_To }}</option>
                                            @foreach($name as $item)
                                            @foreach($item as $value)
                                                <option value="{{$value}}" {{old('Assigned_To') == $value? 'selected' : ''}}>{{$value}}</option>
                                            @endforeach
                                            @endforeach       
                                    </select>  
                                </div>
                                @error('Assigned_To')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>  
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Closing By</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <select class="form-control" name="closing_by"  id="closing_by" value="{{ old('closing_by') }}" data-placeholder="Select an Option" onchange="onAssignedTo(this.value)">                                                                                                                                                           
                                        <option value="{{$contact->closing_by}}">{{ $contact->closing_by }}</option>  
                                        @foreach($users as $item)
                                                @foreach($item as $value)
                                                <option value="{{$value}}" {{old('closing_by') == $value? 'selected' : ''}}>{{$value}}</option>
                                                @endforeach
                                        @endforeach       
                                    </select>  
                                </div>
                                @error('closing_by')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>                                        
                        </div>  
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Lead Source SM</label><br><br>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">
                                    <select class="form-control" id="up_lead_source_sm" name="lead_source_sm" value="{{ old('lead_source_sm') }}" onchange="updateSM(this.value)">                                                                                                                                                           
                                        {{-- <option value="{{ old('lead_source_sm') }}">{{ $contact->lead_source_sm }}</option> --}}
                                        @foreach($property_username as $item)
                                            @foreach($item as $value)
                                            <option value="{{$value}}" {{($contact->lead_source_sm == $value) ? 'selected' : ''}}>{{$value}}</option>
                                            @endforeach
                                        @endforeach
                                    </select>    
                                </div>
                                @error('lead_source_sm')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Lead Source TL</label>
                            <div class="col-sm-4">
                                <div class="input-group input-group-merge">                                   
                                    <select class="form-control"  id="up_lead_source_TL" name="lead_source_TL" value="{{ old('lead_source_TL') }}" onchange="updateTL(this.value)">                                                                                                                                                           
                                        {{-- <option value="{{ old('lead_source_TL') }}">{{ $contact->lead_source_TL }}</option> --}}
                                            @foreach($property_TL as $item)
                                                @foreach($item as $value)
                                                <option value="{{$value}}" {{$contact->lead_source_TL == $value ? 'selected' : ''}}>{{$value}}</option>
                                                @endforeach
                                            @endforeach   
                                    </select>  
                                </div>
                                @error('lead_source_TL')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>                      
                        <div class="row mb-3" style="display:none;">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Status</label>
                            <div class="col-sm-4">                                                      
                                <select class="form-control" name="client_status" value="1">
                                    <option  value="1" {{ old('client_status') == "1" ? 'selected' : '' }}>Active</option> 
                                </select>
                                @error('client_status')
                                    <div style="color: red">{{ $message }}</div>
                                @enderror
                            </div>     
                        </div>                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Requirements --}}
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between"> 
                        <h3>Requirements</h3>                 
                    </div>
                    <div class="card-body">                 
                            @csrf 
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Type of Customer</span></label><br><br>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select class="form-control" name="type_of_customer" value="{{ old('type_of_customer') }}">                                                                                                                                                           
                                            <option value="{{ $contact->type_of_customer}}">{{ $contact->type_of_customer }}</option>                                                                             
                                            <option  value="Indian" {{ old('type_of_customer') == "Indian" ? 'selected' : '' }}>Indian</option>
                                            <option  value="NRI" {{ old('type_of_customer') == "NRI" ? 'selected' : '' }}>NRI</option>
                                            <option  value="Corporate" {{ old('type_of_customer') == "Corporate" ? 'selected' : '' }}>Corporate</option>                                         
                                    </select>  
                                    </div>
                                    @error('type_of_customer')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Profile</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge"> 
                                        <select class="form-control" name="profile" value="{{ old('profile') }}">                                                                                                                                                           
                                            <option value="{{ $contact->profile}}">{{ $contact->profile }}</option>                                                                             
                                            <option  value="Salary"{{ old('profile') == "Salary" ? 'selected' : '' }}>Salary</option>
                                            <option  value="Self-Employed"{{ old('profile') == "Self-Employed" ? 'selected' : '' }}>Self-Employed</option>
                                            <option  value="Business"{{ old('profile') == "Business" ? 'selected' : '' }}>Business</option>  
                                        </select>  
                                    </div>
                                    @error('profile')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>                           
                            </div>       
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Type Of Loan<span class="required">*</span></label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select class="form-control" name="Type_of_Loan" value="{{ old('Type_of_Loan') }}">
                                        <option value="{{  $contact->Type_of_Loan  }}">{{ $contact->Type_of_Loan }}</option>
                                        <option  value="Home_Loan" {{ old('Type_of_Loan') == "Home_Loan" ? 'selected' : '' }}>Home Loan</option>
                                        <option  value="Balance_Transfer" {{ old('Type_of_Loan') == "Balance_Transfer" ? 'selected' : '' }}>Balance Transfer</option> 
                                        <option  value="LAP_Loan" {{ old('Type_of_Loan') == "LAP_Loan" ? 'selected' : '' }}>LAP Loan</option> 
                                        <option  value="Other" {{ old('Type_of_Loan') == "Other" ? 'selected' : '' }}>Other</option> 
                                </select>
                                        </div>
                                    @error('Type_of_Loan')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Interested Bank</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select class="form-control" name="Interested_bank[]" multiple data-placeholder="Select an Option">
                                            <option value="{{ $contact->Interested_bank }}">{{ $contact->Interested_bank }}</option>
                                            @foreach(App\Models\Bankname::all() as $cList => $label)
                                                <option value="{{ $label->bank_name }}" {{ in_array($label->bank_name, old('Interested_bank', explode(',', $contact->Interested_bank))) ? 'selected' : '' }}>
                                                    {{ $label->bank_name }}
                                                </option>
                                            @endforeach
                                        </select>                                                
                                </div>
                                    @error('Interested_bank')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>                           
                            </div>                      
                        
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Is Home Loan Required</label><br><br>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select class="form-control" name="is_homeloan_required" value="{{ old('is_homeloan_required') }}">                                                                                                                                                           
                                            <option value="{{$contact->is_homeloan_required }}">{{ $contact->is_homeloan_required }}</option>                                                                             
                                            <option  value="Yes" {{ old('is_homeloan_required') == "Yes" ? 'selected' : '' }}>Yes</option>
                                            <option  value="No" {{ old('is_homeloan_required') == "No" ? 'selected' : '' }}>No</option>                                         
                                    </select>  
                                    </div>
                                    @error('is_homeloan_required')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Current Residence At</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" name="Current_Residence_At" id="basic-icon-default-fullname" value="{{ $contact->Current_Residence_At}}" placeholder="Current Residence At"  />
                                    </div>
                                    @error('Current_Residence_At')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Property Phase Requirements</label><br><br>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select class="form-control" name="property_phase_req" value="{{ old('property_phase_req') }}">                                                                                                                                                           
                                            <option  value="{{ $contact->property_phase_req }}">{{ $contact->property_phase_req }}</option>                                                                                                          
                                            <option  value="under_construction" {{ old('property_phase_req') == "under_construction" ? 'selected' : '' }}>Under Construction</option>
                                            <option  value="ready_to_move" {{ old('property_phase_req') == "ready_to_move" ? 'selected' : '' }}>Ready To Move</option>
                                            <option  value="Resale" {{ old('property_phase_req') == "Resale" ? 'selected' : '' }}>Resale</option>
                                            <option  value="LAP" {{ old('property_phase_req') == "LAP" ? 'selected' : '' }}>LAP</option>
                                    </select> 
                                    </div>
                                    @error('property_phase_req')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Property Address</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">                                    
                                        <input type="text" class="form-control" name="Porperty_Address" id="basic-icon-default-fullname" value="{{$contact->Porperty_Address}}" placeholder="Property Address" />
                                    </div>
                                    @error('Porperty_Address')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>      
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Property Value</label><br><br>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        {{-- <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span> --}}
                                        <input type="text" class="form-control" name="Property_Value" id="basic-icon-default-fullname" value="{{$contact->Property_Value }}" placeholder="Property Address"  />
                                    </div>
                                    @error('Property_Value')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Is Property Finalised</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">                                   
                                    <select class="form-control" name="is_proprty_final" value="{{ old('is_proprty_final') }}">                                                                                                                                                           
                                        <option value="{{$contact->is_proprty_final }}">{{ $contact->is_proprty_final }}</option>                                                                             
                                        <option  value="Yes" {{ old('is_proprty_final') == "Yes" ? 'selected' : '' }}>Yes</option>
                                        <option  value="No" {{ old('is_proprty_final') == "No" ? 'selected' : '' }}>No</option>
                                    </select>  
                                        </div>
                                    @error('is_proprty_final')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> 
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Reference Take Or Not?</label><br><br>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <select class="form-control" name="reference_take_or_not" value="{{ old('reference_take_or_not') }}">                                                                                                                                                           
                                            <option value="{{$contact->reference_take_or_not }}">{{ $contact->reference_take_or_not }}</option>                                                                             
                                            <option  value="Yes" {{ old('reference_take_or_not') == "Yes" ? 'selected' : '' }}>Yes</option>
                                            <option  value="No" {{ old('reference_take_or_not') == "No" ? 'selected' : '' }}>No</option>
                                    </select>  
                                </div>
                                    @error('reference_take_or_not')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Reference</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="Reference" id="basic-icon-default-fullname" value="{{ $contact->Reference }}" placeholder="Reference"  />
                                    </div>
                                    @error('Reference')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>  
                            {{-- <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Comments</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-merge"> 
                                        <textarea class="form-control" name="comment" id="comments" placeholder="Comments" rows="3">{{ $contact->comment }}</textarea>
                                    </div>
                                    @error('comment')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                </div>  
                            </div>                           --}}
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a class="btn btn-info" href="{{ route('contacts.index')}}">Cancel</a>
                                </div>
                            </div>                             
                    </div>
                </div>
            </div>
        </div>
    </form>                                   
@endsection
{{-- End Form --}}
