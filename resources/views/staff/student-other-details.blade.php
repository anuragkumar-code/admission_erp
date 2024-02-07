@extends('staff.layout.head')
@section('staff')


<?php $counter=1; ?>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Update Student Details</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form action="{{ route('update_other_details') }}" method="post" enctype="multipart/form-data" id="update_student_other_detail">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="first_name"><strong>First Name <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="first_name" value="{{$get_student->first_name}}" name="first_name" placeholder="First Name">
                                            <p class="text-danger">@error('first_name'){{ $message }} @enderror </p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="middle_name"><strong>Middle Name (optional)</strong></label>
                                            <input type="text" class="form-control" id="middle_name" value="{{$get_student->middle_name}}" name="middle_name" placeholder="Middle Name">
                                            <p class="text-danger"> @error('middle_name'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="last_name"><strong>Last Name (optional)</strong></label>
                                            <input type="text" class="form-control" id="last_name" value="{{$get_student->last_name}}" name="last_name" placeholder="Last Name">
                                            <p class="text-danger">@error('last_name'){{ $message }}@enderror </p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="dob"><strong>Date of Birth <span style='color: red'>*</span></strong></label>
                                            <input type="date"  max="<?php echo date("Y-m-d")?>" class="form-control" id="dob" value="{{$get_student->dob}}" placeholder="Enter D.O.B" name="dob">
                                           
                                            <p class="text-danger">@error('dob') {{ $message }} @enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="address"><strong>Address <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="address" value="{{$get_student->address}}" placeholder="Enter Address" name="address">
                                            <p class="text-danger"> @error('address'){{ $message }}@enderror</p>
                                        </div>                                    
                                        <div class="form-group col-md-4">
                                            <label for="country"><strong>Country <span style='color: red'>*</span></strong></label>
                                                <select class="form-control" name="country" id="country">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                    <option <?php if($country->country_name == $get_student->country){  ?> selected <?php }  ?> value="{{$country->country_name}}">{{$country->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            <p class="text-danger">@error('country'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="gender"><strong>Gender <span style='color: red'>*</span></strong></label>
                                                <select class="form-control" name="gender" id="gender">
                                                    <option value="">Please Select</option>
                                                    <option <?php if($get_student->gender == 'Male'){?> selected <?php } ?> value="Male">Male</option>
                                                    <option <?php if($get_student->gender == 'Female'){?> selected <?php } ?> value="Female">Female</option>
                                                    <option <?php if($get_student->gender == 'Others'){?> selected <?php } ?> value="Others">Others</option>
                                                </select>
                                            <p class="text-danger">@error('gender'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email"><strong>Email Address <span style='color: red'>*</span></strong></label>
                                            <input type="email" class="form-control" id="email" value="{{$get_student->email}}" placeholder="Enter Email address" name="email" readonly>
                                            <p class="text-danger">@error('email'){{ $message }} @enderror</p>
                                        </div>

                                        <div class="form-group col-md-4 phone_number">
                                            <label for="phone"><strong>Phone Number <span style='color: red'>*</span></strong></label><br>
                                            <input type="text" class="form-control" id="phone" value="{{$get_student->phone}}" placeholder="Enter Phone Number" name="phone" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger"> @error('phone'){{ $message }}@enderror</p>

                                             <span class="error_msg2"></span>
                                            <br>
                                            <p class="error-msg" id="error-msg"></p>
                                            <p class="valid-msg" id="valid-msg"></p>
                                            <input type="hidden" class="phone_flag" name="phone_flag" value="{{$get_student->phone_flag}}"/>
                                            <input type="hidden" class="phone_dialcode" name="phone_dialcode" value="{{$get_student->phone_dialcode}}"/>

                                        </div>

                                        <div class="form-group col-md-4 whatsapp">
                                            <label for="whatsapp"><strong>Whatsapp Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="whatsapp" value="{{$get_student->whatsapp}}" placeholder="Enter Whatsapp Number" name="whatsapp" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger"> @error('whatsapp'){{ $message }}@enderror</p>

                                            <span class="error_msg2"></span>
                                            <br>
                                            <p class="error-msg" id="error-msg2"></p>
                                            <p class="valid-msg" id="valid-msg2"></p>
                                            <input type="hidden" class="whatsapp_flag" name="whatsapp_flag" value="{{$get_student->whatsapp_flag}}"/>
                                            <input type="hidden" class="whatsapp_dialcode" name="whatsapp_dialcode" value="{{$get_student->whatsapp_dialcode}}"/>

                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="emergency_phone"><strong>Emergency Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="emergency_phone" value="{{$get_student->emergency_phone}}" placeholder="Enter Emergency Contact" name="emergency_phone" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger">@error('emergency_phone'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="purpose"><strong>Purpose of Visit <span style='color: red'>*</span></strong></label>
                                            <select class="form-control"  name="purpose" id="purpose">
                                                <option value="">Please Select</option> 
                                                <option <?php if($get_student->purpose == 'TR'){?> selected <?php } ?> value="TR">TR</option>  
                                                <option <?php if($get_student->purpose == 'PR'){?> selected <?php } ?> value="PR">PR</option>
                                                 <option <?php if($get_student->purpose == 'Change Course'){?> selected <?php } ?> value="Change Course">Change Course</option>
                                                <option <?php if($get_student->purpose == 'Other Services'){?> selected <?php } ?> value="Other Services">Other Service</option>
                                            </select>
                                            <div class="form-group col-md-12 otherPurpose <?php if($get_student->purpose != 'Other Services') {?> d-none <?php } ?>">

                                               <input class="form-control" type="text" placeholder="Please specify other puprpose" value="{{$get_student->other_purpose}}" name="other_purpose">
                                            </div>                                            
                                            <p class="text-danger">@error('purpose'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="referral"><strong>Referral </strong></label>
                                            <select class="form-control"  name="referral" id="referral">
                                                <option value="">Please Select</option>
                                                <option <?php if($get_student->referral == 'Google'){?> selected <?php } ?> value="Google">Google</option>
                                                <option <?php if($get_student->referral == 'Social Media'){?> selected <?php } ?> value="Social Media">Social Media</option>
                                                <option <?php if($get_student->referral == 'Others'){?> selected <?php } ?> value="Others">Others</option>
                                            </select>
                                            <div class="form-group col-md-12 otherReferral <?php if($get_student->referral != 'Others') {?> d-none <?php } ?>">

                                                 <select name="other_referral" class="form-control">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if($referrals_list)
                                                    {
                                                        foreach ($referrals_list as $key => $referrals_list_val)
                                                        {
                                                        ?>
                                                        <option <?php if($referrals_list_val->id == $get_student->other_purpose){?> selected <?php } ?> value="<?php echo $referrals_list_val->id ?>"><?php echo $referrals_list_val->name; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                               <!--  <input class="form-control" type="text" placeholder="Please specify other referral" value="{{$get_student->other_referral}}" name="other_referral"> -->
                                            </div> 
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="staff_name"><strong>Assigned to Staff <span style='color: red'>*</span></strong></label>
                                            <select class="form-control"  name="staff_name" id="staff_name">
                                                <option value="">Please Select</option>
                                                <?php if($get_staffs){
                                                    foreach ($get_staffs as $key => $get_staff) { ?>
                                                        <option <?php if($get_staff->id == $get_student->user_id){  ?> selected <?php }  ?> value="{{$get_staff->id}}">{{$get_staff->first_name}} {{$get_staff->last_name}}</option>
                                                   <?php } } ?>                                                   
                                                </select>
                                            <p class="text-danger">@error('staff_name'){{ $message }}@enderror</p>
                                        </div> 


                                        <div class="form-group col-md-4">
                                            <label for="community"><strong>Community</strong> </label>
                                            <select class="form-control"  name="community" id="community">
                                                <option value="">Please Select</option>

                                                <option <?php if($get_student->community == 'Assamese'){?> selected <?php } ?> value="Assamese">Assamese</option>
                                                <option <?php if($get_student->community == 'Bengali'){?> selected <?php } ?> value="Bengali">Bengali</option>
                                                <option <?php if($get_student->community == 'Hindi'){?> selected <?php } ?> value="Hindi">Hindi</option>
                                                <option <?php if($get_student->community == 'Kannada'){?> selected <?php } ?> value="Kannada">Kannada</option>
                                                <option <?php if($get_student->community == 'Kashmiri'){?> selected <?php } ?> value="Kashmiri">Kashmiri</option>
                                                <option <?php if($get_student->community == 'Konkani'){?> selected <?php } ?> value="Konkani">Konkani</option>
                                                <option <?php if($get_student->community == 'Malayalam'){?> selected <?php } ?> value="Malayalam">Malayalam</option>
                                                <option <?php if($get_student->community == 'Manipuri'){?> selected <?php } ?> value="Manipuri">Manipuri</option>
                                                <option <?php if($get_student->community == 'Marathi'){?> selected <?php } ?> value="Marathi">Marathi</option>
                                                <option <?php if($get_student->community == 'Nepali'){?> selected <?php } ?> value="Nepali">Nepali</option>
                                                <option <?php if($get_student->community == 'Oriya'){?> selected <?php } ?> value="Oriya">Oriya</option>
                                                <option <?php if($get_student->community == 'Punjabi'){?> selected <?php } ?> value="Punjabi">Punjabi</option>
                                                <option <?php if($get_student->community == 'Sindhi'){?> selected <?php } ?> value="Sindhi">Sindhi</option>
                                                <option <?php if($get_student->community == 'Tamil'){?> selected <?php } ?> value="Tamil">Tamil</option>
                                                <option <?php if($get_student->community == 'Telugu'){?> selected <?php } ?> value="Telugu">Telugu</option>
                                                <option <?php if($get_student->community == 'Urdu'){?> selected <?php } ?> value="Urdu">Urdu</option>
                                                <option <?php if($get_student->community == 'Santhali'){?> selected <?php } ?> value="Santhali">Santhali</option>
                                                <option <?php if($get_student->community == 'Maithili'){?> selected <?php } ?> value="Maithili">Maithili</option>
                                                <option <?php if($get_student->community == 'Filipino'){?> selected <?php } ?> value="Filipino">Filipino</option>
                                                <option <?php if($get_student->community == 'Fiji Indian'){?> selected <?php } ?> value="Fiji Indian">Fiji Indian</option>
                                                <option <?php if($get_student->community == 'Gujarati'){?> selected <?php } ?> value="Gujarati">Gujarati</option>
                                                <option <?php if($get_student->community == 'Malaysian'){?> selected <?php } ?> value="Malaysian">Malaysian</option>
                                                <option <?php if($get_student->community == 'Spanish'){?> selected <?php } ?> value="Spanish">Spanish</option>
                                                <option <?php if($get_student->community == 'Labinies'){?> selected <?php } ?> value="Labinies">Labinies</option>
                                                <option <?php if($get_student->community == 'Portugies'){?> selected <?php } ?> value="Portugies">Portugies</option>
                                                <option <?php if($get_student->community == 'Thai'){?> selected <?php } ?> value="Thai">Thai</option>                                                

                                                </select>
                                         
                                        </div>                                        

                                        {{-------------------------Form 2---------------------}}
                                        
                                        <h4>Other Details</h4>
                                        <br>
                                        <div class="col-lg-12 col-md-12 chckstrip">
                                            <input type="checkbox" id="chkPassport" @if($get_student->passport_file != '') checked @endif value="1" {{ old('chkPassport') == '1' ? 'checked' : ''}} name="chkPassport" class="chckright" data-type="passportchkDiv"/>
                                            <strong><b>Passport</b></strong>
                                        </div>                                                   
                                        <div class="form-group col-md-4 passportchkDiv @if($get_student->passport_file != '' || old('chkPassport') == '1') @else d-none @endif">
                                            <label for="passport_number"><strong>Passport Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="passport_number" @if ($get_student->passport_number != '')  value ="{{$get_student->passport_number}}" @else value="{{old('passport_number')}}" @endif placeholder="Enter Passport Number" name="passport_number">
                                            <p class="text-danger">@error('passport_number'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 passportchkDiv @if($get_student->passport_file != '' || old('chkPassport') == '1') @else d-none @endif">
                                            <label for="passport_expiry_date"><strong>Expiry Date <span style='color: red'>*</span></strong></label>
                                            <input type="date" min="{{date("Y-m-d")}}" class="form-control" id="passport_expiry_date" @if ($get_student->passport_expiry_date != '')  value ="{{$get_student->passport_expiry_date}}" @else value="{{old('passport_expiry_date')}}" @endif placeholder="Enter Expiry Date" name="passport_expiry_date">
                                            <p class="text-danger">@error('passport_expiry_date'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-4 passportchkDiv @if($get_student->passport_file != '' || old('chkPassport') == '1') @else d-none @endif">
                                            <label for="passport_file"><strong>Upload Passport <span style='color: red'>*</span></strong></label>
                                            <div class="custom-file">
                                                <input type="file" data_id="passport_file" class="custom-file-input fileclass"  name="passport_file" id="passport_file">
                                                <input type="hidden" class="old_passport_file passport_file" value="{{$get_student->passport_file}}" name="old_passport_file">
                                                <label class="custom-file-label" id="show_passport" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_passport_file'){{ $message }}@enderror</p>                                                    
                                            </div>
                                            @if($get_student->passport_file != '')
                                            <?php $info = pathinfo($get_student->passport_file);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passport_one">Preview</button>

                                        <div class="modal fade" id="passport_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Passport View</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                         <div class="iframediv">
                                            <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/passport/'.$get_student->passport_file); ?>&embedded=true" style="width:100%; height:500px;"  title="passport file"></iframe>
                                        </div>
                                                    </div>                                                  
                                                </div>
                                            </div>
                                        </div>
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                               
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passport_two">Preview</button>

                                                <div class="modal fade" id="passport_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Passport View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="iframediv">
                                                                    <iframe src="{{url('/files/passport/'.$get_student->passport_file)}}" style="width:100%; height:500px;" title="passport file"></iframe>
                                                                </div>
                                                            </div>                                                  
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php } ?>
                                            @endif
                                         </div>                                           
                                        <div class="col-lg-12 col-md-12 chckstrip">
                                            <input type="checkbox" id="chkVisa" @if($get_student->visa_file != '') checked @endif value="1" {{ old('chkVisa') == '1' ? 'checked' : ''}} name="chkVisa" class="chckright" data-type="visaChkDiv"/>
                                            <strong><b>Visa Copy</b></strong>
                                        </div>

                                        <div class="form-group col-md-4 visaChkDiv @if($get_student->visa_file != '' || old('chkVisa') == '1') @else d-none @endif">
                                            <label for="visa_expiry_date"><strong>Expiry Date <span style='color: red'>*</span></strong></label>
                                            <input type="date" min="{{date('Y-m-d')}}" id="visa_expiry_date" <?php if ($get_student->visa_expiry_date != ''){ ?>  value ="{{$get_student->visa_expiry_date}}" <?php } else { ?> value="{{old('visa_expiry_date')}}" <?php } ?> placeholder="Enter Expiry Date" name="visa_expiry_date">
                                            <p class="text-danger">@error('visa_expiry_date'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 visaChkDiv @if($get_student->visa_file != '' || old('chkVisa') == '1') @else d-none @endif">
                                            <label for="visa_type"><strong>Type of Visa <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" name="visa_type" id="visa_type" @if ($get_student->visa_type != '')  value ="{{$get_student->visa_type}}" @else value="{{old('visa_type')}}" @endif placeholder="Enter Type of Visa" name="visa_type">
                                            <p class="text-danger"> @error('visa_type'){{ $message }}@enderror</p>
                                        </div> 
                                        <div class="form-group col-md-4 visaChkDiv @if($get_student->visa_file != '' || old('chkVisa') == '1') @else d-none @endif">
                                            <label for="visa_file"><strong>Upload Visa <span style='color: red'>*</span></strong></label>
                                            <div class="custom-file">
                                                <input class="custom-file-input"  name="visa_file" type="file" id="visa_file" data_id="visa_file_one">
                                                <input type="hidden" value="{{$get_student->visa_file}}" name="old_visa_file" class="visa_file_one">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger"> @error('old_visa_file'){{ $message }}@enderror</p>                                                
                                            </div>
                                            @if($get_student->visa_file != '')
                                            <?php $info = pathinfo($get_student->visa_file);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                            
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visa_one">Preview</button>

                                                <div class="modal fade" id="visa_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Visa View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/visa/'.$get_student->visa_file); ?>&embedded=true" style="width:100%; height:500px;" title="visa file"></iframe>
                                                                </div>
                                                            </div>                                                  
                                                        </div>
                                                    </div>
                                                </div>
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                               
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visa_two">Preview</button>

                                                <div class="modal fade" id="visa_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Visa View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="iframediv">
                                                                    <iframe src="{{url('/files/visa/'.$get_student->visa_file)}}" style="width:100%; height:500px;" title="visa file"></iframe>
                                                                </div>
                                                            </div>                                                  
                                                        </div>
                                                    </div>
                                                </div>


                                                <?php } ?>
                                            @endif
                                        </div>

                                        <div class="col-md-12 col-md-12 chckstrip">
                                            <input type="checkbox" value="1"  @if($get_coes_data) checked @endif value="1" {{ old('chkCoes') == '1' ? 'checked' : ''}}  name="chkCoes" class="chckright" data-type="coesDiv"/>
                                            <strong><b>Coes</b></strong>
                                        </div>

                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="start_date_one"><strong>Start Date <span style='color: red'>*</span></strong></label>
                                            <input type="date"  class="form-control" id="start_date_one" @if($get_coes_data) value ="{{$get_coes_data->start_date_one}}" @else value="{{old('start_date_one')}}" @endif placeholder="Enter Start Date" name="start_date_one">
                                            <p class="text-danger">@error('start_date_one'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="end_date_one"><strong>End Date <span style='color: red'>*</span></strong></label>
                                            <input type="date"  class="form-control" id="end_date_one" placeholder="Enter End Date" name="end_date_one" @if($get_coes_data)  value ="{{$get_coes_data->end_date_one}}" @else value="{{old('end_date_one')}}" @endif>
                                            <p class="text-danger">@error('end_date_one'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="file_one"><strong>Upload Coes <span style='color: red'>*</span></strong></label>
                                            <div class="custom-file">
                                                <input type="file" data_id="old_file_one" class="custom-file-input fileclass" name="file_one" id="file_one">
                                                <input type="hidden" class="old_file_one" @if($get_coes_data) value="{{$get_coes_data->file_one}}" @endif name="old_file_one">
                                                <label class="custom-file-label" id="file_one" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_file_one'){{ $message }}@enderror</p>                                                    
                                            </div>

                                            @if($get_coes_data)
                                            @if($get_coes_data->file_one!='')
                                            <?php $info = pathinfo($get_coes_data->file_one);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                           

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_one">Preview</button>

                                        <div class="modal fade" id="coes_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="iframediv">
                                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_one); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_two">Preview</button>

                                                <div class="modal fade" id="coes_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_one)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <?php } ?>
                                            @endif
                                            @endif

                                            
                                         </div> 


                                         <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="start_date_two"><strong>Start Date</strong></label>
                                            <input type="date"  class="form-control" id="start_date_two" @if($get_coes_data)  value ="{{$get_coes_data->start_date_two}}" @else value="{{old('start_date_two')}}" @endif placeholder="Enter Expiry Date" name="start_date_two">
                                            <p class="text-danger">@error('start_date_two'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="end_date_two"><strong>End Date</strong></label>
                                            <input type="date"  class="form-control" id="end_date_two" placeholder="Enter Expiry Date" name="end_date_two" @if($get_coes_data)  value ="{{$get_coes_data->end_date_two}}" @else value="{{old('end_date_two')}}" @endif>
                                            <p class="text-danger">@error('end_date_two'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="file_two"><strong>Upload Coes</strong></label>
                                            <div class="custom-file">
                                                <input type="file" data_id="old_file_two" class="custom-file-input fileclass" name="file_two" id="file_two">
                                                <input type="hidden" class="old_file_two" @if($get_coes_data) value="{{$get_coes_data->file_two}}" @endif name="old_file_two">
                                                <label class="custom-file-label" id="show_passport" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_file_two'){{ $message }}@enderror</p>                                                    
                                            </div>

                                            @if($get_coes_data)
                                            @if($get_coes_data->file_two!='')
                                            <?php $info = pathinfo($get_coes_data->file_two);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                           
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_three">Preview</button>

                                                <div class="modal fade" id="coes_three" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_two); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_four">Preview</button>

                                                <div class="modal fade" id="coes_four" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_two)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 


                                                <?php } ?>
                                            @endif
                                            @endif
                                            
                                         </div> 

                                         <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="start_date_three"><strong>Start Date</strong></label>
                                            <input type="date"  class="form-control" id="start_date_three" placeholder="Enter Start date" name="start_date_three"  @if($get_coes_data)  value="{{$get_coes_data->start_date_three}}" @else value="{{old('start_date_three')}}" @endif>
                                            <p class="text-danger">@error('start_date_three'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="end_date_three"><strong>End Date</strong></label>
                                            <input type="date"  class="form-control" id="end_date_three" placeholder="Enter Expiry Date" name="end_date_three" @if($get_coes_data) value="{{$get_coes_data->end_date_three}}" @else value="{{old('end_date_three')}}" @endif>
                                            <p class="text-danger">@error('end_date_three'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv  @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="file_three"><strong>Upload Coes</strong></label>
                                            <div class="custom-file">
                                                <input type="file" data_id="old_file_three" class="custom-file-input fileclass" name="file_three" id="file_three">
                                                <input type="hidden" class="old_file_three" @if($get_coes_data) value="{{$get_coes_data->file_three}}" @endif name="old_file_three">
                                                <label class="custom-file-label" id="show_passport" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_file_three'){{ $message }}@enderror</p>                                                    
                                            </div>

                                            @if($get_coes_data)
                                            @if($get_coes_data->file_three!='')
                                            <?php $info = pathinfo($get_coes_data->file_three);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                           
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_five">Preview</button>

                                                    <div class="modal fade" id="coes_five" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_three); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                              
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_six">Preview</button>

                                                <div class="modal fade" id="coes_six" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_three)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <?php } ?>
                                            @endif
                                            @endif
                                           
                                         </div> 



                                         <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="start_date_four"><strong>Start Date</strong></label>
                                            <input type="date"  class="form-control" id="start_date_four" placeholder="Enter Expiry Date" name="start_date_four" @if($get_coes_data) value="{{$get_coes_data->start_date_four}}" @else value="{{old('start_date_four')}}" @endif>
                                            <p class="text-danger">@error('start_date_four'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="end_date_four"><strong>End Date</strong></label>
                                            <input type="date"  class="form-control" id="end_date_four" placeholder="Enter Expiry Date" name="end_date_four" @if($get_coes_data) value="{{$get_coes_data->end_date_four}}" @else value="{{old('end_date_four')}}" @endif>
                                            <p class="text-danger">@error('end_date_four'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="file_four"><strong>Upload Coes</strong></label>
                                            <div class="custom-file">
                                                <input type="file" data_id="old_file_four" class="custom-file-input fileclass"  name="file_four" id="file_four">
                                                <input type="hidden" class="old_file_four" name="old_file_four" @if($get_coes_data) value="{{$get_coes_data->file_four}}" @endif>
                                                <label class="custom-file-label" id="show_passport" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_file_four'){{ $message }}@enderror</p>                                                    
                                            </div>

                                            @if($get_coes_data)
                                            @if($get_coes_data->file_four!='')
                                            <?php $info = pathinfo($get_coes_data->file_four);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                           
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_seven">Preview</button>

                                                    <div class="modal fade" id="coes_seven" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_four); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>  
                                         <?php
                                            }
                                            else
                                            {
                                                ?>

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_eight">Preview</button>

                                                <div class="modal fade" id="coes_eight" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>                                                   
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_four)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } ?>
                                            @endif
                                            @endif
                                            
                                         </div> 

                                         <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="start_date_five"><strong>Start Date</strong></label>
                                            <input type="date"  class="form-control" id="start_date_five" placeholder="Enter Expiry Date" name="start_date_five" @if($get_coes_data) value="{{$get_coes_data->start_date_five}}" @else value="{{old('start_date_five')}}" @endif>
                                            <p class="text-danger">@error('start_date_five'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="end_date_five"><strong>End Date</strong></label>
                                            <input type="date"  class="form-control" id="end_date_five" placeholder="Enter Expiry Date" name="end_date_five" @if($get_coes_data) value="{{$get_coes_data->end_date_five}}" @else value="{{old('end_date_five')}}" @endif>
                                            <p class="text-danger">@error('end_date_five'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 coesDiv @if($get_coes_data || old('chkCoes') == '1') @else d-none @endif">
                                            <label for="file_five"><strong>Upload Coes</strong></label>
                                            <div class="custom-file">
                                                <input type="file" data_id="old_file_five" class="custom-file-input fileclass" name="file_five" id="file_five">
                                                <input type="hidden" class="old_file_five" name="old_file_five" @if($get_coes_data) value="{{$get_coes_data->file_five}}" @endif>
                                                <label class="custom-file-label" id="show_passport" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_file_five'){{ $message }}@enderror</p>                                                    
                                            </div>

                                            @if($get_coes_data)
                                            @if($get_coes_data->file_five!='')
                                            <?php $info = pathinfo($get_coes_data->file_five);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                            
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_nine">Preview</button>

                                                    <div class="modal fade" id="coes_nine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>                                                   
                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_five); ?>&embedded=true" style="width:100%; height:500px;"  title="coes file"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coes_ten">Preview</button>

                                                <div class="modal fade" id="coes_ten" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">COES View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>                                                   
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_five)}}" style="width:100%; height:500px;" title="coes file"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php } ?>
                                            @endif
                                            @endif
                                            
                                         </div> 

                                         


                                        <div class="col-md-6 col-md-6 chckstrip">
                                            <input type="checkbox" id="chkOshc_Ovhc" @if($get_student->oshc_ovhc_file != '') checked @endif value="1" {{ old('chkOshc_Ovhc') == '1' ? 'checked' : ''}} name="chkOshc_Ovhc" class="chckright" data-type="Oshc_OvhcChkDiv"/>
                                            <strong><b>OSHC/OVHC</b></strong>
                                            <div class="custom-file Oshc_OvhcChkDiv @if($get_student->oshc_ovhc_file != '' || old('chkOshc_Ovhc') == '1') @else d-none @endif">
                                                <input class="custom-file-input" type="file" name="oshc_ovhc_file" id="oshc_ovhc_file" data_id="oshc_ovhc_file_one">
                                                <input type="hidden" value="{{$get_student->oshc_ovhc_file}}" name="old_oshc_ovhc_file" class="oshc_ovhc_file_one">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger"> @error('old_oshc_ovhc_file'){{ $message }}@enderror</p>                                                
                                            </div>
                                            @if($get_student->oshc_ovhc_file != '')
                                            <?php $info = pathinfo($get_student->oshc_ovhc_file);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#oshc_ovhc_one">Preview</button>

                                        <div class="modal fade" id="oshc_ovhc_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">OSHC OVHC View</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="iframediv">
                                        <iframe src="{{url('/files/others/'.$get_student->oshc_ovhc_file)}}" style="width:100%; height:500px;" title="oshc ovhc file"></iframe>
                                        </div>                             
                                                </div>
                                            </div>
                                        </div>
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#oshc_ovhc_two">Preview</button>

                                                <div class="modal fade" id="oshc_ovhc_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">OSHC OVHC View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/others/'.$get_student->oshc_ovhc_file)}}" style="width:100%; height:500px;" title="oshc ovhc file"></iframe>
                                                            </div>                             
                                                        </div>
                                                    </div>
                                                </div>


                                                <?php } ?>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-md-6 chckstrip">
                                            <input type="checkbox" id="chkIelts_pte_score" @if($get_student->ielts_pte_score_file != '') checked @endif value="1" {{ old('chkIelts_pte_score') == '1' ? 'checked' : ''}} name="chkIelts_pte_score" class="chckright" data-type="chkIelts_pte_scoreDiv"/>
                                            <strong><b>IELTS/PTE SCORE</b></strong>
                                            <div class="custom-file chkIelts_pte_scoreDiv @if($get_student->ielts_pte_score_file != '' || old('chkIelts_pte_score') == '1') @else d-none @endif">
                                                <input class="custom-file-input" type="file" name="ielts_pte_score_file" data_id="ielts_pte_score_file" id="ielts_pte_score_file">
                                                <input type="hidden" value="{{$get_student->ielts_pte_score_file}}" name="old_ielts_pte_score_file" class="ielts_pte_score_file">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger"> @error('old_ielts_pte_score_file'){{ $message }}@enderror</p>                                                
                                            </div>
                                            @if($get_student->ielts_pte_score_file != '')
                                            <?php $info = pathinfo($get_student->ielts_pte_score_file);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                           
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#IELTS_PTE_one">Preview</button>

                                                    <div class="modal fade" id="IELTS_PTE_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">IELTS/PTE View</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_student->ielts_pte_score_file); ?>&embedded=true" style="width:100%; height:500px;"  title="ielts pte score file"></iframe>
                                                                </div>                  
                                                            </div>
                                                        </div>
                                                    </div>



                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                              
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#IELTS_PTE_two">Preview</button>

                                                <div class="modal fade" id="IELTS_PTE_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">IELTS/PTE View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/others/'.$get_student->ielts_pte_score_file)}}" style="width:100%; height:500px;" title="ielts pte score file"></iframe>
                                                            </div>                 
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            @endif
                                        </div>

                                        <div class="col-lg-12 col-md-12 chckstrip">
                                            <input type="checkbox"  id="chkEducation_details" @if($get_student->ten_marksheet != '') checked @endif value="1" {{ old('chkEducation_details') == '1' ? 'checked' : ''}} name="chkEducation_details" class="chckright" data-type="chkEducation_detailsDiv"/>
                                            <strong><b>Education Details</b></strong>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Stream</strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>School/College</strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Board/University</strong>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Percentage</strong>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Session</strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Marksheet</strong>
                                        </div>
                                        {{-- class 10th --}}
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong> 10th <span style='color: red'>*</span></strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="ten_school_college" @if ($get_student->ten_school_college != '')  value ="{{$get_student->ten_school_college}}" @else value="{{old('ten_school_college')}}" @endif placeholder="Enter school name" name="ten_school_college">
                                            <p class="text-danger"> @error('ten_school_college') {{ $message }} @enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="ten_board_university" @if ($get_student->ten_board_university != '')  value ="{{$get_student->ten_board_university}}" @else value="{{old('ten_board_university')}}" @endif placeholder="Enter board or university" name="ten_board_university">
                                            <p class="text-danger"> @error('ten_board_university'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="ten_percentage"  @if ($get_student->ten_percentage != '')  value ="{{$get_student->ten_percentage}}" @else value="{{old('ten_percentage')}}" @endif placeholder="%" name="ten_percentage">
                                            <p class="text-danger">@error('ten_percentage'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="ten_session" @if ($get_student->ten_session != '')  value ="{{$get_student->ten_session}}" @else value="{{old('ten_session')}}" @endif placeholder="Session" name="ten_session">
                                            <p class="text-danger">@error('ten_session') {{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="ten_marksheet" name="ten_marksheet" data_id="ten_marksheet_file">
                                                <input type="hidden" value="{{$get_student->ten_marksheet}}" name="old_ten_marksheet" class="ten_marksheet_file">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_ten_marksheet'){{ $message }}@enderror</p>
                                            </div>
                                            @if($get_student->ten_marksheet != '')
                                            <?php $info = pathinfo($get_student->ten_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>

                                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ten_marksheet_one">Preview</button>

                                                <div class="modal fade" id="ten_marksheet_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">10th Marksheet View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/education/'.$get_student->ten_marksheet)}}" style="width:100%; height:500px;" title="ten marksheet file"></iframe>
                                                            </div>                 
                                                        </div>
                                                    </div>
                                                </div>



                                            <?php
                                            }
                                            else
                                            {
                                                ?>

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ten_marksheet_two">Preview</button>

                                                <div class="modal fade" id="ten_marksheet_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">10th Marksheet View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/education/'.$get_student->ten_marksheet)}}" style="width:100%; height:500px;" title="ten marksheet file"></iframe>
                                                            </div>                 
                                                        </div>
                                                    </div>
                                                </div>



                                                <?php } ?>
                                            @endif
                                        </div>
                                        {{-- class 10th --}}

                                        {{-- class 12th --}}
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>12th <span style='color: red'>*</span></strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="twelve_school_college" @if ($get_student->twelve_school_college != '')  value ="{{$get_student->twelve_school_college}}" @else value="{{old('twelve_school_college')}}" @endif placeholder="Enter school name" name="twelve_school_college">
                                            <p class="text-danger">@error('twelve_school_college'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="twelve_board_university" @if ($get_student->twelve_board_university != '')  value ="{{$get_student->twelve_board_university}}" @else value="{{old('twelve_board_university')}}" @endif placeholder="Enter board or university" name="twelve_board_university">
                                            <p class="text-danger">@error('twelve_board_university'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="twelve_percentage" @if ($get_student->twelve_percentage != '')  value ="{{$get_student->twelve_percentage}}" @else value="{{old('twelve_percentage')}}" @endif placeholder="%" name="twelve_percentage">
                                            <p class="text-danger"> @error('twelve_percentage'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="twelve_session" @if ($get_student->twelve_session != '')  value ="{{$get_student->twelve_session}}" @else value="{{old('twelve_session')}}" @endif placeholder="Session" name="twelve_session">
                                            <p class="text-danger">@error('twelve_session'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <div class="custom-file">
                                                <input class="custom-file-input"  type="file" id="twelve_marksheet" data_id="twelve_marksheet_file" name="twelve_marksheet">
                                                <input type="hidden" value="{{$get_student->twelve_marksheet}}" name="old_twelve_marksheet" class="twelve_marksheet_file">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_twelve_marksheet'){{ $message }}@enderror</p>
                                            </div>
                                            @if($get_student->twelve_marksheet != '')
                                            <?php $info = pathinfo($get_student->twelve_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#twelve_marksheet_one">Preview</button>

                                                <div class="modal fade" id="twelve_marksheet_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">12th Marksheet View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/education/'.$get_student->twelve_marksheet)}}" style="width:100%; height:500px;" title="twelve marksheet file"></iframe>
                                                            </div>                 
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                              
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#twelve_marksheet_two">Preview</button>

                                                <div class="modal fade" id="twelve_marksheet_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">12th Marksheet View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/education/'.$get_student->twelve_marksheet)}}" style="width:100%; height:500px;" title="twelve marksheet file"></iframe>
                                                            </div>                 
                                                        </div>
                                                    </div>
                                                </div>


                                                <?php } ?>
                                            @endif
                                        </div>
                                        {{-- class 12th --}}

                                        {{-- Diploma --}}
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Diploma</strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="diploma_school_college" @if ($get_student->diploma_school_college != '')  value ="{{$get_student->diploma_school_college}}" @else value="{{old('diploma_school_college')}}" @endif placeholder="Enter college name" name="diploma_school_college">
                                            <p class="text-danger">@error('diploma_school_college'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="diploma_board_university" @if ($get_student->diploma_board_university != '')  value ="{{$get_student->diploma_board_university}}" @else value="{{old('diploma_board_university')}}" @endif placeholder="Enter board or university" name="diploma_board_university">
                                            <p class="text-danger">@error('diploma_board_university'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="diploma_percentage" value="{{$get_student->diploma_percentage}}" placeholder="%" name="diploma_percentage">
                                            <p class="text-danger">@error('diploma_percentage'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="diploma_session" value="{{$get_student->diploma_session}}" placeholder="Session" name="diploma_session">
                                            <p class="text-danger">@error('diploma_session'){{ $message }}@enderror</p>
                                            
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <div class="custom-file">
                                                <input class="custom-file-input" type="file" id="diploma_marksheet" name="diploma_marksheet" data_id="diploma_marksheet_file">
                                                <input type="hidden" value="{{$get_student->diploma_marksheet}}" name="old_diploma_marksheet" class="diploma_marksheet_file">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                            </div>
                                            @if($get_student->diploma_marksheet != '')
                                            <?php $info = pathinfo($get_student->diploma_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#diploma_one">Preview</button>

                                                <div class="modal fade" id="diploma_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Diploma View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/education/'.$get_student->diploma_marksheet)}}" style="width:100%; height:500px;" title="diploma marksheet file"></iframe>
                                                            </div>                 
                                                        </div>
                                                    </div>
                                                </div>


                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#diploma_two">Preview</button>

                                                <div class="modal fade" id="diploma_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Diploma View</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="iframediv">
                                                                <iframe src="{{url('/files/education/'.$get_student->diploma_marksheet)}}" style="width:100%; height:500px;" title="diploma marksheet file"></iframe>
                                                            </div>                 
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            @endif
                                            <p class="text-danger">@error('old_diploma_marksheet'){{ $message }}@enderror</p>
                                        </div>
                                        {{-- Diploma --}}

                                        {{-- Bachelors --}}
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Bachelors</strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="bachelors_school_college" @if ($get_student->bachelors_school_college != '')  value ="{{$get_student->bachelors_school_college}}" @else value="{{old('bachelors_school_college')}}" @endif placeholder="Enter college name" name="bachelors_school_college">
                                            <p class="text-danger">@error('bachelors_school_college'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="bachelors_board_university" @if ($get_student->bachelors_board_university != '')  value ="{{$get_student->bachelors_board_university}}" @else value="{{old('bachelors_board_university')}}" @endif placeholder="Enter board or university" name="bachelors_board_university">
                                            <p class="text-danger">@error('bachelors_board_university'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="bachelors_percentage" @if ($get_student->bachelors_percentage != '')  value ="{{$get_student->bachelors_percentage}}" @else value="{{old('bachelors_percentage')}}" @endif placeholder="%" name="bachelors_percentage">
                                            <p class="text-danger">@error('bachelors_percentage'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="bachelors_session" @if ($get_student->bachelors_session != '')  value ="{{$get_student->bachelors_session}}" @else value="{{old('bachelors_session')}}" @endif placeholder="Session" name="bachelors_session">
                                            <p class="text-danger">@error('bachelors_session'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <div class="custom-file">
                                                <input class="custom-file-input" type="file" id="bachelors_marksheet" data_id="bachelors_marksheet_file" name="bachelors_marksheet">
                                                <input type="hidden" value="{{$get_student->bachelors_marksheet}}" name="old_bachelors_marksheet" class="bachelors_marksheet_file">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                            </div>
                                            @if($get_student->bachelors_marksheet != '')
                                            <?php $info = pathinfo($get_student->bachelors_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                            <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$get_student->bachelors_marksheet); ?>&embedded=true"  title="bachelors_marksheet file"></iframe></p> 
                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <iframe src="{{url('/files/education/'.$get_student->bachelors_marksheet)}}" title="bachelors_marksheet file"></iframe>
                                                <?php } ?>
                                            @endif
                                            <p class="text-danger">@error('old_bachelors_marksheet'){{ $message }}@enderror</p>
                                        </div>
                                        {{-- Bachelors --}}

                                        {{-- Masters --}}
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Masters</strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                           <input type="text" class="form-control" id="masters_school_college" @if ($get_student->masters_school_college != '')  value ="{{$get_student->masters_school_college}}" @else value="{{old('masters_school_college')}}" @endif placeholder="Enter College name" name="masters_school_college">
                                           <p class="text-danger">@error('masters_school_college'){{ $message }}@enderror</p>
                                           
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="masters_board_university" @if ($get_student->masters_board_university != '')  value ="{{$get_student->masters_board_university}}" @else value="{{old('masters_board_university')}}" @endif placeholder="Enter board or university" name="masters_board_university">
                                            <p class="text-danger">@error('masters_board_university'){{ $message }}@enderror</p>
                                            
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                           <input type="text" class="form-control" id="masters_percentage" @if ($get_student->masters_percentage != '')  value ="{{$get_student->masters_percentage}}" @else value="{{old('masters_percentage')}}" @endif placeholder="%"  name="masters_percentage">
                                           <p class="text-danger">@error('masters_percentage'){{ $message }}@enderror</p>
                                           
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="masters_session" @if ($get_student->masters_session != '')  value ="{{$get_student->masters_session}}" @else value="{{old('masters_session')}}" @endif placeholder="Session" name="masters_session">
                                            <p class="text-danger">@error('masters_session'){{ $message }}@enderror</p>
                                            
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <div class ="custom-file">
                                                <input class="custom-file-input" data_id="masters_marksheet_file" type="file" id="masters_marksheet" name="masters_marksheet">
                                                <input type="hidden" value="{{$get_student->masters_marksheet}}" name="old_masters_marksheet" class="masters_marksheet_file">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                            </div>
                                            @if($get_student->masters_marksheet != '')
                                            <?php $info = pathinfo($get_student->masters_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                           
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#masters_marksheet_one">Preview</button>

                                                    <div class="modal fade" id="masters_marksheet_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Master Marksheet View</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$get_student->masters_marksheet); ?>&embedded=true" style="width:100%; height:500px;"  title="Masters Marksheet"></iframe>
                                                                </div>   
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#masters_marksheet_two">Preview</button>

                                                    <div class="modal fade" id="masters_marksheet_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Master Marksheet View</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$get_student->masters_marksheet); ?>&embedded=true" style="width:100%; height:500px;"  title="Masters Marksheet file"></iframe>
                                                                </div>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            @endif
                                            <p class="text-danger">@error('old_masters_marksheet'){{ $message }}@enderror</p>

                                        </div>
                                        {{-- Masters --}}

                                        <div class="col-md-6 col-md-6 chckstrip">
                                            <input type="checkbox" id="chkAustralianId" @if($get_student->australian_id != '') checked @endif value="1" {{ old('chkAustralianId') == '1' ? 'checked' : ''}} name="chkAustralianId" class="chckright" data-type="australian_idDiv"/>
                                            <strong><b>Australian ID (if any)</b></strong>
                                            <div class="custom-file australian_idDiv  @if($get_student->australian_id != '' || old('chkAustralianId') == '1') @else d-none @endif"> 
                                                <input class="custom-file-input" type="file" data_id="australian_id_file" id="australian_id" name="australian_id">
                                                <input type="hidden" value="{{$get_student->australian_id}}" name="old_australian_id" class="australian_id_file"> 
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_australian_id'){{ $message }}@enderror</p>                                                
                                            </div>
                                            @if($get_student->australian_id != '')
                                            <?php $info = pathinfo($get_student->australian_id);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                           
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#australian_id_one">Preview</button>

                                                    <div class="modal fade" id="australian_id_one" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Australian ID View</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_student->australian_id); ?>&embedded=true" style="width:100%; height:500px;"  title="Australian ID"></iframe>
                                                                </div>   
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#australian_id_two">Preview</button>

                                                    <div class="modal fade" id="australian_id_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Australian ID View</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="iframediv">
                                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_student->australian_id); ?>&embedded=true" style="width:100%; height:500px;"  title="Australian ID"></iframe>
                                                                </div>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            @endif
                                        </div>   


                                        @if ($message = Session::get('campus_id'))
                                        <div class="alert alert-danger alert-block col-sm-12">
                                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif                                       

                                        <div class="form-group col-md-12">
                                            <h4>Fee Structure</h4>
                                        </div>                                       
                                        <?php

                                        //echo "<pre>"; print_r($get_course_fee_details); exit;
                                        if($get_course_fee_details)
                                        {   
                                            $counter =1;
                                            ?>
                                            <div class="cloning_section">
                                            <?php
                                            foreach ($get_course_fee_details as $key => $fee_details_val)
                                            {                                                   
                                         ?>                                         
                                        <div class="append_section row course_section{{$fee_details_val->id}}">                                        
                                        <div class="form-group col-md-5">
                                            <label for="college"><strong>College <span style='color: red'>*</span></strong></label>
                                            <select class="form-control college" name="college[<?php echo $counter; ?>]" id="college[<?php echo $counter; ?>]" data-collegeid="<?php echo $counter; ?>" @if($fee_details_val->college_id!='') disabled="true" @endif>
                                                <option value="">Please Select College </option>
                                                <?php if($get_colleges){
                                                    foreach ($get_colleges as $key => $get_college) { ?>
                                                        <option <?php if($fee_details_val->college_id==$get_college->id){  ?> selected <?php }  ?> value="{{$get_college->id}}">{{$get_college->college_trading_name}}</option>
                                                   <?php } } ?> 
                                            </select>
                                            <p class="text-danger">@error('college'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="course"><strong>Course <span style='color: red'>*</span></strong></label>
                                            <select class="form-control collegeCourse<?php echo $counter; ?> selectcourses" name="course[<?php echo $counter; ?>]" id="course<?php echo $counter; ?>" data-course_id="<?php echo $counter; ?>" @if($fee_details_val->course_id!='') disabled="true" @endif>
                                                <option value="">Please Select Course</option>

                                              <?php
                                              if(isset($all_courses_val[$fee_details_val->college_id]))
                                              {
                                                foreach ($all_courses_val[$fee_details_val->college_id] as $key => $all_courses)
                                                { ?>
                                                   
                                                   <option value="{{$all_courses->id}}"  <?php if($all_courses->id==$fee_details_val->course_id){ ?> selected <?php } ?> >{{$all_courses->course_name}}</option> 
                                               <?php }
                                              } 
                                            ?>
                                                
                                            </select>
                                            <p class="text-danger">@error('course'){{ $message }} @enderror</p>
                                        </div>


                                        <div class="form-group col-md-2 show_current_course_checkobx">
                                            <label for="course"><strong>Current Course <span style='color: red'>*</span></strong></label>
                                            <!-- <input type="radio" @if($fee_details_val->current_college_course==1)  checked @endif value="1"> -->

                                            <input type="radio" name="currentcourse" class="current_course" data-curr_courseid="<?php echo $counter; ?>" @if($fee_details_val->current_college_course==1) checked @endif>
                                            <input type="hidden" class="current_course" id="current_course<?php echo $counter; ?>" name="current_course[<?php echo $counter; ?>]" <?php if($fee_details_val->current_college_course==1){?> value="1" <?php } else {?>  value="0" <?php } ?>>


                                        </div>
                                        <div style="clear:both;">&nbsp;</div>


                                        <div class="form-group col-md-2">
                                            <label for="course"><strong>Campuses <span style='color: red'>*</span></strong></label>
                                            <select class="form-control CourseCampuses selectcampuses<?php echo $counter; ?>" name="campuses[<?php echo $counter; ?>]" id="campuses<?php echo $counter; ?>" data-campuses_id="<?php echo $counter; ?>" @if($fee_details_val->campus_id!='') disabled="true" @endif>
                                                <option value="">Please Select Campuses</option>

                                              <?php                   
                                              if(isset($all_campuses_val[$fee_details_val->course_id]))
                                              {
                                                foreach ($all_campuses_val[$fee_details_val->course_id] as $key => $all_campuses)
                                                { 

                                                    ?>
                                                   
                                                   <option value="{{$all_campuses->id}}"  <?php if($all_campuses->id==$fee_details_val->campus_id){ ?> selected <?php } ?> >{{$all_campuses->campus_name}}</option> 
                                               <?php }
                                              } 
                                            ?>
                                                
                                            </select>
                                            <p class="text-danger">@error('campuses'){{ $message }} @enderror</p>
                                        </div>


                                        <div class="form-group col-md-2">
                                            <label for="admission_fees"><strong>Admission fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control admission_fees<?php echo $counter; ?>" name="admission_fees[<?php echo $counter; ?>]" id="admission_fees<?php echo $counter; ?>" value="{{$fee_details_val->fees}}" placeholder="Admission fees" disabled="true">
                                            <p class="text-danger">@error('admission_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="material_fees"><strong>Material fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control material_fees<?php echo $counter; ?>" name="material_fees[<?php echo $counter; ?>]" id="material_fees<?php echo $counter; ?>" value="{{$fee_details_val->material_fees}}"  placeholder="Material fees" disabled="true">
                                            <p class="text-danger">@error('material_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="tuition_fees"><strong>Tuition fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control tuition_fees<?php echo $counter; ?>" name="tuition_fees[<?php echo $counter; ?>]" id="tuition_fees<?php echo $counter; ?>" value="{{$fee_details_val->tuition_fees}}"  placeholder="Tuition fees" disabled="true">
                                            <p class="text-danger">@error('tuition_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="course_fee"><strong>Course total fee</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control course_fee<?php echo $counter; ?>" name="fees[<?php echo $counter; ?>]" id="course_fee<?php echo $counter; ?>" value="<?php echo $fee_details_val->fees + $fee_details_val->tuition_fees + $fee_details_val->material_fees; ?>" placeholder="Course fee" disabled="true">
                                            <p class="text-danger">@error('fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="discount"><strong>Discount Type</strong></label>
                                            <select class="form-control discounttype discount_type<?php echo $counter; ?>" name="discount_type[<?php echo $counter; ?>]" data-discounttype="1" id="course<?php echo $counter; ?>"  >
                                                    <option value="">No Discount</option>
                                                    <option value="1" @if($fee_details_val->discount_type==1) selected @endif >Fixed Amount</option>
                                                    <option value="2" @if($fee_details_val->discount_type==2) selected @endif>Discount(%)</option>
                                            </select>                                  
                                        </div>
                                        <div class="form-group col-md-2 discount_data1 @if($fee_details_val->discount_type=='') d-none @endif">
                                            <label for="discount"><strong>Discount (on tuition fees) </strong></label>
                                            <input type="text" class="form-control discountval discount<?php echo $counter; ?>" name="discount[<?php echo $counter; ?>]" id="discount<?php echo $counter; ?>" value="{{$fee_details_val->discount}}" placeholder="Discount" data-discountval="1" @if($fee_details_val->discount !='') disabled="true" @endif>   
                                            <p class="text-danger">@error('discount'){{ $message }}@enderror </p>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="amount"><strong>Amount To Be Paid</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control amount<?php echo $counter; ?>" name="amount[<?php echo $counter; ?>]" id="amount<?php echo $counter; ?>" value="{{$fee_details_val->total_payable_amount}}"  placeholder="Final Amount" disabled="true">
                                            <p class="text-danger">@error('amount'){{ $message }}@enderror </p>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="installment_frequency"><strong>Installment Frequency <span style='color: red'>*</span></strong></label>
                                            <select class="form-control installment_frequency1" name="installment_frequency[<?php echo $counter; ?>]" id="installment_frequency<?php echo $counter; ?>" @if($fee_details_val->installment_frequency!='') disabled="true" @endif>
                                                 <option value="">Select Frequency</option>
                                                 <option value="1" @if($fee_details_val->installment_frequency==1) selected @endif >Monthly</option>
                                                 <option value="2" @if($fee_details_val->installment_frequency==2) selected @endif >Bimonthly</option>
                                                 <option value="4" @if($fee_details_val->installment_frequency==4) selected @endif >Quaterly</option>
                                                 <option value="6" @if($fee_details_val->installment_frequency==6) selected @endif >Half-Yearly</option>
                                            </select>
                                            
                                            <p class="text-danger"> @error('installment_frequency'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="total_installment"><strong>Total Installment <span style='color: red'>*</span></strong></label>
                                            <select class="form-control total_installment<?php echo $counter; ?>" id="total_installment<?php echo $counter; ?>" name="total_installment[<?php echo $counter; ?>]" @if($fee_details_val->total_installment!='') disabled="true" @endif>
                                                
                                                <option value="">Total Installment</option>
                                                <?php for ($i=1; $i < 31 ; $i++) {  ?>
                                                
                                                    <option value="{{$i}}" @if($fee_details_val->total_installment==$i) selected @endif >{{$i}}</option>
                                                <?php } ?>
                                            </select>                                            
                                            <p class="text-danger"> @error('total_installment'){{ $message }}  @enderror</p>
                                        </div>

                                        <div class="form-group col-md-4 ">
                                            <label for="intake_date"><strong>Intake Date<span style='color: red'>*</span></strong></label>
                                            <input type="text"  class="form-control startdate" name="intake_date[<?php echo $counter; ?>]" id="intake_date<?php echo $counter; ?>" placeholder="Enter End Date" @if($fee_details_val->intake_date!='') disabled="true" value="{{$fee_details_val->intake_date}}" @else value="{{old('intake_date')}}" @endif>
                                            <p class="text-danger">@error('intake_date'){{ $message }}@enderror</p>
                                        </div>


                                        <div class="form-group col-md-4 ">
                                            <label for="course_completion_date"><strong>Course Completion Date<span style='color: red'>*</span></strong></label>
                                            <input type="text"  class="form-control enddate" name="course_completion_date[<?php echo $counter; ?>]" id="course_completion_date<?php echo $counter; ?>" placeholder="Enter End Date" @if($fee_details_val->course_completion_date!='') disabled="true" value="{{$fee_details_val->course_completion_date}}" @else value="{{old('course_completion_date')}}" @endif>
                                            <p class="text-danger">@error('course_completion_date'){{ $message }}@enderror</p>
                                        </div>


                                      <div class="form-group col-md-2">
                                            <button type="button" class="btn btn-outline-info removecourses" data-course_detail_id="{{$fee_details_val->id}}" data-course_user_id="{{$fee_details_val->user_id}}" style="margin-top:32px">
                                                <i class="fa fa-minus-circle" aria-hidden="true"></i> Remove
                                            </button>                                          
                                        </div>

                                        <div class="information_message{{$fee_details_val->id}}"></div>
                                    </div>
                                <input type="hidden" value="<?php echo $fee_details_val->id; ?>" name="course_fees_id[<?php echo $counter; ?>]">

                                        <?php
                                        $counter++;
                                            }
                                        ?>
                                            </div>  
                                        <?php
                                        }
                                        else
                                        {
                                            ?>

                                            <div class="cloning_section">
                                            <div class="append_section row">                                        
                                        <div class="form-group col-md-5">
                                            <label for="college"><strong>College <span style='color: red'>*</span></strong></label>
                                            <select class="form-control college" name="college[1]" id="college" data-collegeid="1">
                                                <option value="">Please Select College </option>
                                                <?php if($get_colleges){
                                                    foreach ($get_colleges as $key => $get_college) { ?>
                                                        <option value="{{$get_college->id}}">{{$get_college->college_trading_name}}</option>
                                                   <?php } } ?> 
                                            </select>
                                            <p class="text-danger">@error('college'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="course"><strong>Course <span style='color: red'>*</span></strong></label>
                                            <select class="form-control collegeCourse1 selectcourses" name="course[1]" id="course" data-course_id="1">
                                                <option value="">Please Select College First</option>
                                                <?php if($get_courses){
                                                    foreach ($get_courses as $key => $get_course) { ?>
                                                        <option value="{{$get_course->id}}">{{$get_course->course_name}}</option>
                                                   <?php } } ?>
                                            </select>
                                            <p class="text-danger">@error('course'){{ $message }} @enderror</p>
                                        </div>

                                        <div class="form-group col-md-2 show_current_course_checkobx">
                                            <label for="course"><strong>Current Course <span style='color: red'>*</span></strong></label>
                                            <input type="radio" name="currentcourse" class="current_course" data-curr_courseid="1" checked>
                                            <input type="hidden" class="current_course" id="current_course1" name="current_course[1]" value="1">

                                        </div>
                                        <div style="clear:both;">&nbsp;</div>


                                        <div class="form-group col-md-5">
                                            <label for="course"><strong>Campuses <span style='color: red'>*</span></strong></label>
                                            <select class="form-control selectcampuses1 CourseCampuses" name="campuses[1]" id="campus" data-campuses_id="1">
                                                <option value="">Please Select Course First</option>

                                            </select>
                                            <p class="text-danger">@error('campus'){{ $message }} @enderror</p>
                                        </div>                                          

                                        <div class="form-group col-md-2">
                                            <label for="admission_fees"><strong>Admission fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control admission_fees1" id="admission_fees" name="admission_fees[1]" placeholder="Admission fees" readonly>
                                            <p class="text-danger">@error('admission_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="material_fees"><strong>Material fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control material_fees1" id="material_fees" name="material_fees[1]" placeholder="Material fees" readonly>
                                            <p class="text-danger">@error('material_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="tuition_fees"><strong>Tuition fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control tuition_fees1" id="tuition_fees" name="tuition_fees[1]" placeholder="Tuition fees" readonly>
                                            <p class="text-danger">@error('tuition_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="course_fee"><strong>Course total fee</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control course_fee1" id="course_fee" name="fees[1]" placeholder="Course fee" readonly>
                                            <p class="text-danger">@error('fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="discount"><strong>Discount Type</strong></label>
                                            <select class="form-control discounttype discount_type1" name="discount_type[1]" data-discounttype="1" id="course"  >
                                                    <option value="">No Discount</option>
                                                    <option value="1">Fixed Amount</option>
                                                    <option value="2">Discount(%)</option>
                                            </select>                                  
                                        </div>
                                        <input type="hidden" value="0" name="course_fees_id[1]">
                                        <div class="form-group col-md-2 discount_data1 @if($get_student->discount_type=='') d-none @endif">
                                            <label for="discount"><strong>Discount (on tuition fees) </strong></label>
                                            <input type="text" class="form-control discountval discount1" id="discount1" name="discount[1]" placeholder="Discount" data-discountval="1">   
                                            <p class="text-danger">@error('discount'){{ $message }}@enderror </p>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="amount"><strong>Amount To Be Paid</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control amount1" id="amount1" name="amount[1]"  placeholder="Final Amount" readonly>
                                            <p class="text-danger">@error('amount'){{ $message }}@enderror </p>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="installment_frequency"><strong>Installment Frequency <span style='color: red'>*</span></strong></label>
                                            <select class="form-control installment_frequency1" name="installment_frequency[1]" id="installment_frequency">
                                                 <option value="">Select Frequency</option>
                                                 <option value="1">Monthly</option>
                                                 <option value="2">Bimonthly</option>
                                                 <option value="4">Quarterly</option>
                                                 <option value="6">Half-Yearly</option>
                                            </select>
                                            
                                            <p class="text-danger"> @error('installment_frequency'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="total_installment"><strong>Total Installment <span style='color: red'>*</span></strong></label>
                                            <select class="form-control total_installment1" name="total_installment[1]" id="total_installment">
                                                
                                                <option value="">Total Installment</option>
                                                <?php for ($i=1; $i < 31 ; $i++) {  ?>
                                                
                                                    <option value="{{$i}}" @if($get_student->total_installment==$i) selected @endif >{{$i}}</option>
                                                <?php } ?>
                                            </select>                                            
                                            <p class="text-danger"> @error('total_installment'){{ $message }}  @enderror</p>
                                        </div>

                                        <div class="form-group col-md-4 ">
                                            <label for="intake_date"><strong>Intake Date <span style='color: red'>*</span></strong></label>
                                            <input type="text"  class="form-control startdate" id="intake_date" placeholder="Enter End Date" name="intake_date[1]">
                                            <p class="text-danger">@error('intake_date'){{ $message }}@enderror</p>
                                        </div>


                                        <div class="form-group col-md-4 ">
                                            <label for="course_completion_date"><strong>Course Completion Date<span style='color: red'>*</span></strong></label>
                                            <input type="text"  class="form-control enddate" name="course_completion_date[1]" id="course_completion_date" placeholder="Course Completion Date" value="">
                                            <p class="text-danger">@error('course_completion_date'){{ $message }}@enderror</p>
                                        </div>


                                      <div class="form-group col-md-2">
                                            <button type="button" class="btn btn-outline-info remove2 d-none">
                                                <i class="fa fa-minus-circle" aria-hidden="true"></i> Remove
                                            </button>                                          
                                        </div>
                                    </div>
                                </div>  

                                            <?php
                                        }
                                        ?>
                                        

                                        <input type="hidden" name="student_id" value="{{$get_student->sid}}">

                                           <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-outline-info addmorebtn clone2">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Add More
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-outline-info">Update Student</button>
                                </form>    
                            </div>
                        </div>
                    </div>                        
                </section> 
            </div>
        </div>            
    </div>  


<style type="text/css">
    .iti--allow-dropdown input, .iti--allow-dropdown input[type=text], .iti--allow-dropdown input[type=tel], .iti--separate-dial-code input, .iti--separate-dial-code input[type=text], .iti--separate-dial-code input[type=tel] {
    padding-right: 6px;
    padding-left: 95px !important;
    margin-left: 0;
    width: 386px !important;
}
</style>



    <script type="text/javascript">        
        $(".chckright").click(function () {
            var data = $(this).attr("data-type");
            if ($(this).is(":checked")) {                
                $("."+data).removeClass('d-none');
            } else {
                $("."+data).addClass('d-none');
            }
        });    
    </script>

<script type="text/javascript">        
    $(".addothercourse").click(function () {
        var data = $(this).attr("data-type");
        if ($(this).is(":checked")) {                
            $("."+data).removeClass('d-none');
        } else {
            $("."+data).addClass('d-none');
        }
    });    
</script>


    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('change','.college', function(){
                var college_id = $(this).val();   
                var college_data = $(this).attr('data-collegeid');

                $('.admission_fees'+college_data).val('');
                $('.material_fees'+college_data).val('');
                $('.tuition_fees'+college_data).val('');
                $('.course_fee'+college_data).val('');
                $('.amount'+college_data).val('');

                 $('.selectcampuses'+college_data).html('<option value="">Select College First</option>');

                if(college_id != '')
                {
                  $('.installment_frequency'+college_data).attr('required', true);
                  $('.total_installment'+college_data).attr('required', true);
                  $('.selectcampuses'+college_data).attr('required', true);
                }
                else
                {
                  $('.installment_frequency'+college_data).attr('required', false);
                  $('.total_installment'+college_data).attr('required', false);
                  $('.selectcampuses'+college_data).attr('required', false);
                }   

                //alert(college_data);
                  
                $.ajax({
                    url: "{{route('get_collegeCourses')}}",
                    type: "post",                    
                    data:{"_token": "{{ csrf_token() }}",college_id:college_id}, 
                    success: function (response) {
                        //alert(response);
                        //$('.collegeCourse').html(response);                        
                        $('.collegeCourse'+college_data).html(response);                        
                    },                    
                });                
            });



            $(document).on('change','.selectcourses', function(){
                var course_id = $(this).val();                  
                var course_data = $(this).attr('data-course_id');
                //alert(course_id);

                $('.admission_fees'+course_data).val('');
                $('.material_fees'+course_data).val('');
                $('.tuition_fees'+course_data).val('');
                $('.course_fee'+course_data).val('');
                $('.amount'+course_data).val('');
                  
                $.ajax({
                    url: "{{route('CoursesCampuses')}}",
                    type: "post",                    
                    data:{"_token": "{{ csrf_token() }}",course_id:course_id}, 
                    success: function (response) {
                        //alert(response);
                        //$('.collegeCourse').html(response);                        
                        $('.selectcampuses'+course_data).html(response);                        
                    },                    
                });                
            });

        });

        $(document).ready(function(){
            $('.material_fees').on('keyup', function(){
                var fees = $(this).val();   
                //alert(fees);                            
            });
        });

        $(document).ready(function(){
            /*$(document).on('change','.collegeCourse', function(){*/
            $(document).on('change','.CourseCampuses', function(){
                var campus_data = $(this).attr('data-campuses_id');
                var total_discount = 0;
                var discount_type = $('.discount_type'+campus_data).val();
                var campus_id = $(this).val();   
                var scholarship = $('#discount'+campus_data).val();

                //alert(campus_data);
                $.ajax({
                    url: "{{route('get_courseFees')}}",
                    type: "POST",
                    dataType: "json",                    
                    data:{"_token": "{{ csrf_token() }}",campus_id:campus_id}, 
                    success: function (response) {

                        console.log(response);

                        /*$('.admission_fees').val(response.admission_fees);
                        $('.material_fees').val(response.material_fees);
                        $('.tuition_fees').val(response.tuition_fees);
                        $('.course_fee').val(response.course_fee);*/

                        $('.admission_fees'+campus_data).val(response.admission_fees);
                        $('.material_fees'+campus_data).val(response.material_fees);
                        $('.tuition_fees'+campus_data).val(response.tuition_fees);
                        $('.course_fee'+campus_data).val(response.course_fee);

                        var fees = response.tuition_fees;

                        if(discount_type!='' && scholarship!='')
                        {
                            if(discount_type==2)
                            {

                                if(scholarship > 100)
                                {
                                    alert('Discount can not be more then 100.');
                                    $('#discount'+campus_data).val("");
                                    $('#amount'+campus_data).val(response.course_fee);
                                    return false;
                                }
                            }
                            else if(discount_type==1)
                            {

                                if(parseInt(scholarship) > parseInt(fees))
                                {
                                    alert('Discount can not be greater than Tuition fees.');
                                    $('#discount'+campus_data).val("");
                                    $('#amount'+campus_data).val(response.course_fee);
                                    return false;
                                }
                            }
                            

                            if(discount_type==1)
                            {
                                total_discount = scholarship;
                            }
                            else
                            {
                                total_discount = (scholarship/100) * fees;
                            }
                        }

                        $('#amount'+campus_data).val(response.course_fee-total_discount);
                    },                    
                });                
            });
        });

        $(document).ready(function(){
            $(document).on('change keyup','.discountval',function(){ 
                
                var discountval = $(this).attr('data-discountval'); 
                //alert(discountval);
                var scholarship = $('#discount'+discountval).val();
                var discount_type = $('.discount_type'+discountval).val();
                var course_fee = $('.course_fee'+discountval).val();
                if(discount_type=='')
                {
                    alert('Please select Discount type first');
                    $('#discount'+discountval).val("");
                    return false;
                }

                if(scholarship != '')
                {
                    var scholarship = scholarship;   
                }
                else
                {
                   var scholarship = 0;
                }

                if($.isNumeric(scholarship)){
                    var fees = $('.tuition_fees'+discountval).val();



                    if(discount_type==2)
                    {

                        if(scholarship > 100)
                        {
                            alert('Discount can not be more then 100.');
                            $('#discount'+discountval).val("");
                            $('#amount'+discountval).val(fees);
                            return false;
                        }
                    }
                    else if(discount_type==1)
                    {

                        if(parseInt(scholarship) > parseInt(fees))
                        {
                            alert('Discount can not be greater than Tuition fees.');
                            $('#discount'+discountval).val("");
                            $('#amount'+discountval).val(fees);
                            return false;
                        }
                    }

                    

                    if(discount_type==1)
                    {
                        var total_discount = scholarship;
                    }
                    else
                    {
                        var total_discount = (scholarship/100) * fees;
                    }

                     //alert(course_fee);

                    total_amt = course_fee-total_discount;
                    


                    $('#amount'+discountval).val(total_amt);
                }else{
                    return false;
                }               
                                               
            }); 

            $(document).on('change','.discounttype',function(){ 

                var total_discount = 0;
                var discounttype_id = $(this).attr('data-discounttype');
                var scholarship = $('#discount'+discounttype_id).val();
                var discount_type = $('.discount_type'+discounttype_id).val();
                var course_fee = $('.course_fee'+discounttype_id).val();
                if(discount_type=='')
                {
                    $('#discount'+discounttype_id).val("");
                    $('.discount_data'+discounttype_id).addClass('d-none');
                    $('#amount'+discounttype_id).val(course_fee);
                    return false;
                }

                $('.discount_data'+discounttype_id).removeClass('d-none');

                if(scholarship != '')
                {
                    var scholarship = scholarship;   
                }
                else
                {
                   var scholarship = 0;
                }

                if($.isNumeric(scholarship)){
                    var fees = $('.tuition_fees'+discounttype_id).val();


                    if(discount_type==2)
                    {
                        //alert(fees);
                        if(scholarship > 100)
                        {
                            alert('Discount can not be more then 100.');
                            $('#discount'+discounttype_id).val("");
                            $('#amount'+discounttype_id).val(fees);
                            return false;
                        }
                    }
                    else if(discount_type==1)
                    {

                        if(parseInt(scholarship) > parseInt(fees))
                        {
                            alert('Discount can not be greater than Tuition fees.');
                            $('#discount'+discounttype_id).val("");
                            $('#amount'+discounttype_id).val(fees);
                            return false;
                        }
                    }

                    

                    if(discount_type==1)
                    {
                        total_discount = scholarship;
                    }
                    else
                    {
                        total_discount = (scholarship/100) * fees;
                    }


                    total_amt = course_fee-total_discount;
                    

                    $('#amount'+discounttype_id).val(total_amt);
                }else{
                    return false;
                }               
                                               
            });


            
            $(document).on('click change','.current_course',function()            
            {
                var curr_courseid = $(this).data("curr_courseid");
                $('.current_course').val(0);
                $('#current_course'+curr_courseid).val(1);
            });


        });

    </script>

    <script>
        $(".custom-file-input").on("change", function() {
             var data = $(this).attr("data_id");
            var fileName = $(this).val().split("\\").pop();            
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

            $('.'+data).val(fileName);


            var name = $(this).attr("name");
            // alert(name);
            $('.old_passport_file').attr(("name"))


        });
    </script>

    <script type="text/javascript">        
        $("#referral").change(function () {
            var data = $("#referral").val();
            
            if(data == 'Others'){ 
                $('.otherReferral').removeClass('d-none');
            }else{
                $('.otherReferral').addClass('d-none')
            }
        });    
    </script>

    <script type="text/javascript">        
        $("#purpose").change(function () {
            var data = $("#purpose").val();
            
            if(data == 'Other Services'){ 
                $('.otherPurpose').removeClass('d-none');
            }else{
                $('.otherPurpose').addClass('d-none')
            }
        });    
    </script>


<script src="{{ asset('admin/js/intlTelInput.js') }}"></script>
<link href="{{ asset('admin/css/intlTelInput.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/isValidNumber.css') }}" rel="stylesheet">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet"> 


<script type="text/javascript">
var inputs_one1 = document.querySelector("#phone"),
  errorMsgs = document.querySelector("#error-msg"),
  validMsgs = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMaps = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var itis1 = window.intlTelInput(inputs_one1, {
  utilsScript: "{{ asset('admin/js/intlTelInput.js') }}"
});

var reset = function() {
  inputs_one1.classList.remove("error"); 
};

<?php if($get_student->phone_flag != '' && $get_student->phone_dialcode != ''){?>
$('.phone_number .thereismeta').addClass('<?php echo $get_student->phone_flag; ?>');
$('.phone_number .iti__selected-dial-code').html('<?php echo $get_student->phone_dialcode; ?>');
<?php } else { ?>
$('.phone_number .thereismeta').addClass('iti__au');
$('.phone_number .iti__selected-dial-code').html('61');
<?php } ?>

// on blur: validate
inputs_one1.addEventListener('blur', function() {

  reset();
  
  if (inputs_one1.value.trim()) {
    console.log(itis1.isValidNumber());
  /*  if (itis.isValidNumber()) {
      alert('2');*/
      var messages_code1 = itis1.selectedFlagInner.className;
      console.log(messages_code1);
      var res1 = messages_code1.replace("iti__flag","");

      var dialcode1 = itis1.selectedCountryData.dialCode;
     
       console.log('flag'+res1);
       console.log('dialcode'+dialcode1);
      $('.phone_flag').val(res1);
      $('.phone_dialcode').val(dialcode1);   
    
  }
});

// on keyup / change flag: reset
inputs_one1.addEventListener('change', reset);
inputs_one1.addEventListener('keyup', reset);

 
</script>

<script type="text/javascript">
var inputs_two = document.querySelector("#whatsapp"),
  errorMsgs = document.querySelector("#error-msg"),
  validMsgs = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMaps = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
var itis = window.intlTelInput(inputs_two, {
  utilsScript: "{{ asset('admin/js/intlTelInput.js') }}"
});

var reset = function() {
  inputs_two.classList.remove("error"); 
};

/*$('.whatsapp .thereismeta').addClass('<?php echo $get_student->whatsapp_flag; ?>');
$('.whatsapp .iti__selected-dial-code').html('<?php echo $get_student->whatsapp_dialcode; ?>');*/

<?php if($get_student->whatsapp_flag != '' && $get_student->whatsapp_dialcode != ''){?>
$('.whatsapp .thereismeta').addClass('<?php echo $get_student->whatsapp_flag; ?>');
$('.whatsapp .iti__selected-dial-code').html('<?php echo $get_student->whatsapp_dialcode; ?>');
<?php } else { ?>
$('.whatsapp .thereismeta').addClass('iti__au');
$('.whatsapp .iti__selected-dial-code').html('61');
<?php } ?>

// on blur: validate
inputs_two.addEventListener('blur', function() {

  reset();
  
  if (inputs_two.value.trim()) {
    console.log(itis.isValidNumber());
  /*  if (itis.isValidNumber()) {
      alert('2');*/
      var messages_code = itis.selectedFlagInner.className;
      console.log(messages_code);
      var res = messages_code.replace("iti__flag","");

      var dialcode = itis.selectedCountryData.dialCode;
      //alert(res);
      //alert(dialcode);
       console.log('flag'+res);
       console.log('dialcode'+dialcode);
      $('.whatsapp_flag').val(res);
      $('.whatsapp_dialcode').val(dialcode);   
    
  }
});

// on keyup / change flag: reset
inputs_two.addEventListener('change', reset);
inputs_two.addEventListener('keyup', reset);

 
</script>

<script type="text/javascript">
    $(document).ready(function(){
        var j=<?php echo $counter; ?>;
    $(".clone2").click(function(){
        j++;
        $(".cloning_section").append('<div class="append_section row"><div class="form-group col-md-4"><label for="college"><strong>College <span style="color: red">*</span></strong></label><select class="form-control college" name="college['+j+']" id="college['+j+']" data-collegeid="'+j+'"><option value="">Please Select College </option><?php if($get_colleges){
                                                    foreach ($get_colleges as $key => $get_college) { ?>
                                                        <option value="<?php echo $get_college->id; ?>"><?php echo $get_college->college_trading_name; ?></option><?php } } ?></select><p class="text-danger">@error("college")<?php echo $message ?>@enderror</p></div><div class="form-group col-md-4"><label for="course"><strong>Course <span style="color: red">*</span></strong></label><select class="form-control  collegeCourse'+j+' selectcourses" name="course['+j+']" id="course['+j+']" data-course_id="'+j+'"><option value="">Please Select College First</option></select><p class="text-danger">@error("course")<?php echo $message ?> @enderror</p></div><div class="form-group col-md-2 show_current_course_checkobx d-none"> <label for="course"><strong>Current Course <span style="color: red">*</span></strong></label><input type="radio" name="currentcourse" class="current_course" data-curr_courseid="'+j+'" ><input type="hidden" class="current_course" id="current_course'+j+'" name="current_course['+j+']" value="0"></div><div style="clear:both;">&nbsp;</div><div class="form-group col-md-5"><label for="course"><strong>Campuses <span style="color: red">*</span></strong></label><select class="form-control selectcampuses'+j+' CourseCampuses" name="campuses['+j+']" id="campus" data-campuses_id="'+j+'"><option value="">Please Select Course First</option><option value=""></option></select><p class="text-danger">@error("campus")<?php echo $message ?> @enderror</p></div><div class="form-group col-md-2"><label for="fees"><strong>Admission Fees</strong> (in $) <strong><span style="color: red">*</span></strong></label><input type="text" class="form-control admission_fees'+j+'" id="fees'+j+'" value="" name="admission_fees['+j+']" placeholder="Admission Fees" readonly><p class="text-danger">@error("fees")<?php echo $message; ?>@enderror</p></div><div class="form-group col-md-2"><label for="material_fees"><strong>Material fees</strong> (in $) <strong><span style="color: red">*</span></strong></label><input type="text" class="form-control material_fees'+j+'" id="material_fees'+j+'" value="" name="material_fees['+j+']" placeholder="Material fees" readonly><p class="text-danger">@error("material_fees")<?php echo $message; ?>@enderror</p></div><div class="form-group col-md-2"><label for="tuition_fees"><strong>Tuition fees</strong> (in $) <strong><span style="color: red">*</span></strong></label><input type="text" class="form-control tuition_fees'+j+'" id="tuition_fees'+j+'" value="" name="tuition_fees['+j+']" placeholder="Tuition fees" readonly><p class="text-danger">@error("tuition_fees")<?php echo $message; ?>@enderror</p></div><div class="form-group col-md-2"><label for="course_fee"><strong>Course total fee</strong> (in $) <strong><span style="color: red">*</span></strong></label><input type="text" class="form-control course_fee'+j+'" id="course_fee'+j+'" value="" name="fees['+j+']" placeholder="Course fee" readonly><p class="text-danger">@error("fees")<?php echo $message; ?>@enderror</p></div><div class="form-group col-md-2"><label for="discount"><strong>Discount Type</strong></label><select class="form-control discounttype discount_type'+j+'" data-discounttype="'+j+'" name="discount_type['+j+']" id="course'+j+'"><option value="">No Discount</option><option value="1" >Fixed Amount</option><option value="2">Discount(%)</option></select></div><div class="form-group col-md-2 discount_data'+j+' d-none"><label for="discount"><strong>Discount (on tuition fees) </strong></label><input type="text" class="form-control discountval discount'+j+'" id="discount'+j+'" value="" name="discount['+j+']" placeholder="Discount" data-discountval="'+j+'" ><p class="text-danger">@error("discount")<?php echo  $message; ?>@enderror </p></div><div class="form-group col-md-3"><label for="amount"><strong>Amount To Be Paid</strong> (in $) <strong><span style="color: red">*</span></strong></label><input type="text" class="form-control amount'+j+'" id="amount'+j+'" value="" name="amount['+j+']"  placeholder="Final Amount" readonly><p class="text-danger">@error("amount")<?php echo $message; ?>@enderror </p></div><div class="form-group col-md-3"><label for="installment_frequency"><strong>Installment Frequency <span style="color: red">*</span></strong></label><select class="form-control" name="installment_frequency['+j+']" id="installment_frequency" required><option value="">Select Frequency</option><option value="1"  >Monthly</option><option value="2"  >Bimonthly</option><option value="4"  >Quarterly</option><option value="6"  >Half-Yearly</option></select><p class="text-danger"> @error("installment_frequency")<?php echo $message; ?>@enderror</p></div><div class="form-group col-md-2"><label for="total_installment"><strong>Total Installment <span style="color: red">*</span></strong></label><select class="form-control" name="total_installment['+j+']" id="total_installment'+j+'" required><option value="">Total Installment</option><?php for ($i=1; $i < 31 ; $i++) {  ?><option value="<?php echo $i; ?>"  ><?php echo $i; ?></option> <?php } ?></select><p class="text-danger"> @error("total_installment")<?php echo $message; ?> @enderror</p></div><div class="form-group col-md-4 "><label for="intake_date"><strong>Intake Date <span style="color: red">*</span></strong></label><input type="text"  class="form-control startdate_'+j+'" id="intake_date" placeholder="Enter End Date" name="intake_date['+j+']"><p class="text-danger">@error("intake_date")<?php echo $message; ?>@enderror</p></div><div class="form-group col-md-4 "><label for="course_completion_date"><strong>Course Completion Date<span style="color: red">*</span></strong></label><input type="text"  class="form-control enddate_'+j+'" name="course_completion_date['+j+']" id="course_completion_date'+j+'" placeholder="Course Completion Date" value=""><p class="text-danger">@error("course_completion_date") <?php echo $message; ?> @enderror</p></div><input type="hidden" value="0" name="course_fees_id['+j+']"><div class="form-group col-md-2"><button type="button" class="btn btn-outline-info remove2"><i class="fa fa-minus-circle" aria-hidden="true"></i> Remove</button></div></div>');        
                                                            $('.show_current_course_checkobx').removeClass('d-none');  


                                                            $(".startdate_"+j).datepicker({
                                                                todayBtn:  1,
                                                                autoclose: true,
                                                                format: 'dd-mm-yyyy',
                                                            }).on('changeDate', function (selected) {
                                                                var minDate = new Date(selected.date.valueOf());
                                                                $('.enddate_'+j).datepicker('setStartDate', minDate);
                                                            });



                                                            $(".enddate_"+j).datepicker({
                                                                autoclose: true,
                                                                format: 'dd-mm-yyyy',
                                                            })
                                                            .on('changeDate', function (selected) {
                                                                var minDate = new Date(selected.date.valueOf());
                                                                $('.startdate_'+j).datepicker('setEndDate', minDate);
                                                            });         


        
                                                    });

    $(document).on('click','.remove2',function(){
        $(this).parent().parent().remove();
    });

    

$(document).ready(function(){
    $(document).on('click', '.removecourses', function(){        
        var course_detail_id = $(this).attr('data-course_detail_id');
        var course_user_id = $(this).attr('data-course_user_id');
        swal({
        title: "Are you sure?",
        text: "Once Remove, you will not be able to Decline!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes do it",
        closeOnConfirm: true,
    },
    function(){
        $.ajax({
            type:'POST',
            url:"{{ route('course_detail_remove') }}",
            data:{"_token": "{{ csrf_token() }}",course_detail_id:course_detail_id,course_user_id:course_user_id},
            success:function(data)
            {    
                if(data == 'current_course')
                {
                    $('.information_message'+course_detail_id).html('<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button> <strong>You can not delete current course. Please make another course as a current course for the student first.</strong></div>');                           
                }
                else if(data == 'cantremove')
                {
                    $('.information_message'+course_detail_id).html('<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button> <strong>You have already taken fees for this course so can not be remove. you may change only current course of the student for now. </strong></div>');
                }

                 else if(data == 'all_course_removed')
                {                    
                    $('.course_section'+course_detail_id).css('background','tomato');
                    $('.course_section'+course_detail_id).fadeOut(800,function(){
                    $(this).remove();      
                    }); 

                     window.location.href = window.location.href;
                }

                else if(data == 'course_removed')
                {                 
                    $('.course_section'+course_detail_id).css('background','tomato');
                    $('.course_section'+course_detail_id).fadeOut(800,function(){
                    $(this).remove();      
                    }); 

                    window.location.href = window.location.href;
                }

            }

        });

         });

    });
});



jQuery(function ($) {        
  $('#update_student_other_detail').bind('submit', function () {
    $(this).find(':input').prop('disabled', false);
  });
});


$(".startdate").datepicker({
todayBtn:  1,
autoclose: true,
format: 'dd-mm-yyyy',
}).on('changeDate', function (selected) {
var minDate = new Date(selected.date.valueOf());
$('.enddate').datepicker('setStartDate', minDate);
});



$(".enddate").datepicker({
autoclose: true,
format: 'dd-mm-yyyy',
})
.on('changeDate', function (selected) {
var minDate = new Date(selected.date.valueOf());
$('.startdate').datepicker('setEndDate', minDate);
}); 

});




 

</script>

@endsection
