<?php

require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET=utf8"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$ord_id = $_POST["ord_id"];
$mem_id = $_POST["mem_id"];
if($ord_id!=null && $ord_id!="")
	$query = "SELECT * FROM shop_car where ord_id = '$ord_id'";
else
	$query = "SELECT * FROM shop_car where mem_no = '$mem_id'";
$result = mysql_query($query) or die(musql_error());
mysql_close();

// array for JSON response 
$response = array(); 

// check for empty result 
if (mysql_num_rows($result) > 0) { 
 	// looping through all results 
    // products node 
    $response["products"] = array(); 
 
    while ($row = mysql_fetch_assoc($result)) {
      // temp user array 
      $product = array(); 
      $product["temp_no"] = $row["temp_no"];
	  $product["ord_id"] = $row["ord_id"];
      $product["goods_id"] = $row["goods_id"];
      $product["goods_name"] = $row["goods_name"];
      $product["goods_price"] = $row["goods_price"];
      $product["goods_stand"] = $row["goods_stand"];
      $product["goods_img"] = $row["goods_img"];
      $product["ord_num"] = $row["ord_num"];
	  $product["ord_sum"] = $row["ord_sum"];
      
      // push single product into final response array 
      array_push($response["products"], $product); 
    }
    
    // success 
    $response["success"] = 1; 
    
    // echoing JSON response 
    echo json_encode($response);
} 
else { 
    // no products found 
    $response["success"] = 0; 
	$time=time();
    $response["ord_id"] = $time; 
  
    // echo no users JSON 
    echo json_encode($response); 
} 

?> 