@extends('staff.layout.head')

@section('staff')

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
                            
                        <?php if (Auth::user()->course_management == 1){ ?>

                            <div class="addnewbtntop">
                            <a href="#" class="btn btn-outline-primary addnewstaffbtn rightbtns" data-toggle="modal" data-target="#myModal"> + Add New Course</a>
                        </div>

                                    <?php } ?>
                        
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

                            <div class="table-responsive addcoructable">                                                      

                                <table class="table table-striped table-bordered" id="bootstrap-data-table-export">

                                    <thead class="thead-dark">

                                    <tr>

                                        <th scope="col">S. No.</th>
                                        <th scope="col">Course Name</th>
                                        <th scope="col">Course Duration</th>
                                        <th scope="col">Tuition Fee</th>
                                        <th scope="col">Course Fee</th>                                    
                                        <th scope="col">Campus</th>
                                        <?php if (Auth::user()->course_management == 1){ ?>
                                        <th scope="col"></th> 
                                          <?php } ?>
                                     

                                    </tr>

                                    </thead> 

                                    <tbody>

                                        <?php if($get_courses){ 
                                            foreach ($get_courses as $key => $get_course) {  ?>                                          
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$get_course->course_name}}</td>
                                                <td>{{$get_course->course_duration}}</td>
                                                <td>${{$get_course->tuition_fees}}</td>
                                                <td>${{$get_course->course_fee}}</td>                                           
                                                <td>{{$get_course->campus}}</td>
                                                <?php if (Auth::user()->course_management == 1){ ?>
                                                <td>  
                                                    <div class="dropdown dropbtn">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                          Action
                                                        </button>
                                                        <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                          <a class="dropdown-item" href="{{url('staff/course-edit/'.base64_encode($get_course->id))}}">Edit Course</a>
                                                          <a class="dropdown-item" href="{{url('staff/course-deleted/'.base64_encode($get_course->id))}}" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                                                        </div>
                                                      </div>
                                               
                                                    {{-- <a href="{{ url('staff/course-edit/'.base64_encode($get_course->id)) }}"><i class="fa fa-edit" style='color: rgb(29, 18, 235)'></i></a> 

                                                    <a href="{{ url('staff/course-deleted/'.base64_encode($get_course->id)) }}" onclick="return confirm('Are you sure you want to delete this course?');"><i class="fa-solid fa-trash-can" style='color: red'></i></a>
  --}}

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
    


    <div class="modal" id="myModal" style="padding-right: 0px!important;">
      <div class="modal-dialog midbox">
        <div class="modal-content popinfo">
            <button type="button" class="close closebtns" data-dismiss="modal">&times;</button>
              <div class="modal-body">
                <div class="popupbg">
                   <div class="row">
                      <div class="col-lg-12">                           
                         <form action="{{ route('staff_add_courses') }}" method="post" enctype="multipart/form-data" id="staff_course_form">
                             @csrf
                                 <div class="form-row">
                                   <div class="form-group col-md-6">
                                      <label for="course_name">Course Name<span style='color: red'>*</span></label>
                                          <input type="text" class="form-control" id="course_name" placeholder="Enter Course Name" name="course_name">
                                            <p class="text-danger">@error('course_name'){{ $message }}@enderror</p>
                                    </div>

                                       <div class="form-group col-md-6">
                                            <label for="course_duration">Course Duration<span style='color: red'>*</span></label>
                                                <select class="form-control"  name="course_duration" id="course_duration">
                                                    <option value="">Select Course Duration</option>
                                                    <option value="1 Week">1 Week</option>

                                                   <?php for ($i=2; $i <161; $i++){?>
                                                    <option value ={{$i}}Weeks>{{$i}}Weeks </option>
                                                 <?php  } ?>
                                                </select>
                                            <p class="text-danger">@error('course_duration'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="admission_fees">Admission Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="admission_fees" placeholder="Enter Admission Fee" name="admission_fees">
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('admission_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="tuition_fees">Tuition Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="tuition_fees" placeholder="Enter Tuition Fee" name="tuition_fees">
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('tuition_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="material_fees">Material Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="material_fees" placeholder="Enter Material Fee" name="material_fees">
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('material_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="campus">Campus<span style='color: red'>*</span></label>
                                            <input type="text" class="form-control" id="campus" placeholder="Enter Campus" name="campus">
                                            <p class="text-danger">@error('campus'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="campus_two">Campus 2</label>
                                            <input type="text" class="form-control" id="campus_two" placeholder="Enter Campus " name="campus_two">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="campus_three">Campus 3</label>
                                            <input type="text" class="form-control" id="campus_three" placeholder="Enter Campus " name="campus_three">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="campus_four">Campus 4</label>
                                            <input type="text" class="form-control" id="campus_four" placeholder="Enter Campus " name="campus_four">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="campus_five">Campus 5</label>
                                            <input type="text" class="form-control" id="campus_five" placeholder="Enter Campus " name="campus_five">
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    <input type="hidden" value="{{$college_id}}" name="college_id">

                                    
                                        <button type="submit" class="btn btn-outline-info addnewbtns">Add Course</button>



                                </form>                            

                        </div>

                    </div>

          </div>
        </div>        
      </div>
    </div>


   
  </div>


  <script>
     jQuery('#staff_course_form').validate({

        rules:{
            course_name: "required",
            course_duration: "required",
            admission_fees: {required: true, digits:true},
            tuition_fees :  {required: true, digits:true},
            material_fees :  {required: true, digits:true},
            campus: "required",
            } ,
     
        messages:{
            course_name:"Please Enter Course Name",
            course_duration:"Please Enter Course Duration",
            admission_fees:"Please Enter Admission Fees",
            tuition_fees:"Please Enter Tuition Fees",
            material_fees:"Please Enter Material Fees",
            campus:"Please Enter Campus",


        }     


    });
  </script>
 

@endsection
