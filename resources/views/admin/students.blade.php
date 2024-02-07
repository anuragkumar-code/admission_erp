@extends('admin.layout.head')
@section('admin')

<style type="text/css">
    .only_header
    {
        display: none !important;
    }
</style>

<?php
$name = $dob = $phone = '';

$name = Request::get('name');
$dob = Request::get('dob'); 
$phone = Request::get('phone');

//echo "DOB =>".$name.'DOB =>'.$dob.'Phone =>'.$phone;


?>
<link rel="stylesheet" href="{{ asset('admin/css/bootstrap-datepicker.css') }}">
  <script src="{{ asset('admin/js/bootstrap-datepicker.min.js') }}"></script>

   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script type="text/javascript">
    
    $("#startdate1").datepicker({

           todayBtn:  1,
           startDate: new Date(),
           autoclose: true,
           format: 'dd/mm/yyyy',
           orientation: 'top',

        }).on('changeDate', function (selected) {

            var minDate = new Date(selected.date.valueOf());

            $('#enddate').datepicker('setStartDate', minDate);

        });


        </script>

<div class="main">
        <div class="container-fluid">
            <div class="header">      
                <div class="container-fluid">
                    <div class="topnavstrip">
                        <div class="row">

                            <div class="col-md-1">
                                <div class="hamburger sidebar-toggle">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                   
                            </div>
                        </div>
                            <div class="col-md-9">
                                <form action="{{url('/admin/search')}}" method="get" class="top-search">
                                    <input type="text" class="form-control" name="name" value="{{ app('request')->input('name') }}" placeholder="Student Name">
                                    <input type="text" id="startdate1" class="form-control" name="dob" value="{{ app('request')->input('dob') }}"  placeholder="dd/mm/yyyy">
                                    <input type="text" class="form-control" name="phone" value="{{ app('request')->input('phone') }}" placeholder="Mobile No.">
                                    <input type="hidden" name="st_type" value="prospects">
                                    <button type="submit" class="btn btn-outline-info searchbtnsinto"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        
                            <div class="col-md-2 mobilehides">
                                <div class="dropdown dib" style="float: right">
                                    <div class="header-icon" data-toggle="dropdown">
                                        <span class="user-avatar">{{Auth::user()->first_name}}
                                            <i class="ti-angle-down f-s-10"></i>
                                        </span>
                                        <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-content-heading">
                                                <span class="text-left">{{Auth::user()->first_name}}</span>
                                            </div>
                                            <div class="dropdown-content-body">
                                                <ul>
                                                    <li>
                                                        <a href="{{route('change_password')}}">
                                                            <i class="fa fa-key"></i>
                                                            <span>Change Password</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('adminLogout')}}">
                                                            <i class="fa fa-power-off"></i>
                                                            <span>Logout</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

