<?php

require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET=utf8");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$id = $_POST["mem_id"];
$ord_id = date("YmdHis").$id;
$ord_name = $_POST["ord_name"];
$ord_tel = $_POST["ord_tel"];
$ord_email = $_POST["ord_email"];
$ord_address = $_POST["ord_address"];
$ord_msg=$_POST["ord_msg"];
$productID=$_POST["productID"];
$num=$_POST["num"];
$fei=$_POST["fei"];
$ord_sum=0;
function addCartToOrder($id, $ord_id,$UserId,$kou,$productID,$num){
	for($i=0;$i<count($productID);$i++){
    $query = "SELECT * FROM prodmain where ProdId = '".$productID[$i]."'";
    $result = mysql_query($query) or die(musql_error());

	if(mysql_num_rows($result)>0) {
		$total = 0;

		if ($rows = mysql_fetch_assoc($result)) {
    		$goods_id = $rows["ProdId"];
    		$goods_name = $rows["ProdName"];
    		$goods_price = $rows["PriceList"];
    		$ord_num = $num[$i];
    		$ord_sum += $rows["PriceList"]*$num[$i];


    		$query = "INSERT INTO orderdetail(OrderNum,UserId, ProdId, ProdName, BuyPrice, ProdUnit)
    				  VALUES ('$ord_id', '$UserId','$goods_id', '$goods_name', '$goods_price', '$ord_num')";
    		mysql_query($query) or die (mysql_error("error"));
		}
	}
	}
	return $ord_sum;
}

function deleteCartItem($id){
    $query = "DELETE FROM shop_car where mem_no = '$id'";

    mysql_query($query) or die (mysql_error("error"));
}
$sql="select * from usermain where usernum='".$id."'";

$result=mysql_query($sql);
if($result=mysql_fetch_assoc($result)){
	$UserId=$result["UserId"];
	$UserKou=$result["UserKou"];
}
$sql="select kou".$UserKou." from shopsetup";

$result=mysql_query($sql);
if($results=mysql_fetch_assoc($result)){
	$kou=$results["kou".$UserKou];
}
$ord_sum = addCartToOrder($id,$ord_id,$UserId,$kou,$productID,$num);
//deleteCartItem($id);
$total = $ord_sum*$kou/10+$fei;
$query = "INSERT INTO orderlist(OrderNum, UserId, OrderSum, RecName, RecAddress, RecPhone , RecMail , Notes) VALUES ('$ord_id', '$UserId', '$total', '$ord_name', '$ord_address', '$ord_tel','$ord_email','$ord_msg')";

if(mysql_query($query)){
	$response["success"]="1";
}else{
	$response["success"]="0";
}
echo json_encode($response);
mysql_close();

?>
