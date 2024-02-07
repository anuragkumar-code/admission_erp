<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (Auth::user()->id==1) {?>
    <title>RMS - Super Admin</title> 
    <?php } else { ?> 
    <title>RMS -  Admin</title> 
    <?php } ?>
    <!-- Styles -->
    <link href="{{asset('admin/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/buttons.bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/css/sidebar.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/helper.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{asset('admin/js/jquery.min.js')}}"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script> 
   <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet"> 

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

</head>
<body>
    <!-- /# sidebar -->

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <div class="logo">
                    <img src="{{url('admin/images/logo.png')}}" alt="" class="mobilehides">                    
                </div>
                    <div class="logoiconshow">
                        <img src="{{url('admin/images/mobileicon.png')}}" alt="">
                    </div>                    
                    <ul>                        
                        <li><a href="{{route('admin_dashboard')}}"><i class="fa fa-home"></i><label class="mobhides">Dashboard</label></a></li>


                        <li class="sidemenu dropdown">
                            <a href="#" data-toggle="dropdown" style="color: #535768; margin-left: 3px;" aria-expanded="true">
                                <i class="fa fa-money" aria-hidden="true"></i><span style="margin-left: -6px;"> Admin Only </span><i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <div class="sidemenu dropdown-menu">                                
                                
                                <a href="{{route('commission_claimed')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Commission Claim</label></a>

                                <a href="{{route('bonus_claimed')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Bonus Claim</label></a>
                                
                                <a href="{{route('commission_generate_report')}}"><i class="fa fa-line-chart" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Commission Reports</label></a>

                                <?php if (Auth::user()->type ==1) { ?>
                                  <a href="{{route('offices')}}"><i class="fa fa-building-o"></i><label class="mobhides"> Offices <strong>({{$get_offices_count}})</strong></label></a>
                                <?php } ?>

                                <a href="{{route('staff')}}"><i class="fa fa-user"></i><label class="mobhides"> Staff <strong> ({{$get_staffs_count}})</strong></label></a>

                                                               
                               <!--  <a href="{{route('/admin/event_list')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Event List</label></a> -->

                                <a href="{{route('/admin/other_services/service_list')}}"><i class="fa fa-life-ring" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Services List</label></a>


                                <a href="{{route('/admin/miscellaneous_income/index')}}"><i class="fa fa-money" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Miscellaneous Income</label></a>

                                <a href="{{route('/admin/miscellaneous_income/miscellaneous_income_report')}}"><i class="fa fa-money" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Miscellaneous Report</label></a>

                                <a href="{{route('event_calendar')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Event Calendar</label></a>
                                

                                <a href="{{route('generate_report')}}"><i class="fa fa-line-chart" aria-hidden="true"></i><label class="mobhides"> Reports</label></a>

                                <a href="{{route('change_password')}}"><i class="fa fa-key"></i><label class="mobhides"> Change Password</a></label>

                            </div>
                        </li>


                        <li><a href="{{route('students')}}"><i class="fa fa-user-graduate"></i><label class="mobhides">Students <strong>({{$get_students_count}})</strong></label><?php if($student_count > 0){ ?><span style="font-size:50px">.</span><?php } ?></a></li>

                        
                        <li><a href="{{route('admin_tasks')}}"><i class="fa fa-tasks"></i><label class="mobhides">Tasks</label><?php if($task_count > 0){ ?><span style="font-size:50px">.</span><?php } ?></a></li>
                        
                         <li><a href="{{route('migrate_students')}}"><i class="fa fa-user"></i><label class="mobhides"> Migration <strong> ({{$migration_student_count}})</strong></label></a></li>

                         <li><a href="{{route('extra_students')}}"><i class="fa fa-user"></i><label class="mobhides"> Extra <strong> ({{$extra_student_count}})</strong></label></a></li>

                        <!-- <li><a href="{{route('staff')}}"><i class="fa fa-user"></i><label class="mobhides"> Staff <strong> ({{$get_staffs_count}})</strong></label></a></li> -->

                        <li><a href="{{route('colleges')}}"><i class="fa fa-university"></i><label class="mobhides"> Colleges  <strong>({{$get_colleges_count}})</strong></label></a></li>

                       
                        
                        <!-- <li><a href="{{route('generate_report')}}"><i class="fa fa-line-chart" aria-hidden="true"></i><label class="mobhides"> Reports</label></a></li> -->

                       <!--  <li class="sidemenu dropdown">
                            <a href="#" data-toggle="dropdown" style="color: #535768; margin-left: 3px;" aria-expanded="true">
                                <i class="fa fa-money" aria-hidden="true"></i><span style="margin-left: -6px;"> Commission/Bonus </span><i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <div class="sidemenu dropdown-menu">                                
                                <a href="{{route('commission_claimed')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Commission Claim</label></a>
                                <a href="{{route('bonus_claimed')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Bonus Claim</label></a>
                                <a href="{{route('commission_generate_report')}}"><i class="fa fa-line-chart" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Reports</label></a>
                            </div>
                        </li> -->


                        <li class="sidemenu dropdown">
                            <a href="#" data-toggle="dropdown" style="color: #535768; margin-left: 3px;" aria-expanded="true">
                                <i class="fa fa-money" aria-hidden="true"></i><span style="margin-left: -6px;"> Follow up </span><i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <div class="sidemenu dropdown-menu">                                
                                <a href="{{route('visa_expire')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Visa Expire</label></a>

                                <a href="{{route('passport_expire')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Passport Expire</label></a>

                                <a href="{{route('fees_due')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Fees Due</label></a>

                                <a href="{{route('course_completion')}}"><i class="fa fa-dollar" aria-hidden="true"></i><label class="mobhides" style="cursor:pointer;">Course Completion</label></a>
                               
                            </div>
                        </li>

                         <li><a href="{{route('filtered_students')}}"><i class="fa fa-users" aria-hidden="true"></i><label class="mobhides"> Filtered Students</label></a></li>


                         <li><a href="{{route('referal_list')}}"><i class="fa fa-bullhorn" aria-hidden="true"></i><label class="mobhides"> Referral</label></a></li>
                        
                          
                        <?php if (Auth::user()->id ==1) { ?>
                         
                        <!-- <li><a href="{{route('trashlogin')}}"><i class="fa-solid fa-trash-can"></i></i><label class="mobhides"> Trash <strong>({{$get_trash_student_count+$get_trash_staff_count+$get_trash_offices_count+$get_trash_colleges_count+$get_trash_courses_count}})</strong></label></a><div id="topdrop" style="float: right"> -->
                            <?php }?>
                            {{-- <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{route('change_password')}}"><i class="fa fa-key"></i> Change Password</a></li>
                                                             
                            </ul>
                        </div> --}}
                    </li> 
                        

                       <!--  <li><a href="{{route('change_password')}}"><i class="fa fa-key"></i><label class="mobhides"> Change Password</a></label></li> -->
                        <li><a href="{{route('adminLogout')}}"><i class="fa fa-power-off"></i><label class="mobhides"> Logout</label></a></li>                                            
                    </ul>
                </div>
            </div>
        </div>
    </div> 

    <!-- /# sidebar -->

