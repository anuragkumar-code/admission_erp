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
                                        <th scope="col">Remaining Bonus</th>
                                        <th scope="col" style="white-space:nowrap;">Claimed Bonus</th>
                                        <th scope="col">Action</th>                                            
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            //echo "<pre>"; print_r($commission_data); exit;
                                    if($bonus_data)
                                    {
                                        $counter = 1;
                                        foreach ($bonus_data as $key => $bonus_value)
                                        {
                                            ?>
                                            <tr class="bonus_row{{$bonus_value->id}}">
                                                <td>{{$key}}</td>
                                                <td><?php echo $bonus_value->fname.' '.$bonus_value->lname; ?></td>
                                                <td><?php echo $bonus_value->email; ?></td>
                                                <td><?php echo $bonus_value->college_name; ?></td>
                                                <td><?php echo $bonus_value->cname; ?></td>         
                                                <td class="remainingbonus{{$bonus_value->id}}"><?php echo number_format($bonus_value->bonus - $bonus_value->bonus_claimed,2); ?></td>
                                                <td class="total_claimed{{$bonus_value->id}}"><?php echo number_format($bonus_value->bonus_claimed,2); ?></td>
                                                <?php if($bonus_value->bonus_claimed < $bonus_value->bonus){ ?>
                                                   <td class="button_class{{$bonus_value->id}}">     
                                                    <button type="button" class="btn btn-primary claim_bonus" data-toggle="modal" data-target="#bonus_modal{{$bonus_value->id}}">Claim</button>
                                                </td>

                                            <?php } else { ?> 
                                             <td>
                                                <button type="button" class="btn btn-danger">Claimed</button>
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
            <?php /* {{$bonus_data->links('pagination::bootstrap-4')}} */ ?>
        </div>                                                       
    </div>                
</div>           
</div>
</div>
</div>

<!-- Modal -->

<?php
//echo "<pre>"; print_r($commission_data); exit;
if($bonus_data)
{
    $counter = 1;
    foreach ($bonus_data as $key => $bonus_value)
    {
        ?>

        <div class="modal fade bonusmodal" id="bonus_modal{{$bonus_value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Claim Bonus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">

            <form action="{{route('bonus_claim')}}" method="post" id="comm_claim" enctype='multipart/form-data'>
                @csrf
                <label for="bonus_claimed"><strong>Amount : <span style='color: red'>*</span></strong></label><br>
                <input type="text" class="form-control bonus_claimed{{$bonus_value->id}}" id="bonus_claimed" name="bonus_claimed"><br>

                 <div class="error_msg"></div> 


                 <input type="hidden" name="totalbonus" class="totalbonus{{$bonus_value->id}}" value="<?php echo $bonus_value->bonus; ?>">

                 <input type="hidden" name="remaining_bonus" class="remaining_bonus{{$bonus_value->id}}" value="<?php echo number_format($bonus_value->bonus - $bonus_value->bonus_claimed,2); ?>">

                 <input type="hidden" name="claimed_bonus" class="claimed_bonus{{$bonus_value->id}}" value="<?php echo $bonus_value->bonus_claimed; ?>">

         <!--    <label for="bonus_comment"><strong>Comment :</strong></label><br>
            <textarea name="bonus_comment" class="form-control bonus_comment{{$bonus_value->id}}" id="" cols="30" rows="10"></textarea> -->

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary claimbonus" data-course_fee_detail_id="{{$bonus_value->id}}">Claim Now</button>
            </div>
        </form>

    </div>

</div>
</div>
</div> 
<?php } } ?>


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
        $(document).on('click', '.claimbonus', function(){        
            var id = $(this).attr('data-course_fee_detail_id');            
            var bonus_claimed = $('.bonus_claimed'+id).val();

            var totalbonus = $('.totalbonus'+id).val();
            var claimedbonus = $('.claimed_bonus'+id).val();

            if(claimedbonus == 0)
            {
                var remaining_bonus = totalbonus - bonus_claimed;
                var bonusclaimed = bonus_claimed;
            }
            else
            {
                var remaining_bonus = totalbonus - (parseInt(claimedbonus) + parseInt(bonus_claimed));
                var bonusclaimed = (parseInt(claimedbonus) + parseInt(bonus_claimed));
            }

          /*  var remaining_bonus = $('.remaining_bonus'+id).val();
            var remained = remaining_bonus - bonus_claimed;
            var claimed_bonus = $('.claimed'+id).val();
            var total_claimed = parseInt(claimed_bonus) + parseInt(bonus_claimed);*/

           
            
            $.ajax({
                type:'POST',
                url:"{{ route('bonus_claim') }}",
                data:{"_token": "{{ csrf_token() }}",id:id,bonus_claimed:bonus_claimed},
                success:function(data)
                {    

                    if(data == 1)
                    {
                        $('.error_msg').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Oopps!</strong> Claimed bonus can not be greater than remaining bonus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    else if(data == 2)
                    {
                        location.reload();
                        
                        
                    }
                    else if(data == 3)
                    {   
                        location.reload();                      

                    }

                }

            });

        });
    });
</script>

<!-- 

$(document).ready(function() {
        $('#example').dataTable( {
            stateSave: true
        } );
    } );

 -->
@endsection
