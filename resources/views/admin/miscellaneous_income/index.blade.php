@extends('admin.layout.head')
@section('admin')
<div class="content-wrap">
    <div class="main">

             <div class="container-fluid">
            <div class="row">
                <div class="headertopcontent">

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

            <a href="{{url('/admin/miscellaneous_income/add_miscellaneous_income')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns">+ Add New Miscellaneous Income</a>
        </div>
    </div>

            <div class="row">  

                <div class="contentinner">              

                    <div class="bootstrap-data-table-panel">

                        <div class="table-responsive studenttabless">

                            <table class="table table-striped table-bordered" id="bootstrap-data-table-export">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Service Type</th>
                                        <th>Income</th>
                                        <th>Total Recieved</th>
                                        <th style="text-align: right;">Action</th>                                    
                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php 
                                    if($miscellaneous_income_list)
                                    {
                                        foreach ($miscellaneous_income_list as $key => $miscellaneous_list_val)
                                        {
                                            ?>
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td><?php echo $miscellaneous_list_val->first_name.' '.$miscellaneous_list_val->last_name; ?></td>
                                                <td><?php echo $miscellaneous_list_val->email; ?></td>
                                                <td><?php echo $miscellaneous_list_val->servicename; ?></td>
                                                <td><?php echo $miscellaneous_list_val->income; ?></td>
                                                <td><?php echo $miscellaneous_list_val->total_recieve; ?></td>
                                                <td>
                                                    <div class="dropdown dropbtn">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">


                                                            <a class="dropdown-item" href="{{url('/admin/miscellaneous_income/edit_miscellaneous_income/'.$miscellaneous_list_val->id) }}">Edit</a>
                                                            <a class="dropdown-item" href="{{url('/admin/miscellaneous_income/delete_miscellaneous_income/'.$miscellaneous_list_val->id)}}" onclick="return confirm('Are you sure you want to delete this Record?');">Delete</a>
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




<style type="text/css">
    .tab a.active {  
  background: #2b9ac9 !important;
  border: none;
  cursor: pointer;
  padding: 10px 25px;
  transition: 0.3s;
  font-size: 15px;
  float: left;
  color: #fff;
  border-radius: 5px;
  margin-right: 10px;
  margin-left: 10px;
}
.tab button, .tab a, .tablinks {
    background: #999;
    border: none;    
    cursor: pointer;
    padding: 10px 25px;
    transition: 0.3s;
    font-size: 15px;
    float: left;
    color: #fff;
    border-radius: 5px;
    margin-right: 10px;
}

#pills-tab>li{
   margin:10px;
}
.nav-link{
   border: none;
   cursor: pointer;
}

.radio_style{
   display: flex;
   justify-content: flex-start;
   align-items: center;
}

.radio_style.lead_update_type{
padding: 2px;
margin: 0 2px;
}
.radio_style span{
   display: inline-block;
   margin:0 5px;
}

.tomato
{
    background-color: #ffcaca !important;
    color: #000;
    font-weight: bold;
}
table.dataTable tbody th, table.dataTable tbody td {
    padding: 15px 4px !important;
}
</style>