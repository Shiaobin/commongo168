<?php

require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET=utf8"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$query = "INSERT INTO shop_user VALUES ('')";
mysql_query($query) or die("Error");

$query = "SELECT MAX(user_id) FROM shop_user";
$result = mysql_query($query) or die(musql_error());

mysql_close();

// array for JSON response 
$response = array(); 

// check for empty result 
if (mysql_num_rows($result) > 0) {  
	
	$row = mysql_fetch_assoc($result);
	$response["user_id"] = $row["MAX(user_id)"]; 

    // success 
    $response["success"] = 1; 

    // echoing JSON response 
    echo json_encode($response);
} 
else { 
    // no user found 
    $response["success"] = 0; 
    $response["message"] = "No user found"; 
  
    // echo no users JSON 
    echo json_encode($response); 
} 

?> 