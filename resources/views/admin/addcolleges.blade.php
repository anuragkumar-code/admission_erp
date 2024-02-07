@extends('admin.layout.head')

@section('admin')

    <div class="content-wrap">

        <div class="main">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-8 p-r-0 title-margin-right">

                        <div class="page-header">

                            <div class="page-title">

                                <h1>Add College here</h1>

                            </div>

                        </div>

                    </div>

                </div>

                <section id="main-content">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card">

                                <form action="{{ route('add_colleges') }}" method="post" enctype="multipart/form-data">

                                    @csrf

                                    <div class="form-row">

                                        <div class="form-group col-md-6">

                                            <label for="college_trading_name"><strong>College Trading Name <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="college_trading_name" value="{{old('college_trading_name')}}" placeholder="Enter College Name" name="college_trading_name">

                                            <p class="text-danger">@error('college_trading_name'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="college_company_name"><strong>College Company Name (Trust) <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="college_company_name" value="{{old('college_company_name')}}" placeholder="Enter College Company Name" name="college_company_name">

                                            <p class="text-danger">@error('college_company_name'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="rto_number"><strong>RTO Number <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="rto_number" value="{{old('rto_number')}}"  placeholder="Enter RTO Number" name="rto_number">

                                            <p class="text-danger">@error('rto_number'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="cricos_number"><strong>Cricos Number <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="cricos_number" value="{{old('cricos_number')}}"  placeholder="Enter Cricos Number" name="cricos_number">

                                            <p class="text-danger">@error('cricos_number'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="campus_address_1"><strong>Campus Address 1 <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="campus_address_1" value="{{old('campus_address_1')}}" placeholder="Enter Campus Address" name="campus_address_1">

                                            <p class="text-danger">@error('campus_address_1'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="campus_address_2"><strong>Campus Address 2</strong></label>

                                            <input type="text" class="form-control" id="campus_address_2" value="{{old('campus_address_2')}}" placeholder="Enter Campus Address" name="campus_address_2">

                                            <p class="text-danger">@error('campus_address_2'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="admission_email"><strong>Admission Email <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="admission_email" value="{{old('admission_email')}}" placeholder="Enter Admission Email Address" name="admission_email">

                                            <p class="text-danger">@error('admission_email'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="website"><strong>Website <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="website" value="{{old('website')}}" placeholder="Enter Webiste" name="website">

                                            <p class="text-danger">@error('website'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="peo_email"><strong>PEO Email <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="peo_email" value="{{old('peo_email')}}" placeholder="Enter PEO Email Address" name="peo_email">

                                            <p class="text-danger">@error('peo_email'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-6">

                                            <label for="marketing_email"><strong>Marketing Email <span style='color: red'>*</span></strong></label>

                                            <input type="text" class="form-control" id="marketing_email" value="{{old('marketing_email')}}" placeholder="Enter Cricos Number" name="marketing_email">

                                            <p class="text-danger">@error('marketing_email'){{ $message }}@enderror</p>

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

