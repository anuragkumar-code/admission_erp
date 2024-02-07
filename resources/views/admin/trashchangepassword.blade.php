@extends('admin.layout.head')

@section('admin')

<div class="content-wrap">

    <div class="main">

        <div class="container-fluid">

            <div class="row">               

                <div class="col-lg-12 p-r-0 title-margin-right">

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

                    <div class="page-header">

                        <div class="page-title">

                            <h1>Change your Trash Password</h1>

                        </div>

                    </div>
                    <div class="row">
                    <div class="col-lg-12">

                        <div class="card">

                            <form action="{{ route('trash_update_password') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                    <div class="form-row">

                                        <div class="form-group col-md-12">

                                            <label for="current_password">Current Trash Password</label>

                                            <input type="password" class="form-control" id="current_password" placeholder="Enter Current Trash password" name="current_password">

                                            <p class="text-danger">@error('current_password'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-12">

                                            <label for="new_password">New Trash Password</label>

                                            <input type="password" class="form-control" id="new_password" placeholder="Enter New Trash Password" name="new_password">

                                            <p class="text-danger">@error('new_password'){{ $message }}@enderror</p>

                                        </div>

                                        <div class="form-group col-md-12">

                                            <label for="confirm_password">Confirm Trash Password</label>

                                            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Trash Password" name="confirm_password">

                                            <p class="text-danger">@error('confirm_password'){{ $message }}@enderror</p>

                                        </div>

                                    </div>

                                <button type="submit" class="btn btn-outline-info">Submit</button>

                            </form>

                        </div>

                    </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>    

@endsection