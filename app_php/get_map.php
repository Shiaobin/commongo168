<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$sql="select * from maplist where Online=1";
$db->query($sql);
$i=0;
$flag=false;
while($result=$db->fetch_array()){
	$news[$i]["mapLat"]=$result["mapLat"];
	$news[$i]["mapLng"]=$result["mapLng"];
	$news[$i]["mapId"]=$result["mapId"];
	$news[$i]["mapName"]=$result["mapName"];
	$news[$i]["mapAddr"]=$result["mapAddr"];
	$news[$i]["pic"]=$result["imgfull"];
	$i++;
	$flag=true;
}
if($flag){
	$response["news"]=$news;
	$response["success"] = 1;
}else{
	$response["success"] = 0;
	$response["message"] = "No news found";
}
echo json_encode($response);
$db->close();
?>
