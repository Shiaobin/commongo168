<?php
header("Content-Type:text/html; charset=utf-8");
include_once('PHP-master/AioSDK/sdk/AllPay.Payment.Integration.php');
include("connections/webshop.php");
try
{
 $oPayment = new AllInOne();
 /* 服務參數 */
 $oPayment->HashKey = "";
 $oPayment->HashIV = "";
 $oPayment->MerchantID ="";
/* 取得回傳參數 */
 $arFeedback = $oPayment->CheckOutFeedback();
 /* 檢核與變更訂單狀態 */
 if (sizeof($arFeedback) > 0) {
 foreach ($arFeedback as $key => $value) {
 switch ($key)
 {
 /* 支付後的回傳的基本參數 */
 case "MerchantID": $szMerchantID = $value; break;
 case "MerchantTradeNo": $szMerchantTradeNo = $value; break;
 case "PaymentDate": $szPaymentDate = $value; break;
 case "PaymentType": $szPaymentType = $value; break;
 case "PaymentTypeChargeFee": $szPaymentTypeChargeFee = $value; break;
 case "RtnCode": $szRtnCode = $value; break;
 case "RtnMsg": $szRtnMsg = $value; break;
 case "SimulatePaid": $szSimulatePaid = $value; break;
 case "TradeAmt": $szTradeAmt = $value; break;
 case "TradeDate": $szTradeDate = $value; break;
 case "TradeNo": $szTradeNo = $value; break;
 default: break;
 }
 }
 // 其他資料處理。
 /*echo "商家編號".$szMerchantID."<br>";
 echo "訂單編號".$szMerchantTradeNo."<br>";
 echo "付款時間".$szPaymentDate."<br>";
 echo "付款方式".$szPaymentType."<br>";
 echo "通路費".$szPaymentTypeChargeFee."<br>";
 echo "付款狀態".$szRtnCode."<br>";
 echo "交易訊息".$szRtnMsg."<br>";
 echo "模擬付款".$szSimulatePaid."<br>";
 echo "交易金額".$szTradeAmt."<br>";
 echo "訂單成立時間".$szTradeDate."<br>";
 echo "AllPay交易編號".$szTradeNo."<br>";*/

 
 
 if(isset($_GET['OrderNum']) && $szRtnCode==1){
	 
	 $query="UPDATE orderlist SET PayStatus='1' WHERE OrderNum='".$_GET['OrderNum']."'";
 	 $result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
 	}
 	header('location:my_order_detail.php?OrderNum='.$_GET['OrderNum']);
 } else {
 
 if(isset($_GET['OrderNum'])){
	 
	 $query="UPDATE orderlist SET PayStatus='0' WHERE OrderNum='".$_GET['OrderNum']."'";
 	 $result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
 	}
	header('location:my_order_detail.php?OrderNum='.$_GET['OrderNum']);
 }
}
catch (Exception $e)
{
 // 例外錯誤處理。
 print '0|' . $e->getMessage();
 header('location:my_order_detail.php?OrderNum='.$_GET['OrderNum']);
}
?>