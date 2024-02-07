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
    title: 'Company Student'
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



<?php if(($all_admission_count>0)){ ?>
google.charts.load('current', {
  callback: function () {
    corechart_admission_fees();
    window.addEventListener('resize', corechart_admission_fees, false);
  },
  packages:['corechart']
});

function corechart_admission_fees() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'From Bank (Income)', 'From Cash (Income)', 'From Bank (Total Recieve)', 'From Cash (Total Recieve)'],
     <?php 
      if(isset($all_admission_count_arr))
      {        
        foreach ($all_admission_count_arr as $key => $all_admission_count_val)
        {            
        ?>
    ['<?php echo $all_admission_count_val->college_office_name; ?>', <?php echo $all_admission_count_val->total_admission_income_bank; ?>, <?php echo $all_admission_count_val->total_admission_income_cash; ?>, <?php echo $all_admission_count_val->rec_admission_fees_bank; ?>, <?php echo $all_admission_count_val->rec_admission_fees_cash; ?>],
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
    title: 'Admission Fees Record'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('admission_fees_div'));
  chart.draw(data, options);
}
<?php } ?>



<?php if(($all_material_count>0)){ ?>
google.charts.load('current', {
  callback: function () {
    corechart_material_fees();
    window.addEventListener('resize', corechart_material_fees, false);
  },
  packages:['corechart']
});

function corechart_material_fees() {
  var data = google.visualization.arrayToDataTable([
    ['College', 'From Bank (Income)', 'From Cash (Income)', 'From Bank (Total Recieve)', 'From Cash (Total Recieve)'],
     <?php 
      if(isset($all_material_count_arr))
      {        
        foreach ($all_material_count_arr as $key => $all_material_count_val)
        {            
        ?>
    ['<?php echo $all_material_count_val->college_office_name; ?>', <?php echo $all_material_count_val->total_material_income_bank; ?>, <?php echo $all_material_count_val->total_material_income_cash; ?>, <?php echo $all_material_count_val->rec_material_fees_bank; ?>, <?php echo $all_material_count_val->rec_material_fees_cash; ?>],
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
    title: 'Material Fees Record'
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('material_fees_div'));
  chart.draw(data, options);
}
<?php } ?>
</script>