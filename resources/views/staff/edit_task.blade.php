@extends('staff.layout.head')

@section('staff')

    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>Edit Task</h1>

                            </div>

                        </div>

                    </div>

                </div>

                <section id="main-content">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card">

                                <form action="{{ url('/staff/edit_task') }}" method="post" enctype="multipart/form-data">

                                    @csrf

                                    <div class="form-row">

                                        <div class="form-group col-md-6">

                                            <label for="name"><strong>Task name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="name" value="{{$task_list->task_name}}" placeholder="Enter Task Name" name="task_name">

                                            <p class="text-danger">@error('task_name'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="name"><strong>Office <span style='color: red'>*</span></strong></label>

                                            <select class="form-control" name="office_id">
                                                <option value="">Select Office</option>
                                                
                                                        <option <?php if($task_list->office_id == $offices->id){?> selected <?php } ?> value="{{$offices->id}}">
                                                            {{$offices->name}}
                                                        </option>
                                                   
                                            </select>

                                            <p class="text-danger">@error('office_id'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="address"><strong>Task Details<span style='color: red'>*</span></strong></label>

                                            <textarea type="text" class="form-control" id="task" name="task">{{$task_list->task}}</textarea>

                                            <p class="text-danger">@error('task'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="address"><strong>Task Date<span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="datepicker" name="task_date" value="{{$task_list->task_date}}">

                                            <p class="text-danger">@error('task_date'){{ $message }}@enderror</p>

                                        </div>


                                        <div class="form-group col-md-6">

                                            <label for="address"><strong>Staff Name</strong></label>
                                            <input type="text" class="form-control" id="staff_name" name="staff_name" value="{{$task_list->staff_name}}">

                                        </div>



                                        <input type="hidden" name="task_id" value="{{$task_list->id}}">
                                        <input type="hidden" name="status" value="{{$task_list->status}}">
                                      
                                        <div class="form-group col-md-6" style="margin-top: 33px;">           
                                            <button type="submit" class="btn btn-outline-info">Submit</button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </section>       

            </div>           

        </div>       

    </div>



@endsection

