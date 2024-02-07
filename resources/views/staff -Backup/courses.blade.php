@extends('staff.layout.head')

@section('staff')



<div class="content-wrap">

    <div class="main">

        <div class="container-fluid">

            <div class="row">

                <div class="headertopcontent">

                    <a href="{{url('/staff/add-course')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns">+ Add New Course</a>

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

                <div class="contentinner">              

                    <div class="bootstrap-data-table-panel">

                        <div class="table-responsive">                                                      

                            <table class="table table-striped table-bordered" id="bootstrap-data-table-export">

                                <thead class="thead-dark">

                                <tr>

                                    <th scope="col">S. No.</th>

                                    <th scope="col">Course Name</th>

                                    <th scope="col">Course Duration</th>

                                    <th scope="col">Intakes Date</th>

                                    <th scope="col">Course Fee</th>                                    

                                    <th scope="col">Time Table</th>

                                    <th scope="col">Action</th>

                                </tr>

                                </thead> 

                                <tbody>

                                    <?php if($get_staff_courses){ 

                                        foreach ($get_staff_courses as $key => $get_staff_course) {  ?>                                          

                                        <tr>

                                            <td>{{$key+1}}</td>

                                            <td>{{$get_staff_course->course_name}}</td>

                                            <td>{{$get_staff_course->course_duration}} Months</td>

                                            <td>{{$get_staff_course->intakes_date}}</td>

                                            <td>{{$get_staff_course->course_fee}}</td>                                           

                                            <td>{{$get_staff_course->time_table}}</td>

                                            <td>  

                                                <a href="{{ url('staff/course-edit/'.base64_encode($get_staff_course->id)) }}"><i class="fa fa-edit" style='color: rgb(29, 18, 235)'></i></a> 

                                                <a href="{{ url('staff/course-deleted/'.base64_encode($get_staff_course->id)) }}" onclick="return confirm('Are you sure you want to delete this course?');"><i class="fa-solid fa-trash-can" style='color: red'></i></a>

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







@endsection