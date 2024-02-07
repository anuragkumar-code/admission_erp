@extends('admin.layout.head')

@section('admin')

<div class="content-wrap">

    <div class="main">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-8 p-r-0 title-margin-right">

                    <div class="page-header">

                        <div class="page-title">

                            <h1>Edit College details</h1>

                        </div>

                    </div>

                </div>

            </div>



            <section id="main-content">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

                            <form action="{{url('/admin/college-updated/'.$edit_colleges->id)}}" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="form-row">

                                    <div class="form-group col-md-4">

                                        <label for="college_trading_name"><strong>College Trading Name <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" value="{{$edit_colleges->college_trading_name}}" id="college_trading_name" name="college_trading_name" placeholder="Enter College Name">

                                        <p class="text-danger">@error('college_trading_name'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="college_company_name"><strong>College Company Name (Trust) <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" value="{{$edit_colleges->college_company_name}}" id="college_company_name" name="college_company_name" placeholder="Enter Course Duration">

                                        <p class="text-danger">@error('college_company_name'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="rto_number"><strong>RTO Number <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" value="{{$edit_colleges->rto_number}}"  id="rto_number"name="rto_number" placeholder="Enter RTO Number">

                                        <p class="text-danger">@error('rto_number'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="cricos_number"><strong>Cricos Number <span style='color: red'>*</span></strong></label>

                                        <input type="text"  value="{{$edit_colleges->cricos_number}}"  class="form-control" id="cricos_number"  name="cricos_number"  placeholder="Enter Cricos Number">

                                        <p class="text-danger">@error('cricos_number'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="campus_address_1"><strong>Campus Address 1 <span style='color: red'>*</span></strong></label>

                                        <input type="text"  value="{{$edit_colleges->campus_address_1}}" class="form-control" id="campus_address_1"  name="campus_address_1"  placeholder="Enter Campus Address">

                                        <p class="text-danger">@error('campus_address_1'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="campus_address_2"><strong>Campus Address 2</strong></label>

                                        <input type="text"  value="{{$edit_colleges->campus_address_2}}" class="form-control" id="campus_address_2"  name="campus_address_2"  placeholder="Enter Campus Address">

                                        <p class="text-danger">@error('campus_address_2'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="admission_email"><strong>Admission Email <span style='color: red'>*</span></strong></label>

                                        <input type="email"  value="{{$edit_colleges->admission_email}}" class="form-control" id="admission_email"  name="admission_email"  placeholder="Enter Admission Email Address">

                                        <p class="text-danger">@error('admission_email'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="website"><strong>Website <span style='color: red'>*</span></strong></label>

                                        <input type="text"  value="{{$edit_colleges->website}}" class="form-control" id="website"  name="website"  placeholder="Enter Website">

                                        <p class="text-danger">@error('website'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="peo_email"><strong>PEO Email <span style='color: red'>*</span></strong></label>

                                        <input type="email" value="{{$edit_colleges->peo_email}}" class="form-control" id="peo_email"  name="peo_email"  placeholder="Enter PEO Email Address">

                                        <p class="text-danger">@error('peo_email'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="marketing_email"><strong>Marketing Email <span style='color: red'>*</span></strong></label>

                                        <input type="email"  value="{{$edit_colleges->marketing_email}}" class="form-control" id="marketing_email"  name="marketing_email"  placeholder="Enter Marketing Email Address">

                                        <p class="text-danger">@error('marketing_email'){{ $message }}@enderror</p>

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