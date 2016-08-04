<!DOCTYPE html>
<html>
<head>
<title>Retention Stats</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style media="screen" type="text/css">
</style>
<script type="text/javascript">
   google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
<?php

$m = new MongoClient(); // connect
$db = $m->selectDB("retention");
$dan = $db->createCollection("links")->count();
$cory = $db->createCollection("cory")->count();
$ryan = $db->createCollection("ryan")->count();
$celia = $db->createCollection("celia")->count();
$dallas = $db->createCollection("dallas")->count();

echo "var dan = $dan;";
echo "var ryan = $ryan;";
echo "var cory = $cory;";
echo "var celia = $celia;";
echo "var dallas = $dallas;";

?>
  var data = google.visualization.arrayToDataTable([
						    ["Person", "Answered", { role: "style" } ],
						    ["Dan", dan, "#35B1F3"],
						    ["Cory", cory, "#E8A30C"],
						    ["Ryan", ryan, "#F37735"],
						    ["Celia", celia, "#AA8CC5"],
						    ["Dallas", dallas, "#00CC00"]
						    ]);

  var view = new google.visualization.DataView(data);
  view.setColumns([0, 1,
		   { calc: "stringify",
		       sourceColumn: 1,
		       type: "string",
		       role: "annotation" },
		   2]);

  var options = {
  title: "Current Links",
  width: 600,
  height: 400,
  bar: {groupWidth: "95%"},
  legend: { position: "none" },
  };
  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
  chart.draw(view, options);
}

   
</script>
</head>

<body>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
</body>

</html>
