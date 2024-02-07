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
</script>