<div class="header only_header">      
    <div class="container-fluid">
        <div class="topnavstrip">
            <div class="row">                         
                <div class="col-md-1">
                    <div class="hamburger sidebar-toggle">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>

                    <div class="mobileshow">
                        {{-- <div class="dropdown dib">

                            <div class="header-icon" data-toggle="dropdown">

                                <i class="ti-bell"></i>

                                <div class="drop-down dropdown-menu dropdown-menu-right">

                                    <div class="dropdown-content-heading">

                                        <span class="text-left">Recent Notifications</span>

                                    </div>

                                    <div class="dropdown-content-body">

                                        <ul>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mr. John</div>

                                                        <div class="notification-text">5 members joined today </div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mariam</div>

                                                        <div class="notification-text">likes a photo of you</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Tasnim</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mr. John</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li class="text-center">

                                                <a href="#" class="more-link">See All</a>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div> --}}

                        {{-- <div class="dropdown dib">

                            <div class="header-icon" data-toggle="dropdown">

                                <i class="ti-email"></i>

                                <div class="drop-down dropdown-menu dropdown-menu-right">

                                    <div class="dropdown-content-heading">

                                        <span class="text-left">2 New Messages</span>

                                        <a href="email.html">

                                            <i class="ti-pencil-alt pull-right"></i>

                                        </a>

                                    </div>

                                    <div class="dropdown-content-body">

                                        <ul>

                                            <li class="notification-unread">

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/1.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Michael Qin</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li class="notification-unread">

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/2.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mr. John</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Michael Qin</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/2.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mr. John</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li class="text-center">

                                                <a href="#" class="more-link">See All</a>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div> --}}

                        <div id="topdrop">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                {{Auth::user()->first_name}}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{route('change_password')}}">Change Password</a></li>
                                <li><a class="nav-link" href="{{route('adminLogout')}}">Logout</a></li>
                              
                            </ul>
                        </div>

                       
                    </div>


                </div>
                <div class="col-md-9">
                    <form action="{{url('/admin/search')}}" method="get" class="top-search">
                        <input type="text" class="form-control" name="name" value="{{ app('request')->input('name') }}" placeholder="Student Name">
                        <input type="text" id="startdate" class="form-control" name="dob" value="{{ app('request')->input('dob') }}"  placeholder="dd/mm/yyyy">
                        <input type="text" class="form-control" name="phone" value="{{ app('request')->input('phone') }}" placeholder="Mobile No.">
                        <button type="submit" class="btn btn-outline-info searchbtnsinto"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>

                    <div class="col-md-2 mobilehides">
                        {{-- <div class="dropdown dib">

                            <div class="header-icon" data-toggle="dropdown">

                                <i class="ti-bell"></i>

                                <div class="drop-down dropdown-menu dropdown-menu-right">

                                    <div class="dropdown-content-heading">

                                        <span class="text-left">Recent Notifications</span>

                                    </div>

                                    <div class="dropdown-content-body">

                                        <ul>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mr. John</div>

                                                        <div class="notification-text">5 members joined today </div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mariam</div>

                                                        <div class="notification-text">likes a photo of you</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Tasnim</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mr. John</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li class="text-center">

                                                <a href="#" class="more-link">See All</a>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div> --}}

                        {{-- <div class="dropdown dib">

                            <div class="header-icon" data-toggle="dropdown">

                                <i class="ti-email"></i>

                                <div class="drop-down dropdown-menu dropdown-menu-right">

                                    <div class="dropdown-content-heading">

                                        <span class="text-left">2 New Messages</span>

                                        <a href="email.html">

                                            <i class="ti-pencil-alt pull-right"></i>

                                        </a>

                                    </div>

                                    <div class="dropdown-content-body">

                                        <ul>

                                            <li class="notification-unread">

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/1.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Michael Qin</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li class="notification-unread">

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/2.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mr. John</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/3.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Michael Qin</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">

                                                    <img class="pull-left m-r-10 avatar-img" src="images/avatar/2.jpg" alt="" />

                                                    <div class="notification-content">

                                                        <small class="notification-timestamp pull-right">02:34 PM</small>

                                                        <div class="notification-heading">Mr. John</div>

                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>

                                                    </div>

                                                </a>

                                            </li>

                                            <li class="text-center">

                                                <a href="#" class="more-link">See All</a>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div> --}}

                        <div id="topdrop" style="float: right">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                {{Auth::user()->first_name}}
                            </a>
                            <ul class="dropdown-menu">
                                <?php if(Auth::user()->id==1) { ?>
                                <li><a class="nav-link" href="{{route('trash_change_password')}}"><i class="fa fa-key"></i> Change Trash Pin</a></li>
                                <?php } ?>
                                
                                <li><a class="nav-link" href="{{route('change_password')}}"><i class="fa fa-key"></i> Change Password</a></li>
                                
                                <li><a class="nav-link" href="{{route('adminLogout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
                              
                            </ul>
                        </div>

                        {{-- <div class="dropdown dib" style="float: right">

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

                        </div> --}}

                    </div>              

            </div>

        </div>       

    </div>

