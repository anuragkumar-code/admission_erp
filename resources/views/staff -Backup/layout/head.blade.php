<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>RMS-Staff </title>

    

    <!-- Styles -->

    <link href="{{asset('staff/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{asset('staff/css/themify-icons.css')}}" rel="stylesheet">

    <link href="{{asset('staff/css/buttons.bootstrap.min.css')}}" rel="stylesheet" />

    <link href="{{asset('staff/css/sidebar.css')}}" rel="stylesheet">

    <link href="{{asset('staff/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('staff/css/helper.css')}}" rel="stylesheet">

    <link href="{{asset('staff/css/style.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{asset('staff/js/jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Font Awesome -->



</head>





<body>



        <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">

            <div class="nano">

                <div class="nano-content">

                    <div class="logo">
                        <img src="{{url('admin/images/logo.png')}}" alt="">
                    </div>
                    <div class="logoiconshow">
                        <img src="{{url('admin/images/mobileicon.png')}}" alt="">
                    </div>

                    <ul>                                              

                        <li><a href="{{route('staff_dashboard')}}"><i class="ti-home"></i><label class="mobhides"> Dashboard</label></a></li>

                        

                        <?php if (Auth::user()->student_management == 1){ ?>

                            <li><a href="{{route('staff_students')}}"><i class="fa fa-user-graduate"></i><label class="mobhides"> Students </label></a></li>

                            <?php } ?>

                        <?php if (Auth::user()->staff_management == 1){ ?>

                            <li><a href="{{route('staff_staff')}}"><i class="ti-user"></i><label class="mobhides"> Staff</label></a></li>

                            <?php } ?>

                        <?php if (Auth::user()->college_management == 1){ ?>

                            <li><a href="{{route('staff_colleges')}}"><i class="fa fa-university"></i><label class="mobhides"> College</label></a></li>

                            <?php } ?>   

                       

                        <li><a href="{{route('staff_change_password')}}"><i class="ti-key"></i><label class="mobhides"> Change Password</label></a></li>

                        <li><a href="{{route('staff_logout')}}"><i class="fa fa-close"></i><label class="mobhides"> Logout
                        </label></a></li>                        

                    </ul>

                </div>

            </div>

        </div>

        <!-- /# sidebar -->





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

                         <div class="mobileshow">
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

                                            {{-- <li>

                                                <a href="#">

                                                    <i class="ti-user"></i>

                                                    <span>Profile</span>

                                                </a>

                                            </li> --}}



                                            {{-- <li>

                                                <a href="#">

                                                    <i class="ti-email"></i>

                                                    <span>Inbox</span>

                                                </a>

                                            </li> --}}

                                            {{-- <li>

                                                <a href="#">

                                                    <i class="ti-settings"></i>

                                                    <span>Setting</span>

                                                </a>

                                            </li> --}}



                                            <li>

                                                <a href="{{route('staff_change_password')}}">

                                                    <i class="ti-key"></i>

                                                    <span>Change Password</span>

                                                </a>

                                            </li>

                                            <li>

                                                <a href="{{route('staff_logout')}}">

                                                    <i class="ti-power-off"></i>

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

                    <div class="col-md-9">
                        <form action="{{route('staff_search')}}" method="get" class="top-search">
                            <input type="text" class="form-control" name="name" value="{{ app('request')->input('name') }}" placeholder="Student Name">
                            <input type="text" class="form-control" name="dob" value="{{ app('request')->input('dob') }}" placeholder="Date of Birth">
                            <input type="text" class="form-control" name="phone" value="{{ app('request')->input('phone') }}" placeholder="Mobile No.">
                            <button type="submit" class="btn btn-outline-info searchbtnsinto"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>

                    <div class="col-md-2 mobilehides">
                        
                        <div id="topdrop" style="float: right">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                {{Auth::user()->first_name}}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="{{route('staff_change_password')}}"><i class="fa fa-key"></i> Change Password</a></li>
                                <li><a class="nav-link" href="{{route('staff_logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
                              
                            </ul>
                        </div>
                                            

                    </div>              

            </div>

            </div>

        </div>

    </div>





    @yield('staff')





    <script>

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


<script>
    jQuery('.topnavstrip .dropdown-toggle').on('click', function (e) {
    $(this).next().toggle();
  });
  jQuery(.drop-down').on('click', function (e) {
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



     <!-- jquery vendor -->

     

     <script src="{{asset('staff/js/jquery.nanoscroller.min.js')}}"></script>

     <!-- nano scroller -->

     <script src="{{asset('staff/js/sidebar.js')}}"></script>

     <script src="{{asset('staff/js/pace.min.js')}}"></script>

     <!-- sidebar -->

     

     <!-- bootstrap -->

 

     <script src="{{asset('staff/js/bootstrap.min.js')}}"></script>

     <script src="{{asset('staff/js/scripts.js')}}"></script>

     <!-- scripit init-->

     <script src="{{asset('staff/js/datatables.min.js')}}"></script>

     <script src="{{asset('staff/js/buttons.html5.min.js')}}"></script>

     <script src="{{asset('staff/js/datatables-init.js')}}"></script>


     {{-- <script>
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
      </script>  
       --}}
<!--        
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />  

<script>
$(function() {
  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('year'),
    // endDate: moment().startOf('year'),
    locale: {
      format: 'M/DD/YY'
    }
  });
});
</script>  
-->
 </body>

 

 </html>