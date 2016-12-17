<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$sql="select * from prodclass C, prodmain N where C.LarCode=N.LarCode and C.MidCode=N.MidCode and C.ClassId='".$_GET["id"]."' and N.Online=1 order by N.LarCode,N.MidCode desc";
$db->query($sql);
$i=0;
while($result=$db->fetch_array()){
	$list[$i]["goods_no"]=$result["ProdNum"];
	$list[$i]["goods_id"]=$result["ProdId"];
	$list[$i]["goods_name"]=$result["ProdName"];
	$list[$i]["goods_img"]=$result["ImgFull"];
	$list[$i]["goods_price"]=$result["PriceList"];
	$list[$i]["goods_oprice"]=$result["PriceOrigin"];
	$list[$i]["discount"]=$result["discount"];
	$list[$i]["item_id"]=$result["ClassId"];
	$list[$i]["goods_desc"]=$result["ProdDisc"];
	$list[$i]["goods_spec"]=$result["MemoSpec"];
	$flag=true;
	$i++;
}
if($flag){
		$response["product"]=$list;
		$response["success"]=1;
	}else{
		$response["success"]=0;
		$response["message"] = "No products found";
	}
	echo json_encode($response);
$db->close();
?>
