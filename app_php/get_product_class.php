<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$sql="select * from prodclass C, prodmain N where C.LarCode=N.LarCode and C.MidCode=N.MidCode and N.Online=1 order by N.LarCode,N.MidCode desc";
$db->query($sql);
$i=0;
$j=0;
$k=0;
$tempLarCode="";
//$checkLarCode=0;
$tempMidCode="";
$MidPic="";
//$checkMidCode=0;
while($result=$db->fetch_array()){
//	var_dump($result);
//	echo "<br>";
	if($tempLarCode!=$result["LarCode"]){
		if($j!=0){
			$SecondClass[$k-1]["ProductLength"]=count($list);
		//	echo count($list)."====<br>";
		//	$SecondClass[$k]["product"]=$list;
		//	$FirstClass[$j-1]["Level2Length"]=count($SecondClass);
			$FirstClass[$j-1]["Level2"]=$SecondClass;
		//	var_dump($SecondClass);
		//	echo "====<br>";
			$i=0;
			//$j=0;
			$k=0;
			unset($list);
			$list = array();
			unset($SecondClass);
			$SecondClass = array();
		}
		$tempLarCode=$result["LarCode"];
		$FirstClass[$j]["Level1Name"]=$result["LarCode"];
	//	echo "first class =".$j." = ".$result["LarCode"]."<br>";
		$j++;
	}
	if($tempMidCode!=$result["MidCode"]){
		if($k!=0){
			$SecondClass[$k-1]["ProductLength"]=count($list);
		//	$SecondClass[$k-1]["product"]=$list;
			unset($list);
			$list = array();
			$i=0;
			//$k=0;
		}
		$tempMidCode=$result["MidCode"];
		$SecondClass[$k]["Level2ID"]=$result["ClassId"];
		$SecondClass[$k]["Level2Name"]=$result["MidCode"];
		$SecondClass[$k]["Level2Image"]=$result["pic"];
	//	var_dump($SecondClass);
	//	echo "===second==<br>";
	//	echo "second class =".$k." = ".$result["MidCode"]."<br>";
		$k++;
	}else{
		if(!$SecondClass){
			$tempMidCode=$result["MidCode"];
			$SecondClass[$k]["Level2ID"]=$result["ClassId"];
			$SecondClass[$k]["Level2Name"]=$result["MidCode"];
			$SecondClass[$k]["Level2Image"]=$result["pic"];
			$k++;
		}
	}
	$list[$i]["goods_no"]=$result["ProdNum"];
	$list[$i]["goods_id"]=$result["ProdId"];
	$list[$i]["goods_name"]=$result["ProdName"];
	$list[$i]["goods_img"]=$result["ImgFull"];
	$list[$i]["goods_price"]=$result["PriceList"];
	$list[$i]["goods_oprice"]=$result["PriceOrigin"];
	$list[$i]["discount"]=$result["discount"];
	$list[$i]["item_id"]=$result["ClassId"];
	$list[$i]["goods_desc"]=$result["ProdDisc"];

	$i++;
//	echo "product =".$i." = ".$result["ProdName"]."<br>";
	$flag=true;
}
	
	$SecondClass[$k-1]["ProductLength"]=count($list);
//	$SecondClass[$k-1]["product"]=$list;
	//$SecondClass[$k]["MidCode"]=$list;
//	$FirstClass[$j-1]["Level2Length"]=count($SecondClass);
	$FirstClass[$j-1]["Level2"]=$SecondClass;
	//$FirstClass[$j]["LarCode"]=$SecondClass;
	$response["Level1"]=$FirstClass;
	if($flag)
		$response["success"]=1;
	else{
		$response["success"]=0;
		$response["message"] = "No products found";
	}
	echo json_encode($response);
	$db->close();
?>
