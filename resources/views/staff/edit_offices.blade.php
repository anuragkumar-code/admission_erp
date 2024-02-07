@extends('staff.layout.head')

@section('staff')

<div class="content-wrap">

    <div class="main">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-8 p-r-0 title-margin-right">

                    <div class="page-header">

                        <div class="page-title">

                            <h1>Edit Office details</h1>

                        </div>

                    </div>

                </div>

            </div>



            <section id="main-content">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

                            <form action="{{url('/admin/office-updated/'.$edit_offices->id)}}" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="form-row">

                                    <div class="form-group col-md-6">

                                        <label for="name"><strong>Office Name <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" value="{{$edit_offices->name}}" id="name" name="name" placeholder="Enter College Name">

                                        <p class="text-danger">@error('name'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="address"><strong>Office Address <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" value="{{$edit_offices->address}}" id="address" name="address" placeholder="Enter Course Duration">

                                        <p class="text-danger">@error('address'){{ $message }}@enderror</p>

                                    </div>
                                    <div class="form-group col-md-6">

                                        <label for="status"><strong>Status </strong></label>

                                        <select class="form-control"  name="status" id="status">
                                            <option value="">Please Select Status</option>
                                            <option <?php if($edit_offices->status == '1'){?> selected <?php } ?> value="1">Active</option>
                                            <option <?php if($edit_offices->status == '0'){?> selected <?php } ?> value="0">Inactive</option>
                                        </select>                                        

                                    </div>

                                    <div class="row rights col-md-6 ">
                                        <label class="assignhead"><strong>Assign Rights</strong></label>
                                        <div class="chckinshow">
                                                <div class="chckstrip">
                                                    <input type="checkbox" <?php if($edit_offices->super_admin_rights == 1) { ?> checked <?php } ?> value="1"  name="super_admin_rights" class="chckright"/>
                                                    <b>Super Admin Rights</b>
                                                </div>
                                          
                                        </div>
                                    </div>
                                          

                                   

                                </div>

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