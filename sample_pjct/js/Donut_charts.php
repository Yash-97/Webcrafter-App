<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
  <div class="panel panel-default">
  <div class="panel-heading">Do_nut-Chart<span class="a"><a href="#">EDIT</a>
				</span></div>
    <div id="donutchart" style="width: 900px; height: 500px;">
	</div>
	</div>
  </body>
  <style>
.a {
	posiiton:absolute;
	padding-left:900px;
	color:#5f6468;
	font-size: 16px;
	text-transform: uppercase;
	font-weight: 500;
	letter-spacing: 2px;
}

</style>
</html>