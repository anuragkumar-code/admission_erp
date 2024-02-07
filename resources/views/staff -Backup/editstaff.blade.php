@extends('staff.layout.head')

@section('staff')



    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>Edit Staff Details</h1>

                            </div>

                        </div>

                    </div>                    

                </div>



                <section id="main-content">

                    <div class="row">                        

                        <div class="col-lg-12">

                            <div class="card">                               

                                <form action="{{url('/staff/staff-updated/'.$get_staff_staff->id)}}" method="post" enctype="multipart/form-data">

                                    @csrf  

                                    <div class="row">

                                        <div class=" col-sm-4 form-group">

                                            <label for="first_name"><strong>First Name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff_staff ->first_name}}" placeholder="Enter first name" name="first_name">

                                            <p class="text-danger">@error('first_name') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-4 form-group">

                                            <label for="last_name"><strong>Last Name (optional)</strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff_staff->last_name}}" placeholder="Enter last name" name="last_name">

                                            <p class="text-danger">@error('last_name') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-4 form-group">

                                            <label for="email"><strong>Email <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff_staff->email}}" placeholder="Enter staff email id" name="email" readonly>

                                            <p class="text-danger">@error('email') {{$message}}@enderror</p>

                                        </div>

                                    </div>                              

                                    

                                    <div class="row">                                        

                                        <div class=" col-sm-6 form-group">

                                            <label for="password"><strong>Password <span style='color: red'>*</span></strong></label>

                                            <input type="password" class="form-control" placeholder="Enter password to update" id="password-field" name="password">

                                            {{-- <span toggle="#password-field" class="fa fa-sm fa-eye field-icon toggle-password"></span> --}}

                                            <p class="password-instruction">Use atleast 6 characters.</p>

                                            <p class="text-danger">@error('password') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-6 form-group">

                                            <label for="confirm_password"><strong>Confirm Password <span style='color: red'>*</span></strong></label>

                                            <input type="password" class="form-control" placeholder="Confirm password" id="password-field" name="confirm_password">

                                            {{-- <span toggle="#password-field" class="fa fa-sm fa-eye field-icon toggle-password"></span> --}}   

                                            <p class="password-instruction">Confirm password should match with password.</p>                                         

                                            <p class="text-danger">@error('confirm_password') {{$message}}@enderror</p>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class=" col-sm-6 form-group">

                                            <label for="mobile"><strong>Mobile <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff_staff->mobile}}" placeholder="Enter mobile number" onkeypress="return isNumberKey(event)" name="mobile">

                                            <p class="text-danger">@error('mobile') {{$message}}@enderror</p>

                                        </div>  

                                        <div class=" col-sm-6 form-group">

                                            <label for="postal_code"><strong>Postal Code <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff_staff->postal}}" placeholder="Enter postal code" onkeypress="return isNumberKey(event)" name="postal_code">

                                            <p class="text-danger">@error('postal_code') {{$message}}@enderror</p>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class=" col-sm-6 form-group">

                                            <label for=""><strong>Country <span style='color: red'>*</span></strong></label>

                                            <select class="form-control" name="country">

                                                <option value="">Select Country</option>

                                                <?php if($get_staff_countries){

                                                    foreach ($get_staff_countries as $key => $get_staff_country) {  ?>

                                                        <option <?php if($get_staff_country->country_name == $get_staff_staff->country){  ?> selected <?php }  ?> value="{{$get_staff_country->country_name}}">{{ $get_staff_country->country_name }}</option> 

                                                <?php  }

                                                } ?>                                                                                       

                                            </select> 

                                            <p class="text-danger">@error('country') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-6 form-group">

                                            <label for="city"><strong>City <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff_staff->city}}" placeholder="Enter postal code" name="city">

                                            <p class="text-danger">@error('city') {{$message}}@enderror</p>

                                        </div>   

                                    </div>   

                                    <div class="row">

                                        <label class="assignhead"><strong>Assign Rights</strong></label>

                                        <div class="chckinshow">

                                            <div class="row">

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input <?php if($get_staff_staff->student_management == 1) { ?> checked <?php } ?> type="checkbox" value="1" name="student_management" class="chckright"/>

                                                    <b>Student Managment</b>

                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input <?php if($get_staff_staff->staff_management == 1) { ?> checked <?php } ?> type="checkbox" value="1" name="staff_management" class="chckright"/>

                                                    <b>Staff Managment</b>

                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input <?php if($get_staff_staff->college_management == 1) { ?> checked <?php } ?> type="checkbox" value="1" name="college_management" class="chckright"/>

                                                    <b>College Managment</b>

                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input <?php if($get_staff_staff->course_management == 1) { ?> checked <?php } ?> type="checkbox" value="1" name="course_management" class="chckright"/>

                                                    <b>Course Managment</b>

                                                </div>

                                            </div>

                                        </div>

                                    </div> 

                                    <div class="row padsubmit">                              

                                        <button type="submit" class="btn btn-outline-info">Update </button>

                                    </div>

                                </form>

                            </div>                                                                      

                        </div>          

                    </div>                                         

                </section>

            </div>

        </div>

    </div>







<script type="text/javascript">

    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");

            var input = $($(this).attr("toggle"));

            if (input.attr("type") == "password") {

            input.attr("type", "text");

                } else {

                    input.attr("type", "password");

                }

    });

</script>



    

@endsection





