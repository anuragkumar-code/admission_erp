@extends('admin.layout.head')
@section('admin')

<div class="content-wrap">
    <div class="main">            
        <div class="container-fluid">                
            <div class="dashinfostrip">
                <div class="page-header">
                        <div class="page-title text-center">
                            <h1>Reports</h1>
                        </div>
                    </div>
                <div class="dashrow">
                    <form method="GET" action="{{ url('miscellaneous_income_report') }}" enctype="multipart/form-data" id="myform">
                    <!-- {{ csrf_field() }} -->
                    <div class="row">

                        <div class="col-md-4 col-sm-6">
                            <div class='input-group date' id='start_date' style="background: #fff; cursor: pointer; padding: 8px 8px; border: 1px solid #ccc; width: 100%">
                                     <i class="fa fa-calendar" style="margin-top: 3px;margin-left: -5px;padding-right: 2px;"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down" style="margin-top: 2px;margin-left: 2px;"></i>
                                </div>
                        </div>

                        <input type="hidden" name="start_date" class="from_date">
                        <input type="hidden" name="end_date" class="to_date">
                        <input type="hidden" class="from_date_last">
                        <input type="hidden" class="to_date_last">                        
                        


                        <div class="col-md-4 col-sm-6 colleges">
                            <div class="form-group">                               
                                    <select class="form-control service_list" name="service_list">
                                        <option value="">Please Select Services</option>
                                        <?php
                                        if($other_services)
                                        {
                                            foreach ($other_services as $key => $value_other_services)
                                            {
                                            ?>
                                            <option value="<?php echo $value_other_services->id ?>"><?php echo $value_other_services->service_name; ?></option>    
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>                               
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                          <input type="button" class="btn btn-primary search_students" value="submit" />
                        </div>
                    </div>
                    </form>
                </div>
            </div>           
        </div>              
    </div>
<div style="clear: both;"></div>


<div id="income_div"></div>

</div>



 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript"> 


<?php if(($all_amount_count>0)){ ?>

google.charts.load('current', {
  callback: function () {
    corechart_payment();
    window.addEventListener('resize', corechart_payment, false);
  },
  packages:['corechart']
});

function corechart_payment() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'Total Income', 'Total Recieve'],
     <?php 
      if(isset($all_amount_count_arr))
      {        
        foreach ($all_amount_count_arr as $key => $all_amount_count_value)
        {            
        ?>
    ['<?php echo $all_amount_count_value->services_name; ?>', <?php echo $all_amount_count_value->total_income; ?>, <?php echo $all_amount_count_value->recieved_amount; ?>],
    <?php
        }
      }
    
      ?>
  ]);

  var options = {
    animation:{
      duration: 1000,
      easing: 'linear',
      startup: true
    },
    height: 600,
    hAxis: {
      title: data.getColumnLabel(0)
    },
    theme: 'material',
    title: 'Company Miscellaneus Income'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('income_div'));
  chart.draw(data, options);
}
<?php } ?>


    $(document).on('click', '.search_students', function(){

        var from_date = $('.from_date').val(); 
        var to_date = $('.to_date').val();   
        var service_id = $('.service_list').val();    
        
        $.ajax({
            type:'POST',
            url:"{{ route('ajax_miscellaneous_income_report') }}",
            data:{"_token": "{{ csrf_token() }}",start_date:from_date,end_date:to_date,service_id:service_id},
            success:function(data)
            {
                $('#income_div').html(data);              
            }
        });     
    });


</script>


@endsection