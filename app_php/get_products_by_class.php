<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$sql="select * from compclass C, compmain N where C.ClassId=".$_GET["item_id"]." and C.LarCode=N.LarCode and C.MidCode=N.MidCode and N.Online=1";
$db->query($sql);
$i=0;

while($result=$db->fetch_array()){
	$list[$i]["goods_no"]=$result["ProdNum"];
	$list[$i]["goods_id"]=$result["ProdId"];
	$list[$i]["goods_name"]=$result["ProdName"];
	$list[$i]["goods_img"]=$result["ImgFull"];
	$list[$i]["goods_price"]=$result["PriceList"];
	$list[$i]["item_id"]=$result["ClassId"];
	$list[$i]["goods_desc"]=$result["ProdDisc"];
	$list[$i]["goods_spec"]=$result["MemoSpec"];
	$i++;
	$flag=true;
}

	$response["products"]=$list;
	if($flag)
		$response["success"]=1;
	else
		$response["success"]=0;
	echo json_encode($response);
	$db->close();
?>
