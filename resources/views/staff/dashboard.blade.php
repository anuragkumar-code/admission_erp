@extends('staff.layout.head')
@section('staff')

<div class="content-wrap">
    <div class="main">            
        <div class="container-fluid">                
            <div class="dashinfostrip">
                <div class="dashrow">

                                    @if(session()->has('success'))
                                    <div class="alert alert-success" id="myDIV" role="alert">
                                        <strong>{{session()->get('success')}}</strong> 
                                        <i class="fa fa-close closeicon" onclick="hide()" aria-hidden="true"></i>                                                   
                                    </div>
                                    @endif
                        
                                    @if(session()->has('error'))
                                    <div class="alert alert-danger" id="myDIV" role="alert">
                                        <strong>{{session()->get('error')}}</strong> 
                                        <i class="fa fa-close closeicon" onclick="hide()" aria-hidden="true"></i>                                                    
                                    </div>
                                    @endif

                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="dashbox">
                                <a href="{{route('students')}}">
                                    <div class="dashicon">
                                        <img src="{{url('admin/images/dashicon01.png')}}" alt=""/>
                                    </div>
                                    <div class="dashtxt">
                                        <h6>{{$student_count}}</h6>
                                        <p>Students</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="dashbox">
                                <a href="{{route('staff')}}">
                                    <div class="dashicon">
                                        <img src="{{url('admin/images/dashicon02.png')}}" alt=""/>
                                    </div>
                                    <div class="dashtxt">
                                        <h6>{{$staff_count}}</h6>
                                        <p class="dashcolor">Staff</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="dashbox">
                                <a href="{{route('colleges')}}">
                                    <div class="dashicon">
                                        <img src="{{url('admin/images/dashicon03.png')}}" alt=""/>
                                    </div>
                                    <div class="dashtxt">
                                        <h6>{{$college_count}}</h6>
                                        <p class="dashcolor02">Colleges</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="clear: both"></div>

            <?php
            $is_admin = Auth::user()->type;
            $office_id = Auth::user()->office_id;
            
                if($is_admin == 2 && $office_id == 10)
                {
            ?>
            <!-- 2nd -->

         <div class="office_wise_data">
            <div class="tsp-content-counter box21">
                <h2>Harris Park</h2>
                <div class="tsp-count">
                    <p class="count"><?php echo $client_hp_count; ?></p>
                    <p class="tsp-section">Clients</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $prospects_hp_count; ?></p>
                    <p class="tsp-section">Prospects</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $migration_hp_count; ?></p>
                    <p class="tsp-section">Migration</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $extra_hp_count; ?></p>
                    <p class="tsp-section">Extra</p>
                </div>
            </div>

        <?php } if($is_admin == 2 && $office_id == 11){ ?>

              <div class="tsp-content-counter box22">
               <h2> Seven Hills</h2>
                <div class="tsp-count">
                    <p class="count"><?php echo $client_sh_count; ?></p>
                    <p class="tsp-section">Clients</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $prospects_sh_count; ?></p>
                    <p class="tsp-section">Prospects</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $migration_sh_count; ?></p>
                    <p class="tsp-section">Migration</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $extra_sh_count; ?></p>
                    <p class="tsp-section">Extra</p>
                </div>
            </div> 

           <?php } if($is_admin == 2 && $office_id == 12){ ?>

            <div class="tsp-content-counter box23">
                <h2>Adelaide</h2>
                <div class="tsp-count">
                    <p class="count"><?php echo $client_ad_count; ?></p>
                    <p class="tsp-section">Clients</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $prospects_ad_count; ?></p>
                    <p class="tsp-section">Prospects</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $migration_ad_count; ?></p>
                    <p class="tsp-section">Migration</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php echo $extra_ad_count; ?></p>
                    <p class="tsp-section">Extra</p>
                </div>
            </div> 
        </div>


<?php } ?>




        <?php //} else { ?>

            <!-- <div class="tsp-content-counter box21">
                <div class="tsp-count">
                    <p class="count"><?php //echo $client_st_count; ?></p>
                    <p class="tsp-section">Clients</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php //echo $prospects_st_count; ?></p>
                    <p class="tsp-section">Prospects</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php //echo $migration_st_count; ?></p>
                    <p class="tsp-section">Migration</p>
                </div>

                <div class="tsp-count">
                    <p class="count"><?php //echo $extra_st_count; ?></p>
                    <p class="tsp-section">Extra</p>
                </div>
            </div> -->

        <?php //} ?>
            <div style="clear: both"></div> 

            <div class="row">
                <div class="col-md-3">                    
                    <div class="dash_box1">
                        <div class="fees_due_followup">Fees Due Followup</div>
                        <div class="dash_details">
                            <ul>
                                <li><a href="{{url('staff/fees_due#feesdue-open-tab')}}">Open requests ({{$fees_duedate_students_count}})</a></li>
                                <li><a href="{{url('staff/fees_due#feesdue-snooze-tab')}}">Snooze requests ({{$snooze_fees_duedate_students_count}})</a></li>
                                <li><a href="{{url('staff/fees_due#feesdue-close-tab')}}">Close requests ({{$close_fees_duedate_students_count}})</a></li>
                            </ul>
                        </div>
                    </div>
                </div>



           
                <div class="col-md-3">                    
                    <div class="dash_box1">
                        <div class="course_exp_followup"> Course Exp Followup</div>
                        <div class="dash_details">
                            <ul>
                                <li><a href="{{url('course_completion#courseExpire-open-tab')}}">Open requests ({{$course_completion_students_count}})</a></li>
                                <li><a href="{{url('course_completion#courseExpire-snooze-tab')}}">Snooze requests ({{$snooze_course_completion_students_count}})</a></li>
                                <li><a href="{{url('course_completion#courseExpire-close-tab')}}">Close requests ({{$close_course_completion_students_count}})</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">                    
                    <div class="dash_box1">
                        <div class="visa_exp_followup"> Visa Exp Followup</div>
                        <div class="dash_details">
                            <ul>
                                <li><a href="{{url('visa_expire#visaExpire-open-tab')}}">Open requests ({{$visa_expiry_students_count}})</a></li>
                                <li><a href="{{url('visa_expire#visaExpire-snooze-tab')}}">Snooze requests ({{$snooze_visa_expiry_students_count}})</a></li>
                                <li><a href="{{url('visa_expire#visaExpire-close-tab')}}">Close requests ({{$close_visa_expiry_students_count}})</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">                    
                    <div class="dash_box1">
                        <div class="passport_exp_followup"> Passport Exp Followup</div>
                        <div class="dash_details">
                            <ul>
                                <li><a href="{{url('passport_expire#passportexpire-open-tab')}}">Open requests ({{$passport_expiry_students_count}})</a></li>
                                <li><a href="{{url('passport_expire#passportexpire-snooze-tab')}}">Snooz requests ({{$snooze_passport_expiry_students_count}})</a></li>
                                <li><a href="{{url('passport_expire#passportexpire-close-tab')}}">Close requests ({{$close_passport_expiry_students_count}})</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
           
            </div>



            <div style="clear: both"></div>           
           

               <div class="dashinfostrip d-none">
                <div class="page-header">
                        <div class="page-title text-center">
                            <h1>Monthly Report</h1>
                        </div>
                    </div>
                <div class="dashrow">
                    <form method="GET" action="{{ url('generate_report') }}" enctype="multipart/form-data" id="myform">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class='input-group date' id='startdate'>
                                    <input type='text' class="form-control" name="start_date" placeholder="0000-00-00" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class='input-group date' id='enddate'>
                                    <input type='text' class="form-control" name="end_date" placeholder="0000-00-00" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">                               
                                    <select class="form-control" name="colleges">
                                        <option value="">Please Select</option>
                                        <?php
                                        if($colleges)
                                        {
                                            foreach ($colleges as $key => $value_colleges)
                                            {
                                            ?>
                                            <option value="<?php echo $value_colleges->id ?>"><?php echo $value_colleges->college_trading_name; ?></option>    
                                            <?php
                                            }
                                        }
                                        ?>
                                        
                                    </select>                               
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                          <input type="submit" class="btn btn-primary" value="submit" />
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <div class="row d-none">

                 <div class="col-md-6">                    
                    <div class="noticbgstrip">
                        <h1 class="side"><a href="#"> List of students whose fees is about to due </a></h1>
                        <div class="notificationlink">
                            <?php
                            if($fees_duedate_students_count > 0){
                                //echo "<pre>"; print_r($fees_duedate_students); exit;
                                foreach ($fees_duedate_students as $key => $fees_duedate_students_val)
                                {
                                    ?>                    
                                    <ul>
                                        <li class="list strow<?php echo $fees_duedate_students_val->stid; ?>" id="hide"><span>Fees will due on <?php echo date('d-m-Y', strtotime($fees_duedate_students_val->fee_due_date)); ?> for this user :- {{$fees_duedate_students_val->first_name}}</span>  added By {{$fees_duedate_students_val->staff_name}} User's Email:- {{$fees_duedate_students_val->email}} Phone :- {{$fees_duedate_students_val->phone}}  <?php if($fees_duedate_students_val->fees_due_follow_status != 1 ) { if($fees_duedate_students_val->fees_due_msg_count > 0){?>  &nbsp;&nbsp;<i class="fa fa-comments colored fees_due_status" aria-hidden="true" data-toggle="modal" data-target="#fees_due_comments" id="<?php echo $fees_duedate_students_val->stid; ?>"  data-userid="<?php echo $fees_duedate_students_val->stid; ?>" data-username="<?php echo $fees_duedate_students_val->first_name; ?>" data-cfd_id="{{$fees_duedate_students_val->cfd_id}}" data-followup="fees_due_followup"></i> <?php } else {?> &nbsp;&nbsp; <i class="fa fa-comments fees_due_status filled<?php echo $fees_duedate_students_val->stid; ?>" aria-hidden="true" data-toggle="modal" data-target="#fees_due_comments" data-userid="<?php echo $fees_duedate_students_val->stid; ?>" data-username="<?php echo $fees_duedate_students_val->first_name; ?>" data-cfd_id="{{$fees_duedate_students_val->cfd_id}}" data-followup="fees_due_followup"></i> <?php } ?> <!--  &nbsp;&nbsp;<i class="fa fa-thumbs-o-up followup_close"  id="<?php //echo $fees_duedate_students_val->stid; ?>" data-followup="fees_due_followup" aria-hidden="true"></i> -->
                                            <?php } ?></li>
                                    </ul>                                  
                                <?php } } else{?>
                                    <div class="alert alert-info alert-block col-sm-12">
                                        <strong>Fees will not due of any student in the next 30 days</strong>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> 


                    <div class="col-md-6">                    
                    <div class="noticbgstrip">
                        <h1 class="side"><a href="#"> List of students whose Course is about to complete </a></h1>
                        <div class="notificationlink">
                            <?php
                            if($course_completion_students_count > 0){
                                foreach ($course_completion_students as $key => $course_comp_students_val)
                                {
                                    ?>                    
                                    <ul>
                                        <li class="list strow<?php echo $course_comp_students_val->stid; ?>" id="hide"><span>Course will complete on <?php echo date('d-m-Y', strtotime($course_comp_students_val->course_completion_date)); ?> for this user :- {{$course_comp_students_val->first_name}}</span>  added By {{$course_comp_students_val->staff_name}} User's Email:- {{$course_comp_students_val->email}} Phone :- {{$course_comp_students_val->phone}}  <?php if($course_comp_students_val->course_complete_follow_status != 1 ) { if($course_comp_students_val->course_complete_msg_count > 0){?>   &nbsp;&nbsp;<i class="fa fa-comments colored course_completion_status" aria-hidden="true" data-toggle="modal" data-target="#course_completion_comments" id="<?php echo $course_comp_students_val->stid; ?>"  data-userid="<?php echo $course_comp_students_val->stid; ?>" data-username="<?php echo $course_comp_students_val->first_name; ?>" data-cfd_id="{{$course_comp_students_val->cfd_id}}" data-followup="fees_due_followup"></i> <?php } else {?> &nbsp;&nbsp; <i class="fa fa-comments course_completion_status filled<?php echo $course_comp_students_val->stid; ?>" aria-hidden="true" data-toggle="modal" data-target="#course_completion_comments" data-userid="<?php echo $course_comp_students_val->stid; ?>" data-username="<?php echo $course_comp_students_val->first_name; ?>" data-cfd_id="{{$course_comp_students_val->cfd_id}}" data-followup="fees_due_followup"></i> <?php } ?> <!--  &nbsp;&nbsp;<i class="fa fa-thumbs-o-up followup_close"  id="<?php //echo $course_comp_students_val->stid; ?>" data-followup="fees_due_followup" aria-hidden="true"></i> --><?php } ?></li>
                                    </ul>                                  
                                <?php } } else{?>
                                    <div class="alert alert-info alert-block col-sm-12">
                                        <strong>Course will not complete of any student in the next 30 days</strong>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> 

                <div class="col-md-6">
                    <div class="noticbgstrip">
                        <h1 class="side"><a href="#"> List of students whose visa is about to expire </a></h1>
                        <div class="notificationlink">
                            <?php
                           // echo "<pre>"; print_r($visa_expiry_students); exit;
                            if($visa_expiry_students_count > 0){
                                foreach ($visa_expiry_students as $key => $visa_expiry_students_val)
                                {
                                    ?>                    
                                    <ul>
                                        <li class="list strow<?php echo $visa_expiry_students_val->stid; ?>" id="hide"><span>Visa will expired on <?php echo date('d-m-Y', strtotime($visa_expiry_students_val->visa_expiry_date)); ?> for this user :- {{$visa_expiry_students_val->first_name}}</span>  added By {{$visa_expiry_students_val->staff_name}} User's Email:- {{$visa_expiry_students_val->email}} Phone :- {{$visa_expiry_students_val->phone}}  <?php if($visa_expiry_students_val->visa_follow_status != 1 ) { if($visa_expiry_students_val->visa_expire_msg_count > 0){?> &nbsp;&nbsp;<i class="fa fa-comments colored visa_status" aria-hidden="true" data-toggle="modal" data-target="#open_visa_comments" id="<?php echo $visa_expiry_students_val->stid; ?>" data-userid="<?php echo $visa_expiry_students_val->stid; ?>" data-username="<?php echo $visa_expiry_students_val->first_name; ?>" data-followup="visa_expiry_followup"></i> <?php } else {?> &nbsp;&nbsp; <i class="fa fa-comments visa_status filled<?php echo $visa_expiry_students_val->stid; ?>" aria-hidden="true" data-toggle="modal" data-target="#open_visa_comments" data-userid="<?php echo $visa_expiry_students_val->stid; ?>" data-username="<?php echo $visa_expiry_students_val->first_name; ?>" data-followup="visa_expiry_followup"></i> <?php } ?> <!--  &nbsp;&nbsp;<i class="fa fa-thumbs-o-up followup_close"  id="<?php //echo $visa_expiry_students_val->stid; ?>" data-followup="visa_expiry_followup" aria-hidden="true"></i> --> <?php } ?></li>
                                    </ul>                                  
                                <?php } } else {?>
                                    <div class="alert alert-info alert-block col-sm-12">
                                        <strong>Visa will not expire of any student in the next 30 days</strong>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-6">
                    <div class="noticbgstrip">
                        <h1 class="side"><a href="#"> List of students whose passport is about to expire </a></h1>
                        <div class="notificationlink">
                            <?php
                            if($passport_expiry_students_count > 0){
                                foreach ($passport_expiry_students as $key => $passport_expiry_students_val)
                                {
                                    ?>                    
                                    <ul>
                                        <li class="list strow<?php echo $passport_expiry_students_val->stid; ?>" id="hide"><span>Passport will expired on <?php echo date('d-m-Y', strtotime($passport_expiry_students_val->passport_expiry_date)); ?> for this user :- {{$passport_expiry_students_val->first_name}}</span>  added By {{$passport_expiry_students_val->staff_name}} User's Email:- {{$passport_expiry_students_val->email}} Phone :- {{$passport_expiry_students_val->phone}}  <?php if($passport_expiry_students_val->passport_follow_status != 1 ) { if($passport_expiry_students_val->passport_expire_msg_count > 0){?> &nbsp;&nbsp;<i class="fa fa-comments colored passport_status" aria-hidden="true" data-toggle="modal" data-target="#open_passport_comments" id="<?php echo $passport_expiry_students_val->stid; ?>"  data-userid="<?php echo $passport_expiry_students_val->stid; ?>" data-username="<?php echo $passport_expiry_students_val->first_name; ?>" data-followup="passport_expiry_followup"></i> <?php } else {?> &nbsp;&nbsp; <i class="fa fa-comments passport_status filled<?php echo $passport_expiry_students_val->stid; ?>" aria-hidden="true" data-toggle="modal" data-target="#open_passport_comments" data-userid="<?php echo $passport_expiry_students_val->stid; ?>" data-username="<?php echo $passport_expiry_students_val->first_name; ?>" data-followup="passport_expiry_followup"></i> <?php } ?> <!--  &nbsp;&nbsp;<i class="fa fa-thumbs-o-up followup_close"  id="<?php //echo $passport_expiry_students_val->stid; ?>" data-followup="passport_expiry_followup" aria-hidden="true"></i> -->
                                            <?php } ?></li>
                                    </ul>                                  
                                <?php } } else{?>
                                    <div class="alert alert-info alert-block col-sm-12">
                                        <strong>Passport will not expire of any student in the next 30 days</strong>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> 

                </div>

           
            @if(Auth::user()->type==1)
            @if($office_array)
                @foreach($office_array as $office_key => $office_value)
            <div class="row d-none">
                <div class="col-md-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1 class="side"><a href="#"> Notifications <?php if(isset($get_offices[$office_key])){ echo  $get_offices[$office_key];  } ?> </a></h1>
                        </div>
                    </div>
                </div>                
            </div>


            <section id="main-content">
                <div class="row">  
                    
                    <div class="col-md-6">
                        <div class="noticbgstrip">
                            <div class="notificationlink  d-none">
                                <ul>
                                    <?php if(isset($notification_data[$office_key]))
                                    {

                                        $counter=0;
                                        foreach($notification_data[$office_key] as $notification_key => $notification_data_value)
                                        {
                                            if($counter<5)
                                            {
                                         ?>
                                   <a > <li @if($notification_data_value->is_read==1)"  @endif class="list" id="hide" data-id="{{$notification_data_value->id}}"><span  >{{$notification_data_value->first_name}}</span> was added By {{$notification_data_value->staff_name}} on {{date('d/m/Y',strtotime($notification_data_value->created_at))}} at {{date('H:i:s',strtotime($notification_data_value->created_at))}}</a></li>
                                        <?php 
                                            }
                                            $counter++;
                                        } 
                                    } ?>
                                   
                                  </ul>
                               </div>
                            </div>
                        </div>
                    </div>
                </section>
            
                @endforeach
               @endif


            @endif 


         @if (Auth::user()->type==3)
        
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Notifications </h1>
                        </div>
                    </div>
                </div>                
            </div>


            <section id="main-content">
                <div class="row">                    
                    <div class="col-lg-12">
                        <div class="noticbgstrip">
                            <div class="notificationlink">
                                <ul>
                                    <?php if($students){
                                        foreach($students as $key => $student){ ?>
                                    <li><a href="#"><span>{{$student->first_name}}</span> was added By {{$student->staff_name}} on {{$student->created_at}}</a></li>
                                    <?php }}?> 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>  

            @endif


        </div>              
    </div>
</div>

<div class="modal fade" id="open_visa_comments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-lg" role="document">
      <form method="POST" action="{{ url('save_visa_expire_followup') }}" enctype="multipart/form-data" id="myform">
         {{ csrf_field() }}
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Visa Expire</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="username"></div>
               <label>Comment</label>
               <textarea class="form-control" name="follow_message"></textarea>
               <br>
               <input type="hidden" class="user_id" name="user_id" value="">

               <div class="radio_style">
                  <input type="radio" name="follow_status" class="followstatus visa_snooze_status" value="2"><span>Snooze</span>
                  <input type="radio" name="follow_status" class="followstatus visa_snooze_status" value="1"><span>Close</span>
                  <input type="radio" name="follow_status" class="followstatus visa_snooze_status" value="3"><span>Add Comment</span>
                  <div class="follow_status_Error" style="color: red;"></div>
               </div>
               <br>
               <input type="text" name="snooze_calender" id="" class="form-control datepicker show_visa_snooze_calender d-none" value="">

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary save_visa_exp_open">Save changes</button>
            </div>
            <br>
            <div class="prev_msg"></div>
         </div>
      </form>
   </div>
</div>



<div class="modal fade" id="open_passport_comments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-lg" role="document">
      <form method="POST" action="{{ url('save_passport_expire_followup') }}" enctype="multipart/form-data" id="myform">
         {{ csrf_field() }}
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Passport Expire</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="username"></div>
               <label>Comment</label>
               <textarea class="form-control" name="follow_message"></textarea>
               <br>
               <input type="hidden" class="user_id" name="user_id" value="">

               <div class="radio_style">
                  <input type="radio" name="follow_status" class="followstatus passport_snooze_status" value="2"><span>Snooze</span>
                  <input type="radio" name="follow_status" class="followstatus passport_snooze_status" value="1"><span>Close</span>
                  <input type="radio" name="follow_status" class="followstatus passport_snooze_status" value="3"><span>Add Comment</span>
                  <div class="follow_status_Error" style="color: red;"></div>
               </div>                    
               <br>
               <input type="text" name="snooze_calender" id="" class="form-control datepicker show_passport_snooze_calender d-none" value="">

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary save_passport_exp_open">Save changes</button>
            </div>
            <br>
            <div class="prev_msg"></div>
         </div>
      </form>
   </div>
</div>





<div class="modal fade" id="fees_due_comments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-lg" role="document">
      <form method="POST" action="{{ url('save_fees_due_followup') }}" enctype="multipart/form-data" id="myform">
         {{ csrf_field() }}
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Fees Due</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="username"></div>
               <label>Comment</label>
               <textarea class="form-control" name="follow_message"></textarea>
               <br>
               <input type="hidden" class="user_id" name="user_id" value="">
               <input type="hidden" class="cfd_id" name="cfd_id" value="">

               <div class="radio_style">
                  <input type="radio" name="follow_status" class="followstatus feesdue_snooze_status" value="2"><span>Snooze</span>
                  <input type="radio" name="follow_status" class="followstatus feesdue_snooze_status" value="1"><span>Close</span>
                  <input type="radio" name="follow_status" class="followstatus feesdue_snooze_status" value="3"><span>Add Comment</span>
                  <div class="follow_status_Error" style="color: red;"></div>
               </div>                    
               <br>
               <input type="text" name="snooze_calender" id="" class="form-control datepicker show_feesdue_snooze_calender d-none" value="">

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary save_fees_due_open">Save changes</button>
            </div>
            <br>
            <div class="prev_msg"></div>
         </div>
      </form>
   </div>
</div>


<!-- Course Completion -->

<div class="modal fade" id="course_completion_comments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-lg" role="document">
      <form method="POST" action="{{ url('save_course_completion_followup') }}" enctype="multipart/form-data" id="myform">
         {{ csrf_field() }}
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Course Completion</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="username"></div>
               <label>Comment</label>
               <textarea class="form-control" name="follow_message"></textarea>
               <br>
               <input type="hidden" class="user_id" name="user_id" value="">
               <input type="hidden" class="cfd_id" name="cfd_id" value="">

               <div class="radio_style">
                  <input type="radio" name="follow_status" class="followstatus course_completion_snooze_status" value="2"><span>Snooze</span>
                  <input type="radio" name="follow_status" class="followstatus course_completion_snooze_status" value="1"><span>Close</span>
                  <input type="radio" name="follow_status" class="followstatus course_completion_snooze_status" value="3"><span>Add Comment</span>
                  <div class="follow_status_Error" style="color: red;"></div>
               </div>                    
               <br>
               <input type="text" id="" name="snooze_calender" class="form-control datepicker show_course_completion_snooze_calender d-none" value="">
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary save_course_completion_open">Save changes</button>
            </div>
            <br>
            <div class="prev_msg"></div>
         </div>
      </form>
   </div>
</div>




<script type="text/javascript">
    $(document).ready(function() {

    $(document).on('click','.visa_status', function(){
        var user_id = $(this).data('userid');
        var username = $(this).data('username');        
        //alert(user_id);
        $('.prev_msg').addClass('follow_message_data'+user_id);
        $('.user_id').val(user_id);

        $.ajax({
                type: "POST",
                url: "{{route('ajax_visa_expire_followup_data')}}",
                data: {"_token": "{{ csrf_token() }}",user_id:user_id},
                success: function(data)
                {
                   //alert(data);
                   $('.follow_message_data'+user_id).html(data);                 
                   $('.username').html("Student Name:- "+username);                 
                }
            });
    });


     $(document).on('change','.visa_snooze_status', function(){
        var status_val = $(this).val();
        if(status_val == 2)
        {
            $('.show_visa_snooze_calender').removeClass('d-none');
            var snoozedate = $('.show_visa_snooze_calender').val();
            if(snoozedate == '')
            {
               $(".show_visa_snooze_calender").prop('required',true);
               return false;
            }
        }
        else if(status_val == 1)
        {
            $('.show_visa_snooze_calender').addClass('d-none');   
        }

    });

 

    $(document).on('click','.save_visa_exp_open',function(){
        var follow_status_count = $(':radio[name="follow_status"]:checked').length;
        var follow_status = $(':radio[name="follow_status"]:checked').val();

        if(follow_status_count==0)
        {
            $('.follow_status_Error').html('Please select Status type');
            return false;
        }


    });

/*Passport Code start form here*/

    $(document).on('click','.passport_status', function(){
        var user_id = $(this).data('userid');
        var username = $(this).data('username');        
        //alert(user_id);
        $('.prev_msg').addClass('follow_message_data'+user_id);
        $('.user_id').val(user_id);

        $.ajax({
                type: "POST",
                url: "{{route('ajax_passport_expire_followup_data')}}",
                data: {"_token": "{{ csrf_token() }}",user_id:user_id},
                success: function(data)
                {
                   //alert(data);
                   $('.follow_message_data'+user_id).html(data);                 
                   $('.username').html("Student Name:- "+username);                 
                }
            });
    });


     $(document).on('change','.passport_snooze_status', function(){
        var status_val = $(this).val();
        if(status_val == 2)
        {
            $('.show_passport_snooze_calender').removeClass('d-none');
            var snoozedate = $('.show_passport_snooze_calender').val();
            if(snoozedate == '')
            {
               $(".show_passport_snooze_calender").prop('required',true);
               return false;
            }
        }
        else if(status_val == 1)
        {
            $('.show_passport_snooze_calender').addClass('d-none');   
        }

    }); 

    $(document).on('click','.save_passport_exp_open',function(){
        var follow_status_count = $(':radio[name="follow_status"]:checked').length;
        var follow_status = $(':radio[name="follow_status"]:checked').val();

        if(follow_status_count==0)
        {
            $('.follow_status_Error').html('Please select Status type');
            return false;
        }


    });


/*fEES DUE JQUERY CODE START */


     $(document).on('click','.fees_due_status', function(){
        var user_id = $(this).data('userid');
        var cfd_id = $(this).data('cfd_id');
        var username = $(this).data('username');        
        //alert(user_id);
        $('.prev_msg').addClass('follow_message_data'+user_id);
        $('.user_id').val(user_id);
        $('.cfd_id').val(cfd_id);

        $.ajax({
                type: "POST",
                url: "{{route('ajax_fees_due_followup_data')}}",
                data: {"_token": "{{ csrf_token() }}",user_id:user_id,cfd_id:cfd_id},
                success: function(data)
                {
                   //alert(data);
                   $('.follow_message_data'+user_id).html(data);                 
                   $('.username').html("Student Name:- "+username);                 
                }
            });
    });


     $(document).on('change','.feesdue_snooze_status', function(){
        var status_val = $(this).val();
        if(status_val == 2)
        {
            $('.show_feesdue_snooze_calender').removeClass('d-none');
            var snoozedate = $('.show_feesdue_snooze_calender').val();
            if(snoozedate == '')
            {
               $(".show_feesdue_snooze_calender").prop('required',true);
               return false;
            }
        }
        else if(status_val == 1)
        {
            $('.show_feesdue_snooze_calender').addClass('d-none');   
        }

    });


    $(document).on('click','.save_fees_due_open',function(){
        var follow_status_count = $(':radio[name="follow_status"]:checked').length;
        var follow_status = $(':radio[name="follow_status"]:checked').val();

        if(follow_status_count==0)
        {
            $('.follow_status_Error').html('Please select Status type');
            return false;
        }


    });




/*Course Completion JQUERY CODE START */


     $(document).on('click','.course_completion_status', function(){
        var user_id = $(this).data('userid');
        var cfd_id = $(this).data('cfd_id');
        var username = $(this).data('username');        
        //alert(user_id);
        $('.prev_msg').addClass('follow_message_data'+user_id);
        $('.user_id').val(user_id);
        $('.cfd_id').val(cfd_id);

        $.ajax({
                type: "POST",
                url: "{{route('ajax_course_completion_followup_data')}}",
                data: {"_token": "{{ csrf_token() }}",user_id:user_id,cfd_id:cfd_id},
                success: function(data)
                {
                   //alert(data);
                   $('.follow_message_data'+user_id).html(data);                 
                   $('.username').html("Student Name:- "+username);                 
                }
            });
    });


     $(document).on('change','.course_completion_snooze_status', function(){
        var status_val = $(this).val();
        if(status_val == 2)
        {
            $('.show_course_completion_snooze_calender').removeClass('d-none');
            var snoozedate = $('.show_course_completion_snooze_calender').val();
            if(snoozedate == '')
            {
               $(".show_course_completion_snooze_calender").prop('required',true);
               return false;
            }
        }
        else if(status_val == 1)
        {
            $('.show_course_completion_snooze_calender').addClass('d-none');   
        }

    });


    $(document).on('click','.save_course_completion_open',function(){
        var follow_status_count = $(':radio[name="follow_status"]:checked').length;
        var follow_status = $(':radio[name="follow_status"]:checked').val();

        if(follow_status_count==0)
        {
            $('.follow_status_Error').html('Please select Status type');
            return false;
        }


    });



});
</script>



    <style>
        .notificationlink {
    width: 100%;
    height: 400px;
    overflow-y: scroll;
    float: left;
    padding: 0 15px;
}

.noticbgstrip h1{
    background: #1D94C7;
    color: #fff;
    padding: 15px 20px;
    font-size: 23px;
}

.noticbgstrip h1 a{
    color: #fff;
}

.noticbgstrip {
    width: 100%;
    float: left;
    background: #fff;
    padding: 0;
    overflow: hidden;
    border-radius: 15px;
    box-shadow: 0px 5px 40px rgb(237 237 237 / 70%);
}

textarea.form-control
{
  height: 150px;
}

i.fa.fa-comments.colored {
    color: #fb0e27;
}

.radio_style span
{
    padding:0px 5px;
}

.tsp-content-counter {
    float: left;
    width: 31.3%;
    margin: 1%;
    border-radius: 20px;
    text-align: center;
    display: inline-block;
    vertical-align: middle;
    padding: 25px;
}
.box1{
    background-image: linear-gradient(to right, #5007c6, #1e8ff1);
}
.box2{
    background-image: linear-gradient(to right, #d9000e, #1b5585);
}
.box3{
    background-image: linear-gradient(to right, #114f02, #8bb48f);
}

.box21{
    background-image: linear-gradient(to right, #ff9a33, #ff9a33);
}
.box22{
    background-image: linear-gradient(to right, #ffffff, #ffffff);
}

.box22 p.count
{
    color: #000;
}

.box22 h2
{
    color: #000 !important;
}

.box23{
    background-image: linear-gradient(to right, #138807, #138807);
}

.box31{
    background-image: linear-gradient(to right, #ff9e01, #995107);
}
.box32{
    background-image: linear-gradient(to right, #5300d957, #1b5585);
}
.box33{
    background-image: linear-gradient(to right, #317a8d, #e2eee3);
}


.box41{
    background-image: linear-gradient(to right, #d69b3d, #d69b3d);
}
.box42{
    background-image: linear-gradient(to right, #5300d957, #5300d957);
}
.box43{
    background-image: linear-gradient(to right, #317a8d, #317a8d);
}


.box51{
    background-image: linear-gradient(to right, #3d46d6, #d69b3d);
}
.box52{
    background-image: linear-gradient(to right, #af0e9ba3, #af0e9ba3);
}
.box53{
    background-image: linear-gradient(to right, #d6eff6, #747575);
}
.tsp-content-counter h2 {
    color: #fff;
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 30px;
}
.tsp-count{
    float: left;
    width: 50%;
    margin: 5px 0;
}
.count{
    color: #fff;
    font-size: 35px;
    font-weight: 600;
}
.tsp-section{
    color: #fff;
}
.tsp-count p{
    font-weight: 600;
    margin: 0;
}

.office_wise_data{
    float: left;
    width: 100%;
}

.fees_due_followup
{
    width: 100%;
  float: left;
  background: rgb(0,212,255);
  background: linear-gradient(90deg, rgba(0,212,255,1) 0%, rgba(23,112,238,1) 100%);
  padding: 10px 20px;
  border-radius: 10px 10px 0px 0px;
  color: #fff;
  font-weight: 600;
  font-size: 18px;
  text-transform: uppercase;
}
.visa_exp_followup
{
    width: 100%;
  float: left;
  background: rgb(245,42,95);
  background: linear-gradient(90deg, rgba(245,42,95,1) 0%, rgba(146,18,52,1) 100%);
  padding: 10px 20px;
  border-radius: 10px 10px 0px 0px;
  color: #fff;
  font-weight: 600;
  font-size: 18px;
  text-transform: uppercase;
}
.course_exp_followup
{
    width: 100%;
  float: left;
  background: rgb(251,183,10);
  background: linear-gradient(90deg, rgba(251,183,10,1) 0%, rgba(211,122,10,1) 100%);
  padding: 10px 20px;
  border-radius: 10px 10px 0px 0px;
  color: #fff;
  font-weight: 600;
  font-size: 18px;
  text-transform: uppercase;
}
.passport_exp_followup
{
    width: 100%;
  float: left;
  background: rgb(18,200,96);
  background: linear-gradient(90deg, rgba(18,200,96,1) 0%, rgba(8,150,68,1) 100%);
  padding: 10px 10px;
  border-radius: 10px 10px 0px 0px;
  color: #fff;
  font-weight: 600;
  font-size: 18px;
  text-transform: uppercase;
}

.dash_details {
  width: 100%;
  float: left;
  padding: 15px 10px;
  min-height: 140px;
  }

  .dash_box1 {
  width: 100%;
  float: left;
  box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
  background: #fff;
  border-radius: 10px;
  margin-bottom: 15px;
}

.dash_details ul li {
  width: 100%;
  float: left;
  color: #000;
  list-style-type: none;
  font-weight: 600;
  padding: 5px 0px;
}

.box22 p.tsp-section
{
    color: #000;
}

    </style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet"> 


 <script>
        $('.count').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    </script>

<!-- <script>
    $(document).ready(function(){

        $(document).on('click', '.fa-comments', function(){
         var id = $(this).attr('id');
         var follow_type = $(this).attr('data-followup');         
         $('.visa_comments_id').val(id);

       $.ajax({
                type: "POST",
                url: "{{route('ajax_followup_data')}}",
                data: {"_token": "{{ csrf_token() }}",id:id,follow_type:follow_type},
                success: function(data) {
                  //alert(data);
                       $('.follow_message_data'+id).html(data);                 
                      }
            });
      });


        $(document).on('click', '.save_visa_follow_message', function(){
         var id = $('.visa_comments_id').val();
         var follow_type = $(this).attr('data-followup');
         var follow_status = $(':radio[name="visa_follow_status"]:checked').val();
         var follow_message = $('.visa_follow_message').val();
         //alert("ID=>"+id+"follow type =>"+follow_type+"status =>"+follow_status+"message =>"+follow_message);
         //var follow_status = $('.status'+id).val();
         var snooze_calender = $('.snooze_calender').val();

          if(follow_message == '')
          {
            $('textarea').attr('required',true);
          }
       $.ajax({
                type: "POST",
                url: "{{route('ajax_followup')}}",
                data: {"_token": "{{ csrf_token() }}",id:id,follow_message:follow_message,follow_type:follow_type,follow_status:follow_status,snooze_calender:snooze_calender},
                success: function(data) {

                       $('.filled'+id).css('color','#fb0e27');
                       $('.follow_message'+id).val('');                                      
                      }
            });
      });


         $(document).on('change','.followstatus', function(){
        var status_val = $(this).val();
        if(status_val == 2)
        {
            $('.show_snooze_calender').removeClass('d-none');
        }
        else if(status_val == 1)
        {
            $('.show_snooze_calender').addClass('d-none');   
        }

    });


        $(document).on('click', '.save_passport_follow_message', function(){
         var id = $(this).attr('id');
         var follow_type = $(this).attr('data-followup');
         var follow_message = $('.passport_follow_message'+id).val();
         var follow_status = $('.status'+id).val();
         var snooze_calender = $('.snooze_calender'+id).val();
        
          if(follow_message == '')
          {
            $('textarea').attr('required',true);
          }
       $.ajax({
                type: "POST",
                url: "{{route('ajax_followup')}}",
                data: {"_token": "{{ csrf_token() }}",id:id,follow_message:follow_message,follow_type:follow_type,follow_status:follow_status,snooze_calender:snooze_calender},
                success: function(data) {

                       $('.filled'+id).css('color','#fb0e27');
                       $('.follow_message'+id).val('');                                      
                      }
            });
      });



        $(document).on('click', '.save_feesdue_follow_message', function(){
         var id = $(this).attr('id');
         var follow_type = $(this).attr('data-followup');
         var follow_message = $('.feesdue_follow_message'+id).val();
         var follow_status = $('.status'+id).val();
         var snooze_calender = $('.snooze_calender'+id).val();

         //alert(id+'=>'+follow_type+'=>'+follow_message);
          if(follow_message == '')
          {
            $('textarea').attr('required',true);
          }
       $.ajax({
                type: "POST",
                url: "{{route('ajax_followup')}}",
                data: {"_token": "{{ csrf_token() }}",id:id,follow_message:follow_message,follow_type:follow_type,follow_status:follow_status,snooze_calender:snooze_calender},
                success: function(data) {

                       $('.filled'+id).css('color','#fb0e27');
                       $('.follow_message'+id).val('');                                      
                      }
            });
      });


        $(document).on('click', '.save_course_comp_follow_message', function(){
         var id = $(this).attr('id');
         var follow_type = $(this).attr('data-followup');
         var follow_message = $('.course_comp_follow_message'+id).val();
         var follow_status = $('.status'+id).val();
         var snooze_calender = $('.snooze_calender'+id).val();
         var course_fee_detail_id = $('.course_fee_detail'+id).val();

         //alert(id+'=>'+follow_type+'=>'+follow_message);
          if(follow_message == '')
          {
            $('textarea').attr('required',true);
          }
       $.ajax({
                type: "POST",
                url: "{{route('ajax_followup')}}",
                data: {"_token": "{{ csrf_token() }}",id:id,follow_message:follow_message,follow_type:follow_type,follow_status:follow_status,snooze_calender:snooze_calender,course_fee_detail_id:course_fee_detail_id},
                success: function(data) {

                       $('.filled'+id).css('color','#fb0e27');
                       $('.follow_message'+id).val('');                                      
                      }
            });
      });
        





        $(document).on('click', '.followup_close', function(){
         var id = $(this).attr('id');
         var follow_type = $(this).attr('data-followup');

          swal({
        title: "Are you sure?",
        text: "Once Close, you will not be able to Decline!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes do it",
        closeOnConfirm: true,
    },
    function(){
       $.ajax({
                type: "POST",
                url: "{{route('ajax_followup_close')}}",
                data: {"_token": "{{ csrf_token() }}",id:id,follow_type:follow_type},
                success: function(data)
                {
                    $('.strow'+id).css('background','tomato');
                    $('.strow'+id).fadeOut(800,function(){
                    $(this).remove();
                });
                }
            });
      });      
    
     }); 
     });     
    </script> -->
  
  
@endsection