@extends('staff.layout.head')
@section('staff')

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
                            {{-- <div class="col-md-1">
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
                                                    <a href="{{route('staff_change_password')}}">
                                                        <i class="fa fa-key"></i>
                                                        <span>Change Password</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{route('staff_logout')}}">
                                                        <i class="fa fa-power-off"></i>
                                                        <span>Logout</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> --}}
                                    {{-- </div> --}}
                                {{-- </div> --}}
                            {{-- </div> --}}
                        {{-- </div>  --}}
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
                        <a href="{{url('/staff/students')}}" class="tablinks">Prospects</a>
                        <a href="{{url('/staff/leads_students')}}" class="tablinks active">Clients</a>
                    </div>
                    <a href="{{url('/staff/add-students')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns"> + Add New Student</a>
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
                                <div class="table-responsive">                                                                  
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">S. No.</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone No.</th>
                                            <th scope="col">Country</th>
                                            <th scope="col">College</th>
                                            <th scope="col">Course</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($get_staff_lead_students){ 
                                                foreach ($get_staff_lead_students as $key => $get_staff_lead_student) { ?>                                           
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td><a style="color: blue" href="{{url('staff/student-details/'.base64_encode($get_staff_lead_student->id))}}">{{$get_staff_lead_student->first_name}} {{$get_staff_lead_student->middle_name}} {{$get_staff_lead_student->last_name}}</a>
                                                    <i class='fa fa-check-circle' style='color:#39f358'></td>
                                                    <td>{{$get_staff_lead_student->email}}</td>
                                                    <td>{{$get_staff_lead_student->phone}}</td>                                                     
                                                    <td>{{$get_staff_lead_student->country}}</td> 
                                                    <td>{{$get_staff_lead_student->college_name}}</td>
                                                    <td>{{$get_staff_lead_student->course_name}}</td>                                                                               
                                                    <td>
                                                    <div class="dropdown dropbtn">
                                                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                          </button>
                                                          <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item message" data-id="{{$get_staff_lead_student->id}}" href="javascript:void(0);" data-name="{{$get_staff_lead_student->first_name}}" data-toggle="modal" data-target="#myModal2">Comment</a>
                                                            <a href="" class="dropdown-item" data-toggle="modal" data-target="#myModal_{{$get_staff_lead_student->id}}">Checklist<a>
                                                            <a class="dropdown-item" href="{{url('staff/student-other-details/'.base64_encode($get_staff_lead_student->id))}}">Add Additional Details</a>
                                                            <a class="dropdown-item" href="{{url('staff/student-deleted/'.base64_encode($get_staff_lead_student->id))}}" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                                          </div>
                                                        </div>
                                                        <!-- <a href="" data-toggle="modal" data-target="#myModal_{{$get_staff_lead_student->id}}"><i class="fa-solid fa-list-check"></i><a>
                                                        <a href="javascript:void(0);" data-id="{{$get_staff_lead_student->id}}" data-name="{{$get_staff_lead_student->first_name}}"  data-toggle="modal" class="message topicon01" data-target="#myModal2"><i style='font-size:20px' class="fa fa-envelope"></i></a> 
                                                        <a href="{{url('staff/student-deleted/'.base64_encode($get_staff_lead_student->id))}}" onclick="return confirm('Are you sure you want to delete this student?');"><i class="fa-solid fa-trash-can fa-lg" style='color: red'></i></a>
                                                        <a href="{{url('staff/student-other-details/'.base64_encode($get_staff_lead_student->id))}} "><i class="fa-solid fa-circle fa-lg" style='color: rgba(22, 97, 4, 0.495)'></i></a> -->
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                        </tbody>
                                    </table>                                                          
                                </div>
                            </div>
                            {{ $get_staff_lead_students->links('pagination::bootstrap-4') }}     
                        </div>
                    </div> 
                    
                </div>                
            </div>           
        </div>
    </div>
</div>







<!-- Modal -->

<?php if($get_staff_lead_students){
    foreach ($get_staff_lead_students as $key =>$get_staff_lead_student) {
 ?>

<div class="modal fade" id="myModal_{{$get_staff_lead_student->id}}" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
            <h5 class="modal-title" id="myModal2Label">Lead Status of {{$get_staff_lead_student->first_name}} {{$get_staff_lead_student->last_name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>          
        <div class="modal-body">
          <p><strong>Personal Details<span class="float-right">@if($get_staff_lead_student->email !='' && $get_staff_lead_student->is_verified==1 )<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

          <p><strong>Passport<span class="float-right">@if($get_staff_lead_student->passport_number !='')<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

          <p><strong>Visa<span class="float-right">@if($get_staff_lead_student->visa_type!='' )<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

          <p><strong>OSHC/OVHC<span class="float-right">@if($get_staff_lead_student->oshc_ovhc_file !='' )<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></p>

          <p><strong>IELTS / PTE Score<span class="float-right">@if($get_staff_lead_student->ielts_pte_score_file !='' )<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></p>

          <p><strong>Education Details<span class="float-right">@if($get_staff_lead_student->ielts_pte_score_file !='' )<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

          <p><strong>COES<span class="float-right">@if($get_staff_lead_student->coes !='' )<i class="fa fa-check" style='color: green' aria-hidden="true"></i>@else<i class="fa fa-times" style='color: red' aria-hidden="true"></i>@endif</span></strong></p>

        </div>        
      </div>      
    </div>
</div>
<?php }}?>


        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal2Label">Add Comment for <span class="student_name"></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('staffAddComment')}}" method="post" id="comment_form_staff">
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

        <!-- Scripts -->

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
        </script>
        
        
        
        <style>
            textarea {
        
        height: 150px!important;
        }
        
        
        .tab a.active {
        background: #363636 !important;
        }
        .tab a {  
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
        }

        .tab a{
    background: #f8f9fe !important;
    color: #363636!important;
}
.tab a.active {
    color: #fff!important;
    background: #2e9bca!important;
}

.dropbtn .dropdown-toggle{
margin-top:0;
}
        </style>

 @endsection