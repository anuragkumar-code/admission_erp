@extends('admin.layout.head')
@section('admin')

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

            <div class="row">
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
                                        <li class="list strow<?php echo $visa_expiry_students_val->stid; ?>" id="hide"><span>Visa will expired on {{$visa_expiry_students_val->visa_expiry_date}} for this user :- {{$visa_expiry_students_val->first_name}}</span>  added By {{$visa_expiry_students_val->staff_name}} User's Email:- {{$visa_expiry_students_val->email}} Phone :- {{$visa_expiry_students_val->phone}}  <?php if($visa_expiry_students_val->visa_follow_status != 1 ) { if($visa_expiry_students_val->visa_expire_msg_count > 0){?> &nbsp;&nbsp;<i class="fa fa-comments colored" aria-hidden="true" data-toggle="modal" data-target="#open_visa_comments<?php echo $visa_expiry_students_val->stid; ?>" id="<?php echo $visa_expiry_students_val->stid; ?>" data-followup="visa_expiry_followup"></i> <?php } else {?> &nbsp;&nbsp; <i class="fa fa-comments filled<?php echo $visa_expiry_students_val->stid; ?>" aria-hidden="true" data-toggle="modal" data-target="#open_visa_comments<?php echo $visa_expiry_students_val->stid; ?>" id="<?php echo $visa_expiry_students_val->stid; ?>" data-followup="visa_expiry_followup"></i> <?php } ?>  &nbsp;&nbsp;<i class="fa fa-thumbs-o-up followup_close"  id="<?php echo $visa_expiry_students_val->stid; ?>" data-followup="visa_expiry_followup" aria-hidden="true"></i> <?php } ?></li>
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
                            echo $passport_expiry_students_count; exit;
                            if($passport_expiry_students_count > 0){
                                foreach ($passport_expiry_students as $key => $passport_expiry_students_val)
                                {
                                    ?>                    
                                    <ul>
                                        <li class="list strow<?php echo $passport_expiry_students_val->stid; ?>" id="hide"><span>Passport will expired on {{$passport_expiry_students_val->visa_expiry_date}} for this user :- {{$passport_expiry_students_val->first_name}}</span>  added By {{$passport_expiry_students_val->staff_name}} User's Email:- {{$passport_expiry_students_val->email}} Phone :- {{$passport_expiry_students_val->phone}}  <?php if($passport_expiry_students_val->passport_follow_status != 1 ) { if($passport_expiry_students_val->passport_expire_msg_count > 0){?> &nbsp;&nbsp;<i class="fa fa-comments colored" aria-hidden="true" data-toggle="modal" data-target="#open_passport_comments<?php echo $passport_expiry_students_val->stid; ?>" id="<?php echo $passport_expiry_students_val->stid; ?>" data-followup="passport_expiry_followup"></i> <?php } else {?> &nbsp;&nbsp; <i class="fa fa-comments filled<?php echo $passport_expiry_students_val->stid; ?>" aria-hidden="true" data-toggle="modal" data-target="#open_passport_comments<?php echo $passport_expiry_students_val->stid; ?>" id="<?php echo $passport_expiry_students_val->stid; ?>" data-followup="passport_expiry_followup"></i> <?php } ?>  &nbsp;&nbsp;<i class="fa fa-thumbs-o-up followup_close"  id="<?php echo $passport_expiry_students_val->stid; ?>" data-followup="passport_expiry_followup" aria-hidden="true"></i> <?php } ?></li>
                                    </ul>                                  
                                <?php } } else{?>
                                    <div class="alert alert-info alert-block col-sm-12">
                                        <strong>Passport will not expire of any student in the next 30 days</strong>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> 



                    <div class="col-md-6">                    
                    <div class="noticbgstrip">
                        <h1 class="side"><a href="#"> List of students whose fees is about to due </a></h1>
                        <div class="notificationlink">
                            <?php
                            if($fees_duedate_students_count > 0){
                                foreach ($fees_duedate_students as $key => $fees_duedate_students_val)
                                {
                                    ?>                    
                                    <ul>
                                        <li class="list strow<?php echo $fees_duedate_students_val->stid; ?>" id="hide"><span>Fees will due on {{$fees_duedate_students_val->fee_due_date}} for this user :- {{$fees_duedate_students_val->first_name}}</span>  added By {{$fees_duedate_students_val->staff_name}} User's Email:- {{$fees_duedate_students_val->email}} Phone :- {{$fees_duedate_students_val->phone}}  <?php if($fees_duedate_students_val->fees_due_follow_status != 1 ) { if($fees_duedate_students_val->fees_due_msg_count > 0){?> &nbsp;&nbsp;<i class="fa fa-comments colored" aria-hidden="true" data-toggle="modal" data-target="#open_feesdue_comments<?php echo $fees_duedate_students_val->stid; ?>" id="<?php echo $fees_duedate_students_val->stid; ?>" data-followup="fees_due_followup"></i> <?php } else {?> &nbsp;&nbsp; <i class="fa fa-comments filled<?php echo $fees_duedate_students_val->stid; ?>" aria-hidden="true" data-toggle="modal" data-target="#open_feesdue_comments<?php echo $fees_duedate_students_val->stid; ?>" id="<?php echo $fees_duedate_students_val->stid; ?>" data-followup="fees_due_followup"></i> <?php } ?>  &nbsp;&nbsp;<i class="fa fa-thumbs-o-up followup_close"  id="<?php echo $fees_duedate_students_val->stid; ?>" data-followup="fees_due_followup" aria-hidden="true"></i> <?php } ?></li>
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
                            if($course_comp_students_count > 0){
                                foreach ($course_comp_students as $key => $course_comp_students_val)
                                {
                                    ?>                    
                                    <ul>
                                        <li class="list strow<?php echo $course_comp_students_val->stid; ?>" id="hide"><span>Fees will due on {{$course_comp_students_val->course_completion_date}} for this user :- {{$course_comp_students_val->first_name}}</span>  added By {{$course_comp_students_val->staff_name}} User's Email:- {{$course_comp_students_val->email}} Phone :- {{$course_comp_students_val->phone}}  <?php if($course_comp_students_val->course_complete_follow_status != 1 ) { if($course_comp_students_val->course_complete_msg_count > 0){?> &nbsp;&nbsp;<i class="fa fa-comments colored" aria-hidden="true" data-toggle="modal" data-target="#open_course_comp_comments<?php echo $course_comp_students_val->stid; ?>" id="<?php echo $course_comp_students_val->stid; ?>" data-followup="course_completion_followup"></i> <?php } else {?> &nbsp;&nbsp; <i class="fa fa-comments filled<?php echo $course_comp_students_val->stid; ?>" aria-hidden="true" data-toggle="modal" data-target="#open_course_comp_comments<?php echo $course_comp_students_val->stid; ?>" id="<?php echo $course_comp_students_val->stid; ?>" data-followup="course_completion_followup"></i> <?php } ?>  &nbsp;&nbsp;<i class="fa fa-thumbs-o-up followup_close"  id="<?php echo $course_comp_students_val->stid; ?>" data-followup="course_completion_followup" aria-hidden="true"></i> <?php } ?></li>
                                    </ul>                                  
                                <?php } } else{?>
                                    <div class="alert alert-info alert-block col-sm-12">
                                        <strong>Course will not complete of any student in the next 30 days</strong>
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

<?php

if($visa_expiry_students_count > 0){
foreach ($visa_expiry_students as $key => $visa_expiry_students_val)
{
?>     

<div class="modal fade visamodel<?php echo $visa_expiry_students_val->stid; ?>" id="open_visa_comments<?php echo $visa_expiry_students_val->stid; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Follow up Visa Expiration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="follow_message_data<?php echo $visa_expiry_students_val->stid; ?>">
       </div>
       <br>


      <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $visa_expiry_students_val->stid; ?>" value="2">Snooze
       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $visa_expiry_students_val->stid; ?>" value="1">Close
       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $visa_expiry_students_val->stid; ?>" value="3">Add Comment

     

        <br>
        <input type="date" name="snooze_calender" class="form-control show_snooze_calender d-none snooze_calender<?php echo $visa_expiry_students_val->stid; ?>" value="">
        <br>
       <textarea class="form-control visa_follow_message<?php echo $visa_expiry_students_val->stid; ?>" name="follow_message" rows="8" placeholder="Enter Comment"></textarea>
       <div class="error_message"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_visa_follow_message save_visamsg<?php echo $visa_expiry_students_val->stid; ?>" id="<?php echo $visa_expiry_students_val->stid; ?>" data-dismiss="modal" data-followup="visa_expiry_followup">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php } } ?>



<?php

 if($passport_expiry_students_count > 0){
  foreach ($passport_expiry_students as $key => $passport_expiry_students_val)
  {
?>     

<div class="modal fade passportmodel<?php echo $passport_expiry_students_val->stid; ?>" id="open_passport_comments<?php echo $passport_expiry_students_val->stid; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Follow up Passport Expiration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

       <div class="follow_message_data<?php echo $passport_expiry_students_val->stid; ?>">

       </div>
       <br>

         <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $passport_expiry_students_val->stid; ?>" value="2">Snooze
       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $passport_expiry_students_val->stid; ?>" value="1">Close
       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $passport_expiry_students_val->stid; ?>" value="3">Only Cmment


        <br>
        <input type="date" name="snooze_calender" class="form-control show_snooze_calender d-none snooze_calender<?php echo $passport_expiry_students_val->stid; ?>" value="">
        <br>

       <textarea class="form-control passport_follow_message<?php echo $passport_expiry_students_val->stid; ?>" name="follow_message" rows="8" placeholder="Enter Comment"></textarea>
       <div class="error_message"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_passport_follow_message save_visamsg<?php echo $passport_expiry_students_val->stid; ?>" id="<?php echo $passport_expiry_students_val->stid; ?>" data-dismiss="modal" data-followup="passport_expiry_followup">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php } } ?>




<?php
if($fees_duedate_students_count > 0){
    foreach ($fees_duedate_students as $key => $fees_duedate_students_val)
    {
        ?>     

<div class="modal fade feesduemodel<?php echo $fees_duedate_students_val->stid; ?>" id="open_feesdue_comments<?php echo $fees_duedate_students_val->stid; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Follow up Fees Due</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

       <div class="follow_message_data<?php echo $fees_duedate_students_val->stid; ?>">
       </div>
       <br>

       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $fees_duedate_students_val->stid; ?>" value="2">Snooze
       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $fees_duedate_students_val->stid; ?>" value="1">Close
       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $fees_duedate_students_val->stid; ?>" value="3">Only Cmment

       <!-- <select class="form-control followstatus status<?php //echo $fees_duedate_students_val->stid; ?>" name="follow_status">
         <option value="1">Close</option>
         <option value="2">Snooze</option>
       </select> -->

        <br>
        <input type="date" name="snooze_calender" class="form-control show_snooze_calender d-none snooze_calender<?php echo $fees_duedate_students_val->stid; ?>" value="">
        <br>

       <textarea class="form-control feesdue_follow_message<?php echo $fees_duedate_students_val->stid; ?>" name="follow_message" rows="8" placeholder="Enter Comment"></textarea>
       <div class="error_message"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_feesdue_follow_message save_visamsg<?php echo $fees_duedate_students_val->stid; ?>" id="<?php echo $fees_duedate_students_val->stid; ?>" data-dismiss="modal" data-followup="fees_due_followup">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php } } ?>




<?php
if($course_comp_students_count > 0){
    foreach ($course_comp_students as $key => $course_comp_students_val)
    {
        ?>    

<div class="modal fade course_compmodel<?php echo $course_comp_students_val->stid; ?>" id="open_course_comp_comments<?php echo $course_comp_students_val->stid; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Follow up Course Complete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

       <div class="follow_message_data<?php echo $course_comp_students_val->stid; ?>">

       </div>
       <br>


       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $course_comp_students_val->stid; ?>" value="2">Snooze
       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $course_comp_students_val->stid; ?>" value="1">Close
       <input type="radio" name="follow_status" class="form-control followstatus status<?php echo $course_comp_students_val->stid; ?>" value="3">Only Cmment

     

        <br>
        <input type="date" name="snooze_calender" class="form-control show_snooze_calender d-none snooze_calender<?php echo $course_comp_students_val->stid; ?>" value="">
        <br>

       <textarea class="form-control course_comp_follow_message<?php echo $course_comp_students_val->stid; ?>" name="follow_message" rows="8" placeholder="Enter Comment"></textarea>

       <input type="hidden" name="course_fee_detail_id" class="course_fee_detail<?php echo $course_comp_students_val->stid; ?>" value="<?php echo $course_comp_students_val->cfd_id; ?>">

       <div class="error_message"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_course_comp_follow_message save_visamsg<?php echo $course_comp_students_val->stid; ?>" id="<?php echo $course_comp_students_val->stid; ?>" data-dismiss="modal" data-followup="course_completion_followup">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php } } ?>





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
    </style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet"> 
<script>
    $(document).ready(function(){
        $(document).on('click', '.save_visa_follow_message', function(){
         var id = $(this).attr('id');
         var follow_type = $(this).attr('data-followup');
         var follow_message = $('.visa_follow_message'+id).val();
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
        


        $(document).on('click', '.fa-comments', function(){
         var id = $(this).attr('id');
         var follow_type = $(this).attr('data-followup');
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
    </script>
  
  
@endsection