@extends('admin.layout.head')
@section('admin')
<div class="content-wrap">
    <div class="main">

        <div class="container-fluid">
            <div class="row">
                <div class="headertopcontent">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="task-open-tab" data-toggle="pill" data-target="#task-open" type="button" role="tab" aria-controls="task-open-tab" aria-selected="true">Open</button>
                        </li>
                         <li class="nav-item" role="presentation">
                            <button class="nav-link" id="task-snooze-tab" data-toggle="pill" data-target="#task-snooze" type="button" role="tab" aria-controls="task-snooze" aria-selected="false">Snooze</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="task-close-tab" data-toggle="pill" data-target="#task-close" type="button" role="tab" aria-controls="task-close" aria-selected="false">Close</button>
                        </li>
                       
                    </ul>

                    <a href="{{url('admin/add_task')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns">+ Add New Task</a>
                </div>


            </div>
            <div class="row">

                

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
                            <div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="task-open" role="tabpanel" aria-labelledby="pills-home-tab">
                            <table class="table table-striped table-bordered" id="bootstrap-data-table-export">

                                <thead class="thead-dark">

                                <tr>
                                    <th scope="col">S. No.</th>
                                    <th scope="col">Office Name</th>
                                    <th scope="col">Task Name</th>
                                    <th scope="col">Task Detail</th>
                                    <th scope="col">Staff Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>                                    
                                </tr>

                                </thead> 

                                <tbody>

                                    <?php 
                                    $current_date = strtotime(date('Y-m-d'));
                                    if($get_tasks){ 

                                        foreach ($get_tasks as $key => $get_task_data) {

                                            $task_date = strtotime($get_task_data->task_date);
                                            $snooze_date = strtotime($get_task_data->snooze_date);

                                            if($get_task_data->status==1)
                                            {
                                                if($current_date>=$task_date)
                                                {
                                                    $status = 'Open';
                                                }
                                                else
                                                {
                                                     $status = 'Overdue';
                                                }
                                            }
                                            else if($get_task_data->status==2)
                                            {
                                                if($snooze_date>$current_date)
                                                {
                                                   $status = 'Snoozed'; 
                                                }
                                                else
                                                {
                                                    $status = 'Overdue';
                                                }
                                            }
                                            else if($get_task_data->status==3)
                                            {
                                                
                                                    $status = 'Closed';
                                                
                                            }

                                            if($get_task_data->is_read==1)
                                            {
                                                     $read_unread = '';
                                            }
                                            if($get_task_data->is_read==0)
                                            {
                                                     $read_unread = 'tomato';
                                            }

                                         ?>                                          

                                        <tr class="task_row{{$get_task_data->id}} <?php echo $read_unread; ?>">

                                            <td>{{$key+1}}</td>

                                            <td>{{$get_task_data->office_name}}</td>

                                            <td>{{$get_task_data->task_name}}</td>
                                            <td><?php echo substr($get_task_data->task, 0,20); ?><i class="fa fa-eye show_taskdetail" data-task_detail="<?php echo $get_task_data->task ?>" data-toggle="modal" data-target="#opentaskdetail"></i></td>
                                            <td>{{$get_task_data->staff_name}}</td>

                                             <td>{{date('d-m-Y',strtotime($get_task_data->task_date))}}</td>

                                           <td> <button class="btn btn-sm btn-primary opnetaskmodal" data-toggle="modal" data-target="#myModalSnooze" data-task_id="{{$get_task_data->id}}" data-office_id="{{$get_task_data->office_id}}">{{$status}}</button></td>
                                           
                                            <td> 
                                             
                                                <div class="dropdown dropbtn">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                    </button>
                                                    <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                      
                                                      <a class="dropdown-item" href="{{url('admin/edit_task/'.base64_encode($get_task_data->id))}}">Edit Task</a>
                                                      <?php if($get_task_data->is_read == 0){ ?>
                                                       <a class="dropdown-item read read_label{{$get_task_data->id}}" data-task_id="{{$get_task_data->id}}" href="#">Mark Read</a>
                                                   <?php } elseif($get_task_data->is_read == 1) {?>
                                                        <a class="dropdown-item unread unread_label{{$get_task_data->id}}" data-task_id="{{$get_task_data->id}}" href="#">Mark Unread</a>
                                                   <?php } ?>
                                                      <a class="dropdown-item" href="{{url('admin/task_delete/'.base64_encode($get_task_data->id))}}" onclick="return confirm('Are you sure you want to delete this Task?');">Delete</a>
                                                    </div>
                                                </div>

                                               
                                            </td>                                     

                                        </tr>

                                    <?php }}?>                                         

                                </tbody>

                            </table>                                   

                        </div>



                        <div class="tab-pane fade" id="task-snooze" role="tabpanel" aria-labelledby="pills-profile-tab">
                            
                            <table class="table table-striped table-bordered" id="bootstrap-data-table-export">

                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">S. No.</th>
                                    <th scope="col">Office Name</th>
                                    <th scope="col">Task Name</th>
                                    <th scope="col">Task Detail</th>
                                    <th scope="col">Staff Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Snooze Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"> </th>              
                                </tr>
                                </thead>

                                  <tbody>

                                    <?php 
                                    $current_date = strtotime(date('Y-m-d'));
                                    if($get_snoozed_tasks){ 

                                        foreach ($get_snoozed_tasks as $key => $get_snoozed_task_data) { 

                                            $task_date = strtotime($get_snoozed_task_data->task_date);
                                            $snooze_date = strtotime($get_snoozed_task_data->snooze_date);

                                            

                                            if($get_snoozed_task_data->status==1)
                                            {
                                                if($current_date<=$task_date)
                                                {
                                                    $status = 'Open';
                                                }
                                                else
                                                {
                                                     $status = 'Overdue';
                                                }
                                            }
                                            else if($get_snoozed_task_data->status==2)
                                            {
                                                if($snooze_date>$current_date)
                                                {
                                                   $status = 'Snoozed'; 
                                                }
                                                else
                                                {
                                                    $status = 'Overdue';
                                                }
                                            }
                                            else if($get_snoozed_task_data->status==3)
                                            {
                                                
                                                    $status = 'Closed';
                                                
                                            }

                                         ?>                                          

                                        <tr>

                                            <td>{{$key+1}}</td>
                                            <td>{{$get_snoozed_task_data->office_name}}</td>
                                            <td>{{$get_snoozed_task_data->task_name}}</td>
                                            <td><?php echo substr($get_snoozed_task_data->task, 0,60); ?><i class="fa fa-eye show_taskdetail" data-task_detail="<?php echo $get_snoozed_task_data->task ?>" data-toggle="modal" data-target="#opentaskdetail"></i></td>
                                            <td>{{$get_snoozed_task_data->staff_name}}</td>
                                            <td>{{date('d-m-Y',strtotime($get_snoozed_task_data->task_date))}}</td>
                                            <td>{{date('d-m-Y',strtotime($get_snoozed_task_data->snooze_date))}}</td>
                                            <td> <button class="btn btn-sm btn-primary opnetaskmodal" data-toggle="modal" data-target="#myModalSnooze" data-task_id="{{$get_snoozed_task_data->id}}" data-office_id="{{$get_snoozed_task_data->office_id}}">{{$status}}</button></td>
                                            <td>  
                                                <div class="dropdown dropbtn">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                    </button>
                                                    <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                      
                                                      <a class="dropdown-item" href="{{url('admin/edit_task/'.base64_encode($get_snoozed_task_data->id))}}">Edit Task</a>
                                                      <a class="dropdown-item" href="{{url('admin/task_delete/'.base64_encode($get_snoozed_task_data->id))}}" onclick="return confirm('Are you sure you want to delete this Task?');">Delete</a>
                                                    </div>
                                                </div>
                                            </td>                                     
                                        </tr>

                                    <?php }}?>                                         

                                </tbody>

                            </table>  

                        </div>



  <div class="tab-pane fade" id="task-close" role="tabpanel" aria-labelledby="pills-contact-tab">      
                    <table class="table table-striped table-bordered" id="bootstrap-data-table-export">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">S. No.</th>
                                    <th scope="col">Office Name</th>
                                    <th scope="col">Task Name</th>
                                    <th scope="col">Task Detail</th>
                                    <th scope="col">Staff Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>                                    
                                </tr>
                                </thead> 
                                <tbody>
                                    <?php 
                                    $current_date = strtotime(date('Y-m-d'));
                                    if($get_closed_tasks){ 

                                        foreach ($get_closed_tasks as $key => $get_closed_task_data) {

                                            $task_date = strtotime($get_closed_task_data->task_date);
                                            $snooze_date = strtotime($get_closed_task_data->snooze_date);

                                            if($get_closed_task_data->status==1)
                                            {
                                                if($current_date<=$task_date)
                                                {
                                                    $status = 'Open';
                                                }
                                                else
                                                {
                                                     $status = 'Overdue';
                                                }
                                            }
                                            else if($get_closed_task_data->status==2)
                                            {
                                                if($snooze_date>$current_date)
                                                {
                                                   $status = 'Snoozed'; 
                                                }
                                                else
                                                {
                                                    $status = 'Overdue';
                                                }
                                            }
                                            else if($get_closed_task_data->status==3)
                                            {                                                
                                                    $status = 'Closed';                                 
                                            }
                                         ?>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$get_closed_task_data->office_name}}</td>
                                            <td>{{$get_closed_task_data->task_name}}</td>
                                            <td><?php echo substr($get_closed_task_data->task, 0,60); ?><i class="fa fa-eye show_taskdetail" data-task_detail="<?php echo $get_closed_task_data->task ?>" data-toggle="modal" data-target="#opentaskdetail"></i></td>
                                            <td>{{$get_closed_task_data->staff_name}}</td>
                                             <td>{{date('d-m-Y',strtotime($get_closed_task_data->task_date))}}</td>
                                            <td> <button class="btn btn-sm btn-primary opnetaskmodal" data-toggle="modal" data-target="#myModalSnooze" data-task_id="{{$get_closed_task_data->id}}" data-office_id="{{$get_closed_task_data->office_id}}">{{$status}}</button></td>
                                            <td>
                                                <div class="dropdown dropbtn">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                    </button>
                                                    <div class="dropdown-menu dropmenu" aria-labelledby="dropdownMenuButton">
                                                      
                                                      <a class="dropdown-item" href="{{url('admin/edit_task/'.base64_encode($get_closed_task_data->id))}}">Edit Task</a>
                                                      <a class="dropdown-item" href="{{url('admin/task_delete/'.base64_encode($get_closed_task_data->id))}}" onclick="return confirm('Are you sure you want to delete this Task?');">Delete</a>
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
    </div>
