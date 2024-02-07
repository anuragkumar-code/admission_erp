@extends('admin.layout.head')

@section('admin')

    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>Add New Office here</h1>

                            </div>

                        </div>

                    </div>

                </div>

                <section id="main-content">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card">

                                <form action="{{ route('add_offices') }}" method="post" enctype="multipart/form-data">

                                    @csrf

                                    <div class="form-row">

                                        <div class="form-group col-md-6">

                                            <label for="name"><strong>Office Name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="name" value="{{old('name')}}" placeholder="Enter Office Name" name="name">

                                            <p class="text-danger">@error('name'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="address"><strong>Office Address <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="address" value="{{old('address')}}" placeholder="Enter Office Address" name="address">

                                            <p class="text-danger">@error('address'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="status"><strong>Status <span style='color: red'>*</span></strong></label>
                                            <select class="form-control "  name="status" id="status">
                                                <option value="">Select Status</option>
                                                <option value="1"@if (old('status') == "1") {{ 'selected' }} @endif>Active</option>
                                                <option value="0"@if (old('status') == "0") {{ 'selected' }} @endif>Inactive</option>
                                               
                                            </select>
                                            <p class="text-danger">@error('status'){{ $message }}@enderror</p>                                            
                                        </div>


                                        <div class="row rights col-md-6 ">
                                            <label class="assignhead"><strong>Assign Rights</strong></label>
                                            <div class="chckinshow">
                                                    <div class="chckstrip">
                                                        <input type="checkbox" value="1" {{ old('super_admin_rights') == '1' ? 'checked' : ''}} name="super_admin_rights" class="chckright"/>
                                                        <b>Super Admin Rights</b>
                                                    </div>
                                              
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">

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

