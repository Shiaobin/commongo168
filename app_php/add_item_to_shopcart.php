<?php

//require_once("data/db_info.php");
require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET=utf8");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$mem_id=$_POST["mem_id"];
$ord_id = $_POST["ord_id"];
$goods_id = $_POST["goods_id"];
$goods_name = $_POST["goods_name"];
$goods_price = $_POST["goods_price"];
$goods_img	 = $_POST["goods_img"];
$goods_stand=$_POST["goods_stand"];
if($ord_id==""){
	$sql="select * from shop_car where mem_no=".$mem_id;
	$result = mysql_query($sql);
	if($result=mysql_fetch_assoc($result)){
		$ord_id=$result["ord_id"];
	}else{
		$ord_id=time();
	}
}
$sql="select * from prodmain where ProdId='".$goods_id."'";
$result = mysql_query($sql);
if($result=mysql_fetch_assoc($result)){
	$goods_name=$result["ProdName"];
}

$query = "SELECT * FROM shop_car where ord_id = '$ord_id' AND goods_id = '$goods_id'";
$result = mysql_query($query) or die(musql_error());

$rows = array();
while ($r = mysql_fetch_assoc($result)) {
    $rows[] = $r;
}

if ($rows == null) {
	$query = "INSERT INTO shop_car(ord_id,mem_no, goods_id, goods_name, goods_price, goods_img, ord_sum,goods_stand) VALUES ('$ord_id','$mem_id', '$goods_id', '$goods_name', '$goods_price', '$goods_img', '$goods_price', '$goods_stand')";
}
else {
    $ord_sum = ($rows['ord_num'] + 1) * $goods_price;
    $query = "UPDATE shop_car SET ord_num = ord_num + 1 where goods_id = '$goods_id'";
    mysql_query($query) or die (mysql_error("error"));
    $query = "UPDATE shop_car SET ord_sum = ord_num * goods_price where goods_id = '$goods_id'";
}
if(mysql_query($query)){
	$response["success"]=1;
	$response["order_id"]=$ord_id;
}else{
	$response["success"]=0;
	$response["order_id"]="";
}
echo json_encode($response);
mysql_close();
?>
