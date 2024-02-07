<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Applicant Information Form - Royal Migration</title>

<style>

*, *::after, *::before {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
body {
	margin:0px;
	padding:0px;
	font-size:15px;
	font-family: 'Inter', sans-serif;	
	color:#000;
	font-weight:400;
}


.wrapper{
    width: 1200px;
    margin: 0 auto;
}
.header{
    float: left;
    width: 90%;
    padding: 30px 0;
    padding-left: 40px;
}
.headerdiv{
    float: left;
    width: 33.33%;
}
.abn{
    color: #113581;
    font-weight: 700;
    font-size: 30px;
    margin-top: 50px;

}
.infoform{
    float: left;
    width: 100%;
}
.infoform-header{
    float: left;
    width: 100%;
    text-align: center;
    border-top: solid 1px #999;
    padding: 25px 0;
    color: #000;
    font-weight: 700;
    font-size: 30px;
    margin-bottom: 50px;
}
.w-100{
    width: 100%;
    float: left;
    padding: 0 15px;
    margin-bottom: 30px;
}
.w-50{
    width: 50%;
    float: left;
    padding: 0 15px;
    margin-bottom: 30px;
}
.lebel{
    width: 20%;
    float: left;
    color: #000;
    font-weight: 600;
    font-size: 20px;
}
.input{
    width: 78%;
    float: right;
    border: none;
    border-bottom: solid 2px #000;
    outline: none;
    height: 40px;
    color: #000;
    font-weight: 600;
    font-size: 20px;
}
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  float: left;
  margin-right: 30px;
  cursor: pointer;
  font-size: 15px;
  color: #3b3c3e;
  padding-top: 2px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #fff;
  border: solid 1px #cfcfcf;
  border-radius: 5px;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #fff;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #fff;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
  left: 9px;
    top: 5px;
    width: 7px;
    height: 11px;
    border: solid #3b3c3e;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    border-radius: 0;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
}
.footer{
  float: left;
  width: 100%;
}
.footer-address{
  float: left;
  width: 50%;
  background: #2e3190;
  padding: 20px 30px;
  color: #fff;
  font-size: 18px;
  font-weight: 600;
}
.footer-address-left{
  float: left;
  border-right: solid 2px #fff;
  padding: 10px 20px 10px 0px;
}
.footer-address-left span{
  float: left;
  margin-right: 10px;
}
.footer-address-right{
  padding-left: 20px;
  float: left;
}
.submitbtns {background: #3f5fa6; padding: 13px 45px; color: #fff; border-radius: 5px; font-size: 18px; border: none;
  outline: none; font-weight: 500;  transition: 0.3s; cursor: pointer;}
.submitbtns:hover, .submitbtns:focus {background: #274689; color: #fff;}

.infoforminner{
  margin: 0 10%;
  width: 80%;
  background-color: #f1f1f1;
  padding: 45px;
  border-radius: 15px;
  float: left;
  margin-bottom: 30px;
}
.inputbox{
  color: #3b3c3e;
  font-size: 15px;
  font-weight: 500;
  height: 58px;
  border-radius: 5px;
  background: #fff;
  border: solid 1px #cfcfcf;
  width: 100%;
  padding: 0 25px;
  outline: none;
}
.inputbox::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #3b3c3e;
}

.w-100, .w-50{
    position: relative;
}

.w-100 .text-danger, .w-50 .text-danger {
    color: red;
    position: absolute;
    bottom: -38px;
}

.text-danger {
  color: red!important;
  font-size: 14px!important;
  font-weight: 700!important;
  text-align: left;

  }

.inputbox::-moz-placeholder { /* Firefox 19+ */
  color: #3b3c3e;
}

.inputbox:-ms-input-placeholder { /* IE 10+ */
  color: #3b3c3e;
}

.inputbox:-moz-placeholder { /* Firefox 18- */
  color: #3b3c3e;
}

.selectbox{
  appearance: none;
  background: url(./Formimage/selectboxarrow.png) no-repeat 95% center #fff!important;
}
.w-100{
  color: #3b3c3e;
}

