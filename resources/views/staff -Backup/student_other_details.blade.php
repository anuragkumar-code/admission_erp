@extends('staff.layout.head')
@section('staff')
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
                                <form action="{{ route('staff_update_other_details') }}" method="post" enctype="multipart/form-data" id="other_details_form">
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
                                            <input type="date"   max="<?php echo date("Y-m-d"); ?>" class="form-control" id="dob" value="{{$get_student->dob}}" placeholder="Enter D.O.B" name="dob">
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
                                                    <option value="">Select Gender</option>
                                                    <option <?php if($get_student->gender == 'Male') {?> selected <?php } ?> value="Male">Male</option>
                                                    <option <?php if($get_student->gender == 'Female') {?> selected <?php } ?> value="Female">Female</option>
                                                    <option <?php if($get_student->gender == 'Others') {?> selected <?php } ?> value="Others">Others</option>
                                                </select>
                                            <p class="text-danger">@error('gender'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email"><strong>Email Address <span style='color: red'>*</span></strong></label>
                                            <input type="email" class="form-control" id="email" value="{{$get_student->email}}" placeholder="Enter Email address" name="email" readonly>
                                            <p class="text-danger">@error('email'){{ $message }} @enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="phone"><strong>Phone Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="phone" value="{{$get_student->phone}}" placeholder="Enter Phone Number" name="phone" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger"> @error('phone'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="emergency_phone"><strong>Emergency Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="emergency_phone" value="{{$get_student->emergency_phone}}" placeholder="Enter Emergency Contact" name="emergency_phone" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger">@error('emergency_phone'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="purpose"><strong>Purpose of Visit <span style='color: red'>*</span></strong></label>
                                            <select class="form-control"  name="purpose" id="purpose">
                                                <option value="">Select Purpose</option> 
                                                <option <?php if($get_student->purpose == 'TR') {?> selected <?php } ?> value="TR">TR</option>
                                                <option <?php if($get_student->purpose == 'PR') {?> selected <?php } ?> value="PR">PR</option>
                                                <option <?php if($get_student->purpose == 'Other Services') {?> selected <?php } ?> value="Other Services">Other Services</option>
                                            </select>
                                            <div class="form-group col-md-12 otherPurpose <?php if($get_student->purpose != 'Other Services') {?> d-none <?php } ?>">
                                                <input class="form-control" type="text" placeholder="Please specify other puprpose" value="{{$get_student->other_purpose}}" name="other_purpose">
                                            </div>              
                                            <p class="text-danger">@error('purpose'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="referral"><strong>Referral </strong></label>
                                            <select class="form-control"  name="referral" id="referral">
                                                <option value="">Select Referral</option>
                                                <option <?php if($get_student->referral == 'Google') {?> selected <?php } ?> value="Google">Google</option>
                                                <option <?php if($get_student->referral == 'Social Media') {?> selected <?php } ?> value="Social Media">Social Media</option>
                                                <option <?php if($get_student->referral == 'Others Specified') {?> selected <?php } ?> value="Others Specified">Others Specified</option>
                                            </select> 
                                            <div class="form-group col-md-12 otherReferral <?php if($get_student->referral != 'Others Specified') {?> d-none <?php } ?>">
                                                <input class="form-control" type="text" placeholder="Please specify other referral" value="{{$get_student->other_referral}}" name="other_referral">
                                            </div>                                           
                                        </div>
                                        <div class="form-group col-md-6">
                                        </div>

                                        {{-------------------------Form 2---------------------}}
                                        
                                            <h4>Other Details</h4>
                                            <br> <br>
                                            <div class="col-lg-12 col-md-12 chckstrip">
                                                <input type="checkbox" id="chkPassport"  @if($get_student->passport_file != '') checked @endif value="1" {{ old('chkPassport') == '1' ? 'checked' : ''}}  name="chkPassport" class="chckright" data-type="passportchkDiv"/>
                                                <strong><b>Passport</b></strong>
                                            </div>                                                   
                                            <div class="form-group col-md-4 passportchkDiv @if($get_student->passport_file != '' || old('chkPassport') == '1') @else d-none @endif">
                                                <label for="passport_number"><strong>Passport Number <span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control" id="passport_number"  @if ($get_student->passport_number != '')  value ="{{$get_student->passport_number}}" @else value="{{old('passport_number')}}" @endif placeholder="Enter Passport Number" name="passport_number">
                                                <p class="text-danger">@error('passport_number'){{ $message }}@enderror</p>
                                            </div>
                                            <div class="form-group col-md-4 passportchkDiv @if($get_student->passport_file != '' || old('chkPassport') == '1') @else d-none @endif">
                                                <label for="passport_expiry_date"><strong>Expiry Date <span style='color: red'>*</span></strong></label>
                                                <input type="date" min="{{date("Y-m-d")}}" class="form-control" id="passport_expiry_date"  @if ($get_student->passport_expiry_date != '')  value ="{{$get_student->passport_expiry_date}}" @else value="{{old('passport_expiry_date')}}" @endif placeholder="Enter Expiry Date" name="passport_expiry_date">
                                                <p class="text-danger">@error('passport_expiry_date'){{ $message }}@enderror</p>
                                            </div>
                                            <div class="form-group col-md-4 passportchkDiv @if($get_student->passport_file != '' || old('chkPassport') == '1') @else d-none @endif">
                                                <label for="passport_file"><strong>Upload Passport <span style='color: red'>*</span></strong></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"  name="passport_file" id="passport_file"  data-id="passport_file_d">
                                                    <input type="hidden" name="old_passport_file" value="{{$get_student->passport_file}}" class="passport_file_d">
                                                    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                    <p class="text-danger">@error('old_passport_file'){{ $message }}@enderror</p>
                                                </div>
                                                @if($get_student->passport_file != '')
                                                <?php $info = pathinfo($get_student->passport_file);
                                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                                { ?>
                                                <p style="margin-top: 15">
                                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/passport/'.$get_student->passport_file); ?>&embedded=true"  title="Passport file"></iframe>
                                                      </p> 
                                             <?php
                                                }
                                                else
                                                { ?> 
                                                    <iframe src="{{url('/files/passport/'.$get_student->passport_file)}}" title="Passport file"></iframe>
                                                    <?php
                                                }?>
                                                @endif
                                            </div>

                                        <div class="col-lg-12 col-md-12 chckstrip">
                                            <input type="checkbox" id="chkVisa"@if($get_student->visa_file != '') checked @endif value="1" {{ old('chkVisa') == '1' ? 'checked' : ''}} name="chkVisa" class="chckright" data-type="visaChkDiv"/>
                                            <strong><b>Visa Copy</b></strong>
                                        </div>

                                        <div class="form-group col-md-4 visaChkDiv @if($get_student->visa_file != '' || old('chkVisa') == '1') @else d-none @endif">
                                            <label for="visa_expiry_date"><strong>Expiry Date <span style='color: red'>*</span></strong></label>
                                            <input type="date" min="{{date("Y-m-d")}}"  class="form-control" id="visa_expiry_date"  @if ($get_student->visa_expiry_date != '')  value ="{{$get_student->visa_expiry_date}}" @else value="{{old('visa_expiry_date')}}" @endif placeholder="Enter Expiry Date" name="visa_expiry_date">
                                            <p class="text-danger">@error('visa_expiry_date'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4 visaChkDiv @if($get_student->visa_file != '' || old('chkVisa') == '1') @else d-none @endif">
                                            <label for="visa_type"><strong>Type of Visa <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" name="visa_type" id="visa_type"  @if ($get_student->visa_type != '')  value ="{{$get_student->visa_type}}" @else value="{{old('visa_type')}}" @endif placeholder="Enter Type of Visa" name="visa_type">
                                            <p class="text-danger"> @error('visa_type'){{ $message }}@enderror</p>
                                        </div> 
                                        <div class="form-group col-md-4 visaChkDiv @if($get_student->visa_file != '' || old('chkVisa') == '1') @else d-none @endif">
                                            <label for="visa_file"><strong>Upload Visa <span style='color: red'>*</span></strong></label>
                                            <div class="custom-file">
                                                <input class="custom-file-input"  name="visa_file" type="file" id="visa_file" data-id="visa_file_d">
                                                <input type="hidden" name="old_visa_file" value="{{$get_student->visa_file}}" class="visa_file_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger"> @error('old_visa_file'){{ $message }}@enderror</p>
                                            </div>
                                            @if($get_student->visa_file != '')
                                                <?php $info = pathinfo($get_student->visa_file);
                                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                                { ?>
                                                <p style="margin-top: 15">
                                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/visa/'.$get_student->visa_file); ?>&embedded=true"  title="Visa file"></iframe>
                                                      </p> 
                                             <?php
                                                }
                                                else
                                                { ?> 
                                                    <iframe src="{{url('/files/visa/'.$get_student->visa_file)}}" title="Visa file"></iframe>
                                                    <?php
                                                }?>
                                                @endif
                                        </div>

                                        <div class="col-md-12 col-md-12 chckstrip">
                                            <input type="checkbox" value="1" @if($get_coes_data != '') checked @endif value="1" {{ old('chkCoes') == '1' ? 'checked' : ''}} name="chkCoes" class="chckright" data-type="coesDiv"/>
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
                                            <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_one); ?>&embedded=true"  title="Coes file"></iframe></p> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_one)}}" title="Coes file"></iframe>
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
                                            <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_two); ?>&embedded=true"  title="Coes file"></iframe></p> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_two)}}" title="Coes file"></iframe>
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
                                            <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_three); ?>&embedded=true"  title="Coes file"></iframe></p> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_three)}}" title="Coes file"></iframe>
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
                                            <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_four); ?>&embedded=true"  title="Coes file"></iframe></p> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_four)}}" title="Coes file"></iframe>
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
                                            <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_coes_data->file_five); ?>&embedded=true"  title="Coes file"></iframe></p> 
                                         <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <iframe src="{{url('/files/others/'.$get_coes_data->file_five)}}" title="Coes file"></iframe>
                                                <?php } ?>
                                            @endif
                                            @endif
                                            
                                         </div> 


                                        <div class="col-md-6 col-md-6 chckstrip">
                                            <input type="checkbox" id="chkOshc_Ovhc" @if($get_student->oshc_ovhc_file != '') checked @endif value="1" {{ old('chkOshc_Ovhc') == '1' ? 'checked' : ''}} name="chkOshc_Ovhc" class="chckright" data-type="Oshc_OvhcChkDiv"/>
                                            <strong><b>OSHC/OVHC</b></strong>
                                            <div class="custom-file Oshc_OvhcChkDiv @if($get_student->oshc_ovhc_file != '' || old('chkOshc_Ovhc') == '1') @else d-none @endif">
                                                <input class="custom-file-input" type="file" name="oshc_ovhc_file" id="oshc_ovhc_file" data-id="oshc_ovhc_d">
                                                <input type="hidden" name="old_oshc_ovhc_file" value="{{$get_student->oshc_ovhc_file}}" class="oshc_ovhc_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger"> @error('old_oshc_ovhc_file'){{ $message }}@enderror</p>
                                            </div>
                                            @if($get_student->oshc_ovhc_file != '')
                                                <?php $info = pathinfo($get_student->oshc_ovhc_file);
                                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                                { ?>
                                                      <p style="margin-top: 15">
                                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_student->oshc_ovhc_file); ?>&embedded=true"  title="oshc_ovhc file"></iframe>
                                                      </p> 
                                             <?php
                                                }
                                                else
                                                { ?> 
                                                    <iframe src="{{url('/files/others/'.$get_student->oshc_ovhc_file)}}" title="oshc_ovhc file"></iframe>
                                                    <?php
                                                }?>
                                                @endif
                                        </div>
                                        <div class="col-md-6 col-md-6 chckstrip">
                                            <input type="checkbox" id="chkIelts_pte_score" @if($get_student->ielts_pte_score_file != '') checked @endif value="1" {{ old('chkIelts_pte_score') == '1' ? 'checked' : ''}} name="chkIelts_pte_score" class="chckright" data-type="chkIelts_pte_scoreDiv"/>
                                            <strong><b>IELTS/PTE SCORE</b></strong>
                                            <div class="custom-file chkIelts_pte_scoreDiv  @if($get_student->ielts_pte_score_file != '' || old('chkIelts_pte_score') == '1') @else d-none @endif">
                                                <input class="custom-file-input" type="file" name="ielts_pte_score_file" id="ielts_pte_score_file" data-id="ielts_pte_score_d">
                                                <input type="hidden" name="old_ielts_pte_score_file" value="{{$get_student->ielts_pte_score_file}}" class="ielts_pte_score_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger"> @error('old_ielts_pte_score_file'){{ $message }}@enderror</p>
                                            </div>
                                            @if($get_student->ielts_pte_score_file != '')
                                                <?php $info = pathinfo($get_student->ielts_pte_score_file);
                                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                                { ?>
                                                      <p style="margin-top: 15">
                                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_student->ielts_pte_score_file); ?>&embedded=true"  title="ielts_pte_score file"></iframe>
                                                      </p> 
                                             <?php
                                                }
                                                else
                                                { ?> 
                                                    <iframe src="{{url('/files/others/'.$get_student->ielts_pte_score_file)}}" title="ielts_pte_score file"></iframe>
                                                    <?php
                                                }?>
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
                                            <input type="text" class="form-control" id="ten_school_college"  @if ($get_student->ten_school_college != '')  value ="{{$get_student->ten_school_college}}" @else value="{{old('ten_school_college')}}" @endif placeholder="Enter school name" name="ten_school_college">
                                            <p class="text-danger"> @error('ten_school_college') {{ $message }} @enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="ten_board_university"  @if ($get_student->ten_board_university != '')  value ="{{$get_student->ten_board_university}}" @else value="{{old('ten_board_university')}}" @endif placeholder="Enter board or university" name="ten_board_university">
                                            <p class="text-danger"> @error('ten_board_university'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="ten_percentage" @if ($get_student->ten_percentage != '')  value ="{{$get_student->ten_percentage}}" @else value="{{old('ten_percentage')}}" @endif placeholder="%" name="ten_percentage">
                                            <p class="text-danger">@error('ten_percentage'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="ten_session" @if ($get_student->ten_session != '')  value ="{{$get_student->ten_session}}" @else value="{{old('ten_session')}}" @endif placeholder="Session" name="ten_session">
                                            <p class="text-danger">@error('ten_session') {{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <div class="custom-file">
                                                <input class="custom-file-input" type="file" id="ten_marksheet" name="ten_marksheet" data-id="ten_marksheet_d">
                                                <input type="hidden" name="old_ten_marksheet" value="{{$get_student->ten_marksheet}}" class="ten_marksheet_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_ten_marksheet'){{ $message }}@enderror</p>
                                            </div>
                                            @if($get_student->ten_marksheet != '')
                                                <?php $info = pathinfo($get_student->ten_marksheet);
                                                if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                                { ?>
                                                      <p style="margin-top: 15">
                                                        <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$get_student->ten_marksheet); ?>&embedded=true"  title="ten_marksheet file"></iframe>
                                                      </p> 
                                             <?php
                                                }
                                                else
                                                { ?> 
                                                    <iframe src="{{url('/files/education/'.$get_student->ten_marksheet)}}" title="ten_marksheet file"></iframe>
                                                    <?php
                                                }?>
                                                @endif
                                        </div>
                                        {{-- class 10th --}}

                                        {{-- class 12th --}}
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>12th <span style='color: red'>*</span></strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="twelve_school_college"  @if ($get_student->twelve_school_college != '')  value ="{{$get_student->twelve_school_college}}" @else value="{{old('twelve_school_college')}}" @endif placeholder="Enter school name" name="twelve_school_college">
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
                                                <input class="custom-file-input" type="file" id="twelve_marksheet" name="twelve_marksheet" data-id="twelve_marksheet_d">
                                                <input type="hidden" name="old_twelve_marksheet" value="{{$get_student->twelve_marksheet}}" class="twelve_marksheet_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_twelve_marksheet'){{ $message }}@enderror</p>
                                            </div>
                                            @if($get_student->twelve_marksheet != '')
                                            <?php $info = pathinfo($get_student->twelve_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                                  <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$get_student->twelve_marksheet); ?>&embedded=true"  title="twelve_marksheet file"></iframe>
                                                  </p> 
                                         <?php
                                            }
                                            else
                                            { ?> 
                                                <iframe src="{{url('/files/education/'.$get_student->twelve_marksheet)}}" title="twelve_marksheet file"></iframe>
                                                <?php
                                            }?>
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
                                            <input type="text" class="form-control" id="diploma_percentage" @if ($get_student->diploma_percentage != '')  value ="{{$get_student->diploma_percentage}}" @else value="{{old('diploma_percentage')}}" @endif placeholder="%" name="diploma_percentage">
                                            <p class="text-danger">@error('diploma_percentage'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="diploma_session" @if ($get_student->diploma_session != '')  value ="{{$get_student->diploma_session}}" @else value="{{old('diploma_session')}}" @endif placeholder="Session" name="diploma_session">
                                            <p class="text-danger">@error('diploma_session'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <div class="custom-file">
                                                <input class="custom-file-input" type="file" id="diploma_marksheet" name="diploma_marksheet" data-id="diploma_marksheet_d">
                                                <input type="hidden" name="old_diploma_marksheet" value="{{$get_student->diploma_marksheet}}" class="diploma_marksheet_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                            </div>
                                            @if($get_student->diploma_marksheet != '')
                                            <?php $info = pathinfo($get_student->diploma_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                                  <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$get_student->diploma_marksheet); ?>&embedded=true"  title="diploma_marksheet file"></iframe>
                                                  </p> 
                                         <?php
                                            }
                                            else
                                            { ?> 
                                                <iframe src="{{url('/files/education/'.$get_student->diploma_marksheet)}}" title="diploma_marksheet file"></iframe>
                                                <?php
                                            }?>
                                            @endif
                                            <p class="text-danger">@error('old_diploma_marksheet'){{ $message }}@enderror</p>
                                        </div>
                                        {{-- Diploma --}}

                                        {{-- Bachelors --}}
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Bachelors</strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <input type="text" class="form-control" id="bachelors_school_college"  @if ($get_student->bachelors_school_college != '')  value ="{{$get_student->bachelors_school_college}}" @else value="{{old('bachelors_school_college')}}" @endif placeholder="Enter college name" name="bachelors_school_college">
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
                                                <input class="custom-file-input" type="file" id="bachelors_marksheet" name="bachelors_marksheet" data-id="bachelors_marksheet_d">
                                                <input type="hidden" name="old_bachelors_marksheet" value="{{$get_student->bachelors_marksheet}}" class="bachelors_marksheet_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                            </div>
                                            @if($get_student->bachelors_marksheet != '')
                                            <?php $info = pathinfo($get_student->bachelors_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                                  <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$get_student->bachelors_marksheet); ?>&embedded=true"  title="bachelors_marksheet file"></iframe>
                                                  </p> 
                                         <?php
                                            }
                                            else
                                            { ?> 
                                                <iframe src="{{url('/files/education/'.$get_student->bachelors_marksheet)}}" title="bachelors_marksheet file"></iframe>
                                                <?php
                                            }?>
                                            @endif
                                            <p class="text-danger">@error('old_bachelors_marksheet'){{ $message }}@enderror</p>
                                        </div>
                                        {{-- Bachelors --}}

                                        {{-- Masters --}}
                                        <div class="form-group col-md-1 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                            <strong>Masters</strong>
                                        </div>
                                        <div class="form-group col-md-3 chkEducation_detailsDiv @if($get_student->ten_marksheet != '' || old('chkEducation_details') == '1') @else d-none @endif">
                                           <input type="text" class="form-control" id="masters_school_college" @if ($get_student->masters_school_college != '')  value ="{{$get_student->masters_school_college}}" @else value="{{old('masters_school_college')}}" @endif placeholder="Enter School Or College" name="masters_school_college">
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
                                                <input class="custom-file-input" type="file" id="masters_marksheet" name="masters_marksheet" data-id="masters_marksheet_d">
                                                <input type="hidden" name="old_masters_marksheet" value="{{$get_student->masters_marksheet}}" class="masters_marksheet_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                            </div>
                                            @if($get_student->masters_marksheet != '')
                                            <?php $info = pathinfo($get_student->masters_marksheet);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                                  <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/education/'.$get_student->masters_marksheet); ?>&embedded=true"  title="masters_marksheet file"></iframe>
                                                  </p> 
                                         <?php
                                            }
                                            else
                                            { ?> 
                                                <iframe src="{{url('/files/education/'.$get_student->masters_marksheet)}}" title="masters_marksheet file"></iframe>
                                                <?php
                                            }?>
                                            @endif
                                           <p class="text-danger">@error('old_masters_marksheet'){{ $message }}@enderror</p>
                                        </div>
                                        {{-- Masters --}}

                                        <div class="col-md-6 col-md-6 chckstrip">
                                            <input type="checkbox"  @if($get_student->australian_id != '') checked @endif  value="1" {{ old('chkAustralianId') == '1' ? 'checked' : ''}} name="chkAustralianId" class="chckright" data-type="australian_idDiv"/>
                                            <strong><b>Australian ID (if any)</b></strong>
                                            <div class="custom-file australian_idDiv @if($get_student->australian_id != '' || old('chkAustralianId') == '1') @else d-none @endif"> 
                                                <input class="custom-file-input" type="file" id="australian_id" name="australian_id" data-id="australian_id_d">
                                                <input type="hidden" name="old_australian_id" value="{{$get_student->australian_id}}" class="australian_id_d">
                                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                                <p class="text-danger">@error('old_australian_id'){{ $message }}@enderror</p>
                                            </div>
                                            @if($get_student->australian_id != '')
                                            <?php $info = pathinfo($get_student->australian_id);
                                            if ($info["extension"] == "doc" || $info["extension"] == "docx" )
                                            { ?>
                                                  <p style="margin-top: 15">
                                                    <iframe class="iframe_pass" src="https://docs.google.com/gview?url=<?php echo url('/files/others/'.$get_student->australian_id); ?>&embedded=true"  title="australian_id file"></iframe>
                                                  </p> 
                                         <?php
                                            }
                                            else
                                            { ?> 
                                                <iframe src="{{url('/files/others/'.$get_student->australian_id)}}" title="australian_id file"></iframe>
                                                <?php
                                            }?>
                                            @endif
                                        </div>

                                      





                                        
                                        <div class="form-group col-md-12">
                                            <h4>Fee Structure</h4>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="college"><strong>College <span style='color: red'>*</span></strong></label>
                                            <select class="form-control college" name="college" id="college" @if($get_student->college!='') disabled @endif>
                                                <option value="">Please Select College </option>
                                                <?php if($get_colleges){
                                                    foreach ($get_colleges as $key => $get_college) { ?>
                                                      <option <?php if ($get_student->college==$get_college->id){ ?> selected  <?php }?>value="{{$get_college->id}}">
                                                       {{$get_college->college_trading_name}}</option>
                                                    <?php }} ?>
                                            </select>
                                            <p class="text-danger">@error('college'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-6"> 
                                            <label for="course"><strong>Course <span style='color: red'>*</span></strong></label>
                                            <select class="form-control collegeCourse" name="course" id="course" @if($get_student->course!='') readonly @endif>
                                                <option value="">Please Select College First</option>
                                                  <?php if($get_courses){
                                                    foreach ($get_courses as $key => $get_course) { ?>
                                                    <option <?php if($get_course->id==$get_student->course){  ?> selected <?php }  ?> value="{{$get_course->id}}">{{$get_course->course_name}}</option>
                                                    <?php }}?>
                                            </select>
                                            <p class="text-danger">@error('course'){{ $message }} @enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="admission_fees"><strong>Admission fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control admission_fees" id="admission_fees" value="{{$get_student->admission_fees}}" name="admission_fees" placeholder="Admission fees" readonly>
                                            <p class="text-danger">@error('admission_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="material_fees"><strong>Material fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control material_fees" id="material_fees" value="{{$get_student->material_fees}}" name="material_fees" placeholder="Material fees" readonly>
                                            <p class="text-danger">@error('material_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="tuition_fees"><strong>Tuition fees</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control tuition_fees" id="tuition_fees" value="{{$get_student->tuition_fees}}" name="tuition_fees" placeholder="Tuition fees" readonly>
                                            <p class="text-danger">@error('tuition_fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="course_fee"><strong>Course total fee</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                                <input type="text" class="form-control course_fee" id="course_fee" value="{{$get_student->fees}}" name="fees" placeholder="Course fee" readonly>
                                            <p class="text-danger">@error('fees'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="discount"><strong>Discount Type</strong></label>
                                            <select class="form-control discount_type" name="discount_type" id="course"  >
                                                    <option value="">No Discount</option>
                                                    <option value="1" @if($get_student->discount_type==1) selected @endif >Fixed Amount</option>
                                                    <option value="2" @if($get_student->discount_type==2) selected @endif>Discount(%)</option>
                                            </select>                                  
                                        </div>
                                        <div class="form-group col-md-2 discount_data @if($get_student->discount_type=='') d-none @endif">
                                            <label for="discount"><strong>Discount (on tuition fees) </strong></label>
                                            <input type="text" class="form-control" id="discount" value="{{$get_student->discount}}" name="discount" placeholder="Discount" @if($get_student->discount !='') readonly @endif> 
                                            <p class="text-danger">@error('discount'){{ $message }}@enderror </p>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="amount"><strong>Amount To Be Paid</strong> (in $) <strong><span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="amount" value="{{$get_student->total_payable_amount}}" name="amount"  placeholder="Final Amount" readonly>
                                            <p class="text-danger">@error('amount'){{ $message }}@enderror </p>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="installment_frequency"><strong>Installment Frequency <span style='color: red'>*</span></strong></label>
                                            <select class="form-control" name="installment_frequency" id="installment_frequency"  @if($get_student->installment_frequency!='') disabled @endif >
                                                <option value="">Select Frequency</option>
                                                <option value="1" @if($get_student->installment_frequency==1) selected @endif >Montlhy</option>
                                                <option value="2" @if($get_student->installment_frequency==2) selected @endif >Bimonthly</option>
                                                <option value="4" @if($get_student->installment_frequency==4) selected @endif >Quaterly</option>
                                                <option value="6" @if($get_student->installment_frequency==6) selected @endif >Half-Yearly</option>
                                            </select>
                                            
                                            <p class="text-danger"> @error('installment_frequency'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="total_installment"><strong>Total Installment <span style='color: red'>*</span></strong></label>
                                            <select class="form-control" name="total_installment" id="total_installment" @if($get_student->total_installment!='') disabled @endif>
                                                <option value="">Total Installment</option>
                                                <?php for ($i=1; $i < 21 ; $i++) {  ?>
                                                    <option value="{{$i}}" @if($get_student->total_installment==$i) selected @endif >{{$i}}</option>
                                                <? } ?>
                                            </select>                                            
                                            <p class="text-danger"> @error('total_installment'){{ $message }}  @enderror</p>
                                        </div>

                                        <div class="form-group col-md-4 ">
                                            <label for="intake_date"><strong>Intake Date <span style='color: red'>*</span></strong></label>
                                            <input type="date"  class="form-control" id="intake_date" placeholder="Enter End Date" name="intake_date" @if($get_student->intake_date!='') readonly="" value="{{$get_student->intake_date}}" @else value="{{old('intake_date')}}" @endif>
                                            <p class="text-danger">@error('intake_date'){{ $message }}@enderror</p>
                                        </div>

                                        <input type="hidden" name="student_id" value="{{$get_student->sid}}">
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
        $(document).ready(function(){
            $('.college').on('change', function(){
                var college_id = $(this).val();   
                  
                $.ajax({
                    url: "{{route('get_staff_collegeCourses')}}",
                    type: "post",                    
                    data:{"_token": "{{ csrf_token() }}",college_id:college_id}, 
                    success: function (response) {
                        $('.collegeCourse').html(response);                        
                    },                    
                });                
            });
        });

        $(document).ready(function(){
            $('.collegeCourse').on('change', function(){
                var total_discount = 0;
                var discount_type = $('.discount_type').val();
                var course_id = $(this).val();   
                var scholarship = $('#discount').val();  
                $.ajax({
                    url: "{{route('get_staff_courseFees')}}",
                    type: "POST",
                    dataType: "json",                    
                    data:{"_token": "{{ csrf_token() }}",course_id:course_id}, 
                    success: function (response) {

                        console.log(response);

                            $('.admission_fees').val(response.admission_fees);
                            $('.material_fees').val(response.material_fees);
                            $('.tuition_fees').val(response.tuition_fees);
                            $('.course_fee').val(response.course_fee);
                            var fees = response.tuition_fees;

                            if(discount_type!='' && scholarship!='')
                        {
                            if(discount_type==2)
                            {

                                if(scholarship > 100)
                                {
                                    alert('Discount can not be more then 100.');
                                    $('#discount').val("");
                                    $('#amount').val(response.course_fee);
                                    return false;
                                }
                            }
                            else if(discount_type==1)
                            {

                                if(parseInt(scholarship) > parseInt(fees))
                                {
                                    alert('Discount can not be greater than Tuition fees.');
                                    $('#discount').val("");
                                    $('#amount').val(response.course_fee);
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

                        $('#amount').val(response.course_fee-total_discount);

                                            
                    },                    
                });                
            });
        });

        
        $(document).ready(function(){
            $(document).on('change keyup','#discount',function(){ 
                var scholarship = $('#discount').val();
                var discount_type = $('.discount_type').val();
                var course_fee = $('#course_fee').val();
                if(discount_type=='')
                {
                    alert('Please select Discount type first');
                    $('#discount').val("");
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
                    var fees = $('#tuition_fees').val();


                    if(discount_type==2)
                    {

                        if(scholarship > 100)
                        {
                            alert('Discount can not be more then 100.');
                            $('#discount').val("");
                            $('#amount').val(fees);
                            return false;
                        }
                    }
                    else if(discount_type==1)
                    {

                        if(parseInt(scholarship) > parseInt(fees))
                        {
                            alert('Discount can not be greater than Tuition fees.');
                            $('#discount').val("");
                            $('#amount').val(fees);
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


                    total_amt = course_fee-total_discount;
                    

                    $('#amount').val(total_amt);
                }else{
                    return false;
                }               
                                               
            }); 

            $(document).on('change','.discount_type',function(){ 

                var total_discount = 0;
                var scholarship = $('#discount').val();
                var discount_type = $('.discount_type').val();
                var course_fee = $('#course_fee').val();

                if(discount_type=='')
                {
                    $('#discount').val("");
                    $('.discount_data').addClass('d-none');
                    $('#amount').val(course_fee);
                    return false;
                }

                $('.discount_data').removeClass('d-none');

                if(scholarship != '')
                {
                    var scholarship = scholarship;   
                }
                else
                {
                   var scholarship = 0;
                }

                if($.isNumeric(scholarship)){
                    var fees = $('#tuition_fees').val();


                    if(discount_type==2)
                    {

                        if(scholarship > 100)
                        {
                            alert('Discount can not be more then 100.');
                            $('#discount').val("");
                            $('#amount').val(fees);
                            return false;
                        }
                    }
                    else if(discount_type==1)
                    {

                        if(parseInt(scholarship) > parseInt(fees))
                        {
                            alert('Discount can not be greater than Tuition fees.');
                            $('#discount').val("");
                            $('#amount').val(fees);
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
                    

                    $('#amount').val(total_amt);
                }else{
                    return false;
                }               
                                               
            });
        });

    </script>
   

    <script>
        $(".custom-file-input").on("change", function() {
            var data = $(this).attr("data-id");

            var fileName = $(this).val().split("\\").pop();            
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

            $('.'+data).val(fileName);


            // var name = $(this).attr("name");
            // // alert(name);
            // $('.old_passport_file').attr(("name"))


        });
    </script>


<script type="text/javascript">        
    $("#referral").change(function () {
        var data = $("#referral").val();
        
        if(data == 'Others Specified'){ 
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


@endsection
