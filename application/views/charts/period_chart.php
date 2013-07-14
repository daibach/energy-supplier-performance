// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawVisualization);

function drawVisualization() {
  // Some raw data (not necessarily accurate)
  var data = google.visualization.arrayToDataTable([
    ['Supplier', 'Weighted cases per 100,000 customers', 'Average'],
    <?php foreach($period_data as $supplier) {
      echo "['$supplier->supplier_short_name (".add_ordinal_suffix($supplier->ranking).")', $supplier->period_average, $period_average->period_average],";
    } ?>
  ]);

  var options = {
    vAxis: {title: "Weighted cases per 100,000 customers", minValue:0},
    seriesType: "bars",
    series: {1: {type: "line"}},
    colors: ['#006c78', '#000'],
    height: 400,
    legend: 'bottom'
  };

  var chart = new google.visualization.ComboChart(document.getElementById('graph'));
  chart.draw(data, options);
}