</div>

<div class="modal" id="myModalSnooze">
    <div class="modal-dialog widinfos modal-lg">
      <div class="modal-content boxpop">
           <div class="modal-header">
         <h5 class="bgtophead modal-title" id="exampleModalLabel">Update Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <form class="auth-login-form" action="{{ url('add_task_comments') }}" method="POST">
             {{ csrf_field() }}
          <div class="formdetils">
            <h3 class="customer_name text-left"></h3>
            
                 <div class="radio_style">
                 <div class="col-md-3">
                    <input type="radio" name="status_task_update_type" class="lead_update_type" value="1"><span>Add Notes</span>
                </div> 
                <div class="col-md-3">
                    <input type="radio" name="status_task_update_type" class="lead_update_type" value="2"><span> Snooze Task</span>
                </div>
                <div class="col-md-3">
                    <input type="radio" name="status_task_update_type" class="lead_update_type" value="3"><span> Close Task </span>
                </div> 
            
                <div class="col-md-12">
                <span style="color: red" class="leadTypeError"></span>
                </div>
            </div>
            <br>
            <div class="follow_status_Error" style="color: red;"></div>
            <input type="hidden" name="lead_id" value="" class="getCustomerId">
           
            <label class="reminder_class d-none">Next Reminder Date</label>
            <input type="text" name="due_date" class="form-control reminder_class d-none" placeholder="Reminder date" id="date" value="" data-select="datepicker">
            <br>
            <label>Comment</label>           
            <textarea class="form-control" name="comment" style="height:200px"></textarea>
            <br>
            <div class="snoozedate d-none">
            <label>Snooze date</label>           
            <input type="text" id="datepicker" class="form-control snooze_calender" name="snooze_date">
            </div>

            <br>
            <input type="hidden" class="task_id" name="task_id" value="">
            <input type="hidden" class="office_id" name="office_id" value="">
            <input type="submit" name="" value="Submit" class="btn btn-primary submitbtnss submitUpdateLead">
            <input type="button" data-dismiss="modal" value="Close" class="btn btn-basic submitbtnss01">
          </div>     
          </form>  

          <div class="prev_msg all_comments">
              
          </div>

          </div> 
      </div>
    </div>
  </div>



