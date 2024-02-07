@extends('admin.layout.head')
@section('admin')

<style type="text/css">
    .only_header
    {
        display: none !important;
    }
</style>

<?php
$name = $dob = $phone = '';

$name = Request::get('name');
$dob = Request::get('dob'); 
$phone = Request::get('phone');

//echo "DOB =>".$name.'DOB =>'.$dob.'Phone =>'.$phone;


?>

<div class="main">
        <div class="container-fluid">
            <div class="header">      
                <div class="container-fluid">
                    <div class="topnavstrip">
                        <div class="row">

                        <div class="col-md-1">
                        <div class="hamburger sidebar-toggle">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                   
                            </div>
                        </div>
                                <div class="col-md-8"></div>
                        
                            <div class="col-md-2 mobilehides">
                                <div class="dropdown dib" style="float: right">
                                    <div class="header-icon" data-toggle="dropdown">
                                        <span class="user-avatar">{{Auth::user()->first_name}}
                                            <i class="ti-angle-down f-s-10"></i>
                                        </span>
                                        <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-content-heading">
                                                <span class="text-left">{{Auth::user()->first_name}}</span>
                                            </div>
                                            <div class="dropdown-content-body">
                                                <ul>
                                                    <li>
                                                        <a href="{{route('change_password')}}">
                                                            <i class="fa fa-key"></i>
                                                            <span>Change Password</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('adminLogout')}}">
                                                            <i class="fa fa-power-off"></i>
                                                            <span>Logout</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

<div style="clear: both;">&nbsp;</div>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="headertopcontent">
                
                </div>
            </div>

            @if(session()->has('success_commission'))
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
                <div class="studenttab">                   
                               
                               <div class="success_msg"></div>       

                        <div class="contentinner">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive studenttabless">                                                                  
                                    <table class="table table-striped table-bordered" id="bootstrap-data-table-export">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">S. No.</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">College</th>
                                            <th scope="col">Course</th>
                                            <th scope="col" style="white-space:nowrap;">Recieved Commission</th>        
                                            <th scope="col">Action</th>                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //echo "<pre>"; print_r($commission_data); exit;
                                            if($commission_data)
                                            {
                                                $counter = 1;
                                                foreach ($commission_data as $key => $commission_value)
                                                {
                                                ?>
                                                <tr class="commission_row{{$commission_value->id}}">
                                                    <td>{{ ($commission_data->currentpage()-1) * $commission_data->perpage() + $key + 1 }}</td>
                                                    <td><?php echo $commission_value->fname.' '.$commission_value->lname; ?></td>
                                                    <td><?php echo $commission_value->email; ?></td>
                                                    <td><?php echo $commission_value->college_name; ?></td>
                                                    <td><?php echo $commission_value->cname; ?></td>
                                                    <td><?php echo number_format($commission_value->total_rec_commission,2); ?></td>
                                                    <?php if($commission_value->is_commission_claimed == 1){ ?>
                                                        <td>
                                                        <button type="button" class="btn btn-danger">Claimed</button>
                                                    </td>
                                                    <?php } else { ?> 
                                                    <td class="button_class{{$commission_value->id}}">
                                                        <button type="button" class="btn btn-primary claim_commission" data-fee_emi_id="{{$commission_value->id}}">Claim</button>
                                                    </td>
                                                <?php } ?>
                                                </tr>
                                                <?php
                                                }
                                               
                                            }
                                            $counter++;
                                            ?>

                                        </tbody>
                                    </table>                                                          
                                </div>
                            </div>
                             {{$commission_data->links('pagination::bootstrap-4')}}
                        </div>                                                       
                </div>                
            </div>           
        </div>
    </div>
</div>

<!-- Modal -->


<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Claim Commission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form action="{{route('commission_claim')}}" method="post" id="comm_claim" enctype='multipart/form-data'>
            @csrf
            <label for="amount"><strong>Amount : <span style='color: red'>*</span></strong></label><br>
            <input type="text" class="form-control" id="amount" name="amount"><br>

            <label for="comment"><strong>Comment :</strong></label><br>
            <textarea name="comment" class="form-control" id="" cols="30" rows="10"></textarea>

            <input type="hidden" class="fee_id" value="" name="fee_id">
            <input type="hidden" class="amt_due" value="" name="amt_due">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Claim Now</button>
            </div>
        </form>

      </div>
      
    </div>
  </div>
</div> -->



<style type="text/css">
    .iti--allow-dropdown input, .iti--allow-dropdown input[type=text], .iti--allow-dropdown input[type=tel], .iti--separate-dial-code input, .iti--separate-dial-code input[type=text], .iti--separate-dial-code input[type=tel] {
    padding-right: 6px;
    padding-left: 95px !important;
    margin-left: 0;
    width: 386px !important;
}
</style>



<script src="{{ asset('admin/js/intlTelInput.js') }}"></script>
<link href="{{ asset('admin/css/intlTelInput.css') }}" rel="stylesheet">
<link href="{{ asset('admin/css/isValidNumber.css') }}" rel="stylesheet">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" rel="stylesheet"> 

<style>
    textarea {

  height: 150px!important;
}

/*.tab button.active {
  background: #2b9ac9 !important;
}*/
.tab a.active {  
  background: #2b9ac9 !important;
  border: none;
  cursor: pointer;
  padding: 10px 25px;
  transition: 0.3s;
  font-size: 15px;
  /*float: left;*/
  color: #fff;
  border-radius: 5px;
  margin-right: 10px;
  margin-left: 10px;
}

.top-search {
    width: inherit;
}

.fa-whatsapp
{
    font: normal normal normal 14px/1 FontAwesome!important;
}

.fa-comment-o
{
    font: normal normal normal 14px/1 FontAwesome!important;
}

    .msgicons {
        float: left;
    margin: 0px 5px 0 0;
}
</style>

<script type="text/javascript">

    $(document).ready(function(){
    $(document).on('click', '.claim_commission', function(){     
        var id = $(this).attr('data-fee_emi_id');
        swal({
        title: "Are you sure?",
        text: "Once Claimed, you will not be able to Decline!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes do it",
        closeOnConfirm: true,
    },
    function(){
        $.ajax({
            type:'POST',
            url:"{{ route('commission_claim') }}",
            data:{"_token": "{{ csrf_token() }}",id:id},
            success:function(data)
            {    
                if(data == 1)
                {
                    $('.button_class'+id).html('<button type="button" class="btn btn-danger">Claimed</button>');
                    $('.success_msg').html('<div class="alert alert-success" id="myDIV" role="alert"><strong>Commission Claimed Successfuly.</strong><i class="fa fa-close closeicon" onclick="hide()" aria-hidden="true"></i></div>');
                    $('.commission_row'+id).css('background','tomato');
                    $('.commission_row'+id).fadeOut(800,function(){
                    $(this).remove();
                });
                }

            }

        });
        });

    });
    });
</script>


@endsection
