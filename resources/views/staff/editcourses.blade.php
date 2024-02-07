@extends('staff.layout.head')
@section('staff')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Edit Course details</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{url('/staff/course-updated/'.$edit_courses->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="course_name">Course Name<span style='color: red'>*</span></label>
                                        <input type="text" class="form-control" value="{{$edit_courses->course_name}}" id="course_name" name="course_name" placeholder="Enter Course Name">
                                        <p class="text-danger">@error('course_name'){{ $message }}@enderror</p>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="course_duration">Course Duration<span style='color: red'>*</span></label>
                                            <select class="form-control" name="course_duration" id="course_duration">
                                                
                                            <option value="1 Week" <?php if($edit_courses->course_duration == '1 Week'){echo "selected";} ?>>1 Week</option>
                                                <?php for ($i=2; $i < 161 ; $i++) {  ?>
                                                
                                                    <option value="{{$i}} Weeks" @if($edit_courses->course_duration==$i) selected @endif >{{$i}}Weeks</option>
                                                <?php } ?>


                                            </select>
                                         <p class="text-danger">@error('course_duration'){{ $message }}@enderror</p>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="admission_fees">Admission Fees<span style='color: red'>*</span></label>
                                        <div class="inputgroup">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                <input type="text" class="form-control" id="admission_fees" value="<?php echo rtrim($edit_courses->admission_fees,'$'); ?>" placeholder="Enter Tuition Fee" name="admission_fees">
                                            </div>                                                
                                        </div>
                                        <p class="text-danger">@error('admission_fees'){{ $message }}@enderror</p>
                                    </div>     

                                    <div class="form-group col-md-4">
                                        <label for="tuition_fees">Tuition Fees<span style='color: red'>*</span></label>
                                        <div class="inputgroup">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                <input type="text" class="form-control" id="tuition_fees" value="<?php echo rtrim($edit_courses->tuition_fees,'$'); ?>" placeholder="Enter Tuition Fee" name="tuition_fees">
                                            </div>                                                
                                        </div>
                                        <p class="text-danger">@error('tuition_fees'){{ $message }}@enderror</p>
                                    </div>   
                                      
                                    <div class="form-group col-md-4">
                                        <label for="material_fees">Material Fees<span style='color: red'>*</span></label>
                                        <div class="inputgroup">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                                <input type="text" class="form-control" id="material_fees" value="<?php echo rtrim($edit_courses->material_fees,'$'); ?>" placeholder="Enter Tuition Fee" name="material_fees">
                                            </div>                                                
                                        </div>
                                        <p class="text-danger">@error('material_fees'){{ $message }}@enderror</p>
                                    </div>    


                                    <div class="form-group col-md-4">
                                        <label for="commission">Commission (in % applicable on tuition fees)</label>
                                        <input type="number" min="1" max="100" class="form-control" value="{{$edit_courses->commission}}" id="commission" placeholder="Enter commission" name="commission">
                                        <p class="text-danger">@error('commission'){{ $message }}@enderror</p>
                                    </div>



                                    <div class="form-group col-md-4">
                                        <label for="bonus">Bonus</label>
                                        <input type="text" class="form-control" value="{{$edit_courses->bonus}}" id="bonus" placeholder="Enter bonus" name="bonus"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01">
                                        <p class="text-danger">@error('bonus'){{ $message }}@enderror</p>
                                    </div>




                                    <div class="form-group col-md-4">
                                        <label for="campus">Campus<span style='color: red'>*</span></label>
                                        <input type="text" class="form-control" value="{{$edit_courses->campus}}" id="campus" placeholder="Enter Campus" name="campus">
                                        <p class="text-danger">@error('campus'){{ $message }}@enderror</p>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="campus_two">Campus 2</label>
                                        <input type="text" class="form-control" value="{{$edit_courses->campus_two}}" id="campus_two" placeholder="Enter Campus" name="campus_two">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="campus_three">Campus 3</label>
                                        <input type="text" class="form-control" value="{{$edit_courses->campus_three}}" id="campus_three" placeholder="Enter Campus" name="campus_three">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="campus_four">Campus 4</label>
                                        <input type="text" class="form-control" value="{{$edit_courses->campus_four}}" id="campus_four" placeholder="Enter Campus" name="campus_four">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="campus_five">Campus 5</label>
                                        <input type="text" class="form-control" value="{{$edit_courses->campus_five}}" id="campus_five" placeholder="Enter Campus" name="campus_five">
                                    </div>

                                </div>
                                <input type="hidden" name="college_id" value="{{$edit_courses->college_id}}">
                                <button type="submit" class="btn btn-outline-primary">Update</button>

                            </form>    

                        </div>

                    </div>                    

                </div>

            </section> 

        </div>

    </div>    

</div>







@endsection