<!-- Show task detail content only -->


<div class="modal fade" id="opentaskdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Task Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="show_task_detail"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">
     $(document).ready(function() {
    $(document).on('change','.lead_update_type', function(){
        var status_val = $(this).val();
        /*alert(status_val);*/
        if(status_val == 2)
        {
            $('.snoozedate').removeClass('d-none');
            var snoozedate = $('.snooze_calender').val();
            if(snoozedate == '')
            {
               $(".snooze_calender").prop('required',true);
               return false;
            }

        }
        else if(status_val == 1 || status_val == 3)
        {
            $('.snoozedate').addClass('d-none');   
        }

    });

$(document).on('click','.show_taskdetail', function(){

    var task_detail = $(this).data('task_detail');

    $('.show_task_detail').html(task_detail);
});

    $(document).on('click','.opnetaskmodal', function(){
        var task_id = $(this).data('task_id');
        var office_id = $(this).data('office_id');      
        //alert(user_id);
        $('.prev_msg').addClass('all_comments'+task_id);
        $('.task_id').val(task_id);
        $('.office_id').val(office_id);

        $.ajax({
                type: "POST",
                url: "{{route('ajax_task_comment_data')}}",
                data: {"_token": "{{ csrf_token() }}",task_id:task_id},
                success: function(data)
                {
                   //alert(data);
                   $('.all_comments'+task_id).html(data);                 
                   //$('.username').html("Student Name:- "+username);                 
                }
            });
    });


    $(document).on('click','.submitUpdateLead',function(){
        var follow_status_count = $(':radio[name="status_task_update_type"]:checked').length;
        var follow_status = $(':radio[name="status_task_update_type"]:checked').val();

        if(follow_status_count==0)
        {
            $('.follow_status_Error').html('Please select Status type');
            return false;
        }


    });


    $(document).on('click','.read', function(){
        var task_id = $(this).data('task_id');      
        var is_read = 1;      
        //alert(user_id);
        $.ajax({
                type: "POST",
                url: "{{route('ajax_task_read_unread')}}",
                data: {"_token": "{{ csrf_token() }}",task_id:task_id,is_read:is_read},
                success: function(data)
                {
                   //alert(data);
                   $('.all_task'+task_id).html(data);   
                   $('.read_label'+task_id).html('Mark Unread');              
                   $('.read_label'+task_id).removeClass('read');              
                   $('.read_label'+task_id).addClass('unread');              
                   $('.task_row'+task_id).removeClass("tomato",1000);               
                }
            });
    });


    $(document).on('click','.unread', function(){
        var task_id = $(this).data('task_id');      
        var is_read = 0;     
        //alert(user_id);
        $.ajax({
                type: "POST",
                url: "{{route('ajax_task_read_unread')}}",
                data: {"_token": "{{ csrf_token() }}",task_id:task_id,is_read:is_read},
                success: function(data)
                {
                   //alert(data);
                   $('.all_task'+task_id).html(data);                 
                   $('.unread_label'+task_id).html('Mark Read');
                   $('.unread_label'+task_id).removeClass('unread');              
                   $('.unread_label'+task_id).addClass('read');                 
                   $('.task_row'+task_id).addClass("tomato",1000);                 
                }
            });
    });


    });

</script>

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