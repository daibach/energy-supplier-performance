// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawVisualization);

function drawVisualization() {
  // Some raw data (not necessarily accurate)
  var data = google.visualization.arrayToDataTable([
    ['Period', <?php foreach($suppliers as $supplier) : ?>'<?php echo $supplier->supplier_short_name; ?>',<?php endforeach; ?>],
    <?php foreach($periods as $key => $period) {
      //month 1
      echo "[";
      echo "'Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,1,'short')." ".$period->period_year.")',";
      foreach($suppliers as $k => $s) {
        echo $supplier_data[$k]['supplier_data'][$key]->month1.",";
      }
      echo "],\n";

      //month 2
      echo "[";
      echo "'Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,2,'short')." ".$period->period_year.")',";
      foreach($suppliers as $k => $s) {
        echo $supplier_data[$k]['supplier_data'][$key]->month2.",";
      }
      echo "],\n";

      //month 3
      echo "[";
      echo "'Q".$period->period_quarter." (".identify_quarter_month($period->period_quarter,3,'short')." ".$period->period_year.")',";
      foreach($suppliers as $k => $s) {
        echo $supplier_data[$k]['supplier_data'][$key]->month3.",";
      }
      echo "],\n";
    } ?>
  ]);

  var options = {
    vAxis: {title: "Weighted cases per 100,000 customers", minValue: 0},
    colors:['#3366CC','#DC3912','#FF9900','#109618','#990099','#0099C6','#CCCCCC'],
    height: 400,
    legend: 'bottom',
    pointSize: 4,
    curveType: 'none',
    chartArea: { width: "85%", top: "10%" },
    hAxis: { maxAlternation: 2, minTextSpacing: 0 },
    tooltip: { showColorCode: true },
    titlePosition: 'none'
  };

  var chart = new google.visualization.LineChart(document.getElementById('graph'));
  chart.draw(data, options);
}