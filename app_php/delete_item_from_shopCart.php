<?php

require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET=utf8"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$temp_no = $_POST["temp_no"];

$query = "DELETE FROM shop_car where temp_no = '$temp_no'";
if(mysql_query($query))
	$response["success"]="1";
else
	$response["success"]="0";
echo json_encode($response);
mysql_close();
?>
