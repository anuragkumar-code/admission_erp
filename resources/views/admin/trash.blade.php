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
                                                {{--  <a href="{{url('/admin/trash')}}" class="tablinks active">Deleted Students</a>                    
                                                                            
                                                    <a href="{{url('/admin/trash')}}" class="tablinks active">Deleated Course</a>
                                                
                                                    <a href="{{url('/admin/trash')}}" class="tablinks active">Deleated Staff</a>
                                                    <a href="{{url('/admin/trash')}}" class="tablinks active">Deleated Colleges</a>
                                                    --}}

                      
                   

                            <ul class="nav nav-tabs tablinks active" role="tablist">

                                    <li class="nav-item">


                                        <a class="nav-link active tablinks" data-toggle="tab" href="#delstd">Deleted Students</a>


                                    </li>

                                    <li class="nav-item">


                                        <a class="nav-link tablinks " data-toggle="tab" href="#delcourse">Deleted Courses</a>


                                    </li>

                                    <li class="nav-item">

                                        <a class="nav-link tablinks " data-toggle="tab" href="#delstaff">Deleted Staff</a>

                                    </li>

                                    <li class="nav-item">

                                        <a class="nav-link tablinks " data-toggle="tab" href="#delcolleges">Deleted Colleges</a>

                                    </li>


                                    <li class="nav-item">

                                        <a class="nav-link tablinks " data-toggle="tab" href="#deloffices">Deleted Offices</a>

                                    </li>



                            </ul>
              
           

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


                            @if(session()->has('warning_msg'))
                            <div class="alert alert-danger" id="myDIV" role="alert">
                                <strong>{{session()->get('warning_msg')}}</strong> 
                                <i class="fa fa-close closeicon" onclick="hide()" aria-hidden="true"></i>                                                    
                            </div>
                            @endif                      
        

                        <div class="tab-content">

                                <div id="delstd" class="tab-pane active">

                                    <table class="table">
                    
                                            <thead>
    
                                                     <tr>
    
                  
                                                        <th>S.No</th>

                                                        <th>Name</th>
                                        
                                                        <th>Email</th>
                                        

                                                        <th>Deleted by</th>

                                        
                                                        <th>Action</th>
                                        
                    
                                                    </tr>
                                        
                                                 </thead>
                                        
                                                    <tbody>
                                                        <?php if ($get_trash_student_data){
                                                            foreach ($get_trash_student_data as $key => $get_trash_student){?>
                                                        
    
                               
    
                                                            <tr>         
                                                    
                                                            <td>{{$key+1}} </td>
                                                    
                                                             <td> {{$get_trash_student->first_name}}</td>
                                                    
                                                            <td>{{$get_trash_student->email}} </td>                              
                                                    
                                                            <td>{{$get_trash_student->deleted_by}} </td>

                                                            <td> <div class="dropdown dropbtn">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                  Action
                                                                </button>
                                                                <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                                  
                                                                  <a class="dropdown-item" href="{{url('admin/student_trash_restore/'.base64_encode($get_trash_student->id))}}">Restore</a>
                                                                  <a class="dropdown-item" href="{{url('admin/student_trash_delete/'.base64_encode($get_trash_student->id))}}" onclick="return confirm('Are you sure you want to permanently delete this student?');">Permanently Delete</a>
                                                                </div>
                                                              </div>
                                                            </td>
                                                                
                                                    
                                                            </tr>
    
                         
                                                            <?php }} ?>
                                                    </tbody>
    
                                    </table>
    
            
                                </div>
        
            

        
    
    
                                            <div id="delcourse" class="tab-pane">
                                    
                                                <table class="table">
                                        
                                                    <thead>
                                        
                                                    <tr>
                                        
                                                        <th>S.No</th>
                                        
                                                        <th>Course Name</th>                                      
                                                        
                                                        <th>Deleted by</th>
                                        
                                                        <th>Action</th>
                                        
                                                        
                                                    </tr>
                                        
                                                    </thead>
                                        
                                                    <tbody>
                                        
                                                       <?php if($get_trash_course_data) {
                                                        foreach ($get_trash_course_data as $key => $get_trash_course) { ?>
                                                             <tr>             
                                                                                                      
                                        
                                                                <td> {{$key+1}} </td>

                                                                <td>  {{$get_trash_course->course_name}}</td>
                                                               
                                                                <td>  {{$get_trash_course->deleted_by}}</td>

                                                                <td> <div class="dropdown dropbtn">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                      Action
                                                                    </button>
                                                                    <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                                      
                                                                      <a class="dropdown-item" href="{{url('admin/course_trash_restore/'.base64_encode($get_trash_course->id))}}">Restore</a>
                                                                      <a class="dropdown-item" href="{{url('admin/course_trash_delete/'.base64_encode($get_trash_course->id))}}" onclick="return confirm('Are you sure you want to permanently delete this course?');">Permanently Delete</a>
                                                                    </div>
                                                                  </div>
                                                                    
                                                                </td>

                                                                
                                                            </tr>
                                                     <?php   }}?>         
                                        
                                                   
                                        
                                                            
                                        
                                                    </tbody>
                                        
                                                </table>       
                                                
                                        
                                            </div>
           
        
        
                                            <div id="delstaff" class="tab-pane">
                                    
                                                <table class="table">
                                        
                                                    <thead>
                                        
                                                    <tr>
                                        
                                                    
                                                        <th>S. No</th>
                                                        
                                                        <th>Staff Name</th>
                                        
                                                        <th>Email</th>
                                        
                                                        <th>Deleted by</th>
                                        
                                                        <th>Action</th>
                                        
                                                        
                                                    </tr>
                                        
                                                    </thead>
                                        
                                                    <tbody>
                                                        <?php if($get_trash_staff_data) {
                                                            foreach ($get_trash_staff_data as $key => $get_trash_staff) { ?>
                                        
                                                                
                                        
                                                    <tr>              
                                        
                                                                    
                                        
                                                        <td>{{$key+1}} </td>
                                        
                                                        <td> {{$get_trash_staff->first_name}}</td>
                                        

                                                        <td>{{$get_trash_staff->email}} </td>   
                                                                                   
                                        
                                                        <td> {{$get_trash_staff->deleted_by}}</td>


                                                        <td> <div class="dropdown dropbtn">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                              Action
                                                            </button>
                                                            <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                              
                                                              <a class="dropdown-item" href="{{url('admin/staff_trash_restore/'.base64_encode($get_trash_staff->id))}}">Restore</a>
                                                              <a class="dropdown-item" href="{{url('admin/staff_trash_delete/'.base64_encode($get_trash_staff->id))}}" onclick="return confirm('Are you sure you want to permanently delete this staff?');">Permanently Delete</a>
                                                            </div>
                                                          </div>
                                                            
                                                        </td>



                                                    
                                        
                                                    </tr>

                                                    <?php   }}?> 
                                        
                                                            
                                        
                                                    </tbody>
                                        
                                                </table>
            
                                            </div>
            
               
            
            
                                            <div id="delcolleges" class="tab-pane">
                                    
                                                <table class="table">
                                        
                                                    <thead>
                                        
                                                    <tr>
                                        
                                                    
                                                        <th>S. No.</th>
                                                        
                                                        <th>College Name</th>
                                        
                                                        <th>Email</th>
                                        
                                                        <th>Deleted by</th>
                                        
                                                        <th>Action</th>
                                        
                                                        
                                                    </tr>
                                        
                                                    </thead>
                                        
                                                    <tbody>
                                                        <?php if($get_trash_college_data) {
                                                            foreach ($get_trash_college_data as $key => $get_trash_college) { ?>
                                        
                                        
                                                                
                                        
                                                    <tr>              
                                        
                                                                    
                                                        <td>{{$key+1}} </td>

                                                        <td>{{$get_trash_college->college_trading_name}} </td>
                                        
                                                        <td> {{$get_trash_college->admission_email}}  </td>
                                        

                                                        <td> {{$get_trash_college->deleted_by}}</td>                              

                                                        <td> <div class="dropdown dropbtn">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                              Action
                                                            </button>
                                                            <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                              
                                                              <a class="dropdown-item" href="{{url('admin/college_trash_restore/'.base64_encode($get_trash_college->id))}}">Restore</a>
                                                              <a class="dropdown-item" href="{{url('admin/college_trash_delete/'.base64_encode($get_trash_college->id))}}" onclick="return confirm('Are you sure you want to permanently delete this college?');">Permanently Delete</a>
                                                            </div>
                                                          </div>
                                                            
                                                        </td>
                                                        
                                                    
                                        
                                                    </tr>
                                        
                                                    <?php   }}?>     
                                        
                                                    </tbody>
                                        
                                                </table>
                                            </div>
                        
                

                                            <div id="deloffices" class="tab-pane">
                                    
                                                <table class="table" >
                                        
                                                    <thead>
                                        
                                                    <tr>
                                        
                                                    
                                                        <th>S. No.</th>
                                                        
                                                        <th>Office Name</th>
                                        
                                        
                                                        <th>Deleted by</th>
                                        
                                                        <th>Action</th>
                                        
                                                        
                                                    </tr>
                                        
                                                    </thead>
                                        
                                                    <tbody>
                                                        <?php if($get_trash_office_data) {
                                                            foreach ($get_trash_office_data as $key => $get_trash_office) { ?>
                                        
                                        
                                                                
                                        
                                                    <tr>              
                                        
                                                                    
                                                        <td>{{$key+1}} </td>

                                                        <td>{{$get_trash_office->name}} </td>
                                        
                                        
                                                        <td> {{$get_trash_office->deleted_by}}</td>   

                                                        <td> <div class="dropdown dropbtn">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                              Action
                                                            </button>
                                                            <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                              
                                                              <a class="dropdown-item" href="{{url('admin/office_trash_restore/'.base64_encode($get_trash_office->id))}}">Restore</a>
                                                              <a class="dropdown-item" href="{{url('admin/office_trash_delete/'.base64_encode($get_trash_office->id))}}" onclick="return confirm('Are you sure you want to permanently delete this office?');">Permanently Delete</a>
                                                            </div>
                                                          </div>
                                                            
                                                        </td>
                                                        
                                                    
                                        
                                                    </tr>
                                        
                                                    <?php   }}?>     
                                        
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


<!-- Modal -->





 

    



{{-- <script>
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
</script> --}}







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
  /*float: left;*/
  color: #fff;
  border-radius: 5px;
  margin-right: 10px;
  margin-left: 10px;
}

.top-search {
    width: inherit;
}


.table {
  width: 270%;
}

</style>

@endsection