</div>

@yield('admin')

    <!-- jquery vendor -->

    <script src="{{asset('admin/js/jquery.nanoscroller.min.js')}}"></script>
    <!-- nano scroller -->
    <script src="{{asset('admin/js/sidebar.js')}}"></script>
    <script src="{{asset('admin/js/pace.min.js')}}"></script>

    <!-- sidebar -->
    <!-- bootstrap -->
    <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/js/scripts.js')}}"></script>
    <!-- scripit init-->
    <!-- <script src="{{asset('admin/js/datatables.min.js')}}"></script> -->
    <script src="{{asset('admin/js/buttons.html5.min.js')}}"></script>
    <!-- <script src="{{asset('admin/js/datatables-init.js')}}"></script> -->

    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />  
  -->
<link rel="stylesheet" href="{{ asset('admin/css/datepicker.css') }}">
  <script src="{{ asset('admin/js/bootstrap-datepicker.min.js') }}"></script>

   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script type="text/javascript">
    
   /* $("#startdate").datepicker({

           todayBtn:  1,
           startDate: new Date(),
           autoclose: true,
           format: 'dd/mm/yyyy',
           orientation: 'top',

        }).on('changeDate', function (selected) {

            var minDate = new Date(selected.date.valueOf());

            $('#enddate').datepicker('setStartDate', minDate);

        });*/

 $('#startdate1').datepicker({
            todayBtn:  1,
           startDate: new Date(),
       autoclose: true,
  }).on("changeDate", function (e) {
       $('#enddate').datepicker('setStartDate', e.date);
  });

  $('#enddate').datepicker({
      autoclose: true,
  });


  $(function () {

  $("#datepicker").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        startDate: '+1d',
  });

  $(".date_picker").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        startDate: 'd',
  });


  $(".intake_date").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        startDate: '01/01/1996',
  });

  });

