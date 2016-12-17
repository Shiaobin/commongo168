<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$sql="select * from prodmain where ProdId='".$_GET["goods_id"]."'";
$db->query($sql);
$i=0;
while($result=$db->fetch_array()){
	$list[$i]["img_name"]= $result["ImgFull"];
	$flag=true;
	$i++;
}
if($flag){
	$response["images"]=$list;
	$response["success"]=1;
}else{
	$response["message"]="no image";
	$response["success"]=0;
}
echo json_encode($response);
$db->close();
?>