<div style="clear: both;">&nbsp;</div>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="headertopcontent">
                 <div class="tab">
                       <a href="{{url('/admin/students')}}" class="tablinks active">Prospects</a>
                       <?php if($name != '' || $dob != '' || $phone != ''){ ?>
                        
                        <form action="{{url('/admin/search')}}" method="get" class="top-search">
                            <input type="hidden" class="form-control" name="name" value="{{ $name }}" placeholder="Student Name">
                            <input type="hidden" class="form-control" name="dob" value="{{ $dob }}"  placeholder="Date of Birth">
                            <input type="hidden" class="form-control" name="phone" value="{{ $phone }}" placeholder="Mobile No.">
                        <input type="hidden" name="st_type" value="leads">
                        <button type="submit" class="tab">Clients</button>
                        </form>
                        <!-- <a href="{{url('/admin/leads_students')}}" class="tablinks">Leads</a> -->
                       <?php } else { ?>
                        <a href="{{url('/admin/leads_students')}}" class="tablinks">Clients</a>
                       <?php } ?>
                    </div>
                    <a href="{{url('/admin/add-students')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns"> + Add New Student</a>
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
                    <div id="prospect" class="tabcontent">                    
                        <div class="contentinner">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive studenttabless">                                                                  
                                    <table class="table table-striped table-bordered" id="bootstrap-data-table-export">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">S. No.</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Staff Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone No.</th>
                                            <th scope="col">Country</th>               
                                            <th scope="col">Type</th>               
                                            <th scope="col"></th>                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            //echo "<pre>"; print_r($get_prospect_students); exit;
                                            if($get_prospect_students ){ 
                                                foreach ($get_prospect_students as $key => $get_prospect_student) { 

                                                    if($get_prospect_student->is_read==1  && $get_prospect_student->type == 1)
                                                    {
                                                        $read_unread = '';
                                                        if($get_prospect_student->is_read_client_notes == 0)
                                                        {
                                                            $unread_clientnotes = 'yellow';
                                                        }
                                                        else
                                                        {
                                                            $unread_clientnotes = '';
                                                        }
                                                    }
                                                    if($get_prospect_student->is_read==0 && $get_prospect_student->type == 1)
                                                    {
                                                        $read_unread = 'tomato';
                                                        $unread_clientnotes = '';

                                                    }


                                                ?>                                           
                                                <tr class="migration_row<?php echo $get_prospect_student->id; ?> student_row{{$get_prospect_student->id}} <?php echo $read_unread; ?> <?php echo $unread_clientnotes; ?>">
                                                    <td>{{$key+1}}</td>
                                                    <td><?php if($get_prospect_student->priority == 1){ ?>
                                                        <span style="color: green"><strong>High</strong></span>
                                                        <?php }elseif($get_prospect_student->priority == 2){ ?>
                                                            <span style="color:orange"><strong>Medium</strong></span>
                                                        <?php }else{ ?>
                                                            <span style="color: red"><strong>Low</strong></span>
                                                        <?php } ?>
                                                    </td> 
                                                    <td><a style="color: blue" href="{{url('admin/student-details/'.base64_encode($get_prospect_student->id))}}">{{$get_prospect_student->first_name}} {{$get_prospect_student->middle_name}} {{$get_prospect_student->last_name}}
                                                    </a><i class='fa fa-times-circle' style='color:red'></i>
                                                       </td>

                                                    <td>{{$get_prospect_student->staff_name}} @if(Auth::user()->type==1 )  <?php if(isset($get_prospect_student->office_name)) {?>({{$get_prospect_student->office_name}}) <?php }?> @endif </td>

                                                    <td>{{$get_prospect_student->email}}</td>
                                                    <td>{{$get_prospect_student->phone}}</td>
                                                    <td>{{$get_prospect_student->country}}</td>       
                                                    <td>
                                                        <?php if($get_prospect_student->added_by == 1){?>
                                                            Self
                                                        <?php } else {?>
                                                            Admin
                                                        <?php } ?>
                                                    </td>         
                                                    <td width="350">                                    

                                                    <a href="javascript:void(0);" data-id="{{$get_prospect_student->id}}" class="migrate topicon01"><i style='font-size:22px !important;' class="fa fa-rocket" aria-hidden="true" title="Move to Migration"></i></a> 

                                                    <a href="javascript:void(0);" data-id="{{$get_prospect_student->id}}" class="extra topicon01"><i style='font-size:22px !important;' class="fa fa-external-link" aria-hidden="true" title="Move to Extra"></i>

                                                        <a href="javascript:void(0);" data-id="{{$get_prospect_student->id}}" data-name="{{$get_prospect_student->first_name}}" data-phone="{{$get_prospect_student->phone}}" data-dialcode="{{$get_prospect_student->phone_dialcode}}"  data-flag="{{$get_prospect_student->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_sms"><i style='font-size:22px !important' class="fa fa-comment-o"></i></a>    


                                                        <a href="javascript:void(0);" data-id="{{$get_prospect_student->id}}" data-name="{{$get_prospect_student->first_name}}" data-phone="{{$get_prospect_student->phone}}"  data-dialcode="{{$get_prospect_student->phone_dialcode}}"  data-flag="{{$get_prospect_student->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_whatsapp"><i style='font-size:22px !important'  class="fa fa-whatsapp" aria-hidden="true"></i></a> 


                                                        <a href="javascript:void(0);" data-id="{{$get_prospect_student->id}}" data-name="{{$get_prospect_student->first_name}}" data-phone="{{$get_prospect_student->phone}}" data-email="{{$get_prospect_student->email}}"  data-dialcode="{{$get_prospect_student->phone_dialcode}}"  data-flag="{{$get_prospect_student->phone_flag}}"  data-toggle="modal" class="message topicon01 msgicons" data-target="#send_mail"><i style='font-size:22px !important'  class="fa fa-envelope-o" aria-hidden="true"></i></a>    

                                                          

                                                    <div class="dropdown dropbtn">                                                       
                                                            <i class="fa fa-ellipsis-h" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-hidden="true"></i>  

                                                          <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">

                                                            <?php if($get_prospect_student->is_read == 0 && $get_prospect_student->type == 1){ ?>
                                                                <a class="dropdown-item read read_label{{$get_prospect_student->id}}" data-student_id="{{$get_prospect_student->id}}" href="#">Mark Read</a>
                                                            <?php } elseif($get_prospect_student->is_read == 1 && $get_prospect_student->type == 1) {?>
                                                                <a class="dropdown-item unread unread_label{{$get_prospect_student->id}}" data-student_id="{{$get_prospect_student->id}}" href="#">Mark Unread</a>
                                                            <?php } ?>


                                                            <a class="dropdown-item message" data-id="{{$get_prospect_student->id}}" href="javascript:void(0);" data-name="{{$get_prospect_student->first_name}}" data-toggle="modal" data-target="#myModal2">Client Notes</a>

                                                            <?php if($get_prospect_student->is_read_client_notes == 0){?> 
                                                            <a class="dropdown-item read_clientnotes client_note_label{{$get_prospect_student->id}}" data-id="{{$get_prospect_student->id}}" href="javascript:void(0);" data-type="1" data-name="{{$get_prospect_student->first_name}}">Read Client Notes</a>
                                                        <?php } else if($get_prospect_student->is_read_client_notes == 1) {?>
                                                            <a class="dropdown-item read_clientnotes client_note_label{{$get_prospect_student->id}}" data-id="{{$get_prospect_student->id}}" href="javascript:void(0);" data-type="0" data-name="{{$get_prospect_student->first_name}}">Unread Client Notes</a>
                                                        <?php } ?>

                                                            <a href="" class="dropdown-item" data-toggle="modal" data-target="#myModal_{{$get_prospect_student->id}}">Checklist</a>
                                                            <a class="dropdown-item" href="{{url('admin/student-other-details/'.base64_encode($get_prospect_student->id))}}">Convert to Client</a>
                                                            <a class="dropdown-item" href="{{url('admin/student-deleted/'.base64_encode($get_prospect_student->id))}}" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                                          </div>
                                                    </div>
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                        </tbody>
                                    </table>                                                          
                                </div>
                            </div>                           
                        </div>
                    </div>                                   
                </div>                
            </div>           
        </div>
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
                <input type="hidden" name="subject" value="Genral Information">                
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send Mail</button> 
            </div>
        </form>
      </div>
    </div>
  </div>


<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModal2Label">Add Comment for <span class="student_name"></span> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('adminAddComment')}}" method="post" id="comment_form">
        @csrf
            <div class="modal-body">
                <label><strong> Comment <span style='color: red'>*</span></strong></label>
                <textarea type="text" name="comment" class="form-control passcode"></textarea>             
                <input type="hidden" name="student_id" class="student_id">
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Comment</button> 
            </div>
        </form>
      </div>
    </div>
  </div>



  <?php if($get_prospect_students){ 
   
    foreach ($get_prospect_students as $key => $get_prospect_student) { ?>

    <div class="modal fade" id="myModal_{{$get_prospect_student->id}}" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">   
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2Label">Lead Status of {{$get_prospect_student->first_name}} {{$get_prospect_student->last_name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>    
            <div class="modal-body">
                <p>
                    <strong>
                        Personal Details
                        <span class="float-right">
                            @if($get_prospect_student->email !='' && $get_prospect_student->is_verified==1 )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                <p>
                    <strong>
                        Passport
                        <span class="float-right">
                            @if($get_prospect_student->passport_number != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                <p>
                    <strong>
                        Visa
                        <span class="float-right">
                            @if($get_prospect_student->visa_type != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>
            
                <p>
                    <strong>
                        OSHC/OVHC
                        <span class="float-right">
                            @if($get_prospect_student->oshc_ovhc_file != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                 <p>
                    <strong>
                        IELTS / PTE Score
                        <span class="float-right">
                            @if($get_prospect_student->ielts_pte_score_file != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                <p>
                    <strong>
                        Education Details
                        <span class="float-right">
                            @if($get_prospect_student->ielts_pte_score_file != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>


                 <p>
                    <strong>
                        COES
                        <span class="float-right">
                            @if($get_prospect_student->coes != '' )
                            <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                            @else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif
                        </span>
                    </strong>
                </p>

                <p><textarea class="form-control checklist_mail_content" name="send_mail_checklist"></textarea></p>

                <p><button type="button" class="btn btn-primary send_mail_checklist" data-student_id="<?php echo $get_prospect_student->id; ?>">Send Mail</button></p>

            </div>        
          </div>      
        </div>
    </div>
        
<?php }}?>







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

CKEDITOR.replace( 'mail_desc' );


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



$(document).ready(function(){
$(document).on('click', '.migrate', function(){
         var id = $(this).attr('data-id');

       $.ajax({
                type: "POST",
                url: "{{route('migration')}}",
                data: {"_token": "{{ csrf_token() }}",id:id},
                success: function(data)
                {
                    $('.migration_row'+id).css('background','tomato');
                    $('.migration_row'+id).fadeOut(800,function(){
                    $(this).remove();
                });
                }
            });
      }); 


$(document).on('click', '.extra', function(){
         var id = $(this).attr('data-id');

       $.ajax({
                type: "POST",
                url: "{{route('extra')}}",
                data: {"_token": "{{ csrf_token() }}",id:id},
                success: function(data)
                {
                    $('.migration_row'+id).css('background','tomato');
                    $('.migration_row'+id).fadeOut(800,function(){
                    $(this).remove();
                });
                }
            });
      }); 


$(document).on('click', '.send_mail_checklist', function(){
         var id = $(this).attr('data-student_id');
         var mail_content = CKEDITOR.instances['send_mail_checklist'].getData();
         //alert(mail_content);
       $.ajax({
                type: "POST",
                url: "{{route('send_mail_checklist')}}",
                data: {"_token": "{{ csrf_token() }}",id:id,mail_content:mail_content},
                success: function(data)
                {
                    $('#myModal_'+id).modal('hide');
                    $('.modal-backdrop').removeClass('show');
                     CKEDITOR.instances['send_mail_checklist'].setData('');
                }  
                });
                
            });


 $(document).on('click','.read', function(){
        var student_id = $(this).data('student_id');      
        var is_read = 1;      
        //alert(user_id);
        $.ajax({
                type: "POST",
                url: "{{route('ajax_student_read_unread')}}",
                data: {"_token": "{{ csrf_token() }}",student_id:student_id,is_read:is_read},
                success: function(data)
                {
                   //alert(data);
                   $('.all_task'+student_id).html(data);   
                   $('.read_label'+student_id).html('Mark Unread');              
                   $('.read_label'+student_id).removeClass('read');              
                   $('.read_label'+student_id).addClass('unread');              
                   $('.student_row'+student_id).removeClass("tomato",1000);               
                }
            });
    });


    $(document).on('click','.unread', function(){
        var student_id = $(this).data('student_id');      
        var is_read = 0;     
        //alert(user_id);
        $.ajax({
                type: "POST",
                url: "{{route('ajax_student_read_unread')}}",
                data: {"_token": "{{ csrf_token() }}",student_id:student_id,is_read:is_read},
                success: function(data)
                {
                   //alert(data);
                   $('.all_task'+student_id).html(data);                 
                   $('.unread_label'+student_id).html('Mark Read');
                   $('.unread_label'+student_id).removeClass('unread');              
                   $('.unread_label'+student_id).addClass('read');                 
                   $('.student_row'+student_id).addClass("tomato",1000);                 
                }
            });
    });



    $(document).on('click','.read_clientnotes', function(){
        var student_id = $(this).data('id');            
        var type = $(this).data('type');            
        //alert(user_id);
        $.ajax({
                type: "POST",
                url: "{{route('ajax_client_notes_read_unread')}}",
                data: {"_token": "{{ csrf_token() }}",student_id:student_id,type:type},
                success: function(data)
                {
                   //alert(data); 
                   if(data == 1)
                   {                            
                       $('.client_note_label'+student_id).html('Unread Client Notes');
                       $('.client_note_label'+student_id).removeClass('Unread Client Notes');              
                       $('.client_note_label'+student_id).addClass('Unread Client Notes');                 
                       $('.student_row'+student_id).removeClass("yellow",1000);
                       $('.client_note_label'+student_id).data('type',0);                 
                   }

                   if(data == 0)
                   {                            
                       $('.client_note_label'+student_id).html('Read Client Notes');
                       $('.client_note_label'+student_id).removeClass('Read Client Notes');              
                       $('.client_note_label'+student_id).addClass('Read Client Notes');                 
                       $('.student_row'+student_id).addClass("yellow",1000);                 
                       $('.client_note_label'+student_id).data('type',1);
                   }
                }
            });
    });




      }); 

 </script>



<style>
    textarea {

  height: 150px!important;
}





/*.tab button.active {
  background: #2b9ac9 !important;
}*/
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

.top-search {
    width: inherit;
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

.tomato
{
    background-color: #ffcaca !important;
    color: #000;
    font-weight: bold;
}


.yellow
{
    background-color: yellow !important;
    color: #000;
    font-weight: bold;
}

table.dataTable tbody th, table.dataTable tbody td {
    padding: 15px 4px !important;
}

</style>
@endsection
