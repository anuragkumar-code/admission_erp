@extends('staff.layout.head')

@section('staff')
<?php $college_id =  request()->id; ?>
    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>Courses</h1>

                            </div>

                        </div>

                    </div>

                    <div  class="col-lg-4">

                    <div class="addnewbtntop">
                        <?php if(Auth::user()->rights_college_add==1){ ?> 
                        <a href="{{ url('/staff/add_course_campus/'.$college_id) }}" class="btn btn-outline-primary addnewstaffbtn rightbtns"> + Add New Course</a>
                        <?php } ?>
                    </div>

                    </div>

                </div>

                <section id="main-content">                

                              
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

                    <div class="table-responsive studenttabless">                                                      

                        <table class="table table-striped table-bordered" id="bootstrap-data-table-export">

                            <thead class="thead-dark">

                            <tr>

                                <th style="text-align:center;">S. No.</th>
                                <th style="text-align:center;">Course Name</th>
                                <th style="text-align:center;">Course Duration</th>
                                <?php if(Auth::user()->rights_college_add==1){ ?>
                                <th style="text-align:center;">Action</th>
                            <?php } ?>
                                <!--<th scope="col">Tuition Fee</th>
                                <th scope="col">Course Fee</th>      -->                               
                                <!-- <th scope="col">Campus</th> -->

                                <?php if (Auth::user()->type==1){ ?>
                                <th scope="col"></th>
                                    <?php } ?>
                            </tr>

                            </thead> 

                            <tbody>
                                <?php //echo  "<pre>"; print_r($get_courses); exit; ?>
                                <?php if($get_courses){ 
                                    foreach ($get_courses as $key => $get_course) {
                                     //$course_id = base64_decode($get_course->course_id);
                                        ?>                                          
                                    <tr>
                                        <td style="text-align:center;">{{$key+1}}</td>
                                        <td style="text-align:center;">{{$get_course->course_name}}</td>
                                        <td style="text-align:center;">{{$get_course->course_duration}} </td>
                                        <?php /*<td>${{$get_course->tuition_fees}}</td>*/ ?>   
                                        <!-- <td> --><!-- $ --><?php // echo $get_course->admission_fees + $get_course->tuition_fees + $get_course->material_fees; ?><!-- </td> -->

                                        <?php /* <td>{{$get_course->campus_name}}</td> */ ?>
                                        
                                        <?php if(Auth::user()->rights_college_add==1){ ?>
                                        <td style="text-align:center;">  
                                            <div class="dropdown dropbtn">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Action
                                                </button>
                                                <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">

                                                  <a class="dropdown-item" href="{{url('/staff/edit_course_campus/'.base64_encode($get_course->id))}}">Edit Course</a>

                                                  <!-- <a class="dropdown-item" href="{{url('/staff/course-edit/'.base64_encode($get_course->id))}}">Edit Course</a> -->

                                                  <a class="dropdown-item" href="{{url('/staff/course-deleted/'.base64_encode($get_course->id))}}" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                                                </div>
                                              </div>
                                        </td>    
                                        <?php } ?>                                 

                                    </tr>

                                <?php }}?>                                         

                            </tbody>

                        </table>                                   

                    </div>

                </div>

            </div>

        </div>

                </section>

            </div>

        </div>      

    </div>



  <script>
     jQuery ('#course_form').validate({

        rules: {
            course_name: "required",
            course_duration: "required",
            admission_fees: {required: true, number:true},          
            tuition_fees :  {required: true, number:true},
            material_fees :  {required: true, number:true},
            campus: "required",

            } ,
     
        messages: {
            course_name:"Please Enter Course Name",
            course_duration:"Please Enter Course Duration",
            admission_fees:"Please Enter Admission Fees",
            tuition_fees:"Please Enter Tuition Fees",
            material_fees:"Please Enter Material Fees",
            campus:"Please Enter Campus",

        }     


    });
  </script>
 
 <style type="text/css">
    .coursemodal .form-group
     {
        margin-bottom: 0px !important;
     }

     .studenttabless th:nth-child(2)
     {
        width: 500px !important;
     }
     
 </style>

@endsection

