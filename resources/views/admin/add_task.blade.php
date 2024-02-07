@extends('admin.layout.head')

@section('admin')

    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>New Task</h1>

                            </div>

                        </div>

                    </div>

                </div>

                <section id="main-content">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card">

                                <form action="{{ url('admin/add_task') }}" method="post" enctype="multipart/form-data">

                                    @csrf

                                    <div class="form-row">

                                        <div class="form-group col-md-6">

                                            <label for="name"><strong>Task name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="name" value="{{old('task_name')}}" placeholder="Enter Task Name" name="task_name">

                                            <p class="text-danger">@error('task_name'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="name"><strong>Office <span style='color: red'>*</span></strong></label>

                                            <select class="form-control" name="office_id">
                                                <option value="">Select Office</option>
                                                @if($offices)
                                                    @foreach($offices as $key => $ofice_data)
                                                        <option value="{{$ofice_data->id}}">
                                                            {{$ofice_data->name}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            <p class="text-danger">@error('office_id'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="address"><strong>Task Details<span style='color: red'>*</span></strong></label>

                                            <textarea type="text" class="form-control" id="task" name="task">{{old('task')}}</textarea>

                                            <p class="text-danger">@error('task'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="address"><strong>Task Date<span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="datepicker" name="task_date">

                                            <p class="text-danger">@error('task_date'){{ $message }}@enderror</p>

                                        </div>


                                        <div class="form-group col-md-6">

                                            <label for="address"><strong>Staff Name</strong></label>
                                            <input type="text" class="form-control" id="staff_name" name="staff_name">

                                        </div>

                                      
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

