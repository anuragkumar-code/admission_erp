@extends('admin.layout.head')

@section('admin')



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

                                <form action="{{url('/admin/staff-edited/'.$get_staff->id)}}" method="post" enctype="multipart/form-data">

                                    @csrf  

                                    <div class="row">

                                        <div class=" col-sm-4 form-group">

                                            <label for="first_name"><strong>First Name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff->first_name}}" placeholder="Enter first name" name="first_name">

                                            <p class="text-danger">@error('first_name') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-4 form-group">

                                            <label for="last_name"><strong>Last Name (optional)</strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff->last_name}}" placeholder="Enter last name" name="last_name">

                                            <p class="text-danger">@error('last_name') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-4 form-group">

                                            <label for="email"><strong>Email <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff->email}}" placeholder="Enter staff email id" name="email" readonly>

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

                                            <input type="text" class="form-control" value="{{$get_staff->mobile}}" placeholder="Enter mobile number" onkeypress="return isNumberKey(event)" name="mobile">

                                            <p class="text-danger">@error('mobile') {{$message}}@enderror</p>

                                        </div>  

                                        <div class=" col-sm-6 form-group">

                                            <label for="postal_code"><strong>Postal Code <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff->postal}}" placeholder="Enter postal code" onkeypress="return isNumberKey(event)" name="postal_code">

                                            <p class="text-danger">@error('postal_code') {{$message}}@enderror</p>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class=" col-sm-6 form-group">

                                            <label for=""><strong>Country <span style='color: red'>*</span></strong></label>

                                            <select class="form-control" name="country">

                                                <option value="">Select Country</option>

                                                <?php if($get_countries){

                                                    foreach ($get_countries as $key => $country) {  ?>

                                                        <option <?php if($country->country_name == $get_staff->country){  ?> selected <?php }  ?> value="{{$country->country_name}}">{{ $country->country_name }}</option> 

                                                <?php  }

                                                } ?>                                                                                       

                                            </select> 

                                            <p class="text-danger">@error('country') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-6 form-group">

                                            <label for="city"><strong>City <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{$get_staff->city}}" placeholder="Enter postal code" name="city">

                                            <p class="text-danger">@error('city') {{$message}}@enderror</p>

                                        </div>   

                                    </div>   




                                    
                                    <div class="row">

                                        <div class=" col-sm-6 form-group">
                                            <label for=""><strong>Type Of Staff <span style='color: red'>*</span></strong></label>
                                            <select class="form-control jjj" name="type">
                                                <option value="">Select Type of Staff</option>
                                                <option <?php if($get_staff->type == '3' OR $get_staff->type == '1' ){?> selected <?php } ?> value="3">Admin</option>
                                                <option <?php if($get_staff->type == '2'){?> selected <?php } ?> value="2">Staff</option>

                                                </select>
                                            <p class="text-danger">@error('type') {{$message}}@enderror</p>
                                        </div>

                                        <div class=" col-sm-6 form-group">

                                            <label for="office"><strong>Office <span style='color: red'>*</span></strong></label>

                                            <select class="form-control"  name="office" id="office">

                                            <option value="">Select Office</option>
                                            <?php if($get_offices){
                                                    foreach ($get_offices as $key => $get_office) { ?>
                                                        <option  <?php if ($get_office->id == $get_staff->office_id){ ?> selected <?php } ?> value="{{$get_office->id}}">{{$get_office->name}} </option>
                                                        <?php } } ?>                                                   
                                                    </select>

                                            <p class="text-danger">@error('office') {{$message}}@enderror</p>

                                        </div>   

                                    </div>  

                                    <div class="row rights @if($get_staff->type=='3' OR $get_staff->type=='1') d-none @endif" >

                                        <label class="assignhead "><strong>Assign Rights</strong></label>

                                        <div class="chckinshow">

                                            <div class="row">

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input <?php if($get_staff->student_management == 1) { ?> checked <?php } ?> type="checkbox" value="1" name="student_management" class="chckright student_rights"/>

                                                    <b>Student Managment</b>


                                                    <div class="student_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_prospects == 1) { ?> checked <?php } ?> name="rights_prospects" class="chckright"/>
                                                        <b>Prospects</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_clients == 1) { ?> checked <?php } ?> name="rights_clients" class="chckright"/>
                                                        <b>Clients</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_whatsapp == 1) { ?> checked <?php } ?> name="rights_whatsapp" class="chckright"/>
                                                        <b>Whatsapp</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_message == 1) { ?> checked <?php } ?> name="rights_message" class="chckright"/>
                                                        <b>Message</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_email == 1) { ?> checked <?php } ?> name="rights_email" class="chckright"/>
                                                        <b>Email</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_migration == 1) { ?> checked <?php } ?> name="rights_migration" class="chckright"/>
                                                        <b>Migration</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_extra == 1) { ?> checked <?php } ?> name="rights_extra" class="chckright"/>
                                                        <b>Extra</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_mark_unread == 1) { ?> checked <?php } ?> name="rights_mark_unread" class="chckright"/>
                                                        <b>Mark Unread</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_client_notes == 1) { ?> checked <?php } ?> name="rights_client_notes" class="chckright"/>
                                                        <b>Client Notes</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_read_client_notes == 1) { ?> checked <?php } ?>  name="rights_read_client_notes" class="chckright"/>
                                                        <b>Read Client Notes</b>
                                                        <br>

                                                        <input type="checkbox" value="1" name="rights_checklist" class="chckright"/>
                                                        <b>Checklist</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_convert_to_client == 1) { ?> checked <?php } ?> name="rights_convert_to_client" class="chckright"/>
                                                        <b>Convert to Client</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_delete == 1) { ?> checked <?php } ?> name="rights_delete" class="chckright"/>
                                                        <b>Delete</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_admission_fees == 1) { ?> checked <?php } ?> name="rights_admission_fees" class="chckright"/>
                                                        <b>Admission Fees</b>
                                                        <br>

                                                        <input type="checkbox" value="1"  <?php if($get_staff->rights_material_fees == 1) { ?> checked <?php } ?>  name="rights_material_fees" class="chckright"/>
                                                        <b>Material Fees</b>
                                                        <br>

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_fees_details == 1) { ?> checked <?php } ?> name="rights_fees_details" class="chckright"/>
                                                        <b>Fees Details</b>
                                                        <br>

                                                    </div>


                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input <?php if($get_staff->staff_management == 1) { ?> checked <?php } ?> type="checkbox" value="1" name="staff_management" class="chckright"/>

                                                    <b>Staff Managment</b>

                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input <?php if($get_staff->college_management == 1) { ?> checked <?php } ?> type="checkbox" value="1" name="college_management" class="chckright"/>

                                                    <b>College Managment</b>

                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input <?php if($get_staff->course_management == 1) { ?> checked <?php } ?> type="checkbox" value="1" name="course_management" class="chckright"/>

                                                    <b>Course Managment</b>

                                                </div>

                                            </div>

                                        </div>

                                    </div> 

                                    <div class="row padsubmit">                              

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


    $(".jjj").change(function() {
        var user = $(this).val();
        if (user == 2){
            $(".rights").removeClass('d-none');
        }
        else{
            $(".rights").addClass('d-none');
        }
                

        });

</script>



    

@endsection