<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$id=$_POST["mem_id"];
$orderId=$_POST["ord_id"];
$sql="select * from usermain where usernum=".$id;
$db->query($sql);
$flag=false;
if($result=$db->fetch_array()){
	$userId=$result["UserId"];
	$sql="select P.ProdName,O.BuyPrice,O.ProdUnit,P.ImgFull from orderdetail O,prodmain P where O.OrderNum='".$orderId."' and O.UserId='".$userId."' and P.ProdId=O.ProdId";
	$db->query($sql);
	$i=0;
	while($row=$db->fetch_array()){
		$flag=true;
		$product[$i]["name"] = $row["ProdName"];
		$product[$i]["price"] = $row["BuyPrice"];
		$product[$i]["unit"] = $row["ProdUnit"];
		$product[$i]["img"] = $row["ImgFull"];
		$i++;
	}
}
if($flag){
	$response["success"] = 1;
	$response["order"] = $product;
}else{
	$response["success"] = 0;
	$response["order"] = "no product found";
}
echo json_encode($response); 
$db->close();
?>
