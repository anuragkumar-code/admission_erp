@extends('staff.layout.head')
@section('staff')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="headertopcontent">
                    <a href="{{url('/staff/add-students')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns"> + Add New Student</a>
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
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">S. No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Staff Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone No.</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if($get_students){ 
                                        foreach ($get_students as $key => $get_student) { ?>                                           
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$get_student->first_name}} {{$get_student->middle_name}} {{$get_student->last_name}}</td>
                                            <td>{{$get_student->staff_name}}</td>
                                            <td>{{$get_student->email}}</td>
                                            <td>{{$get_student->phone}}</td>
                                            <td>{{$get_student->country}}</td>                                        
                                            <td><a href="" data-toggle="modal" data-target="#myModal"><i class="fa fa-ellipsis-h"></i><a>
                                                <a href="{{url('admin/student-details/'.base64_encode($get_student->id))}}"><i class="fa fa-eye" style='color: rgb(7, 197, 26)'></i><a>  
                                                <a href="{{url('admin/student-edit/'.base64_encode($get_student->id))}}"><i class="fa fa-edit" style='color: rgb(29, 18, 235)'></i></a> 
                                                <a href="{{url('admin/student-deleted/'.base64_encode($get_student->id))}}" onclick="return confirm('Are you sure you want to delete this student?');"><i class="fa-solid fa-trash-can" style='color: red'></i></a>
                                                <a href="{{url('admin/student-other-details/'.base64_encode($get_student->id))}}"><i class="fa-solid fa-circle" style='color: rgba(22, 97, 4, 0.495)'></i></a>
                                            </td>
                                        </tr>
                                    <?php }}?>
                                </tbody>
                            </table>                                                          
                        </div>
                    </div>
                    {{ $get_students->links() }}     
                </div>
            </div>           
        </div>
    </div>
</div>

<!-- Modal -->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">       
        <div class="modal-body">
          <p><strong>Personal Details<span class="float-right"><i class="fa fa-check" style='color: green' aria-hidden="true"></i></span></strong></p>
          <p><strong>Passport<span class="float-right"><i class="fa fa-times" style='color: red' aria-hidden="true"></i></span></strong></p>
          <p><strong>Visa<span class="float-right"><i class="fa fa-check" style='color: green' aria-hidden="true"></i></span></strong></p>
          <p><strong>OSHC/OVHC<span class="float-right"><i class="fa fa-times" style='color: red' aria-hidden="true"></i></span></p>
          <p><strong>IELTS / PTE Score<span class="float-right"><i class="fa fa-times" style='color: red' aria-hidden="true"></i></span></p>
          <p><strong>Education Details<span class="float-right"><i class="fa fa-check" style='color: green' aria-hidden="true"></i></span></strong></p>
          <p><strong>COES<span class="float-right"><i class="fa fa-check" style='color: green' aria-hidden="true"></i></span></strong></p>
        </div>        
      </div>      
    </div>
</div>

@endsection