@media only screen and (min-width: 960px) and (max-width: 1195px) {
  .wrapper{width: 96%;}
  .headerdiv img{max-width: 100%;}
  .footer-address{padding: 20px; font-size: 13px;}
}
@media only screen and (min-width: 768px) and (max-width: 959px) {
  .wrapper{width: 96%;}
  .headerdiv img{max-width: 100%;}
  .abn{font-size: 20px; text-align: center;}
  .infoform-header{margin-bottom: 0;}
  .infoforminner{margin: 0; width: 100%;}
  .footer-address{width: 100%; text-align: center;}
  .footer-address-left{width: 100%; padding: 0 0 20px 0; border: none;}
  .footer-address-left span{width: 100%; margin: 0 0 10px 0;}
  .footer-address-right{padding-left: 0; width: 100%;}
}
@media only screen and (min-width: 600px) and (max-width: 767px) {
  .wrapper{width: 96%;}
  .headerdiv{width: 100%; text-align: center;}
  .abn{margin: 25px 0;}
  .headerdiv img{max-width: 100%;}
  .infoform-header{font-size: 25px; margin: 0;}
  .infoforminner{margin: 0; width: 100%; padding: 20px 10px;}
  .w-50{width: 100%;}
  .footer-address{width: 100%; text-align: center;}
  .footer-address-left{width: 100%; padding: 0 0 20px 0; border: none;}
  .footer-address-left span{width: 100%; margin: 0 0 10px 0;}
  .footer-address-right{padding-left: 0; width: 100%;}
}
@media only screen and (max-width: 599px) {
  .wrapper{width: 96%;}
  .headerdiv{width: 100%; text-align: center;}
  .abn{margin: 25px 0;}
  .headerdiv img{max-width: 100%;}
  .infoform-header{font-size: 25px; margin: 0;}
  .infoforminner{margin: 0; width: 100%; padding: 20px 10px;}
  .w-50{width: 100%;}
  .footer-address{width: 100%; text-align: center;}
  .footer-address-left{width: 100%; padding: 0 0 20px 0; border: none;}
  .footer-address-left span{width: 100%; margin: 0 0 10px 0;}
  .footer-address-right{padding-left: 0; width: 100%;}
}

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<body>
   
      
    <div class="wrapper">
        
        <div class="header">
            <div class="headerdiv"><img src="{{asset('/Formimage/logo.png')}}" width="300" alt=""></div>
            <div class="headerdiv abn"></div>
            <div class="headerdiv"><img src="{{asset('/Formimage/rightlogo.jpg')}}" alt=""></div>
        </div>

        <div class="infoform">
            <div class="infoform-header">Applicant Information Form</div>
            <form action="{{route('form_students')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="infoforminner">

              <div class="w-50 mb-3">
                <input type="text" class="inputbox" name="first_name" id="first_name" placeholder="First Name"  value="{{old('first_name')}}">
                <p class="text-danger">@error('first_name'){{ $message }}@enderror</p> 
              </div>
         

              <div class="w-50 mb-3">
                <input type="text" class="inputbox" name="last_name" id="last_name" placeholder="Last Name"  value="{{old('last_name')}}">
                <p class="text-danger">@error('last_name'){{ $message }}@enderror</p> 
              </div>

              <div class="w-50 mb-3">
                <select name="marital_status" id="marital_status" class="inputbox selectbox">
                  <option value="">Select Marital Status</option>  
                  <option value="Married"@if (old('marital_status') == "Married") {{ 'selected' }} @endif>Married</option>  
                  <option value="Unmarried"@if (old('marital_status') == "Unmarried") {{ 'selected' }} @endif>Unmarried</option>
                </select>
                <p class="text-danger">@error('marital_status'){{ $message }}@enderror</p> 
              </div>

              <div class="w-50 mb-3">
                {{-- <input type="text"  onfocus="(this.type='date')" class="inputbox" name="dob" id="dob" placeholder="Date of Birth"  value="{{old('dob')}}"> --}}
                <input type="text"  class="inputbox" name="dob" id="dob" placeholder="Date of Birth"  value="{{old('dob')}}">
                <p class="text-danger">@error('dob'){{ $message }}@enderror</p> 
              </div>

             

              <div class="w-50 mb-3">
                <input type="text" class="inputbox" name="address" id="address" placeholder="Address"  value="{{old('address')}}">
                <p class="text-danger">@error('address'){{ $message }}@enderror</p> 

              </div>

             

              <div class="w-50 mb-3">
                <select name="country" id="country" class="inputbox selectbox">
                  <option value=""> Select Country</option>
                  @foreach ($countries as $country)
                  <option <?php if(old('country') == $country->country_name){ echo 'selected'; } ?> value="{{$country->country_name}}">{{$country->country_name}}</option>
                  @endforeach
                </select>
                <p class="text-danger">@error('country') {{$message}}@enderror</p>
              </div>

              <div class="w-50 mb-3">
                <input type="text" class="inputbox" name="phone" id="phone" placeholder="Mobile No."  value="{{old('phone')}}">
                <p class="text-danger">@error('phone') {{$message}}@enderror</p>
              </div>

              <div class="w-50 mb-3">
                <input type="text" class="inputbox" name="email" id="email" placeholder="Email address"  value="{{old('email')}}">
                <p class="text-danger">@error('email') {{$message}}@enderror</p>
              </div>

              <div class="w-50 mb-3">
                <input type="text" class="inputbox" name="preferred_college" id="preferred_college" placeholder="Current College"  value="{{old('preferred_college')}}">
                <p class="text-danger">@error('preferred_college') {{$message}}@enderror</p>
              </div>

              <div class="w-50 mb-3">
                <input type="text" class="inputbox" name="preferred_course" id="preferred_course" placeholder="Current Course"  value="{{old('preferred_course')}}">
                <p class="text-danger">@error('preferred_course') {{$message}}@enderror</p>
              </div>

              <div class="w-50 mb-3">
                {{-- <input type="text"  onfocus="(this.type='date')" class="inputbox" name="preferred_intake" id="preferred_intake" placeholder="Current Intake "  value="{{old('preferred_intake')}}"> --}}
                <input type="text"  class="inputbox" name="preferred_intake" id="preferred_intake" placeholder="Current Intake"  value="{{old('preferred_intake')}}">
                <p class="text-danger">@error('preferred_intake') {{$message}}@enderror</p>
              </div>

              <div class="w-50 mb-3">
                <select name="preferred_location" id="preferred_location" class="inputbox selectbox">
                  <option value="">Select Location</option>  
                  <option value="NSW"@if (old('NSW') == "NSW") {{ 'selected' }} @endif>NSW</option>  
                  <option value="QLD"@if (old('QLD') == "QLD") {{ 'selected' }} @endif>QLD</option>
                  <option value="TAS"@if (old('TAS') == "TAS") {{ 'selected' }} @endif>TAS</option>
                  <option value="Victoria"@if (old('Victoria') == "Victoria") {{ 'selected' }} @endif>VICTORIA</option>
                  <option value="WA"@if (old('WA') == "WA") {{ 'selected' }} @endif>WA</option>

                </select>
                <p class="text-danger">@error('preferred_location'){{ $message }}@enderror</p> 
              </div>

              <div class="w-100 mb-3">
                <strong>VISA Information</strong>
              </div>

              <div class="w-50 mb-3">
                <input type="text" class="inputbox" name="visa_type" id="visa_type" placeholder="Current visa"  value="{{old('visa_type')}}">
                <p class="text-danger">@error('visa_type') {{$message}}@enderror</p>
              </div>

              <div class="w-50 mb-3">
                {{-- <input type="text"  onfocus="(this.type='date')" class="inputbox" name="visa_expiry_date" id="visa_expiry_date" placeholder="Visa Expiry Date"  value="{{old('visa_expiry_date')}}"> --}}
               <input type="text"  class="inputbox" name="visa_expiry_date" id="visa_expiry_date" placeholder="Visa Expiry Date"  value="{{old('visa_expiry_date')}}">
                <p class="text-danger">@error('visa_expiry_date') {{$message}}@enderror</p>
              </div>

              <div class="w-100 mb-3">
                <strong>How did you hear about Royal International Migration Consultants?</strong>
              </div>

              <div class="w-100 mb-3">

                <label class="container">Friend
                  <input type="radio" name="referral" class="chkRadio" id="friend" value="friend" >
                  <span class="checkmark"></span>
                </label>

                <label class="container">Website
                  <input type="radio" name="referral" class="chkRadio" id="website" value="website">
                  <span class="checkmark"></span>
                </label>

                <label class="container">Advertisement
                  <input type="radio"  name="referral" class="chkRadio" id="advertisement" value="advertisement">
                  <span class="checkmark"></span>
                </label>

                <label class="container">Other
                  <input type="radio" name="referral" class="chkRadio" id ="other" value="other">
                  <span class="checkmark"></span>
                </label>
                <p class="text-danger">@error('referral') {{$message}}@enderror</p>

              </div>

              <div class="w-100 mb-3 chkInput" style="display: none">
                <input type="text" class="inputbox" name="other_referral" id="other_referral" placeholder="Specify the name" value="{{old('other_referral')}}">
                <p class="text-danger">@error('other_referral') {{$message}}@enderror</p>
              </div>

              <div class="w-100 mb-3">
                <select name="purpose"   id="purpose" class="inputbox selectbox ChkPurpose">
                  <option value="">Select Purpose of Visit</option> 
                  <option value="Change Course" @if (old('purpose') == "Change Course") {{ 'selected' }} @endif>Change Course</option> 
                  <option value="TR"@if (old('purpose') == "TR") {{ 'selected' }} @endif>TR</option>  
                  <option value="PR"@if (old('purpose') == "PR") {{ 'selected' }} @endif>PR</option>
                  <option value="Other Services"@if (old('purpose') == "Other Services") {{ 'selected' }} @endif>Other Services</option>
                </select>
                <p class="text-danger">@error('purpose'){{ $message }}@enderror</p> 
              </div>


              <div class="w-100 mb-3  chkPurpose_div" @if (old('purpose') != "Other Services") style="display: none" @endif>
                <input type="text" class="inputbox" name="other_purpose" id="other_purpose"   placeholder="Specify the Purpose" >
                <p class="text-danger">@error('other_purpose'){{ $message }}@enderror</p> 
              </div>


              <div class="w-100 mb-3">
                <label class="container"><strong>I acknowledge that i have received the copy of consumer guide for MARA information.</strong>
                  <input type="checkbox" name="declaration">
                  <span class="checkmark"></span>
                  <p class="text-danger">@error('declaration'){{ $message }}@enderror</p> 
                </label>
                </div>

              <div class="w-100 mb-3"> <strong>*: Under clause 3.2A of Migration Agents Regulations 1998</strong></div>

              <div class="w-100">
                <input type="submit" value="Submit"  class="submitbtns">
                
              </div>
            </form> 
            </div>

        </div>

        <div class="footer">
          
          <div class="footer-address">
            <div class="footer-address-left">
              <span><img src="Formimage/images/mapicon.png" alt=""></span>
              Harris Park <br> Location
            </div>
            <div class="footer-address-right">
              87 Wigram Street, NSW 2150. <br>
              Phone : 02 8810 8348 <br>
              Email : info@royalmigration.com.au
            </div>
          </div>

          <div class="footer-address" style="background: #be1e2e;">
            <div class="footer-address-left">
              <span><img src="Formimage/images/mapicon.png" alt=""></span>
              Seven Hills <br> Location
            </div>
            <div class="footer-address-right">
              G02/140B, Best Rd, NSW 2147 <br>
              Phone : 0481 224 444 <br>
              Email : sevenhills@royalmigration.com.au
            </div>
          </div>

        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
      $(document).ready(function(){
        $(".chkRadio").click(function(){
          var value = $(this).val();
          if (value == 'friend'){   
            $('.chkInput').css('display','block');         
            $('#other_referral').attr("placeholder","Enter friend name");

          }else if(value == 'website'){
            $('.chkInput').css('display','block');
            $('#other_referral').attr("placeholder","Enter website name");

          }else if(value == 'advertisement'){
            $('.chkInput').css('display','block');
            $('#other_referral').attr("placeholder","Enter advertisement name");

          }else{
            $('.chkInput').css('display','block');
            $('#other_referral').attr("placeholder","Specify other name");
          }
        });
      });
 
  
  $( function() {
    $( "#visa_expiry_date" ).datepicker();
  } );

  $( function() {
    $( "#dob" ).datepicker();
  } );

  $( function() {
    $( "#preferred_intake" ).datepicker();
  } );

    </script>
     

    <script>
        $(document).on('change','.ChkPurpose',function(){
        
          var value = $(this).val();
           if(value == 'Other Services'){
            $('.chkPurpose_div').css('display','block'); 
           }
           else
            {
            $('.chkPurpose_div').css('display','none'); 
           }
          


        });


     
     

    </script>
 
</body>
</html>