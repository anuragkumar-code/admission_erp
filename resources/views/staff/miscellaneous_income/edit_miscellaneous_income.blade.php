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
                                <form action="{{ route('/staff/miscellaneous_income/edit_miscellaneous_income') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="first_name"><strong>First Name <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{$get_miscellaneous_income->first_name}}" placeholder="First Name">
                                            <p class="text-danger">@error('first_name'){{ $message }} @enderror </p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="middle_name"><strong>Middle Name (optional)</strong></label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{$get_miscellaneous_income->middle_name}}" placeholder="Middle Name">
                                            <p class="text-danger"> @error('middle_name'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="last_name"><strong>Last Name (optional)</strong></label>
                                            <input type="text" class="form-control" id="last_name"name="last_name" value="{{$get_miscellaneous_income->last_name}}" placeholder="Last Name">
                                            <p class="text-danger">@error('last_name'){{ $message }}@enderror </p>
                                        </div>
                                       
                                        <div class="form-group col-md-4">
                                            <label for="address"><strong>Address <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="address" value="{{$get_miscellaneous_income->address}}" placeholder="Enter Address" name="address">
                                            <p class="text-danger"> @error('address'){{ $message }}@enderror</p>
                                        </div>  

                                        <div class="form-group col-md-4">
                                            <label for="country"><strong>Country <span style='color: red'>*</span></strong></label>
                                                <select class="form-control" name="country" id="country">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                    <option <?php if($get_miscellaneous_income->country_name == $country->country_name){ echo 'selected'; } ?> value="{{$country->country_name}}">{{$country->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            <p class="text-danger">@error('country'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="gender"><strong>Gender <span style='color: red'>*</span></strong></label>
                                                <select class="form-control" name="gender" id="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" @if ($get_miscellaneous_income->gender == "Male") {{ 'selected' }} @endif>Male</option>
                                                    <option value="Female" @if ($get_miscellaneous_income->gender == "Female") {{ 'selected' }} @endif>Female</option>
                                                    <option value="Others" @if ($get_miscellaneous_income->gender == "Others") {{ 'selected' }} @endif>Others</option>
                                                  </select>
                                            <p class="text-danger">@error('gender'){{ $message }}@enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email"><strong>Email Address <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="email" value="{{$get_miscellaneous_income->email}}" placeholder="Enter Email address" name="email">
                                            <p class="text-danger">@error('email'){{ $message }} @enderror</p>
                                        </div>
                                       

                                         <div class="form-group col-md-4">
                                            <label for="whatsapp"><strong>Whatsapp Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="whatsapp" value="{{$get_miscellaneous_income->whatsapp}}" placeholder="Enter Whatsapp Number" name="whatsapp" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger"> @error('whatsapp'){{ $message }}@enderror</p>

                                            <span class="error_msg2"></span>
                                            <br>
                                            <p class="error-msg" id="error-msg"></p>
                                            <p class="valid-msg" id="valid-msg"></p>
                                            <input type="hidden" class="whatsapp_flag" name="whatsapp_flag" value="iti__in"/>
                                            <input type="hidden" class="whatsapp_dialcode" name="whatsapp_dialcode" value="+91"/> 


                                        </div>

                                    

                                      <?php /*  <div class="form-group col-md-4">
                                            <label for="colleges"><strong>Colleges <span style='color: red'>*</span></strong></label>
                                            <select class="form-control" name="college">
                                                <option value="">Please Select College</option>
                                                <?php
                                                if($colleges)
                                                {
                                                    foreach ($colleges as $key => $colleges_value)
                                                    { */
                                                    ?>
                                                    <!-- <option <?php //if($get_miscellaneous_income->college == $colleges_value->id){?> selected <?php //} ?> value="<?php //echo $colleges_value->id; ?>"><?php //echo $colleges_value->college_trading_name; ?></option> -->
                                                    <?php
                                                    /*}
                                                }*/
                                                ?>
                                            <!-- </select>
                                            <p class="text-danger">@error('other_services'){{ $message }} @enderror</p>
                                        </div> -->


                                        <div class="form-group col-md-4">
                                            <label for="other_services"><strong>Other Services <span style='color: red'>*</span></strong></label>
                                           
                                             <select class="form-control" name="other_services">
                                                <option value="">Please Select Services</option>
                                                <?php if($other_services){
                                                    foreach ($other_services as $key => $other_services_value)
                                                    {
                                                    ?>
                                                    <option <?php if($get_miscellaneous_income->other_services == $other_services_value->id){?> selected <?php } ?> value="{{$other_services_value->id}}">{{$other_services_value->service_name}}</option>
                                                    <?php
                                                    }
                                                } ?>
                                            </select>

                                            <p class="text-danger">@error('other_services'){{ $message }} @enderror</p>
                                        </div>

                                         <div class="form-group col-md-4">
                                            <label for="income"><strong>Income <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="income" value="{{$get_miscellaneous_income->income}}" placeholder="Enter Income" name="income">
                                            <p class="text-danger">@error('income'){{ $message }} @enderror</p>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="income"><strong>Total Recieve <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="total_recieve" value="{{$get_miscellaneous_income->total_recieve}}" placeholder="Enter Total Recieve" name="total_recieve">
                                            <p class="text-danger">@error('total_recieve'){{ $message }} @enderror</p>
                                        </div>


                                         </div>

                                         <input type="hidden" name="miscellaneous_income_id" value="{{$get_miscellaneous_income->id}}">

                                          <button type="submit" class="btn btn-outline-info">Update</button>
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

        $('.iti__selected-dial-code').html('<?php echo $get_miscellaneous_income->whatsapp_dialcode; ?>');
        $('.iti__flag').addClass('<?php echo $get_miscellaneous_income->whatsapp_flag; ?>')

        }); 

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
