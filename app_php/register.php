<?php

require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER_SET=utf8"); 
mysql_query("SET CHARACTER_SET_CLIENT=utf8"); 
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$mem_nickname = $_POST["mem_nickname"];
$mem_id = $_POST["mem_id"];
$mem_pass = $_POST["mem_pass"];

$query = "INSERT INTO usermain (UserName, UserId, UserPassword,UserKou) VALUES ('$mem_nickname', '$mem_id', '$mem_pass',1)";



// mysql_query($query) or die (mysql_error());

$r = mysql_query($query);


if(!$r){
	$response["success"]=0;
die (mysql_error());
}else{
	$response["success"]=2;
}

mysql_close();
echo json_encode($response);

?>
