<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       <script type="text/javascript">
   google.charts.load('current', {'packages':['sankey']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = new google.visualization.DataTable();
  data.addColumn('string', 'From');
  data.addColumn('string', 'To');
  data.addColumn('number', 'Weight');
  data.addRows([

<?php
		$colname=rtrim(file_get_contents('col.txt'));
		$m = new MongoClient();
$c = $m->selectDB("retention")->selectCollection($colname);

$pipeline = array(
		  array(
			'$group' => array(
					  '_id' => array('w1' => '$w1', 'w2' => '$w2'),
					  'count' => array('$sum' => 1),
					  )
			),
		  array(
			'$match' => array(
					  'count' => array('$gte' => 0)
					  )
			),
		  array(
			'$sort' => array(
					 'count' => -1
					 )
			),
		  );
$out = $c->aggregate($pipeline);
$many=count($out["result"]);
foreach($out["result"] as $line){
  $w1 = strtolower($line["_id"]["w1"]);
  $w2 = strtolower($line["_id"]["w2"]);
  if(strcmp($w1, $w2) > 0)
    echo "[\"" . $w1 . "\",\"" . $w2 . "\",1],\n";
  else if(strcmp($w1, $w2) < 0)
    echo "[\"" . $w2 . "\",\"" . $w1 . "\",1],\n";
}
//echo file_put_contents("out.txt", $content);
//echo $content;
//var_dump($out["result"]);
?>

		]);

  // Sets chart options.
  var options = {
  width: 600,
  };

  // Instantiates and draws our chart, passing in some options.
  var chart = new google.visualization.Sankey(document.getElementById('sankey_basic'));
  chart.draw(data, options);
}
    </script>
      </head>
      <body>
        <div id="sankey_basic" style="width: 610px; height: <?php echo $many*20; ?>px;"></div>
    </body>
  </html>