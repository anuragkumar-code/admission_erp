@extends('staff.layout.head')
@section('staff')


<?php $counter=1; ?>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Edit Courses and Campuses</h1>
                            </div>
                        </div>
                    </div>
                </div>
<?php //echo "<pre>"; print_r($get_courses); exit; ?>
                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form action="{{ route('/staff/edit_course_campus') }}" method="post" enctype="multipart/form-data" id="course_form">

                                    @csrf

                                    <div class="cloning_section">
                                    <div class="append_section">

                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label for="course_name">Course Name<span style='color: red'>*</span></label>
                                            <input type="text" class="form-control" id="course_name" placeholder="Enter Course Name" name="course_name" value="{{$get_courses->course_name}}" required>
                                            <p class="text-danger">@error('course_name'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="course_duration">Course Duration<span style='color: red'>*</span></label>
                                                <select class="form-control"  name="course_duration" id="course_duration" required>
                                                <option value="">Select Course Duration</option>
                                                    <option value="1 Week">1 Week</option>
                                                <?php for ($i=2; $i < 251; $i++) {  ?>
                                                
                                                    <option <?php if($get_courses->course_duration == $i.' Weeks'){?> selected <?php } ?> value="{{$i}} Weeks" >{{$i}} Weeks</option>
                                                <?php } ?>
                                                   
                                                </select>
                                            <p class="text-danger">@error('course_duration'){{ $message }}@enderror</p>
                                        </div>

                                         <?php
                                         if($edit_courses)
                                         {
                                            $counter = 1;
                                            foreach ($edit_courses as $key => $edit_courses_val)
                                            {
                                            ?>
                                            <span class="row campus_section{{$edit_courses_val->id}}">
                                            <div class="form-group col-md-6">
                                            <label for="admission_fees">Admission Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="admission_fees[<?php echo $key; ?>]" placeholder="Enter Admission Fee" name="admission_fees[<?php echo $key; ?>]" value="{{$edit_courses_val->admission_fees}}" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('admission_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="tuition_fees">Tuition Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="tuition_fees[<?php echo $key; ?>]" placeholder="Enter Tuition Fee" name="tuition_fees[<?php echo $key; ?>]" value="{{$edit_courses_val->tuition_fees}}" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('tuition_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="material_fees">Material Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="material_fees[<?php echo $key; ?>]" placeholder="Enter Material Fee" name="material_fees[<?php echo $key; ?>]" value="{{$edit_courses_val->material_fees}}" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('material_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="commission">Commission (in % applicable on tuition fees)</label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">                   
                                                    <input type="number" min="1" max="100" class="form-control" id="commission[<?php echo $key; ?>]" placeholder="Enter Commission" name="commission[<?php echo $key; ?>]" value="{{$edit_courses_val->commission}}" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('commission'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="bonus">Bonus (fixed amount)</label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="">$</span>
                                                    <input type="text" class="form-control" id="bonus[<?php echo $key; ?>]" placeholder="Enter Bonus" name="bonus[<?php echo $key; ?>]"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" value="{{$edit_courses_val->bonus}}" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('bonus'){{ $message }}@enderror</p>
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="campus">Campus<span style='color: red'>*</span></label>
                                            <input type="text" class="form-control" id="campus[<?php echo $key; ?>]" placeholder="Enter Campus" name="campus[<?php echo $key; ?>]" value="{{$edit_courses_val->campus_name}}" required>               
                                        </div>  

                                        <input type="hidden" value="{{$edit_courses_val->id}}" name="campus_id[<?php echo $key; ?>]">

                                         <div class="form-group col-md-12">
                                            <div class="message_shows{{$edit_courses_val->id}}"></div>
                                            <button type="button" class="btn btn-outline-info removecampus" data-campus_id="{{$edit_courses_val->id}}"><i class="fa fa-minus-circle" aria-hidden="true"></i> Remove
                                            </button>
                                        </div>
                                    </span>

                                            <?php
                                            }
                                            $counter++;
                                        }
                                         ?>   

                                        
                                    </div>
                                </div>
                            </div>
                                    <input type="hidden" value="{{$course_id}}" name="course_id">
                                    <input type="hidden" value="{{$get_courses->college_id}}" name="college_id">
                                    
                                    <div class="form-group col-md-12" style="margin:0px 0px 22px -15px">
                                        <button type="button" class="btn btn-outline-info addmorebtn clone2">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add More
                                        </button>
                                    </div>
                                    <button type="submit" class="btn btn-outline-info addnewbtns">Add Course</button>

                                </form>   
                            </div>
                        </div>
                    </div>                        
                </section> 
            </div>
        </div>            
    </div>  

 
 <style type="text/css">
    .coursemodal .form-group
     {
        margin-bottom: 0px !important;
     }
     
 </style>

 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet"> 


<script type="text/javascript">
    $(document).ready(function(){
        var j=<?php echo $counter; ?>;
    $(".clone2").click(function(){
        j++;
        $(".cloning_section").append('<div class="append_section"><div class="form-row"><div class="form-group col-md-6"><label for="admission_fees">Admission Fees<span style="color: red">*</span></label><div class="inputgroup"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend3">$</span><input type="text" class="form-control" id="admission_fees['+j+']" placeholder="Enter Admission Fee" name="admission_fees['+j+']" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required></div></div> </div><div class="form-group col-md-6"><label for="tuition_fees">Tuition Fees<span style="color: red">*</span></label><div class="inputgroup"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend3">$</span><input type="text" class="form-control" id="tuition_fees['+j+']" placeholder="Enter Tuition Fee" name="tuition_fees['+j+']" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required></div></div></div><div class="form-group col-md-6"><label for="material_fees">Material Fees<span style="color: red">*</span></label><div class="inputgroup"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend3">$</span><input type="text" class="form-control" id="material_fees['+j+']" placeholder="Enter Material Fee" name="material_fees['+j+']" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required></div></div></div><div class="form-group col-md-6"><label for="commission">Commission (in % applicable on tuition fees)</label><div class="inputgroup"><div class="input-group-prepend"><input type="number" min="1" max="100" class="form-control" id="commission['+j+']" placeholder="Enter Commission" name="commission['+j+']" required></div></div></div><div class="form-group col-md-6"><label for="bonus">Bonus (fixed amount)</label><div class="inputgroup"><div class="input-group-prepend"><span class="input-group-text" id="">$</span><input type="text" class="form-control" id="bonus['+j+']" placeholder="Enter Bonus" name="bonus['+j+']" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required></div></div></div><div class="form-group col-md-6"><label for="campus">Campus<span style="color: red">*</span></label><input type="text" class="form-control" id="campus['+j+']" placeholder="Enter Campus" name="campus['+j+']" required></div></div><input type="hidden" value="0" name="campus_id['+j+']"><div class="form-group col-md-2"><button type="button" class="btn btn-outline-info remove2"><i class="fa fa-minus-circle" aria-hidden="true"></i> Remove</button></div></div>');       
        
    });

    $(document).on('click','.remove2',function(){
        $(this).parent().parent().remove();
    });

    

});


$(document).ready(function(){
    $(document).on('click', '.removecampus', function(){        
        var campus_id = $(this).attr('data-campus_id');
        swal({
        title: "Are you sure?",
        text: "Once Remove, you will not be able to Decline!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes do it",
        closeOnConfirm: true,
    },
    function(){
        $.ajax({
            type:'POST',
            url:"{{ route('campus_remove') }}",
            data:{"_token": "{{ csrf_token() }}",campus_id:campus_id},
            success:function(data)
            {    
                if(data == 0)
                {
                    $('.message_shows'+campus_id).html('<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button> <strong>Campus remove successfully</strong></div>');
                    $('.campus_section'+campus_id).css('background','tomato');
                    $('.campus_section'+campus_id).fadeOut(800,function(){
                    $(this).remove();      
                    });        
                }
                else if(data == 1)
                {
                    $('.message_shows'+campus_id).html('<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button> <strong>This campus is not delete due to its already assigned to students. </strong></div>');
                }

            }

        });
         });

    });
});
    


</script>

@endsection