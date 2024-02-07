@extends('staff.layout.head')
@section('staff')
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Enter New Student Details</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form action="{{ route('staff_add_students') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="first_name"><strong>First Name <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                placeholder="First Name" value="{{old('first_name')}}">
                                            <p class="text-danger">@error('first_name') {{ $message }}  @enderror</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="middle_name"><strong>Middle Name (optional)</strong></label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name"
                                                placeholder="Middle Name"value="{{old('middle_name')}}">
                                            <p class="text-danger">@error('middle_name') {{ $message }} @enderror </p>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="last_name"><strong>Last Name (optional)</strong></label>
                                            <input type="text" class="form-control" id="last_name"name="last_name"  placeholder="Last Name" value="{{old('last_name')}}">
                                            <p class="text-danger"> @error('last_name'){{ $message }}  @enderror </p>
                                        </div>

                                     <div class="form-group col-md-4">
                                        <label for="dob"><strong>Date of Birth <span style='color: red'>*</span></strong></label>
                                        <input type="date"   max="<?php echo date("Y-m-d"); ?>" class="form-control" id="dob" placeholder="Enter D.O.B" name="dob" value="{{old('dob')}}">
                                        <p class="text-danger">@error('dob') {{ $message }} @enderror </p>
                                     </div>

                                      <div class="form-group col-md-4">
                                        <label for="address"><strong>Address <span style='color: red'>*</span></strong></label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address" value="{{old('address')}}">
                                        <p class="text-danger">@error('address'){{ $message }}@enderror  </p>
                                     </div>

                                        <div class="form-group col-md-4">
                                            <label for="country"><strong>Country <span style='color: red'>*</span></strong></label>
                                                <select class="form-control" name="country" id="country">
                                                    <option value="">Select Country</option>
                                                    @foreach ($staff_countries as $staff_country)
                                                    <option <?php if(old('country') == $staff_country->country_name){ echo 'selected'; } ?> value="{{$staff_country->country_name}}">{{$staff_country->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            <p class="text-danger">@error('country') {{ $message }} @enderror </p>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="gender"><strong>Gender <span style='color: red'>*</span></strong></label>
                                                <select class="form-control" name="gender" id="gender" >
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" @if (old('gender') == "Male") {{ 'selected' }} @endif>Male</option>
                                                    <option value="Female" @if (old('gender') == "Female") {{ 'selected' }} @endif>Female</option>
                                                    <option value="Others" @if (old('gender') == "Others") {{ 'selected' }} @endif>Others</option>
                                                  </select>
                                            <p class="text-danger">@error('gender'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="email"><strong>Email Address <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="email"  value="{{old('email')}}"placeholder="Enter Email address" name="email">
                                            <p class="text-danger">@error('email'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="phone"><strong>Phone Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="phone" value="{{old('phone')}}" placeholder="Enter Phone Number" name="phone" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger">@error('phone') {{ $message }} @enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="emergency_phone"><strong>Emergency Number <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="emergency_phone" value="{{old('emergency_phone')}}"
                                            placeholder="Enter Emergency Contact" name="emergency_phone" onkeypress="return isNumberKey(event)">
                                            <p class="text-danger">@error('emergency_phone'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="purpose"><strong>Purpose of Visit <span style='color: red'>*</span></strong></label>
                                            <select class="form-control"  name="purpose" id="purpose">
                                                <option value="">Select Purpose of Visit</option>  
                                                <option value="TR" @if (old('purpose') == "TR") {{ 'selected' }} @endif>TR</option>  
                                                <option value="PR"  @if (old('purpose') == "PR") {{ 'selected' }} @endif>PR</option>
                                                <option value="Other Services"  @if (old('purpose') == "Other Services") {{ 'selected' }} @endif>Other Services</option>
                                              </select>
                                              <div class="form-group col-md-6 otherPurpose d-none">
                                                <input class="form-control" type="text" value="{{old('other_purpose')}}" placeholder="Please specify other purpose" name="other_purpose">
                                                <p class="text-danger"> @error('other_purpose') {{ $message }}@enderror </p>
                                            </div>
                                            <p class="text-danger"> @error('purpose') {{ $message }}@enderror </p>
                                        </div>

                                        <div class="form-group col-md-6">
                                                <label for="referral"><strong>Referral </strong></label>
                                                <select class="form-control"  name="referral" id="referral">
                                                    <option value="">Select Referral</option>
                                                    <option value="Google" @if (old('referral') == "Google") {{ 'selected' }} @endif>Google</option>
                                                    <option value="Social Media" @if (old('referral') == "Social Media") {{ 'selected' }} @endif>Social Media</option>
                                                    <option value="Others Specified" @if (old('referral') == "Others Specified") {{ 'selected' }} @endif>Others </option>
                                                </select>  
                                                <div class="form-group col-md-6 otherReferral d-none">
                                                    <input class="form-control" type="text" value="{{old('other_referral')}}" placeholder="Please specify other referral" name="other_referral">
                                                <p class="text-danger">@error('other_referral'){{ $message }}@enderror</p>                                          

                                                </div>   
                                                <p class="text-danger">@error('referral'){{ $message }}@enderror</p>                                          
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="priority"><strong>Priority <span style='color: red'>*</span></strong></label>
                                            <select class="form-control"  name="priority" id="priority">
                                                <option value="">Select Status</option>
                                                <option value="1" @if (old('priority') == "1") {{ 'selected' }} @endif>Highest</option>
                                                <option value="2" @if (old('priority') == "2") {{ 'selected' }} @endif>Medium</option>
                                                <option value="3" @if (old('priority') == "3") {{ 'selected' }} @endif>Low</option>
                                            </select>
                                            <p class="text-danger">@error('priority'){{ $message }}@enderror</p>                                            
                                        </div>


                                        <div class="form-group col-md-12">
                                            <label for="comment"><strong>Comment <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="comment" value="{{old('comment')}}" placeholder="Enter Comment" name="comment">
                                            <p class="text-danger"> @error('comment'){{ $message }}@enderror</p>
                                        </div> 
                                        <input type="hidden" name="user_id" class="student_id">

                                    </div>
                                        <button type="submit" class="btn btn-outline-info">Add Student</button>
                                </form>    
                             </div>
                          </div>
                        </div>                        
                </section> 
             </div>
        </div>            
    </div>    

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
            var referal = $("#referral").val();

            if(referal == 'Others Specified')
            {
                $('.otherReferral').removeClass('d-none');
            }
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

         if(purpose == 'Other Services'){
            $('.otherPurpose').removeClass('d-none');

         }
        });  
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

