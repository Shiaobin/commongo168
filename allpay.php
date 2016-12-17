<?php
header("Content-Type:text/html; charset=utf-8");
include_once('PHP-master/AioSDK/sdk/AllPay.Payment.Integration.php');
include("connections/webshop.php");
if(isset($_GET['OrderNum'])) $OrderNum=$_GET['OrderNum'];

$query_orderlist=  "select B.OrderTime,B.OrderNum,B.pei,B.fei,B.Memo,B.thiskou,B.RecName,B.RecPhone,B.RecMail,B.RecAddress,B.ZipCode,B.PayType,B.Discount,B.Notes,B.OrderSum,D.UserKou
		  from orderlist B,usermain D
		  where B.OrderNum='".$OrderNum."'";
$result_orderlist=mysql_query($query_orderlist, $webshop) or die("cannot connect to table" . mysql_error( ));
$num=mysql_num_rows($result_orderlist);

if($num==0){
header("location:index.php");
}
else
{
while($rs_orderlist = mysql_fetch_array($result_orderlist))
{ 

$query_orderdetail=  "select A.UserId,A.OrderNum,A.ProdUnit,A.ProdPrice,A.BuyPrice,A.goods_spec_1,A.goods_spec_2,C.ProdName,C.ProdNum,C.LarCode,C.MidCode,C.ProdId
		  from orderdetail A,prodmain C
		  where A.OrderNum='".$OrderNum."' and A.ProdId=C.ProdId";
$result_orderdetail=mysql_query($query_orderdetail, $webshop) or die("cannot connect to table" . mysql_error( ));
	while($rs_orderdetail = mysql_fetch_array($result_orderdetail))
	{
		$sum = $rs_orderdetail['ProdUnit']*$rs_orderdetail['BuyPrice'];
	}
?>

<?php $amount=floor(($rs_orderlist['OrderSum']*($rs_orderlist['thiskou']/10))+$rs_orderlist['fei']); ?>

<?php
/*
* 產生訂單的範例程式碼。
*/
	try
	{
 		$oPayment = new AllInOne();
 		/* 服務參數 */
 		$oPayment->ServiceURL ="https://payment.allpay.com.tw/Cashier/AioCheckOut";
 		$oPayment->HashKey = "";
 		$oPayment->HashIV = "";
 		$oPayment->MerchantID ="";
 		/* 基本參數 */
 		$format_time=explode(" ",$rs_orderlist['OrderTime']);
 		$Ymd=explode("-",$format_time[0]);
 		$new_time=$Ymd[0]."/".$Ymd[1]."/".$Ymd[2]." ".$format_time[1];
		$random=rand(10000,99999);
		$MerchantTradeNo=date('ymdhis').$random;
 		$oPayment->Send['ReturnURL'] = "http://www.v88t.com/receive.php?OrderNum=".$rs_orderlist['OrderNum'];
 		$oPayment->Send['ClientBackURL'] = "http://www.v88t.com/receive.php?OrderNum=".$rs_orderlist['OrderNum'];
 		$oPayment->Send['OrderResultURL'] = "http://www.v88t.com/receive.php?OrderNum=".$rs_orderlist['OrderNum'];
 		$oPayment->Send['MerchantTradeNo'] = $MerchantTradeNo;
 		$oPayment->Send['MerchantTradeDate'] = $new_time;
 		$oPayment->Send['TotalAmount'] = (int) $amount;
 		$oPayment->Send['TradeDesc'] = "蔘大王";
 		$oPayment->Send['ChoosePayment'] = PaymentMethod::ALL;
 		$oPayment->Send['Remark'] = "無備註";
 		$oPayment->Send['ChooseSubPayment'] = PaymentMethodItem::None;
 		$oPayment->Send['NeedExtraPaidInfo'] = ExtraPaymentInfo::No;
 		$oPayment->Send['DeviceSource'] = DeviceType::PC;
 		/* 加入選購商品資料。*/
		 array_push($oPayment->Send['Items'], array('Name' => "蔘大王", 'Price' => (int)$amount,
		'Currency' => "元", 'Quantity' => (int) "1", 'URL' => "<<產品說明位址>>"));

 		/* Alipay 延伸參數 */
 		$oPayment->SendExtend["Email"] = $rs_orderlist['RecMail'];
 		$oPayment->SendExtend["PhoneNo"] = $rs_orderlist['RecPhone'];
 		$oPayment->SendExtend["UserName"] = $rs_orderlist['RecName'];
 		/* 產生訂單 */
 		$oPayment->CheckOut();
 		/* 產生產生訂單 Html Code 的方法 */
 		$szHtml = $oPayment->CheckOutString();
	}
	catch (Exception $e)
	{
 		// 例外錯誤處理。
 		throw $e;
	}
}
}
?>