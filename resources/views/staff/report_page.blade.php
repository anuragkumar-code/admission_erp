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
                    <form method="GET" action="{{ url('/staff/generate_report') }}" enctype="multipart/form-data" id="myform">
                    <!-- {{ csrf_field() }} -->
                    <div class="row">

                        <div class="col-md-3 col-sm-6">
                            <div class='input-group date' id='start_date' style="background: #fff; cursor: pointer; padding: 8px 10px; border: 1px solid #ccc; width: 100%">
                                     <i class="fa fa-calendar" style="margin-top: 3px;margin-left: -4px;padding-right: 2px;"></i>&nbsp;
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
                                        <option value="">Please Select Type</option>
                                            <option selected value="college">Colleges</option>
                                            <option value="office">Offices</option>
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

                        <div class="col-md-3 col-sm-6 offices d-none">
                            <div class="form-group">                               
                                    <select class="form-control office_list" name="office_list">
                                        <option value="">Please Select Offices</option>
                                        <?php
                                        if($user_type == 1)
                                         {
                                        if($offices)
                                        {
                                            foreach ($offices as $key => $value_offices)
                                            {                                          
                                            ?>
                                            <option value="<?php echo $value_offices->id ?>"><?php echo $value_offices->name; ?></option>    
                                            <?php
                                                }
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

<div class="row">

<div class="col-md-12 col-sm-12">
   <div id="student_count"></div>
</div>

</div>

<div id="payment_div"></div>


</div>



 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
google.charts.load('current', {
  callback: function () {
    drawChart();
    window.addEventListener('resize', drawChart, false);
  },
  packages:['corechart']
});

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'Total Student'],
    ['', 0],
     
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
    title: 'Company Performance'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('student_count'));
  chart.draw(data, options);
}

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
            url:"{{ route('/staff/show_report') }}",
            data:{"_token": "{{ csrf_token() }}",start_date:from_date,end_date:to_date,selectedType:selectedType,college_id:college,office_id:office},
            success:function(data)
            {
                $('#student_count').html(data);              
            }
        });     
    });


</script>





@endsection