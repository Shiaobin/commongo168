<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$sql="select * from compclass where LarSeq<100 order by LarCode asc";
$db->query($sql);
$i=0;
$temp="";
while($result=$db->fetch_array()){
	
	$pnum=$result["pnum"];
	if($pnum==0 && $temp==$result["LarCode"]){
	}else{
		$list[$i]["item_id"]=$result["ClassId"];
		$list[$i]["class_name"]=$result["LarCode"];
		$list[$i]["item_name"]=$result["MidCode"];
		$list[$i]["item_img"]=$result["pic"];
		$list[$i]["url"]=$result["url"];
		$list[$i]["pnum"]=$result["pnum"];
		$list[$i]["snum"]=$result["snum"];		
		$i++;
	}
	$temp=$result["LarCode"];
	$flag=true;
}

	$response["class"]=$list;
	if($flag)
		$response["success"]=1;
	else
		$response["success"]=0;
	echo json_encode($response);
	$db->close();
?>
