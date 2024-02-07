@extends('admin.layout.head')
@section('admin')

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">

            <div class="row">
                <div class="headertopcontent">
                    <?php if (Auth::user()->type == 1){ ?>
                    <a href="{{url('/admin/add_refferals')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns">+ Add New Referral</a>
                        <?php } ?>
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
                                    <th scope="col">Referal Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if($referal_list){
                                        foreach ($referal_list as $key => $get_referal_list){ ?>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$get_referal_list->name}}</td>
                                            <td>{{$get_referal_list->email}}</td>
                                            <td>{{$get_referal_list->phone}}</td>
                                            <td>   
                                              <a class="btn btn-primary" href="{{url('admin/all_referral_student/'.base64_encode($get_referal_list->id))}}">View Student</a>
                                              <a class="btn btn-primary" href="{{url('admin/edit_refferals/'.base64_encode($get_referal_list->id))}}">Edit</a>
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