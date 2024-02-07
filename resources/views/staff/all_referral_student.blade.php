@extends('staff.layout.head')
@section('staff')

<div class="content-wrap">    
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="contentinner"> 

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
                    <div class="bootstrap-data-table-panel">
                        <div class="table-responsive studenttabless">
                            <table class="table table-striped table-bordered" id="refferal_student_list">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">S. No.</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if($referal_student_list){
                                        foreach ($referal_student_list as $key => $get_student_list){ ?>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$get_student_list->first_name}} {{$get_student_list->last_name}}</td>                                            
                                            <td>{{$get_student_list->email}}</td>
                                            <td>{{$get_student_list->phone}}</td>
                                            <td>{{$get_student_list->country}}</td>     
                                            <td>
                                                <a href="#" class="pay_commission btn btn-primary" data-student_id="{{$get_student_list->id}}"  data-referral_id="{{$get_student_list->other_referral}}" data-toggle="modal" data-target="#pay_commission" class="btn btn-primary btn-sm">View</a> 
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




<div class="modal fade" id="pay_commission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-lg" role="document">
      <form method="POST" action="{{ url('save_referral_commission') }}" enctype="multipart/form-data" id="myform">
         {{ csrf_field() }}
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Pay Commission <span class="ref_name"></span>   <br>Total Commission Recieved : <span class="total_comm"></span></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="username"></div>
               <label>Commission Price</label>
               <input type="number" class="form-control" name="commission" min="1" required>
               <label>Commission Message</label>
               <textarea class="form-control" name="commission_message" style="height:100px"></textarea>
               <br>
               <input type="hidden" class="student_data" name="student_id" value="">
               <input type="hidden" class="referral_data" name="referral_id" value="">
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <br>
            <div class="prev_msg"></div>
         </div>
      </form>
   </div>
</div>



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

<script type="text/javascript">
    $('#refferal_student_list').DataTable({
        dom: 'Bfrtip',
                responsive: false,
                pageLength: 25,
                buttons:[          
                {
                extend: 'excelHtml5',
                title:  'Refferer Name:- <?php echo $refferal_name; ?>'
                },          
            ]
    });

$(document).ready(function() {
    $(document).on('click','.pay_commission', function(){
        var student_id = $(this).data('student_id');       
        var referral_id = $(this).data('referral_id');       
        //alert(referral_id);
        $('.student_data').addClass('studentid'+student_id);
        $('.studentid'+student_id).val(student_id);

        $('.referral_data').addClass('referralId'+referral_id);
        $('.referralId'+referral_id).val(referral_id);

        $('.prev_msg').addClass('commission_data'+student_id);
        $('.total_comm').addClass('total_commission'+student_id);
        $('.ref_name').addClass('referrals_name'+student_id);
        
        $.ajax({
                type: "POST",
                url: "{{route('ajax_show_commission')}}",
                dataType: 'json',
                data: {"_token": "{{ csrf_token() }}",student_id:student_id,referral_id:referral_id},
                success: function(data)
                {
                   //alert(data);
                   $('.commission_data'+student_id).html(data.referralsData);
                   $('.total_commission'+student_id).html(data.total_commission);
                   $('.referrals_name'+student_id).html(data.referrals_name);
               }
            });
    });

    });

</script>




@endsection

