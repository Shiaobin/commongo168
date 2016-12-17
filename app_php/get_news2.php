<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

$sql="select * from news where Online=1 order by PubDate DESC";
$db->query($sql);
$i=0;
$flag=false;
while($result=$db->fetch_array()){
	$news[$i]["title"]=$result["NewsTitle"];
	//$news[$i]["content"]=$result["NewsContain"];
	$news[$i]["id"]=$result["NewsID"];
	$news[$i]["pic"]=$result["imgfull"];
	$news[$i]["date"]=$result["PubDate"];
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
