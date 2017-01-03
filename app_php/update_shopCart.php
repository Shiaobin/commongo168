<?php

require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET=utf8");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$temp_no = $_GET["temp_no"];
$ord_num = $_GET["ord_num"];

$query = "UPDATE shop_car SET ord_num = '$ord_num' where temp_no = '$temp_no'";
mysql_query($query) or die (mysql_error("error"));

$query = "UPDATE shop_car SET ord_sum = ord_num * goods_price where temp_no = '$temp_no'";
mysql_query($query) or die (mysql_error("error"));

mysql_close();
?>
