@extends('staff.layout.head')
@section('staff')

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
                    <form method="GET" action="{{ url('/staff/commission_generate_report') }}" enctype="multipart/form-data" id="myform">
                    <!-- {{ csrf_field() }} -->
                    <div class="row">

                        <div class="col-md-3 col-sm-6">
                            <div class='input-group date' id='start_date' style="background: #fff; cursor: pointer; padding: 8px 8px; border: 1px solid #ccc; width: 100%">
                                     <i class="fa fa-calendar" style="margin-top: 3px;margin-left: -5px;padding-right: 2px;"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down" style="margin-top: 2px;margin-left: 2px;"></i>
                                </div>
                        </div>

                        <input type="hidden" name="start_date" class="from_date">
                        <input type="hidden" name="end_date" class="to_date">
                        <input type="hidden" class="from_date_last">
                        <input type="hidden" class="to_date_last">                        
                        

                         <div class="col-md-3 col-sm-6">
                            <div class="form-group">                               
                                    <select class="form-control search_type" name="type">
                                       <!--  <option value="">Please Select Type</option> -->
                                            <option value="college">Colleges</option>
                                            <!-- <option value="office">Offices</option> -->
                                    </select>                               
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 colleges">
                            <div class="form-group">                               
                                    <select class="form-control college_list" name="college_office_list">
                                        <option value="">Please Select College</option>
                                        <?php
                                        if($colleges)
                                        {
                                            foreach ($colleges as $key => $value_colleges)
                                            {
                                            ?>
                                            <option value="<?php echo $value_colleges->id ?>"><?php echo $value_colleges->college_trading_name; ?></option>    
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>                               
                            </div>
                        </div>

                        <?php /*
                        <div class="col-md-3 col-sm-6 offices d-none">
                            <div class="form-group">                               
                                    <select class="form-control office_list" name="office_list">
                                        <option value="">Please Select Offices</option>
                                        <?php
                                        if($offices)
                                        {
                                            foreach ($offices as $key => $value_offices)
                                            {
                                            ?>
                                            <!-- <option value="<?php // echo $value_offices->id ?>"><?php // echo $value_offices->name; ?></option>     -->
                                            <?php
                                          /*  }
                                        }*/
                                        ?>                                        
                                    <!-- </select>                               
                            </div>
                        </div> -->

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

<div class="row">
<div class="col-md-12 col-sm-6">
   <div id="student_count"></div>
</div>

</div>

<div id="payment_div"></div>

<div id="pending_comm_div"></div>

<div id="pending_bonus_div"></div>

<div id="discount_div"></div>


</div>



 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript"> 

<?php if(($all_amount_count>0)){ ?>
    google.charts.load('current', {
  callback: function () {
    drawChart();
    window.addEventListener('resize', drawChart, false);
  },
  packages:['corechart']
});

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'Total Commission'],
     <?php  
      if(isset($all_amount_count_arr))
      {        
        foreach ($all_amount_count_arr as $key => $commission_data_value)
        {            
        ?>
    ['<?php echo $commission_data_value->college_office_name; ?>', <?php echo $commission_data_value->total_commission_received; ?>],
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
    title: 'Company Commission performance'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('student_count'));
  chart.draw(data, options);
}
<?php } ?>

<?php if(($all_bonus_count>0)){ ?>

google.charts.load('current', {
  callback: function () {
    corechart_payment();
    window.addEventListener('resize', corechart_payment, false);
  },
  packages:['corechart']
});

function corechart_payment() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'Total Bonus'],
     <?php 
      if(isset($all_bonus_count_arr))
      {        
        foreach ($all_bonus_count_arr as $key => $bonus_data_value)
        {            
        ?>
    ['<?php echo $bonus_data_value->college_office_name; ?>', <?php echo $bonus_data_value->total_bonus; ?>],
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
    title: 'Company Bonus Performance'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('payment_div'));
  chart.draw(data, options);
}
<?php } ?>

<?php if(($all_pending_comm_count>0)){ ?>
google.charts.load('current', {
  callback: function () {
    pending_commission();
    window.addEventListener('resize', pending_commission, false);
  },
  packages:['corechart']
});

function pending_commission() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'Total Pending Commission'],
     <?php 
      if(isset($all_pending_comm_count_arr))
      {        
        foreach ($all_pending_comm_count_arr as $key => $pending_comm_data_value)
        {            
        ?>
    ['<?php echo $pending_comm_data_value->college_office_name; ?>', <?php echo $pending_comm_data_value->total_commission_pending; ?>],
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
    title: 'Pending Commission'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('pending_comm_div'));
  chart.draw(data, options);
}

<?php } ?>

<?php if(($all_pending_bonus_data_count>0)){ ?>
google.charts.load('current', {
  callback: function () {
    pending_bonus();
    window.addEventListener('resize', pending_bonus, false);
  },
  packages:['corechart']
});

function pending_bonus() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'Total Pending Bonus'],
     <?php 
      if(isset($all_pending_bonus_data))
      {        
        foreach ($all_pending_bonus_data as $key => $pending_bonus_data_value)
        {            
        ?>
    ['<?php echo $pending_bonus_data_value->college_office_name; ?>', <?php echo $pending_bonus_data_value->total_pending_bonus-$pending_bonus_data_value->total_claimed_bonus; ?>],
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
    title: 'Pending Bonus'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('pending_bonus_div'));
  chart.draw(data, options);
}

<?php } ?>



<?php if(($all_discount_count>0)){ ?>
google.charts.load('current', {
  callback: function () {
    discount();
    window.addEventListener('resize', discount, false);
  },
  packages:['corechart']
});

function discount() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'Total Discount'],
     <?php 
      if(isset($all_discount_data))
      {        
        foreach ($all_discount_data as $key => $all_discount_data_value)
        {            
        ?>
    ['<?php echo $all_discount_data_value->college_office_name; ?>', <?php echo $all_discount_data_value->total_discount; ?>],
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
    title: 'Total Discount'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('discount_div'));
  chart.draw(data, options);
}

<?php } ?>


    $(document).ready(function()
    {
        $(document).on('change', '.search_type', function()
        {

            var selectedType = $(this).find("option:selected").text();
            if(selectedType == 'Colleges')
            {
                $('.colleges').removeClass('d-none');      
                $('.offices').addClass('d-none');      
            }
            else if(selectedType == 'Offices')
            {
                $('.colleges').addClass('d-none');      
                $('.offices').removeClass('d-none');
            }     
        });
    });


    $(document).on('click', '.search_students', function(){

        var from_date = $('.from_date').val(); 
        var to_date = $('.to_date').val();      
        var selectedType = $('.search_type').val();     
        var college = $('.college_list').val();     
        var office = $('.office_list').val();     
        
        $.ajax({
            type:'POST',
            url:"{{ route('/staff/commission_show_report') }}",
            data:{"_token": "{{ csrf_token() }}",start_date:from_date,end_date:to_date,selectedType:selectedType,college_id:college,office_id:office},
            success:function(data)
            {
                $('#student_count').html(data);              
            }
        });     
    });


</script>


@endsection