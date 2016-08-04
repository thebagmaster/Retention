<!DOCTYPE html>
<html>
<head>
<title>Retention</title>
<style media="screen" type="text/css">
input {
 height:20px;
 width:220px;
 padding:5px 8px;
 }
input:focus {
 border:1px solid cyan;
 }
</style>
</head>

<body onload="populate();">
<script type="text/javascript">
   //https://chrome.google.com/webstore/detail/ignore-x-frame-headers/gleekbfjekiniecknbkamfmkohkpodhe/related
   function populate(){
   var rnd = Math.floor((Math.random() * document.getElementById("words").options.length));
   var word = document.getElementById("words").options[rnd].value;
   document.getElementById("w1").value = word;
   document.getElementById("link").href += word;
}
</script>
<?php
$colname=rtrim(file_get_contents('col.txt'));
$m = new MongoClient(); // connect
$db = $m->selectDB("retention");
$col = $db->createCollection($colname);
if(!empty($_POST["w1"] && !empty($_POST["w2"]))){
  $col->insert(array("w1"=>$_POST["w1"],"w2"=>$_POST["w2"],"date"=>new MongoDate()));
  //  echo "Relation Added";
}
?>
<form action="" method="POST" enctype="multipart/form-data">
<datalist id="words">
<?php
  $root = realpath($_SERVER["DOCUMENT_ROOT"]);
  $lines = file("$root/google-dic.txt");
foreach ($lines as $line_num => $line) {
  $line=trim($line);
  echo "<option value='$line'>";
}
?>
</datalist>
<a id="link" href="http://www.google.com/search?q=" target="_blank">
<input id="w1" name="w1" list="words" size="15" type="text">
</a>
<input name="w2" list="words" size="15" type="text" autofocus>
<input type="submit" style="position: absolute; left: -9999px"/>
</form>
  <br>
  <a href="map.php">Map</a>
</body>

</html>
