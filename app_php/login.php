<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$id=$_POST["mem_id"];
$pwd=$_POST["mem_pass"];
$sql="select * from usermain where UserId='".$id."' and UserPassword='".$pwd."'";
$db->query($sql);
if($result=$db->fetch_array()){
	$kou=$result["UserKou"];
	$list[0]["mem_id"]=$result["usernum"];
	$list[0]["mem_name"]=$result["UserName"];
	$list[0]["mem_nickname"]=$result["UserName"];	
	$list[0]["mem_phone"]=$result["HomePhone"];
	$list[0]["mem_mail"]=$result["UserMail"];	
	$list[0]["mem_add"]=$result["Address"];
	$response["success"]=1;
	$sql="select kou".$kou." from shopsetup";
	$db->query($sql);
	if($result2=$db->fetch_array())
		$list[0]["mem_kou"]=$result2[0];	
	$response["member"]=$list;
}else{
	$response["success"]=0;
	$response["message"] = "No products found"; 
}


echo json_encode($response);
$db->close();
?>
