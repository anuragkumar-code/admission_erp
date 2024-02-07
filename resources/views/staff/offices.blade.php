@extends('staff.layout.head')
@section('staff')
<div class="content-wrap">
    <div class="main">

        <div class="container-fluid">

            <div class="row">

                <div class="headertopcontent">

                    <a href="{{url('/staff/add-office')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns">+ Add New Office</a>

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

                                    <th scope="col">Office Name</th>

                                    <th scope="col">Address </th>

                                    <th scope="col">Status </th>


                                    <th scope="col">Created On</th>

                                    <th scope="col"> </th>


                                    
                                </tr>

                                </thead> 

                                <tbody>

                                    <?php if($get_offices){ 

                                        foreach ($get_offices as $key => $get_office) {  ?>                                          

                                        <tr>

                                            <td>{{$key+1}}</td>

                                            <td>{{$get_office->name}}</a></td>

                                            <td>{{$get_office->address}}</td>

                                            <td><?php if ($get_office->status =='1') echo "Active" ; else echo "Inactive" ;?></td>


                                            <td>{{date('d-m-Y',strtotime($get_office->created_at))}}</td>

                                           
                                            <td>  

                                                <div class="dropdown dropbtn">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                    </button>
                                                    <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                      
                                                      <a class="dropdown-item" href="{{url('admin/office-edit/'.base64_encode($get_office->id))}}">Edit Office</a>
                                                      <a class="dropdown-item" href="{{url('admin/office-deleted/'.base64_encode($get_office->id))}}" onclick="return confirm('Are you sure you want to delete this Office?');">Delete</a>
                                                    </div>
                                                </div>

                                               
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