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

                                        <div class=" col-sm-4 form-group">
                                            <label for="mobile"><strong>Mobile <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" value="{{$get_staff->mobile}}" placeholder="Enter mobile number" onkeypress="return isNumberKey(event)" name="mobile">
                                            <p class="text-danger">@error('mobile') {{$message}}@enderror</p>
                                        </div>  

                                        <div class=" col-sm-4 form-group">
                                            <label for="postal_code"><strong>Postal Code <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" value="{{$get_staff->postal}}" placeholder="Enter postal code" onkeypress="return isNumberKey(event)" name="postal_code">
                                            <p class="text-danger">@error('postal_code') {{$message}}@enderror</p>
                                        </div>


                                        <div class=" col-sm-4 form-group">
                                            <label for="ip_address"><strong>IP Address <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" value="{{$get_staff->ip_address}}" placeholder="Enter Ip Address" name="ip_address">
                                            <p class="text-danger">@error('ip_address') {{$message}}@enderror</p>
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

                                     <div class="row <?php if($get_staff->type != 2){?>d-none <?php } ?> rights">
                                        <label class="assignhead"><strong>Assign Rights</strong></label>
                                        <div class="chckinshow">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-6 chckstrip">
                                                    <input type="checkbox" value="1" <?php if($get_staff->student_management == 1){ ?> checked <?php } ?> name="student_management" class="chckright student_rights"/>
                                                    <b>Student Managment</b>


                                                    <!-- <div class="student_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('rights_prospects') == '1' ? 'checked' : ''}} name="rights_prospects" class="chckright"/>
                                                        <b>Prospects</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_clients') == '1' ? 'checked' : ''}} name="rights_clients" class="chckright"/>
                                                        <b>Clients</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_whatsapp') == '1' ? 'checked' : ''}} name="rights_whatsapp" class="chckright"/>
                                                        <b>Whatsapp</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_message') == '1' ? 'checked' : ''}} name="rights_message" class="chckright"/>
                                                        <b>Message</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_email') == '1' ? 'checked' : ''}} name="rights_email" class="chckright"/>
                                                        <b>Email</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_migration') == '1' ? 'checked' : ''}} name="rights_migration" class="chckright"/>
                                                        <b>Migration</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_extra') == '1' ? 'checked' : ''}} name="rights_extra" class="chckright"/>
                                                        <b>Extra</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_mark_unread') == '1' ? 'checked' : ''}} name="rights_mark_unread" class="chckright"/>
                                                        <b>Mark Unread</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_client_notes') == '1' ? 'checked' : ''}} name="rights_client_notes" class="chckright"/>
                                                        <b>Client Notes</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_read_client_notes') == '1' ? 'checked' : ''}} name="rights_read_client_notes" class="chckright"/>
                                                        <b>Read Client Notes</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_checklist') == '1' ? 'checked' : ''}} name="rights_checklist" class="chckright"/>
                                                        <b>Checklist</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_convert_to_client') == '1' ? 'checked' : ''}} name="rights_convert_to_client" class="chckright"/>
                                                        <b>Convert to Client</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_delete') == '1' ? 'checked' : ''}} name="rights_delete" class="chckright"/>
                                                        <b>Delete</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_admission_fees') == '1' ? 'checked' : ''}} name="rights_admission_fees" class="chckright"/>
                                                        <b>Admission Fees</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_material_fees') == '1' ? 'checked' : ''}} name="rights_material_fees" class="chckright"/>
                                                        <b>Material Fees</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_fees_details') == '1' ? 'checked' : ''}} name="rights_fees_details" class="chckright"/>
                                                        <b>Fees Details</b>
                                                        <br>

                                                    </div> -->

                                                </div>


                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="student_delete_management" class="chckright student_delete_rights" <?php if($get_staff->student_delete_management == 1){ ?> checked <?php } ?>>
                                                    <b>Right to Delete Students</b>
                                                </div>

                                                <!-- <div class="col-lg-3 col-md-6 chckstrip">
                                                    <input type="checkbox" value="1" 
                                                    {{ old('staff_management') == '1' ? 'checked' : ''}} name="staff_management" class="chckright staff_rights"/>
                                                    <b>Staff Managment</b>

                                                     <div class="staff_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('rights_staff_add') == '1' ? 'checked' : ''}} name="rights_staff_add" class="chckright"/>
                                                        <b>Add</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_staff_edit') == '1' ? 'checked' : ''}} name="rights_staff_edit" class="chckright"/>
                                                        <b>Edit</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_staff_delete') == '1' ? 'checked' : ''}} name="rights_staff_delete" class="chckright"/>
                                                        <b>Delete</b>
                                                        <br>

                                                    
                                                        

                                                        
                                                        <br>

                                                    </div>

                                                </div> -->

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="college_management" class="chckright college_rights" <?php if($get_staff->college_management == 1){ ?> checked <?php } ?>>

                                                    <b>College Managment</b>


                                                    <div class="college_mgmt_rights <?php if($get_staff->college_management == 0){ ?> d-none <?php } ?>">

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_college_add == 1){ ?> checked <?php } ?> name="rights_college_add" class="chckright"/>
                                                        <b>Add College</b>
                                                        <br>

                                                        <!-- <input type="checkbox" value="1" {{ old('rights_college_edit') == '1' ? 'checked' : ''}} name="rights_college_edit" class="chckright"/>
                                                        <b>Edit College</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_college_delete') == '1' ? 'checked' : ''}} name="rights_college_delete" class="chckright"/>
                                                        <b>Delete College</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_college_course') == '1' ? 'checked' : ''}} name="rights_college_course" class="chckright course_rights"/>
                                                        <b>Courses</b>
                                                        <br> -->

                                                       <!--  <div class="course_mgmt_rights d-none"> 

                                                        <input type="checkbox" value="1" {{ old('rights_college_course_add') == '1' ? 'checked' : ''}} name="rights_college_course_add" class="chckright"/>
                                                        <b>Add Course</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_college_course_edit') == '1' ? 'checked' : ''}} name="rights_college_course_edit" class="chckright"/>
                                                        <b>Edit Course</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_college_course_delete') == '1' ? 'checked' : ''}} name="rights_college_course_delete" class="chckright"/>
                                                        <b>Delete Course</b>
                                                        <br>
                                                          </div> -->

                                                    </div>

                                                </div>

                                              

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="migration_management" class="chckright migration_rights" <?php if($get_staff->migration_management == 1){ ?> checked <?php } ?> >
                                                    <b>Migration Managment</b>
                                                    <br>

                                                    <input type="checkbox" value="1" name="extra_management" class="chckright extra_rights" <?php if($get_staff->extra_management == 1){ ?> checked <?php } ?> >
                                                    <b>Extra Managment</b>

                                                    <!--   <div class="migration_mgmt_rights d-none">

                                                         <input type="checkbox" value="1" {{ old('rights_migration_message') == '1' ? 'checked' : ''}} name="rights_migration_message" class="chckright"/>
                                                        <b>Message</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_migration_whatsapp') == '1' ? 'checked' : ''}} name="rights_migration_whatsapp" class="chckright"/>
                                                        <b>Whatsapp</b>
                                                        <br>

                                                       

                                                        <input type="checkbox" value="1" {{ old('rights_migration_email') == '1' ? 'checked' : ''}} name="rights_migration_email" class="chckright"/>
                                                        <b>Email</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_migration_prospect') == '1' ? 'checked' : ''}} name="rights_migration_prospect" class="chckright"/>
                                                        <b>Make Prospect</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_migration_clientnotes') == '1' ? 'checked' : ''}} name="rights_migration_clientnotes" class="chckright"/>
                                                        <b>Client Notes</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_migration_checklist') == '1' ? 'checked' : ''}} name="rights_migration_checklist" class="chckright"/>
                                                        <b>Checklist</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_migration_details') == '1' ? 'checked' : ''}} name="rights_migration_details" class="chckright"/>
                                                        <b>Migration Details</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_migration_delete') == '1' ? 'checked' : ''}} name="rights_migration_delete" class="chckright"/>
                                                        <b>Delete</b>
                                                        <br>

                                                        

                                                    </div>
 -->
                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="task_management" class="chckright task_rights" <?php if($get_staff->task_management == 1){ ?> checked <?php } ?> >

                                                    <b>Task Managment</b>

                                                <!--     <div class="task_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('rights_task_open') == '1' ? 'checked' : ''}} name="rights_task_open" class="chckright"/>
                                                        <b>Open</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_task_snooze') == '1' ? 'checked' : ''}} name="rights_task_snooze" class="chckright"/>
                                                        <b>Snooze</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_task_close') == '1' ? 'checked' : ''}} name="rights_task_close" class="chckright"/>
                                                        <b>Close</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_task_comment') == '1' ? 'checked' : ''}} name="rights_task_comment" class="chckright"/>
                                                        <b>Comment on Status</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_task_edit') == '1' ? 'checked' : ''}} name="rights_task_edit" class="chckright"/>
                                                        <b>Edit Task</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_task_read') == '1' ? 'checked' : ''}} name="rights_task_read" class="chckright"/>
                                                        <b>Mark Read</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_task_delete') == '1' ? 'checked' : ''}} name="rights_task_delete" class="chckright"/>
                                                        <b>Delete</b>
                                                        <br>

                                                        
                                                    </div> -->

                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="follow_up_management" class="chckright follow_rights" <?php if($get_staff->follow_up_management == 1){ ?> checked <?php } ?> >

                                                    <b>Follow up Managment</b>


                                                    <div class="follow_mgmt_rights <?php if($get_staff->follow_up_management == 0){ ?> d-none <?php } ?>">

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_visa_expire == 1){ ?> checked <?php } ?> name="rights_visa_expire" class="chckright visa_rights"/>
                                                        <b>VISA EXPIRE</b>
                                                        <br>

                                                        <!-- <div class="visa_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('rights_visa_message') == '1' ? 'checked' : ''}} name="rights_visa_message" class="chckright"/>
                                                        <b>Message</b>
                                                        <br>
                                                        
                                                        <input type="checkbox" value="1" {{ old('rights_visa_whatsapp') == '1' ? 'checked' : ''}} name="rights_visa_whatsapp" class="chckright"/>
                                                        <b>Whatsapp</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_visa_email') == '1' ? 'checked' : ''}} name="rights_visa_email" class="chckright"/>
                                                        <b>Email</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_visa_comment') == '1' ? 'checked' : ''}} name="rights_visa_comment" class="chckright"/>
                                                        <b>View (Add Comment)</b>
                                                        <br>    

                                                        <input type="checkbox" value="1" {{ old('rights_visa_open') == '1' ? 'checked' : ''}} name="rights_visa_open" class="chckright"/>
                                                        <b>Open</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_visa_snooze') == '1' ? 'checked' : ''}} name="rights_visa_snooze" class="chckright"/>
                                                        <b>Snooze</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_visa_close') == '1' ? 'checked' : ''}} name="rights_visa_close" class="chckright"/>
                                                        <b>Close</b>
                                                        <br>


                                                         </div> -->

                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_passport_expire == 1){ ?> checked <?php } ?> name="rights_passport_expire" class="chckright passport_rights"/>
                                                        <b>PASSPORT EXPIRE</b>
                                                        <br>

                                                        <!-- <div class="passport_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('rights_passport_message') == '1' ? 'checked' : ''}} name="rights_passport_message" class="chckright"/>
                                                        <b>Message</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_passport_whatsapp') == '1' ? 'checked' : ''}} name="rights_passport_whatsapp" class="chckright"/>
                                                        <b>Whatsapp</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_passport_email') == '1' ? 'checked' : ''}} name="rights_passport_email" class="chckright"/>
                                                        <b>Email</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_passport_comment') == '1' ? 'checked' : ''}} name="rights_passport_comment" class="chckright"/>
                                                        <b>View (Add Comment)</b>
                                                        <br>    

                                                        <input type="checkbox" value="1" {{ old('rights_passport_open') == '1' ? 'checked' : ''}} name="rights_passport_open" class="chckright"/>
                                                        <b>Open</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_passport_snooze') == '1' ? 'checked' : ''}} name="rights_passport_snooze" class="chckright"/>
                                                        <b>Snooze</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_passport_close') == '1' ? 'checked' : ''}} name="rights_passport_close" class="chckright"/>
                                                        <b>Close</b>
                                                        <br>

                                                         </div> -->


                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_fees_due == 1){ ?> checked <?php } ?> name="rights_fees_due" class="chckright fees_due_rights "/>
                                                        <b>FEES DUE</b>
                                                        <br>

                                                        <!-- <div class="fees_due_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('rights_fees_due_message') == '1' ? 'checked' : ''}} name="rights_fees_due_message" class="chckright"/>
                                                        <b>Message</b>
                                                        <br>
                                                        
                                                        <input type="checkbox" value="1" {{ old('rights_fees_due_whatsapp') == '1' ? 'checked' : ''}} name="rights_fees_due_whatsapp" class="chckright"/>
                                                        <b>Whatsapp</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_fees_due_email') == '1' ? 'checked' : ''}} name="rights_fees_due_email" class="chckright"/>
                                                        <b>Email</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_fees_due_comment') == '1' ? 'checked' : ''}} name="rights_fees_due_comment" class="chckright"/>
                                                        <b>View (Add Comment)</b>
                                                        <br>    

                                                        <input type="checkbox" value="1" {{ old('rights_fees_due_open') == '1' ? 'checked' : ''}} name="rights_fees_due_open" class="chckright"/>
                                                        <b>Open</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_fees_due_snooze') == '1' ? 'checked' : ''}} name="rights_fees_due_snooze" class="chckright"/>
                                                        <b>Snooze</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_fees_due_close') == '1' ? 'checked' : ''}} name="rights_fees_due_close" class="chckright"/>
                                                        <b>Close</b>
                                                        <br>


                                                         </div> -->


                                                        <input type="checkbox" value="1" <?php if($get_staff->rights_course_completion == 1){ ?> checked <?php } ?> name="rights_course_completion" class="chckright course_completion_rights"/>
                                                        <b>COURSE COMPLETION</b>
                                                        <br>

                                                        
                                                        <!-- <div class="course_completion_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('rights_course_completion_message') == '1' ? 'checked' : ''}} name="rights_course_completion_message" class="chckright"/>
                                                        <b>Message</b>
                                                        <br>
                                                        
                                                        <input type="checkbox" value="1" {{ old('rights_course_completion_whatsapp') == '1' ? 'checked' : ''}} name="rights_course_completion_whatsapp" class="chckright"/>
                                                        <b>Whatsapp</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_course_completion_email') == '1' ? 'checked' : ''}} name="rights_course_completion_email" class="chckright"/>
                                                        <b>Email</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_course_completion_comment') == '1' ? 'checked' : ''}} name="rights_course_completion_comment" class="chckright"/>
                                                        <b>View (Add Comment)</b>
                                                        <br>    

                                                        <input type="checkbox" value="1" {{ old('rights_course_completion_open') == '1' ? 'checked' : ''}} name="rights_course_completion_open" class="chckright"/>
                                                        <b>Open</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_course_completion_snooze') == '1' ? 'checked' : ''}} name="rights_course_completion_snooze" class="chckright"/>
                                                        <b>Snooze</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_course_completion_close') == '1' ? 'checked' : ''}} name="rights_course_completion_close" class="chckright"/>
                                                        <b>Close</b>
                                                        <br>


                                                         </div> -->


                                                        

                                                    </div>

                                                </div>

                                                <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="filter_management" class="chckright filter_rights" <?php if($get_staff->filter_management == 1){ ?> checked <?php } ?> />
                                                    <b>Filter Managment</b>                             

                                                </div>

                                                <!-- <div class="col-lg-3 col-md-6 chckstrip">

                                                    <input type="checkbox" value="1" name="referral_management" class="chckright referral_rights" {{ old('referral_management') == '1' ? 'checked' : ''}} />

                                                    <b>Referral Managment</b>


                                                    <div class="referral_mgmt_rights d-none">

                                                        <input type="checkbox" value="1" {{ old('rights_referral_view') == '1' ? 'checked' : ''}} name="rights_referral_view" class="chckright"/>
                                                        <b>View</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_referral_add') == '1' ? 'checked' : ''}} name="rights_referral_add" class="chckright"/>
                                                        <b>Add</b>
                                                        <br>

                                                        <input type="checkbox" value="1" {{ old('rights_referral_edit') == '1' ? 'checked' : ''}} name="rights_referral_edit" class="chckright"/>
                                                        <b>Edit </b>
                                                        <br>

                                                        

                                                    </div>

                                                </div> -->

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


$(".college_rights").click(function() {
    if($(this).is(":checked")) {
        $(".college_mgmt_rights").removeClass('d-none');
    } else {
        $(".college_mgmt_rights").addClass('d-none');
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