@extends('staff.layout.head')
@section('staff')
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Enter Student Details</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form action="{{ route('add_students') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="first_name"><strong>First Name <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}" placeholder="First Name">
                                            <p class="text-danger">@error('first_name'){{ $message }} @enderror </p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="middle_name"><strong>Middle Name (optional)</strong></label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{old('middle_name')}}" placeholder="Middle Name">
                                            <p class="text-danger"> @error('middle_name'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="last_name"><strong>Last Name (optional)</strong></label>
                                            <input type="text" class="form-control" id="last_name"name="last_name" value="{{old('last_name')}}" placeholder="Last Name">
                                            <p class="text-danger">@error('last_name'){{ $message }}@enderror </p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="dob"><strong>Date of Birth <span style='color: red'>*</span></strong></label>
                                            <input type="date" max="<?php echo date("Y-m-d"); ?>" class="form-control" id="dob" value="{{old('dob')}}" placeholder="Enter D.O.B" name="dob">
                                            <p class="text-danger">@error('dob') {{ $message }} @enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="address"><strong>Address <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="address" value="{{old('address')}}" placeholder="Enter Address" name="address">
                                            <p class="text-danger"> @error('address'){{ $message }}@enderror</p>
                                        </div>  

                                        <div class="form-group col-md-4">
                                            <label for="country"><strong>Country <span style='color: red'>*</span></strong></label>
                                                <select class="form-control" name="country" id="country">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                    <option <?php if(old('country') == $country->country_name){ echo 'selected'; } ?> value="{{$country->country_name}}">{{$country->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            <p class="text-danger">@error('country'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="gender"><strong>Gender <span style='color: red'>*</span></strong></label>
                                                <select class="form-control" name="gender" id="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" @if (old('gender') == "Male") {{ 'selected' }} @endif>Male</option>
                                                    <option value="Female" @if (old('gender') == "Female") {{ 'selected' }} @endif>Female</option>
                                                    <option value="Others" @if (old('gender') == "Others") {{ 'selected' }} @endif>Others</option>
                                                  </select>
                                            <p class="text-danger">@error('gender'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email"><strong>Email Address <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="email" value="{{old('email')}}" placeholder="Enter Email address" name="email">
                                            <p class="text-danger">@error('email'){{ $message }} @enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="phone"><strong>Phone Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="phone" value="{{old('phone')}}" placeholder="Enter Phone Number" name="phone" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger"> @error('phone'){{ $message }}@enderror</p>

                                            <span class="error_msg2"></span>
                                            <br>
                                            <p class="error-msg" id="error-msg"></p>
                                            <p class="valid-msg" id="valid-msg"></p>
                                            <input type="hidden" class="phone_flag" name="phone_flag" value="iti__in"/>
                                            <input type="hidden" class="phone_dialcode" name="phone_dialcode" value="+91"/>
                                        </div>

                                         <div class="form-group col-md-4">
                                            <label for="whatsapp"><strong>Whatsapp Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="whatsapp" value="{{old('whatsapp')}}" placeholder="Enter Whatsapp Number" name="whatsapp" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger"> @error('whatsapp'){{ $message }}@enderror</p>

                                            <span class="error_msg2"></span>
                                            <br>
                                            <p class="error-msg" id="error-msg"></p>
                                            <p class="valid-msg" id="valid-msg"></p>
                                            <input type="hidden" class="whatsapp_flag" name="whatsapp_flag" value="iti__in"/>
                                            <input type="hidden" class="whatsapp_dialcode" name="whatsapp_dialcode" value="+91"/> 


                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="emergency_phone"><strong>Emergency Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="emergency_phone" value="{{old('emergency_phone')}}" placeholder="Enter Emergency Contact" name="emergency_phone" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger">@error('emergency_phone'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="purpose"><strong>Purpose of Visit <span style='color: red'>*</span></strong></label>
                                            <select class="form-control"  name="purpose" id="purpose">
                                                <option value="">Select Purpose of Visit</option>  
                                                <option value="TR"@if (old('purpose') == "TR") {{ 'selected' }} @endif>TR</option>  
                                                <option value="PR"@if (old('purpose') == "PR") {{ 'selected' }} @endif>PR</option>
                                                <option value="Other Services"@if (old('purpose') == "Other Services") {{ 'selected' }} @endif>Other Services</option>
                                            </select>

                                                <input class="form-control" type="text" value="{{old('other_purpose')}}"  placeholder="Please specify other purpose" name="other_purpose">
                                                <p class="text-danger">@error('other_purpose'){{ $message }}@enderror</p>
                                            </div>
                                            <p class="text-danger">@error('purpose'){{ $message }}@enderror</p>
                                       
                                        
                                        <div class="form-group col-md-6">
                                            <label for="referral"><strong>Referral </strong></label>
                                            <select class="form-control"  name="referral" id="referral">
                                                <option value="">Select Referral</option>
                                                <option value="Google" @if (old('referral') == "Google") {{ 'selected' }} @endif>Google</option>
                                                <option value="Social Media"@if (old('referral') == "Social Media") {{ 'selected' }} @endif>Social Media</option>
                                                <option value="Others Specified"@if (old('referral') == "Others Specified") {{ 'selected' }} @endif>Others Specified</option>
                                            </select> 
                                            <div class="form-group col-md-12 otherReferral d-none">
                                                 <select name="other_referral" class="form-control">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    if($referrals_list)
                                                    {
                                                        foreach ($referrals_list as $key => $referrals_list_val)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $referrals_list_val->id ?>"><?php echo $referrals_list_val->name; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <!-- <input class="form-control" type="text" value="{{old('other_referral')}}" placeholder="Please specify other referral" name="other_referral"> -->
                                                <p class="text-danger">@error('other_referral'){{ $message }}@enderror</p>
                                            </div>  
                                            <p class="text-danger">@error('referral'){{ $message }}@enderror</p>                                         
                                        </div>


                                    <?php  
                                     $user_type =  Auth::user()->type;
                                     if($user_type==1){ ?>

                                               <div class="form-group col-md-6">
                                            <label for="staff_name"><strong>Assigned to Staff <span style='color: red'>*</span></strong></label>
                                            <select class="form-control"  name="staff_name" id="staff_name">
                                                <option value="">Select Staff</option>
                                                <?php if($get_staffs){
                                                    foreach ($get_staffs as $key => $get_staff) { ?>
                                                        <option  <?php if(old('staff_name') == $get_staff->id){ echo 'selected'; } ?> value="{{$get_staff->id}}">{{$get_staff->first_name}} {{$get_staff->last_name}}</option>
                                                   <?php } } ?>                                                   
                                                </select>
                                            <p class="text-danger">@error('staff_name'){{ $message }}@enderror</p>
                                        </div>
                                         <?php } ?>


                                        <div class="form-group col-md-6">
                                            <label for="priority"><strong>Priority <span style='color: red'>*</span></strong></label>
                                            <select class="form-control"  name="priority" id="priority">
                                                <option value="">Select Status</option>
                                                <option value="1"@if (old('priority') == "1") {{ 'selected' }} @endif>High</option>
                                                <option value="2"@if (old('priority') == "2") {{ 'selected' }} @endif>Medium</option>
                                                <option value="3"@if (old('priority') == "3") {{ 'selected' }} @endif>Low</option>
                                            </select>
                                            <p class="text-danger">@error('priority'){{ $message }}@enderror</p>                                            
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="comment"><strong>Comment <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="comment" value="{{old('comment')}}" placeholder="Enter Comment" name="comment">
                                            <p class="text-danger"> @error('comment'){{ $message }}@enderror</p>
                                        </div> 
                                         </div>
                                          <button type="submit" class="btn btn-outline-info">Add Student</button>
                                    </div>
                                   
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
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

    <script type="text/javascript">     
        $(document).ready(function(){
        var referral = $("#referral").val();
        if(referral == 'Others Specified'){
            $('.otherReferral').removeClass('d-none');
        }
        })  ; 

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
        $(document).ready(function(){
        var purpose = $("#purpose").val();
        if(purpose =='Other Services'){
       $('.otherPurpose').removeClass('d-none');
        }
        }) ;

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
<style>
    #phone
    {
        width: 330px !important;
    }

    #whatsapp
    {
        width: 330px !important;
    }
    </style>
@endsection
