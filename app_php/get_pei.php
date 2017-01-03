<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$sql="select * from shopsetup";
$db->query($sql);
if($result=$db->fetch_array()){
	for($i=0;$i<4;$i++){
		$list[$i]["pei"]=$result["pei".($i+1)];
		$list[$i]["fei"]=$result["fei".($i+1)];
	}
	$response["message"]=$list;
	$response["success"]=1;
}else{
	$response["success"]=0;
	$response["message"] = "No products found";
}
echo json_encode($response);
$db->close();
?>