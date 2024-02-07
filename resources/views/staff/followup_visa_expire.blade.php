@extends('staff.layout.head')
@section('staff')

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="headertopcontent">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active visaExpire_open" id="visaexpire-open-tab" data-toggle="pill" data-target="#visaexpire-open" type="button" role="tab" aria-controls="visaexpire-open-tab" aria-selected="true">Open</button>
                        </li>
                         <li class="nav-item" role="presentation">
                            <button class="nav-link visaExpire_snooze" id="visaexpire-snooze-tab" data-toggle="pill" data-target="#visaexpire-snooze" type="button" role="tab" aria-controls="visaexpire-snooze" aria-selected="false">Snooze</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link visaExpire_close" id="visaexpire-close-tab" data-toggle="pill" data-target="#visaexpire-close" type="button" role="tab" aria-controls="visaexpire-close" aria-selected="false">Close</button>
                        </li>
                       
                    </ul>
                </div>
            </div>

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
                <div class="studenttab">
                    <div id="leadss" class="tabcontent">                     
                        <div class="contentinner">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive studenttabless">

                                    <div class="tab-content" id="pills-tabContent">
                                       <div class="tab-pane fade show active visa_Expire_open" id="visaexpire-open" role="tabpanel" aria-labelledby="visaexpire-open-tab">
                                          <table class="table table-striped table-bordered" id="open_visa_expire" style="width:1250px">
                                             <thead class="thead-dark">
                                                <tr>
                                                   <th scope="col">S. No.</th>
                                                   <th scope="col">Name</th>
                                                   <th scope="col">Staff Name</th> 
                                                   <th scope="col">Email</th>
                                                   <th scope="col">Phone No.</th>
                                                   <th scope="col">Expire date</th>
                                                   <th scope="col">Due date</th>
                                                   <th scope="col">Status</th>
                                                   <th scope="col">Action</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                $curr_date =  strtotime(date('d-m-Y'));
                                                //echo "<pre>"; print_r($visa_expiry_students); exit;
                                                if($visa_expiry_students){ 
                                                   $count = 1;
                                                   foreach ($visa_expiry_students as $key => $visa_expiry_students_val) {
                                                      $student_id = base64_encode($visa_expiry_students_val->stid);
                                                      ?>                                           
                                                      <tr>
                                                         <td>{{$count}}</td>
                                                         <td><a href="{{url('admin/student-details/'.$student_id)}}">{{$visa_expiry_students_val->first_name}}</a></td>
                                                         <td>{{$visa_expiry_students_val->staff_name}}</td>
                                                         <td>{{$visa_expiry_students_val->email}}</td>
                                                         <td>{{$visa_expiry_students_val->phone}}</td>
                                                          <td><?php echo date('d-m-Y',strtotime($visa_expiry_students_val->visa_expiry_date)); ?></td>
                                                         <td>
                                                            <?php
                                                               if(isset($visa_expiry_students_val->visa_snooze_date) && $visa_expiry_students_val->visa_snooze_date != '')
                                                                 {
                                                               $visaexpiry_date = strtotime($visa_expiry_students_val->visa_snooze_date);
                                                               echo date('d-m-Y',strtotime($visa_expiry_students_val->visa_snooze_date));
                                                            }
                                                            else
                                                            {   
                                                               $visaexpiry_date = strtotime($visa_expiry_students_val->visa_expiry_date);
                                                               echo date('d-m-Y',strtotime($visa_expiry_students_val->visa_expiry_date));
                                                            }
                                                            ?>
                                                         </td>
                                                        
                                                         <td>
                                                            <?php
                                                            if($visa_expiry_students_val->visa_snooze_date != '')
                                                            {
                                                               $visaexpiry_date = strtotime($visa_expiry_students_val->visa_snooze_date);

                                                               if($curr_date > $visaexpiry_date)
                                                               {
                                                                  ?>
                                                                  <button class="btn btn-danger">Overdue</button>
                                                                  <?php
                                                               }
                                                               else
                                                               {
                                                                  ?>      
                                                                  <button class="btn btn-primary">Open</button>
                                                                  <?php
                                                               }
                                                            }
                                                            else
                                                            {
                                                               $visaexpiry_date = strtotime($visa_expiry_students_val->visa_expiry_date);

                                                               if($curr_date > $visaexpiry_date)
                                                               {
                                                                  ?>
                                                                  <button class="btn btn-danger">Overdue</button>
                                                                  <?php    
                                                               }
                                                               else
                                                               {
                                                                  ?>
                                                                  <button class="btn btn-primary">Open</button>    
                                                                  <?php
                                                               }
                                                            }
                                                            ?>
                                                         </td>   
                                                         <td style="width:170px; float:right">

                                                            <a href="javascript:void(0);" data-id="{{$visa_expiry_students_val->id}}" data-name="{{$visa_expiry_students_val->first_name}}" data-phone="{{$visa_expiry_students_val->phone}}"  data-dialcode="{{$visa_expiry_students_val->phone_dialcode}}"  data-flag="{{$visa_expiry_students_val->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_sms"><i style='font-size:22px !important' class="fa fa-comment-o"></i></a>    


                                                        <a href="javascript:void(0);" data-id="{{$visa_expiry_students_val->id}}" data-name="{{$visa_expiry_students_val->first_name}}" data-phone="{{$visa_expiry_students_val->phone}}"  data-dialcode="{{$visa_expiry_students_val->phone_dialcode}}"  data-flag="{{$visa_expiry_students_val->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_whatsapp"><i style='font-size:22px !important'  class="fa fa-whatsapp" aria-hidden="true"></i></a> 


                                                        <a href="javascript:void(0);" data-id="{{$visa_expiry_students_val->id}}" data-name="{{$visa_expiry_students_val->first_name}}" data-phone="{{$visa_expiry_students_val->phone}}" data-email="{{$visa_expiry_students_val->email}}"  data-dialcode="{{$visa_expiry_students_val->phone_dialcode}}"  data-flag="{{$visa_expiry_students_val->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_mail"><i style='font-size:22px !important'  class="fa fa-envelope-o" aria-hidden="true"></i></a> 

                                                            <button type="button" class="btn btn-primary visa_status" data-toggle="modal" data-target="#open_visa" data-userid="{{$visa_expiry_students_val->stid}}" data-username="{{$visa_expiry_students_val->first_name}}">View</button></td>
                                                         </tr>
                                                         <?php $count++; }  }?>
                                                      </tbody>
                                                   </table>
                                                </div>



                           <div class="tab-pane fade visa_Expire_snooze " id="visaexpire-snooze" role="tabpanel" aria-labelledby="visaexpire-snooze">  

        <table class="table table-striped table-bordered" id="snooze_visa_expire" style="width:1400px">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">S. No.</th>
                                                   <th scope="col">Name</th>
                                                   <th scope="col">Staff Name</th> 
                                                   <th scope="col">Email</th>
                                                   <th scope="col">Phone No.</th>
                                                   <th scope="col">Expire date</th>               
                                                   <th scope="col">Due date</th> 
                                                   <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                                                $curr_date =  strtotime(date('d-m-Y'));
                                                if($snooze_visa_expiry_students){ 
                                                   $count = 1;
                                                   foreach ($snooze_visa_expiry_students as $key => $snooze_visa_expiry_students_val) {
                                                      $student_id = base64_encode($snooze_visa_expiry_students_val->stid);
                                                      ?>                                           
                                                      <tr>
                                                         <td>{{$count}}</td>
                                                         <td><a href="{{url('admin/student-details/'.$student_id)}}">{{$snooze_visa_expiry_students_val->first_name}}</a></td>
                                                         <td>{{$snooze_visa_expiry_students_val->staff_name}}</td>
                                                         <td>{{$snooze_visa_expiry_students_val->email}}</td>
                                                         <td>{{$snooze_visa_expiry_students_val->phone}}</td>
                                                         <td><?php echo date('d-m-Y',strtotime($snooze_visa_expiry_students_val->visa_expiry_date)); ?></td>
                                                         <td>
                                                            <?php
                                                            if(isset($snooze_visa_expiry_students_val->visa_snooze_date) && $snooze_visa_expiry_students_val->visa_snooze_date != '')
                                                                 {
                                                               $visaexpiry_date = strtotime($snooze_visa_expiry_students_val->visa_snooze_date);
                                                               echo date('d-m-Y',strtotime($snooze_visa_expiry_students_val->visa_snooze_date));
                                                            }
                                                            else
                                                            {   
                                                               $visaexpiry_date = strtotime($snooze_visa_expiry_students_val->visa_expiry_date);
                                                               echo date('d-m-Y',strtotime($snooze_visa_expiry_students_val->visa_expiry_date));
                                                            }
                                                            ?>
                                                         </td>
                                                          
                                                         <td style="width:170px; float: right;">

                                                             <a href="javascript:void(0);" data-id="{{$snooze_visa_expiry_students_val->id}}" data-name="{{$snooze_visa_expiry_students_val->first_name}}" data-phone="{{$snooze_visa_expiry_students_val->phone}}"  data-dialcode="{{$snooze_visa_expiry_students_val->phone_dialcode}}"  data-flag="{{$snooze_visa_expiry_students_val->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_sms"><i style='font-size:22px !important' class="fa fa-comment-o"></i></a>    


                                                        <a href="javascript:void(0);" data-id="{{$snooze_visa_expiry_students_val->id}}" data-name="{{$snooze_visa_expiry_students_val->first_name}}" data-phone="{{$snooze_visa_expiry_students_val->phone}}"  data-dialcode="{{$snooze_visa_expiry_students_val->phone_dialcode}}"  data-flag="{{$snooze_visa_expiry_students_val->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_whatsapp"><i style='font-size:22px !important'  class="fa fa-whatsapp" aria-hidden="true"></i></a> 


                                                        <a href="javascript:void(0);" data-id="{{$snooze_visa_expiry_students_val->id}}" data-name="{{$snooze_visa_expiry_students_val->first_name}}" data-phone="{{$snooze_visa_expiry_students_val->phone}}" data-email="{{$snooze_visa_expiry_students_val->email}}"  data-dialcode="{{$snooze_visa_expiry_students_val->phone_dialcode}}"  data-flag="{{$snooze_visa_expiry_students_val->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_mail"><i style='font-size:22px !important'  class="fa fa-envelope-o" aria-hidden="true"></i></a> 

                                                            <button type="button" class="btn btn-primary visa_status" data-toggle="modal" data-target="#open_visa" data-userid="{{$snooze_visa_expiry_students_val->stid}}"  data-username="{{$snooze_visa_expiry_students_val->first_name}}">View</button></td>
                                                         </tr>
                                                         <?php $count++; }  }?>
                                                      </tbody>
                                    </table>

        </div>       




        <div class="tab-pane fade visa_Expire_close" id="visaexpire-close" role="tabpanel" aria-labelledby="visaexpire-close"> 

        <table class="table table-striped table-bordered" id="close_visa_expire" style="width:1400px">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">S. No.</th>
                                                   <th scope="col">Name</th>
                                                   <th scope="col">Staff Name</th> 
                                                   <th scope="col">Email</th>
                                                   <th scope="col">Phone No.</th>
                                                   <th scope="col">Expire date</th>               
                                                   <th scope="col">Due date</th>
                                                   <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                                                $curr_date =  strtotime(date('d-m-Y'));
                                                if($close_visa_expiry_students){ 
                                                   $count = 1;
                                                   foreach ($close_visa_expiry_students as $key => $close_visa_expiry_students_val) {
                                                      $student_id = base64_encode($close_visa_expiry_students_val->stid);
                                                      ?>                                           
                                                      <tr>
                                                         <td>{{$count}}</td>
                                                         <td><a href="{{url('admin/student-details/'.$student_id)}}">{{$close_visa_expiry_students_val->first_name}}</a></td>
                                                         <td>{{$close_visa_expiry_students_val->staff_name}}</td>
                                                         <td>{{$close_visa_expiry_students_val->email}}</td>
                                                         <td>{{$close_visa_expiry_students_val->phone}}</td>
                                                         <td><?php echo date('d-m-Y',strtotime($close_visa_expiry_students_val->visa_expiry_date)); ?></td>
                                                         <td>
                                                            <?php
                                                            if(isset($close_visa_expiry_students_val->visa_snooze_date) && $close_visa_expiry_students_val->visa_snooze_date != '')
                                                               {                      
                                                               $visaexpiry_date = strtotime($close_visa_expiry_students_val->visa_snooze_date);
                                                               echo date('d-m-Y',strtotime($close_visa_expiry_students_val->visa_snooze_date));
                                                            }
                                                            else
                                                            {   
                                                               $visaexpiry_date = strtotime($close_visa_expiry_students_val->visa_expiry_date);
                                                               echo date('d-m-Y',strtotime($close_visa_expiry_students_val->visa_expiry_date));
                                                            }
                                                            ?>
                                                         </td>   
                                                         <td style="width:170px">
                                                            <button type="button" class="btn btn-primary visa_status" data-toggle="modal" data-target="#close_visa" data-userid="{{$close_visa_expiry_students_val->stid}}"  data-username="{{$close_visa_expiry_students_val->first_name}}">View</button></td>
                                                         </tr>
                                                         <?php $count++; } } ?>
                                                      </tbody>
                                    </table>


                                     <div class="modal fade" id="close_visa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                      <div class="modal-dialog  modal-lg" role="document">
                                                            <div class="modal-content">
                                                               <div class="modal-header">
                                                                  <h5 class="modal-title" id="exampleModalLabel">Visa Expire</h5>
                                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                     <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                               </div>
                                                               <div class="modal-body">
                                                                  <div class="username"></div>
                                                               <br>
                                                               <div class="prev_msg"></div>
                                                            </div>
                                                      </div>
                                                   </div>

        </div>
        
