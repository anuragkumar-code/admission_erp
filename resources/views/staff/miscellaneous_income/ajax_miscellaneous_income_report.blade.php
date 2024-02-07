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
