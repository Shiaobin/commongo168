<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
header("Content-type: application/json");
$id = $_GET["id"];
//echo $id;
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

//$sql="select * from news where Online=1 order by PubDate DESC";
$sql="select * from news where NewsID='$id' order by PubDate DESC";
//echo $sql;
$db->query($sql);
$i=0;
$flag=false;
while($result=$db->fetch_array()){
	$news[$i]["content"]=$result["NewsContain"];
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
