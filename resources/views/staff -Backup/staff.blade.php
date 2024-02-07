@extends('staff.layout.head')

@section('staff')



<div class="content-wrap">

    <div class="main">

        <div class="container-fluid">

            <div class="row">

                <div class="headertopcontent">

                    <a href="{{url('/staff/add-staff')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns">+ Add New Staff</a>

                </div>

            </div>



            @if(session()->has('success'))

                <div class="alert alert-success" id="myDIV" role="alert">

                    <strong>{{session()->get('success')}}</strong> 

                    <i class="fa fa-close closeicon" onclick="hide()" aria-hidden="true"></i>                                                    

                </div>

            @endif

            @if(session()->has('error'))

                <div class="alert alert-danger" id="myDIV" role="alert">

                    <strong>{{session()->get('error')}}</strong> 

                    <i class="fa fa-close closeicon" onclick="hide()" aria-hidden="true"></i>                                                    

                </div>

            @endif



            <div class="row">  

                <div class="contentinner">              

                    <div class="bootstrap-data-table-panel">

                        <div class="table-responsive">                                                      

                            <table class="table table-striped table-bordered" id="bootstrap-data-table-export">

                                <thead class="thead-dark">

                                <tr>

                                    <th scope="col">S. No.</th>

                                    <th scope="col">Name</th>

                                    <th scope="col">Email</th>

                                    <th scope="col">Mobile</th>

                                    <th scope="col">Country</th>                                    

                                    <th scope="col">City</th>

                                    <th scope="col">Action</th>

                                </tr>

                                </thead> 

                                <tbody>

                                    <?php if($get_staff_staffs){ 

                                        foreach ($get_staff_staffs as $key => $get_staff_staff) {  ?>                                          

                                        <tr>

                                            <td>{{$key+1}}</td>

                                            <td>{{$get_staff_staff->first_name}} {{$get_staff_staff->last_name}}</td>

                                            <td>{{$get_staff_staff->email}}</td>

                                            <td>{{$get_staff_staff->mobile}}</td>

                                            <td>{{$get_staff_staff->country}}</td>                                           

                                            <td>{{$get_staff_staff->city}}</td>

                                            <td>  
                                            <div class="dropdown dropbtn">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                    </button>
                                                    <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                      <a class="dropdown-item" href="{{url('staff/edit-staff/'.base64_encode($get_staff_staff->id))}}">Edit</a>
                                                      <a class="dropdown-item" href="{{url('staff/delete-staff/'.base64_encode($get_staff_staff->id))}}" onclick="return confirm('Are you sure you want to delete this staff?');">Delete</a>
                                                    </div>
                                                  </div>
                                                <!-- <a href="{{url('staff/edit-staff/'.base64_encode($get_staff_staff->id)) }}"><i class="fa fa-edit" style='color: rgb(29, 18, 235)'></i></a> 

                                                <a href="{{url('staff/delete-staff/'.base64_encode($get_staff_staff->id)) }}" onclick="return confirm('Are you sure you want to delete this staff?');"><i class="fa-solid fa-trash-can" style='color: red'></i></a> -->

                                            </td>                                     

                                        </tr>

                                    <?php }}?>                                         

                                </tbody>

                            </table>                                   

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>





@endsection