$(document).ready(function() {
    $('#bootstrap-data-table-export').DataTable({
        "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
        "iDisplayLength": 25
    });
   
  
});

        /*$("#enddate").datepicker({ 
            startDate: new Date(),
            autoclose: true,
           format: 'yyyy-mm-dd',
           orientation: 'top'
        })

        .on('changeDate', function (selected) {

            var minDate = new Date(selected.date.valueOf());

            $('#startdate').datepicker('setEndDate', minDate);

        });*/




        $(function() {
    
        var start = moment().subtract(29, 'days');
        var end = moment();
    
        function cb(start, end) {
            $('#start_date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

                var startOlddate = start.format('DD-MM-YYYY');
                var endOlddate = end.format('DD-MM-YYYY');

                var oldYearStartDate = moment(startOlddate, "DD-MM-YYYY").subtract(1, 'years').format('YYYY-MM-DD');
            var oldYearEndDate = moment(endOlddate, "DD-MM-YYYY").subtract(1, 'years').format('YYYY-MM-DD');


            $('.from_date').val(start.format('YYYY-MM-D'));
            $('.to_date').val(end.format('YYYY-MM-D'));
            $('.from_date_last').val(oldYearStartDate);
            $('.to_date_last').val(oldYearEndDate);
        }
    
        $('#start_date').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Week': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
               'Last week': [moment().subtract(1, 'week').startOf('isoWeek'), moment().subtract(1, 'week').endOf('isoWeek')],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
    
        cb(start, end);
    
    });

</script>
  <script>
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

    <script type="text/javascript">
        function hide() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        } 
    </script>

    <script type="text/javascript">
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

    <script>
        $('#topdrop').on('hide.bs.dropdown', function (e) {
            if (e.clickEvent) {
            e.preventDefault();
            }
        });
    </script> 

    {{-- <script type="text/javascript">
        jQuery('.dropdown-toggle').on('click', function (e) {
            $(this).next().toggle();
            });
            jQuery('.drop-down').on('click', function (e) {
            e.stopPropagation();
        });

        if(1) {
            $('body').attr('tabindex', '0');
        }
        else {
            alertify.confirm().set({'reverseButtons': true});
            alertify.prompt().set({'reverseButtons': true});
        }
    </script> --}}
    
    <script>
        jQuery('.topnavstrip .dropdown-toggle').on('click', function (e) {
        $(this).next().toggle();
      });
      jQuery('.drop-down').on('click', function (e) {
        e.stopPropagation();
      });
      
      if(1) {
        $('body').attr('tabindex', '0');
      }
      else {
        alertify.confirm().set({'reverseButtons': true});
        alertify.prompt().set({'reverseButtons': true});
      }
      </script>





<!--
    <script type="text/javascript">
        $(function() {
            $('input[name="datetimes"]').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('year'),
                endDate: moment().startOf('year'),
                locale: {
                format: 'M/DD/YY'
                }
            });
        });
    </script>

-->

<!-- <script>
     jQuery ('#course_form').validate({

        rules: {
            course_name: "required",
            course_duration: "required",
            datetimes: "required",
            course_fee: {required: true, digits:true},
            bonus :  {decimal: true},
            time_table: "required",

            } ,
     
        messages: {
            course_name:"Please Enter Course Name",
            course_duration:"Please Enter Course Duration",
            datetimes:"Please Enter Intakes Date",
            course_fee:"Please Enter Course Fees",
            time_table:"Please Select Time Table",
            bonus:"Please Enter Bonus in numbers only.",


        }     


    });
  </script> -->

  <style type="text/css">
      
      .sidemenu.dropdown-menu.show {
    display: block;
    transform: inherit!important;
    position: relative!important;
    padding: 15px;
}

.sidemenu.dropdown{
    background: none!important;
}
.sidemenu.dropdown-menu a{
    display: block;
}
.sidemenu.dropdown-menu{
    border: none;
    top: -10px!important;
    left: 20px!important;
    transform: inherit!important;
    position: relative!important;
}
.sidemenu.dropdown a{
  background: none!important;
}
</style>

</body>
</html>