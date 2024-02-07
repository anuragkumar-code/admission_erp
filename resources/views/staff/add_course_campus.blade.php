@extends('staff.layout.head')
@section('staff')


<?php $counter=0; ?>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Add Courses and Campuses</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form action="{{ route('/staff/college/course-added') }}" method="post" enctype="multipart/form-data" id="course_form">

                                    @csrf

                                    <div class="cloning_section">
                                    <div class="append_section">

                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label for="course_name">Course Name<span style='color: red'>*</span></label>
                                            <input type="text" class="form-control" id="course_name" placeholder="Enter Course Name" name="course_name" required>
                                            <p class="text-danger">@error('course_name'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="course_duration">Course Duration<span style='color: red'>*</span></label>
                                                <select class="form-control"  name="course_duration" id="course_duration" required>
                                                <option value="">Select Course Duration</option>
                                                    <option value="1 Week">1 Week</option>
                                                <?php for ($i=2; $i < 251; $i++) {  ?>
                                                
                                                    <option value="{{$i}} Weeks" >{{$i}} Weeks</option>
                                                <?php } ?>
                                                   
                                                </select>
                                            <p class="text-danger">@error('course_duration'){{ $message }}@enderror</p>
                                        </div>

                                        
                                        <div class="form-group col-md-6">
                                            <label for="admission_fees">Admission Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="admission_fees" placeholder="Enter Admission Fee" name="admission_fees[0]"   pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('admission_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="tuition_fees">Tuition Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="tuition_fees" placeholder="Enter Tuition Fee" name="tuition_fees[0]"   pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('tuition_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="material_fees">Material Fees<span style='color: red'>*</span></label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                    <input type="text" class="form-control" id="material_fees" placeholder="Enter Material Fee" name="material_fees[0]"   pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('material_fees'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="commission">Commission (in % applicable on tuition fees)</label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">                   
                                                    <input type="number" min="1" max="100" class="form-control" id="commission" placeholder="Enter Commission" name="commission[0]" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('commission'){{ $message }}@enderror</p>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="bonus">Bonus (fixed amount)</label>
                                            <div class="inputgroup">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="">$</span>
                                                    <input type="text" class="form-control" id="bonus" placeholder="Enter Bonus" name="bonus[0]" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required>
                                                </div>                                                
                                            </div>    
                                            <p class="text-danger">@error('bonus'){{ $message }}@enderror</p>
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="campus">Campus<span style='color: red'>*</span></label>
                                            <input type="text" class="form-control" id="campus" placeholder="Enter Campus" name="campus[0]" required>               
                                        </div>                                      
                                        
                                    </div>
                                </div>
                            </div>
                                    <input type="hidden" value="{{$college_id}}" name="college_id">



                                    <div class="form-group col-md-12">
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


<script>
    /* jQuery('#course_form').validate({

        rules: {
            course_name: "required",
            course_duration: "required",
            admission_fees: {required: true, number:true},          
            tuition_fees:  {required: true, number:true},
            material_fees:  {required: true, number:true},
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


    });*/
  </script>
 
 <style type="text/css">
    .coursemodal .form-group
     {
        margin-bottom: 0px !important;
     }
     
 </style>

<script type="text/javascript">
    $(document).ready(function(){
        var j=<?php echo $counter; ?>;
    $(".clone2").click(function(){
        j++;
        $(".cloning_section").append('<div class="append_section"><div class="form-row"><div class="form-group col-md-6"><label for="admission_fees">Admission Fees<span style="color: red">*</span></label><div class="inputgroup"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend3">$</span><input type="text" class="form-control" id="admission_fees['+j+']" placeholder="Enter Admission Fee" name="admission_fees['+j+']" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required></div></div> </div><div class="form-group col-md-6"><label for="tuition_fees">Tuition Fees<span style="color: red">*</span></label><div class="inputgroup"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend3">$</span><input type="text" class="form-control" id="tuition_fees['+j+']" placeholder="Enter Tuition Fee" name="tuition_fees['+j+']" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required></div></div></div><div class="form-group col-md-6"><label for="material_fees">Material Fees<span style="color: red">*</span></label><div class="inputgroup"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend3">$</span><input type="text" class="form-control" id="material_fees['+j+']" placeholder="Enter Material Fee" name="material_fees['+j+']" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required></div></div></div><div class="form-group col-md-6"><label for="commission">Commission (in % applicable on tuition fees)</label><div class="inputgroup"><div class="input-group-prepend"><input type="number" min="1" max="100" class="form-control" id="commission['+j+']" placeholder="Enter Commission" name="commission['+j+']" required></div></div></div><div class="form-group col-md-6"><label for="bonus">Bonus (fixed amount)</label><div class="inputgroup"><div class="input-group-prepend"><span class="input-group-text" id="">$</span><input type="text" class="form-control" id="bonus['+j+']" placeholder="Enter Bonus" name="bonus['+j+']" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" required></div></div></div><div class="form-group col-md-6"><label for="campus">Campus<span style="color: red">*</span></label><input type="text" class="form-control" id="campus['+j+']" placeholder="Enter Campus" name="campus['+j+']" required></div></div><div class="form-group col-md-2"><button type="button" class="btn btn-outline-info remove2"><i class="fa fa-minus-circle" aria-hidden="true"></i> Remove</button></div></div>');       
        
    });

    $(document).on('click','.remove2',function(){
        $(this).parent().parent().remove();
    });

    

});


</script>

@endsection
