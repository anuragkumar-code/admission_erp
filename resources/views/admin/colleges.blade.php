@extends('admin.layout.head')
@section('admin')
<div class="content-wrap">
    <div class="main">

        <div class="container-fluid">

            <div class="row">
               
                <div class="headertopcontent">
                    <?php if(Auth::user()->type==1){ ?>
                    <a href="{{url('/admin/add-college')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns">+ Add New College</a>
                    <?php }?>
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

                        <div class="table-responsive studenttabless">                                                      

                            <table class="table table-striped table-bordered" id="bootstrap-data-table-export">

                                <thead class="thead-dark">

                                <tr>

                                    <th scope="col">S. No.</th>

                                    <th scope="col">Trading Name</th>

                                    <th scope="col">Company Name</th>

                                    <th scope="col">Website</th>

                                    <th scope="col">Email</th>                                    

                                    <th scope="col"></th>

                                </tr>

                                </thead> 

                                <tbody>

                                    <?php if($get_colleges){ 

                                        foreach ($get_colleges as $key => $get_college) {  ?>                                          

                                        <tr>

                                            <td>{{$key+1}}</td>

                                            <td><a style="color: blue" href="{{url('/admin/college-details/'.base64_encode($get_college->id))}}">{{$get_college->college_trading_name}}</a></td>

                                            <td>{{$get_college->college_company_name}}</td>

                                            <td>{{$get_college->website}}</td>

                                            <td>{{$get_college->admission_email}}</td>                                           

                                            <td>  

                                                <div class="dropdown dropbtn">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                    </button>
                                                    <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                      <a class="dropdown-item" href="{{url('admin/add-course/'.base64_encode($get_college->id))}}">Courses</a>

                                                      <?php if (Auth::user()->type==1){ ?>
                                                      <a class="dropdown-item" href="{{url('admin/college-edit/'.base64_encode($get_college->id))}}">Edit College</a>
                                                      <a class="dropdown-item" href="{{url('admin/college-deleted/'.base64_encode($get_college->id))}}" onclick="return confirm('Are you sure you want to delete this college?');">Delete</a>
                                                      <?php  } ?>
                                                      
                                                    </div>
                                                </div>

                                                {{-- <a href="{{url('/admin/add-course/'.base64_encode($get_college->id))}}"><i class="fa fa-graduation-cap" style='color: rgb(18, 235, 29)'></i></a>
                                                
                                                <a href="{{url('admin/college-edit/'.base64_encode($get_college->id)) }}"><i class="fa fa-edit" style='color: rgb(29, 18, 235)'></i></a> 

                                                <a href="{{ url('admin/college-deleted/'.base64_encode($get_college->id))}}" onclick="return confirm('Are you sure you want to delete this college?');"><i class="fa-solid fa-trash-can" style='color: red'></i></a> --}}

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