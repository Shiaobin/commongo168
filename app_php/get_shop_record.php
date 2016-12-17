<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$id=$_POST["mem_id"];
$sql="select * from usermain where usernum=".$id;
$db->query($sql);
$flag=false;
if($result=$db->fetch_array()){
	$userId=$result["UserId"];
	$sql="select * from orderlist where UserId='".$userId."' order by OrderTime desc";
	$db->query($sql);
	$i=0;
	while($result=$db->fetch_array()){
		$list[$i]["OrderNum"]=$result["OrderNum"];
		$list[$i]["OrderTime"]=$result["OrderTime"];
		$list[$i]["OrderSum"]=$result["OrderSum"];
		$i++;
		$flag=true;
	}
}
$response["order"]=$list;
	if($flag)
		$response["success"]=1;
	else{
		$response["success"]=0;
		$response["message"] = "No order found";
	}
	echo json_encode($response);
	$db->close();
?>