</div>



                                                                                             
                                </div>
                            </div>

                           <?php /* {{$get_lead_students->links('pagination::bootstrap-4')}} */ ?>
                          
                        </div>
                    </div>                   
                </div>                
            </div>           
        </div>
    </div>
</div>



<div class="modal fade" id="open_visa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <input type="radio" name="follow_status" class="followstatus status" value="2"><span>Snooze</span>
                  <input type="radio" name="follow_status" class="followstatus status" value="1"><span>Close</span>
                  <input type="radio" name="follow_status" class="followstatus status" value="3"><span>Add Comment</span>
                  <div class="follow_status_Error" style="color: red;"></div>
               </div>
               <br>
               <input type="text" name="snooze_calender" id="datepicker" class="form-control show_snooze_calender d-none" value="">

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





<!-- Modal -->

<div class="modal fade" id="send_sms" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModal2Label">Send SMS to <span class="student_name"></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('send_sms_to_student')}}" method="post" id="sms_form">
        @csrf
            <div class="modal-body phone_number">
                <label><strong> Phone Number <span style='color: red'>*</span></strong></label>
                <input type="text" name="phone_number" id="phone" class="form-control student_phone" value="">

                <span class="error_msg2"></span>
                <br>
                <p class="error-msg" id="error-msg"></p>
                <p class="valid-msg" id="valid-msg"></p>
                <input type="hidden" class="phone_flag" name="phone_flag" value="iti__in"/>
                <input type="hidden" class="phone_dialcode" name="phone_dialcode" value="+91"/>
                <br>
                <textarea name="sms_desc" rows="4" class="form-control smsdesc" maxlength="160"></textarea>
                <span class="length_error" style="color: red;"></span>
                <input type="hidden" name="student_id" class="student_id">
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send SMS</button> 
            </div>
        </form>
      </div>
    </div>
  </div>



  <div class="modal fade" id="send_whatsapp" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModal2Label">Send Whatsapp to <span class="student_name"></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('send_whatsapp_to_student')}}" method="post" id="sms_form" enctype="multipart/form-data">
        @csrf
            <div class="modal-body phone_number">
                <label><strong> Phone Number <span style='color: red'>*</span></strong></label>
                <input type="text" name="whatsapp_number" id="whatsapp" class="form-control student_phone" value="">

                <span class="error_msg2"></span>
                <br>
                <p class="error-msg" id="error-msg"></p>
                <p class="valid-msg" id="valid-msg"></p>
                <input type="hidden" class="whatsapp_flag" name="whatsapp_flag" value="iti__in"/>
                <input type="hidden" class="whatsapp_dialcode" name="whatsapp_dialcode" value="+91"/>
                <br>
                <textarea name="whatsapp_desc" rows="4" class="form-control smsdesc" maxlength="160"></textarea>
                <span class="length_error" style="color: red;"></span>
                <input type="hidden" name="student_id" class="student_id">
                <br>
                <input type="file" name="whatsapp_attachment">
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send SMS</button> 
            </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="send_mail" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModal2Label">Send Mail to <span class="student_name"></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('send_mail_to_student')}}" method="post" id="mail_form" enctype="multipart/form-data">
        @csrf
            <div class="modal-body phone_number">
                <label><strong> Email <span style='color: red'>*</span></strong></label>
                <input type="text" name="email" id="email" class="form-control student_email" value="" readonly>
                <br>
                
                <textarea name="mail_desc" rows="4" class="form-control" required></textarea>                
                <input type="hidden" name="student_id" class="student_id">                
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send SMS</button> 
            </div>
        </form>
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



