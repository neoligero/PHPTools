<?php
/*
  example for tables
*/
$index = 0;
$data = array();
$array_products = Product::getProducts($_REQUEST["type"]);
foreach($array_products as $product)
{
  $data[$index] = array();
  $data[$index]["NAME"] = $product["NAME"]; //this is used like index for the search
  
  $content = "";
  $content .= "<td>".$product["ID"]."</td>";
  $content .= "<td>".$product["NAME"]."</td>";
  $content .= "<td>".$product["DESCRIPCTION"]."</td>";
  $content .= "<td>".$product["STOCK"]."</td>";
  if(isset($_REQUEST["image"])){
  	$content .= "<td width='85' height='70'><img src='".$product["PATH"]."' border ='0'/>";
  }
  $data[$index]["CONTENT"] = utf8_encode($content);
  $index++;
}

//passing data to javascript
echo "<script>var data = ".json_encode($data).";</script>";
?>
<html>
<head>
<script language='javascript'>
function repaint(){
  //I use a bit of jquery, but can be done with normal javascript
  var text_pressed = $("#text_filter").attr("value").toUpperCase();
  
  var index = 0;
  var content = "<table class='table_itune'>";
  	content += "<thead><th>ID</th>";
  	content += "<th>NAME</th>";
  	content += "<th>DESCRIPTION</th>";
  	content += "<th>STOCK</th>";
  	content += "<th>IMAGE</th></thead>";
  	content += "<tbody>";

  for(var i in data){
  	if(data[i].NAME.indexOf(text_pressed) != -1){
  		if(index % 2 == 0)
  			content += "<tr>";
  		else
  			content += "<tr class='odd'>";
  		content += data[i].CONTENT;
  		content += "</tr>";
  		index++;
  	}
  }
  content += "</tbody></table>";
  $("#div_content").html(content);
}
</script>
</head>
<body>
  <form name="search" method="post" action="contentFilter.php">
  	Select product:
  	<select name="type">
  		<option value="1">Informatica</option>
  		<option value="3">Consumables</option>
  		<option value="21">Peripherals</option>
  	</select>
  	Image:
  	<input type="checkbox" name="image" />
  	<input type="submit" value="Search" />
  </form>
</body>
<div>Filter: <input type="text" name="text_filter" id="text_filter" /></div>
<div id="div_content"></div>
<script>repaint();</script>
</html>
