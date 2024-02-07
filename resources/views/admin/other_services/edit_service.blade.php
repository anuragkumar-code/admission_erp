@extends('admin.layout.head')
@section('admin')

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Edit Service</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <form action="{{ url('admin/other_services/edit_service') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name"><strong>Service Name <span style='color: red'>*</span></strong></label>
                                            <input type="text" class="form-control" id="name" value="{{$service_list->service_name}}" placeholder="Enter Service Name" name="service_name">

                                            <p class="text-danger">@error('service_name'){{ $message }}@enderror</p>
                                        </div>
                                        <input type="hidden" name="service_id" value="{{$service_list->id}}">
                                      
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

