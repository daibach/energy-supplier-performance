// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawVisualization);

function drawVisualization() {
  // Some raw data (not necessarily accurate)
  var data = google.visualization.arrayToDataTable([
  <?php if($is_average_supplier) : ?>
    ['Period', '<?php echo $supplier->supplier_short_name; ?>'],
    <?php foreach($period_data as $key => $period) {
      echo "['Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,1,'short')." ".$period->period_year.")', $period->month1],";
      echo "['Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,2,'short')." ".$period->period_year.")', $period->month2],";
      echo "['Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,3,'short')." ".$period->period_year.")', $period->month3],";
    } ?>
  <?php else : ?>
    ['Period', '<?php echo $supplier->supplier_short_name; ?>', 'Average'],
    <?php foreach($period_data as $key => $period) {
      echo "['Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,1,'short')." ".$period->period_year.")', $period->month1, ".$average_data[$key]->month1."],";
      echo "['Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,2,'short')." ".$period->period_year.")', $period->month2, ".$average_data[$key]->month2."],";
      echo "['Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,3,'short')." ".$period->period_year.")', $period->month3, ".$average_data[$key]->month3."],";
    } ?>
  <?php endif; ?>
  ]);

  var options = {
    vAxis: {title: "Weighted cases per 100,000 customers", minValue: 0},
    colors: ['<?php echo $line_colour; ?>', '#ccc'],
    height: 400,
    legend: 'bottom',
    pointSize: 6,
    lineWidth: 3,
    curveType: 'none',
    fontSize: 11

  };

  var chart = new google.visualization.LineChart(document.getElementById('graph'));
  chart.draw(data, options);
}