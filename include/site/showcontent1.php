<?php require_once('../../connections/webshop.php'); ?>
<?php require('../../include/system.php'); ?>

<?php  //-----------------------------顯示商品資訊------------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$colname_productRec = "-1";
if (isset($_GET['goods_id'])) {
  $colname_productRec = $_GET['goods_id'];
}
mysql_select_db($database_webshop, $webshop);
$query_productRec = sprintf("SELECT goods_desc FROM shop_goods WHERE goods_id = %s", GetSQLValueString($colname_productRec, "text"));
$ContentRec = mysql_query($query_productRec, $webshop) or die(mysql_error());
$row_contentRec = mysql_fetch_assoc($ContentRec);
?>
<!--------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<title>顯示商品詳細內容</title>
<!-------------------------商品詳細說明------------------------------->
<p><?php echo $row_contentRec['goods_desc'];?></p>
<?php
mysql_free_result($ContentRec);
?>
