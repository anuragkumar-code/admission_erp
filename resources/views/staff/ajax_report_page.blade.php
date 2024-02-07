<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  


<script type="text/javascript"> 
<?php if(($all_student_count>0)){ ?>
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
     <?php  
      if(isset($all_student_count_arr))
      {        
        foreach ($all_student_count_arr as $key => $student_data_value)
        {            
        ?>
    ['<?php echo $student_data_value->college_office_name; ?>', <?php echo $student_data_value->total; ?>],
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
    title: 'Company Performance'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('student_count'));
  chart.draw(data, options);
}

<?php } ?>

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
    ['College', 'From Bank', 'From Cash'],
     <?php 
      if(isset($all_amount_count_arr))
      {        
        foreach ($all_amount_count_arr as $key => $amount_data_value)
        {            
        ?>
    ['<?php echo $amount_data_value->college_office_name; ?>', <?php echo $amount_data_value->total_cash_received; ?>, <?php echo $amount_data_value->total_bank_transfer_received; ?>],
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
    title: 'Company Performance'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('payment_div'));
  chart.draw(data, options);
}
<?php } ?>
</script>