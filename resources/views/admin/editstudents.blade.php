@extends('admin.layout.head')

@section('admin')





<div class="content-wrap">

    <div class="main">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-8 p-r-0 title-margin-right">

                    <div class="page-header">

                        <div class="page-title">

                            <h1>Edit Student details</h1>

                        </div>

                    </div>

                </div>

            </div>



            <section id="main-content">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

                            <form action="{{('/admin/student-updated/'.$edit_students->id)}}" method="post" enctype="multipart/form-data">

                                @csrf

                                <div class="form-row">

                                    <div class="form-group col-md-4">

                                        <label for="first_name"><strong>First Name <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" value="{{$edit_students->first_name}}" id="first_name" name="first_name"

                                            placeholder="First Name">

                                        <p class="text-danger">@error('first_name'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="middle_name"><strong>Middle Name</strong></label>

                                        <input type="text" class="form-control" value="{{$edit_students->middle_name}}" id="middle_name" name="middle_name" placeholder="Middle Name">      

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="last_name"><strong>Last Name <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" value="{{$edit_students->last_name}}" id="last_name"name="last_name" placeholder="Last Name">

                                        <p class="text-danger">@error('last name'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="dob"><strong>Date of Birth <span style='color: red'>*</span></strong></label>

                                        <input type="date" min="1970-01-01" max="2022-09-07" value="{{$edit_students->dob}}" class="form-control" id="dob" placeholder="Enter D.O.B" name="dob">

                                        <p class="text-danger">@error('dob'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="address"><strong>Address <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" id="address" placeholder="Enter Address"  value="{{$edit_students->address}}" name="address">

                                        <p class="text-danger">@error('country'){{ $message }}@enderror</p>

                                    </div>                                

                                    <div class="form-group col-md-4">

                                        <label for=""><strong>Country <span style='color: red'>*</span></strong></label>

                                            <select class="form-control" name="country">

                                                <option value="">Select Country</option>

                                                <?php if($get_countries){

                                                    foreach ($get_countries as $key => $country) {  ?>

                                                        <option <?php if($country->country_name == $edit_students->country){  ?> selected <?php }  ?> value="{{$country->country_name}}">{{ $country->country_name }}</option> 

                                                <?php  }

                                                } ?>                                                                                       

                                            </select>

                                        <p class="text-danger">@error('country'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="gender"><strong>Gender <span style='color: red'>*</span></strong></label>

                                        <select class="form-control" name="gender" id="gender">

                                            <option value="{{$edit_students->gender}}">{{$edit_students->gender}}</option>

                                            <option value="Male">Male</option>

                                            <option value="Female">Female</option>

                                            <option value="Others">Others</option>

                                        </select>

                                        <p class="text-danger">@error('gender'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="email"><strong>Email Address <span style='color: red'>*</span></strong></label>

                                        <input type="email" class="form-control" id="email"

                                            placeholder="Enter Email address" value="{{$edit_students->email}}" name="email">

                                        <p class="text-danger">@error('email'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="phone"><strong>Phone Number <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id="phone" placeholder="Enter Phone Number" value="{{$edit_students->phone}}" name="phone">

                                        <p class="text-danger">@error('phone'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="emergency_phone"><strong>Emergency Number <span style='color: red'>*</span></strong></label>

                                        <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id="emergency_phone" placeholder="Enter Emergency Contact" value="{{$edit_students->emergency_phone}}" name="emergency_phone">

                                        <p class="text-danger">@error('emergency_phone'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="purpose"><strong>Purpose of visit <span style='color: red'>*</span></strong></label>

                                        <select class="form-control" name="purpose" id="purpose">

                                            <option value="{{$edit_students->purpose}}">{{$edit_students->purpose}}</option>

                                            <option value="TR">TR</option>

                                            <option value="PR">PR</option>

                                            <option value="Other Services">Other Services</option>

                                        </select>

                                        <p class="text-danger">@error('purpose'){{ $message }}@enderror</p>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="referral"><strong>Referral </strong></label>

                                        <select class="form-control"  name="referral" id="referral">

                                            <option value="{{$edit_students->referral}}">{{$edit_students->referral}}</option>

                                            <option value="Google">Google</option>

                                            <option value="Social Media">Social Media</option>

                                            <option value="Others Specified">Others Specified</option>

                                        </select>                                        

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="user_id">Assigned to Staff</label>

                                        <select class="form-control"  name="user_id" id="user_id">

                                            

                                         

                                          <?php if($get_staffs){

                                            foreach ($get_staffs as $key => $get_staff) {  ?>

                                                <option <?php if($get_staff->id == $edit_students->user_id){  ?> selected <?php }  ?> value="{{$get_staff->id}}">{{ $get_staff->first_name }}{{ $get_staff->last_name }}</option> 

                                        <?php  }

                                        } ?>                                                                                       

                                    </select>

                                        <p class="text-danger">

                                            @error('referral')

                                                {{ $message }}

                                            @enderror

                                        </p>

                                    </div>

                                </div>

                                <button type="submit" class="btn btn-outline-primary">Update Student</button>

                            </form>    

                        </div>

                    </div>

                </div>

            </section>                    

        </div>      

    </div>       

</div>

  







@endsection