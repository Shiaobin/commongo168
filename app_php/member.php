<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$id=$_POST["id"];
$pwd=$_POST["oldPwd"];
$newPwd=$_POST["newPwd"];
$sql="select * from usermain where usernum=".$id." and UserPassword='".$pwd."'";
$db->query($sql);
$flag=false;
if($result=$db->fetch_array()){
	$sql="update usermain set UserPassword='".$newPwd."' where usernum=".$id;
	if($db->query($sql)){
		$flag=true;
	}
}

if($flag)
	$response["success"]="1";
else
	$response["success"]="0";
echo json_encode($response);
$db->close();
?>
