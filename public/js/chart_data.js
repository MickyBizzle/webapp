var array = [];

$(document).ready(function() {
  $.each(data, function(index, value) {
    var tempArr = [index+1];
    $.each(JSON.parse(value.data), function(index, value) {
      tempArr.push(parseFloat(value.value));
    });
    array.push(tempArr);
  });

  google.charts.load('current', {packages: ['line']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    // Define the chart to be drawn.
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Time elapsed (seconds)');
    data.addColumn('number', 'Beats Per Minute');
    data.addColumn('number', 'Skin Temperature');
    data.addColumn('number', 'Galvanic Skin Resistance');

    data.addRows(array);

    var options = {
      chart: {
        title: 'Results',
        legend: { position: 'bottom' },
      }
    };

    // Instantiate and draw the chart.
    var chart = new google.charts.Line($('.data_chart')[0]);
    chart.draw(data, google.charts.Line.convertOptions(options));
  }

});
