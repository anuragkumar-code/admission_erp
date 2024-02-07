@extends('staff.layout.head')
@section('staff')


<div class="content-wrap">
    <div class="main">            
        <div class="container-fluid">                
            <div class="dashinfostrip">
                <div class="dashrow">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="dashbox">
                            <a href="{{route('staff_students')}}">
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
                                <?php if (Auth::user()->staff_management == 1){?>
                                <a href="{{route('staff_staff')}}">
                                <div class="dashicon">
                                    <img src="{{url('admin/images/dashicon02.png')}}" alt=""/>
                                </div>
                                <div class="dashtxt">
                                    <h6>{{$staff_count}}</h6>
                                    <p class="dashcolor">Staff</p>
                                </div>
                                </a>
                            <?php } else { ?>
                                <div class="dashicon">
                                <img src="{{url('admin/images/dashicon02.png')}}" alt=""/>
                            </div>
                            <div class="dashtxt">
                                <h6>{{$staff_count}}</h6>
                                <p class="dashcolor">Staff</p>
                            </div>
                         <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="dashbox">
                                <?php if (Auth::user()->college_management == 1){?>
                                    <a href="{{route('staff_colleges')}}">
                                <div class="dashicon">
                                    <img src="{{url('admin/images/dashicon03.png')}}" alt=""/>
                                </div>
                                <div class="dashtxt">
                                    <h6>{{$college_count}}</h6>
                                    <p class="dashcolor02">Colleges</p>
                                </div>
                                    </a>
                                    <?php } else { ?>
                                        <div class="dashicon">
                                    <img src="{{url('admin/images/dashicon03.png')}}" alt=""/>
                                </div>
                                <div class="dashtxt">
                                    <h6>{{$college_count}}</h6>
                                    <p class="dashcolor02">Colleges</p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Notification</h1>
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
                                    <?php if($staff_students){
                                        foreach($staff_students as $key => $staff_student){ ?>
                                    <li><a href="#"><span>{{$staff_student->first_name}}</span> was added By {{$staff_student->staff_name}} on {{$staff_student->created_at}}</a></li>
                                    {{-- <li><a href="#"><span>{{$staff_student->first_name}}</span> DDS your passport / visa will expire on 24/8/2022</a></li>
                                    <li><a href="#"><span>{{$staff_student->first_name}}</span> your passport / visa will expire on 24/8/2022</a></li>
                                    <li><a href="#"><span>{{$staff_student->first_name}}</span> your passport / visa will expire on 24/8/2022</a></li>
                                    <li><a href="#"><span>{{$staff_student->first_name}}</span> your passport / visa will expire on 24/8/2022</a></li> --}}
                                  <?php }} ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>    
        </div>              
    </div>
</div>



@endsection