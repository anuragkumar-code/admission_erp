@extends('admin.layout.head')

@section('admin')



    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>Add New Staff Details</h1>

                            </div>

                        </div>

                    </div>                    

                </div>



                <section id="main-content">

                    <div class="row">                        

                        <div class="col-lg-12">

                            <div class="card">                               

                                <form action="{{url('/admin/staff-added')}}" method="post" enctype="multipart/form-data">

                                    @csrf  

                                    <div class="row">

                                        <div class=" col-sm-4 form-group">

                                            <label for="first_name"><strong>First Name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{old('first_name')}}" placeholder="Enter first name" name="first_name">

                                            <p class="text-danger">@error('first_name') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-4 form-group">

                                            <label for="last_name"><strong>Last Name (optional)</strong></label>

                                            <input type="text" class="form-control" value="{{old('last_name')}}" placeholder="Enter last name" name="last_name">

                                            <p class="text-danger">@error('last_name') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-4 form-group">

                                            <label for="email"><strong>Email <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{old('email')}}" placeholder="Enter staff email id" name="email">
                                            <p class="text-danger">@error('email') {{$message}}@enderror</p>
                                        </div>

                                    </div>                              

                                    

                                    <div class="row">                                        

                                        <div class=" col-sm-6 form-group">

                                            <label for="password"><strong>Password <span style='color: red'>*</span></strong></label>

                                            <input type="password" class="form-control" placeholder="Enter password" id="password-field" name="password">

                                            {{-- <span toggle="#password-field" class="fa fa-sm fa-eye field-icon toggle-password"></span> --}}

                                            <p class="password-instruction">Use atleast 6 characters.</p>

                                            <p class="text-danger">@error('password') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-6 form-group">

                                            <label for="confirm_password"><strong>Confirm Password <span style='color: red'>*</span></strong></label>

                                            <input type="password" class="form-control" placeholder="Enter password" id="password-field" name="confirm_password">

                                            {{-- <span toggle="#password-field" class="fa fa-sm fa-eye field-icon toggle-password"></span> --}}

                                            <p class="password-instruction">Confirm password should match with password.</p>

                                            <p class="text-danger">@error('confirm_password') {{$message}}@enderror</p>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class=" col-sm-6 form-group">

                                            <label for="mobile"><strong>Mobile <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{old('mobile')}}" placeholder="Enter mobile number" onkeypress="return isNumberKey(event)" name="mobile">

                                            <p class="text-danger">@error('mobile') {{$message}}@enderror</p>

                                        </div>  

                                        <div class=" col-sm-6 form-group">

                                            <label for="postal_code"><strong>Postal Code <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{old('postal_code')}}" placeholder="Enter postal code" onkeypress="return isNumberKey(event)" name="postal_code">

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

                                                        <option value="{{$country->country_name}}" @if (old('country') == $country->country_name) {{ 'selected' }} @endif>{{ $country->country_name }}</option> 

                                                <?php  }

                                                } ?>                                                                                       

                                            </select> 

                                            <p class="text-danger">@error('country') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-6 form-group">

                                            <label for="city"><strong>City <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" value="{{old('city')}}" placeholder="Enter City" name="city">

                                            <p class="text-danger">@error('city') {{$message}}@enderror</p>

                                        </div>   

                                    </div>   

                                    <div class="row">

                                        <div class=" col-sm-6 form-group">

                                            <label for=""><strong>Type Of Staff <span style='color: red'>*</span></strong></label>

                                            <select id="mySelect" class="form-control jjj" name="type">

                                                <option value="">Select Type</option>

                                                <option  value="3"@if (old('type') == "3") {{ 'selected' }} @endif>Admin</option>
                                                <option value="2"@if (old('type') == "2") {{ 'selected' }} @endif>Staff</option>                                                                                  

                                            </select> 

                                            <p class="text-danger">@error('type') {{$message}}@enderror</p>

                                        </div>

                                        <div class=" col-sm-6 form-group">

                                            <label for="office"><strong>Office <span style='color: red'>*</span></strong></label>

                                            <select class="form-control"  name="office" id="office">

                                            <option value="">Select Office</option>
                                                <?php if($get_offices){
                                                    foreach ($get_offices as $key => $get_office) { ?>
                                                        <option value="{{$get_office->id}}" @if(old('office') == $get_office->id) {{ 'selected'}}  @endif >{{$get_office->name}} </option>
                                                        <?php } } ?>                                                   
                                                    </select>

                                            <p class="text-danger">@error('office') {{$message}}@enderror</p>

                                        </div>   

                                    </div>   

                                    <div class="row d-none rights">
                                        <label class="assignhead"><strong>Assign Rights</strong></label>
                                        <div class="chckinshow">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-6 chckstrip">
                                                    <input type="checkbox" value="1" {{ old('student_management') == '1' ? 'checked' : ''}} name="student_management" class="chckright student_rights"/>
                                                    <b>Student Managment</b>


                                                    <div class="student_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('prospects') == '1' ? 'checked' : ''}} name="rights_prospects" class="chckright"/>
                                                        <b>Prospects</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('clients') == '1' ? 'checked' : ''}} name="rights_clients" class="chckright"/>
                                                        <b>Clients</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('whatsapp') == '1' ? 'checked' : ''}} name="rights_whatsapp" class="chckright"/>
                                                        <b>Whatsapp</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('message') == '1' ? 'checked' : ''}} name="rights_message" class="chckright"/>
                                                        <b>Message</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('email') == '1' ? 'checked' : ''}} name="rights_email" class="chckright"/>
                                                        <b>Email</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('migration') == '1' ? 'checked' : ''}} name="rights_migration" class="chckright"/>
                                                        <b>Migration</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('extra') == '1' ? 'checked' : ''}} name="rights_extra" class="chckright"/>
                                                        <b>Extra</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('mark_unread') == '1' ? 'checked' : ''}} name="rights_mark_unread" class="chckright"/>
                                                        <b>Mark Unread</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('client_notes') == '1' ? 'checked' : ''}} name="rights_client_notes" class="chckright"/>
                                                        <b>Client Notes</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('read_client_notes') == '1' ? 'checked' : ''}} name="rights_read_client_notes" class="chckright"/>
                                                        <b>Read Client Notes</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('checklist') == '1' ? 'checked' : ''}} name="rights_checklist" class="chckright"/>
                                                        <b>Checklist</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('convert_to_client') == '1' ? 'checked' : ''}} name="rights_convert_to_client" class="chckright"/>
                                                        <b>Convert to Client</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('delete') == '1' ? 'checked' : ''}} name="rights_delete" class="chckright"/>
                                                        <b>Delete</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('admission_fees') == '1' ? 'checked' : ''}} name="rights_admission_fees" class="chckright"/>
                                                        <b>Admission Fees</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('material_fees') == '1' ? 'checked' : ''}} name="rights_material_fees" class="chckright"/>
                                                        <b>Material Fees</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('fees_details') == '1' ? 'checked' : ''}} name="rights_fees_details" class="chckright"/>
                                                        <b>Fees Details</b>
                                                        <br>

                                                    </div>

                                                    


                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">
                                                    <input type="checkbox" value="1" 
                                                    {{ old('staff_management') == '1' ? 'checked' : ''}} name="staff_management" class="chckright"/>
                                                    <b>Staff Managment</b>
                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="college_management" class="chckright" {{ old('college_management') == '1' ? 'checked' : ''}}/>

                                                    <b>College Managment</b>

                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="course_management" class="chckright"/>

                                                    <b>Course Managment</b>

                                                </div>

                                            </div>

                                        </div>

                                    </div> 


                                    


                                    <div class="row padsubmit">                              

                                        <button type="submit" class="btn btn-outline-info">Add Staff</button>

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

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;

    }

    $(".jjj").change(function() {
        var user = $(this).val();
        if (user == 2){
            $(".rights").removeClass('d-none');
        }
        else{
            $(".rights").addClass('d-none');
        }
                

        });




$(".student_rights").click(function() {
    if($(this).is(":checked")) {
        $(".student_mgmt_rights").removeClass('d-none');
    } else {
        $(".student_mgmt_rights").addClass('d-none');
    }
});

</script>



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





