@extends('admin.layout.head')

@section('admin')

    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>New Event</h1>

                            </div>

                        </div>

                    </div>

                </div>

                <section id="main-content">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card">

                                <form action="{{ url('admin/add_event') }}" method="post" enctype="multipart/form-data">

                                    @csrf

                                    <div class="form-row">

                                        <div class="form-group col-md-6">

                                            <label for="name"><strong>Event Title <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="name" value="{{old('event_title')}}" placeholder="Enter Event Name" name="event_title">

                                            <p class="text-danger">@error('event_title'){{ $message }}@enderror</p>

                                        </div>


                                        <div class="form-group col-md-6">

                                            <label for="address"><strong>Event Start Date<span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="startdate1" name="start_date">
                                          <p class="text-danger">@error('start_date'){{ $message }}@enderror</p>
                                        </div>


                                         <div class="form-group col-md-6">

                                            <label for="address"><strong>Event End Date<span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="enddate" name="end_date">

                                            <p class="text-danger">@error('end_date'){{ $message }}@enderror</p>

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

<style type="text/css">
    .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom
    {margin-top: 62px}
</style>

@endsection

