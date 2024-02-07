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
                                <form action="{{ route('/staff/migration_student_detail') }}" method="post" enctype="multipart/form-data" id="update_student_other_detail">
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
                                        <div class="form-group col-md-6">
                                            <label for="referral"><strong>Referral </strong></label>
                                            <select class="form-control"  name="referral" id="referral">
                                                <option value="">Please Select</option>
                                                <option <?php if($get_student->referral == 'Google'){?> selected <?php } ?> value="Google">Google</option>
                                                <option <?php if($get_student->referral == 'Social Media'){?> selected <?php } ?> value="Social Media">Social Media</option>
                                                <option <?php if($get_student->referral == 'Others'){?> selected <?php } ?> value="Others">Others</option>
                                            </select>
                                            <div class="form-group col-md-12 otherReferral <?php if($get_student->referral != 'Others') {?> d-none <?php } ?>">
                                                <input class="form-control" type="text" placeholder="Please specify other referral" value="{{$get_student->other_referral}}" name="other_referral">
                                            </div> 
                                        </div>
                                        <div class="form-group col-md-6">
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
                                    </div>

                                  

                                    <input type="hidden" name="student_id" value="<?php echo $get_student->sid; ?>">
                                     <div class="form-group">
                                        <label><strong>Other Images <span style='color: red'>*</span></strong></label>
                                            <input type="file" class="form-control" id="other_images" name="other_images[]" multiple>
                                            <br>
                                            <?php

                                            if($get_student->migration_other_images)
                                            {
                                            $other_imgs = explode(',', $get_student->migration_other_images);

                                            if($other_imgs) 
                                            {
                                              
                                              foreach ($other_imgs as $key => $img_value)
                                                {
                                                     $info = pathinfo($img_value);
                                                      $x_img = pathinfo($img_value, PATHINFO_FILENAME);
                                              if($info["extension"] == "doc" || $info["extension"] == "docx" )
                                              { 

                                                ?>
                                                <div class="image_section removesection<?php echo $x_img; ?>">
                                               <i class="fa fa-times removeimg" data-userid="<?php echo $get_student->sid; ?>" data-imgname="<?php echo $img_value; ?>"></i>


                                               <div class="iframediv">
                                                <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/images/migration_other_images/'.$img_value); ?>&embedded=true" width="100" height="100" title=""></iframe>  
                                            </div>
                                            </div>
                                                <?php                                                
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="image_section removesection<?php echo $x_img; ?>">
                                                <i class="fa fa-times removeimg" data-userid="<?php echo $get_student->sid; ?>" data-imgname="<?php echo $img_value; ?>"></i>
                                                 <img src="<?php echo url('/images/migration_other_images/'.$img_value); ?>" title="" width="100" height="100">
                                             </div>
                                                <?php
                                            }
                                         }
                                        }
                                    }
                                            ?>                                        
                                        </div>
                                 <div style="float: left; width:100%">
                                    <input type="submit" name="submit" value="submit" class="btn btn-primary">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>    

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet"> 


<style type="text/css">
    .iti--allow-dropdown input, .iti--allow-dropdown input[type=text], .iti--allow-dropdown input[type=tel], .iti--separate-dial-code input, .iti--separate-dial-code input[type=text], .iti--separate-dial-code input[type=tel] {
    padding-right: 6px;
    padding-left: 95px !important;
    margin-left: 0;
    width: 386px !important;
}
</style>



    <script type="text/javascript">   

         $(document).ready(function(){
            $(document).on('click','.removeimg', function(){

             var userid = $(this).data("userid");
             var image_name = $(this).data("imgname");

             var imagename = image_name.replace(/\.[^/.]+$/, "");

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
                    url: "{{route('/staff/remove_migration_image')}}",
                    type: "post",                    
                    data:{"_token": "{{ csrf_token() }}",userid:userid,image_name:image_name}, 
                    success: function (response) {
                       
                        $('.removesection'+imagename).css('background','tomato');
                        $('.removesection'+imagename).fadeOut(800); 
                    },                    
                }); 

            });
        });
      });      



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

<style type="text/css">
   .image_section .fa{
    width: 25px;
    height: 25px;
    background: #000;
    color: #fff;
    border-radius: 50%;
    padding: 6px 7px;
    position: absolute;
    left: -11px;
    top: -11px;
}
.image_section
{
    position: relative;
    float: left;
    margin-right: 20px;
}
</style>

@endsection
