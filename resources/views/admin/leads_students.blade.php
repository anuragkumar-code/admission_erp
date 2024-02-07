@extends('admin.layout.head')
@section('admin')

<style type="text/css">
.only_header
{
    display: none !important;
}
</style>


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
                                    <input type="date" class="form-control" name="dob" value="{{ app('request')->input('dob') }}"  placeholder="Date of Birth">
                                    <input type="text" class="form-control" name="phone" value="{{ app('request')->input('phone') }}" placeholder="Mobile No.">
                                    <input type="hidden" name="st_type" value="leads">
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
                        <a href="{{url('/admin/students')}}" class="tablinks">Prospects</a>
                        <a href="{{url('/admin/leads_students')}}" class="tablinks active">Clients</a>
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
                    <div id="leadss" class="tabcontent">                     
                        <div class="contentinner">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive studenttabless">                                                                  
                                    <table class="table table-striped table-bordered" id="bootstrap-data-table-export">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">S. No.</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Staff Name</th> 
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone No.</th>
                                                <th scope="col">Country</th>  
                                                <th scope="col">College</th>               
                                                <th scope="col">Course</th>                
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //echo "<pre>"; print_r($get_lead_students); exit;

                                             if($get_lead_students){ 
                                                foreach ($get_lead_students as $key => $get_lead_student) { 


                                                        if($get_lead_student->is_read_client_notes == 0)
                                                        {
                                                            $unread_clientnotes = 'yellow';
                                                        }
                                                        else
                                                        {
                                                            $unread_clientnotes = '';
                                                        }
                                                   

                                                    ?>                                           
                                                <tr class="migration_row<?php echo $get_lead_student->id; ?> student_row{{$get_lead_student->id}} <?php echo $unread_clientnotes; ?>">
                                                    <td>{{$key+1}} <?php /*{{ ($get_lead_students->currentpage()-1) * $get_lead_students->perpage() + $key + 1 }} */ ?></td>
                                                    <td><a style="color: blue" href="{{url('admin/student-details/'.base64_encode($get_lead_student->id))}}">{{$get_lead_student->first_name}} {{$get_lead_student->middle_name}} {{$get_lead_student->last_name}}</a>
                                                        <i class='fa fa-check-circle' style='color:#39f358'>
                                                    </td>
                                                    <td>{{$get_lead_student->staff_name}}  @if(Auth::user()->type==1 )  <?php if(isset($get_lead_student->office_name)) {?>({{$get_lead_student->office_name}}) <?php }?> @endif</td>
                                                    <td>{{$get_lead_student->email}}</td>
                                                    <td>{{$get_lead_student->phone}}</td>   
                                                    <td>{{$get_lead_student->country}}</td>                                                     
                                                    <td>{{$get_lead_student->college_name}}</td>                                                     
                                                    <td>{{$get_lead_student->course_name}}</td>                                                     
                                                    <td>
                                                    <div class="dropdown dropbtn">
                                                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                          </button>
                                                          <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                            
                                                            <a class="dropdown-item message" data-id="{{$get_lead_student->id}}" href="javascript:void(0);" data-name="{{$get_lead_student->first_name}}" data-toggle="modal" data-target="#myModal2">Client Notes</a>

                                                            <?php if($get_lead_student->is_read_client_notes == 0){?> 
                                                            <a class="dropdown-item read_clientnotes client_note_label{{$get_lead_student->id}}" data-id="{{$get_lead_student->id}}" href="javascript:void(0);" data-type="1" data-name="{{$get_lead_student->first_name}}">Read Client Notes</a>
                                                        <?php } else if($get_lead_student->is_read_client_notes == 1) {?>
                                                            <a class="dropdown-item read_clientnotes client_note_label{{$get_lead_student->id}}" data-id="{{$get_lead_student->id}}" href="javascript:void(0);" data-type="0" data-name="{{$get_lead_student->first_name}}">Unread Client Notes</a>
                                                        <?php } ?>

                                                            <a href="" class="dropdown-item" data-toggle="modal" data-target="#myModal_{{$get_lead_student->id}}">Checklist<a>
                                                            <a class="dropdown-item" href="{{url('admin/student-other-details/'.base64_encode($get_lead_student->id))}}">Add Additional Details</a>
                                                            <a class="dropdown-item" href="{{url('admin/student-deleted/'.base64_encode($get_lead_student->id))}}" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                                          </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            <?php }}?>
                                        </tbody>
                                    </table>                                                          
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

<!-- Modal -->

 <?php if($get_lead_students){ 
   
        foreach ($get_lead_students as $key => $get_lead_student) { ?>

        <div class="modal fade" id="myModal_{{$get_lead_student->id}}" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">   
                <div class="modal-header">
                    <h5 class="modal-title" id="myModal2Label">Lead Status of {{$get_lead_student->first_name}} {{$get_lead_student->last_name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>    
                <div class="modal-body">
                  <p><strong>Personal Details<span class="float-right">@if($get_lead_student->email!='' && $get_lead_student->is_verified==1 )<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif </span></strong></p>

                  <p><strong>Passport<span class="float-right">@if($get_lead_student->passport_number!='')<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

                  <p><strong>Visa<span class="float-right">@if($get_lead_student->visa_type!='')<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

                  <p><strong>OSHC/OVHC<span class="float-right">@if($get_lead_student->oshc_ovhc_file!='')<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

                  <p><strong>IELTS / PTE Score<span class="float-right">@if($get_lead_student->ielts_pte_score_file!='')<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

                  <p><strong>Education Details<span class="float-right">@if($get_lead_student->ielts_pte_score_file!='')<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>
                  
                  <p><strong>COES<span class="float-right">@if($get_lead_student->coes!='')<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

                  <p><textarea class="form-control checklist_mail_content" name="send_mail_checklist"></textarea></p>

                  <p><button type="button" class="btn btn-primary send_mail_checklist" data-student_id="<?php echo $get_lead_student->id; ?>">Send Mail</button></p>
                </div>        
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
                <input type="hidden" name="student_id" value="{{$get_lead_student->id}}" class="student_id">
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Comment</button> 
            </div>
        </form>
      </div>
    </div>
  </div>

<?php } } ?>

<script src="https://cdn.ckeditor.com/4.13.1/basic/ckeditor.js"></script>
<script>

CKEDITOR.replace( 'send_mail_checklist' );
</script>

<script>
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
        $('.student_id').val(student_id);
        $('.student_name').html(student_name);
        
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


$(document).ready(function(){
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