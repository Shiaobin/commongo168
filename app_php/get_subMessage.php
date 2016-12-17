<?php

require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET=utf8"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$msg_no = $_GET["msg_no"];

$query = "SELECT * FROM shop_member_sub_msg WHERE msg_no='$msg_no'";
$result = mysql_query($query) or die(musql_error());
mysql_close();

// array for JSON response 
$response = array(); 

// check for empty result 
if (mysql_num_rows($result) > 0) { 
 	// looping through all results 
    // products node 
    $response["message"] = array(); 
 
    while ($row = mysql_fetch_assoc($result)) {
      // temp user array 
      $message = array(); 
	  $message["sub_msg_no"] = $row["sub_msg_no"];
      $message["msg_no"] = $row["msg_no"];
	  $message["mem_nickname"] = $row["mem_nickname"];
	  $message["msg_send"] = $row["msg_send"];
	  $message["msg_img"] = $row["msg_img"];
	  $message["sub_msg_date"] = $row["sub_msg_date"];
      
      // push single product into final response array 
      array_push($response["message"], $message); 
    }
    
    // success 
    $response["success"] = 1; 
    
    // echoing JSON response 
    echo json_encode($response);
} 
else { 
    // no products found 
    $response["success"] = 0; 
    $response["message"] = "No products found"; 
  
    // echo no users JSON 
    echo json_encode($response); 
} 
?> 