<script src="{{ asset('admin/js/intlTelInput.js') }}"></script>
<link href="{{ asset('admin/css/intlTelInput.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/isValidNumber.css') }}" rel="stylesheet">

<script src="https://cdn.ckeditor.com/4.13.1/basic/ckeditor.js"></script>
<script>

CKEDITOR.replace( 'send_mail_checklist' );
</script>

<script type="text/javascript">
var inputs_one1 = document.querySelector("#phone"),
  errorMsgs = document.querySelector("#error-msg"),
  validMsgs = document.querySelector("#valid-msg");


var errorMaps = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];


var itis1 = window.intlTelInput(inputs_one1, {
  utilsScript: "{{ asset('admin/js/intlTelInput.js') }}"
});

var reset = function() {
  inputs_one1.classList.remove("error"); 
};

$('.phone_number .thereismeta').addClass('<?php if(isset($get_prospect_student->phone_flag)){ echo $get_prospect_student->phone_flag; } ?>');
$('.phone_number .iti__selected-dial-code').html('<?php if(isset($get_prospect_student->phone_dialcode)){ echo $get_prospect_student->phone_dialcode; } ?>');


inputs_one1.addEventListener('blur', function() {

  reset();
  
  if (inputs_one1.value.trim()) {
    console.log(itis1.isValidNumber());

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

$('.whatsapp .thereismeta').addClass('<?php if(isset($get_prospect_student->whatsapp_flag)){ echo $get_prospect_student->whatsapp_flag; } ?>');
$('.whatsapp .iti__selected-dial-code').html('<?php if(isset($get_prospect_student->whatsapp_dialcode)){ echo $get_prospect_student->whatsapp_dialcode; }?>');

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

 



    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace("active");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<script>
    $(document).on('click','.message',function(){       
        var student_id = $(this).attr("data-id");
        var student_name = $(this).attr("data-name");
        var student_phone = $(this).attr("data-phone");
        var student_email = $(this).attr("data-email");
        var student_flag = $(this).attr("data-flag");
        var student_dialcode = $(this).attr("data-dialcode");
        $('.student_id').val(student_id);
        $('.student_name').html(student_name);
        $('.student_phone').val(student_phone);        
        $('.student_email').val(student_email);        
        $('.phone_number .data1').removeClass('iti__in');
        $('.phone_number .data1').addClass(student_flag);
        $('.phone_number .iti__selected-dial-code').html(student_dialcode);
        
    })
</script>

<script>
    jQuery ('#comment_form').validate({

       rules: {
        comment: "required",         
           } ,
    
       messages: {
        comment:"Please type comment.",
       }     
    });



var maxLength = 160;
var len = 0;
$('.smsdesc').keyup(function(e) {
    var code = e.keyCode;
    if(len == maxLength && code != 8)
    {
        e.preventDefault();
        return false;
    }
  var textlen = maxLength - $(this).val().length;
  //$('#rchars').text(textlen);
  
  if(textlen == 0)
  {    
    $('.length_error').html('Maximum length is 160 for text message.');
  }
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#open_visa_expire').DataTable();


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


     $(document).on('change','.status', function(){
        var status_val = $(this).val();
        if(status_val == 2)
        {
            $('.show_snooze_calender').removeClass('d-none');
            var snoozedate = $('.show_snooze_calender').val();
            if(snoozedate == '')
            {
               $(".show_snooze_calender").prop('required',true);
               return false;
            }
        }
        else if(status_val == 1)
        {
            $('.show_snooze_calender').addClass('d-none');   
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


    var type = window.location.hash.substr(1);
     if(type == 'visaExpire-open-tab')
     {
        $('.visaExpire_open').addClass('active');
        $('.visaExpire_snooze').removeClass('active');
        $('.visaExpire_close').removeClass('active');        
        $('.visa_Expire_open').addClass('active show');
        $('.visa_Expire_snooze').removeClass('active show');
        $('.visa_Expire_close').removeClass('active show');        
     }  

     if(type == 'visaExpire-snooze-tab')
     {
        $('.visaExpire_open').removeClass('active');
        $('.visaExpire_snooze').addClass('active');
        $('.visaExpire_close').removeClass('active');
        $('.visa_Expire_open').removeClass('active show');
        $('.visa_Expire_snooze').addClass('active show');
        $('.visa_Expire_close').removeClass('active show');
     }  
     if(type == 'visaExpire-close-tab')
     {
        $('.visaExpire_open').removeClass('active');
        $('.visaExpire_snooze').removeClass('active');
        $('.visaExpire_close').addClass('active');
        $('.visa_Expire_open').removeClass('active show');
        $('.visa_Expire_snooze').removeClass('active show');
        $('.visa_Expire_close').addClass('active show');
     }

});
</script>
@endsection



<style>
    textarea {

  height: 150px!important;
}

.tab a.active {  
  background: #2b9ac9 !important;
  border: none;
  cursor: pointer;
  padding: 10px 25px;
  transition: 0.3s;
  font-size: 15px;
  float: left;
  color: #fff;
  border-radius: 5px;
  margin-right: 10px;
  margin-left: 10px;
}
.tab button, .tab a, .tablinks {
    background: #999;
    border: none;    
    cursor: pointer;
    padding: 10px 25px;
    transition: 0.3s;
    font-size: 15px;
    float: left;
    color: #fff;
    border-radius: 5px;
    margin-right: 10px;
}

.overduebg
{
    background-color: red !important;
}
.radio_style{
   display: flex;
   justify-content: flex-start;
   align-items: center;
}

.radio_style.followstatus.status{
padding: 2px;
margin: 0 2px;
}
.radio_style span{
   display: inline-block;
   margin:0 5px;
}
#pills-tab>li{
   margin:10px;
}
.nav-link{
   border: none;
   cursor: pointer;
}

#user_list>thead {
    position: sticky;
    top: 0;
    background-color: #166f95;
    width: auto;
    }

#user_list>thead>tr>th{
   color: #fff;
  
}
#user_list>tbody>tr>td{
   border-bottom: 1px solid #ccc;
}

#user_list tr>td{
line-height: 25px;
}

.modal-content
{
   height: 500px;
    overflow-y: scroll;
}


.fa-whatsapp
{
    font: normal normal normal 14px/1 FontAwesome!important;
}

.fa-comment-o
{
    font: normal normal normal 14px/1 FontAwesome!important;
}

    .msgicons {
        float: left;
    margin: 0px 5px 0 0;
}




</style>