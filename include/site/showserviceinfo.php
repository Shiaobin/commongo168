<?php  //-----------------------------取得商品支付說明資訊------------------------------------//
mysql_select_db($database_webshop, $webshop);
$query_showpaywayRec = "SELECT * FROM shop_payway";
$showpaywayRec = mysql_query($query_showpaywayRec, $webshop) or die(mysql_error());
$row_showpaywayRec = mysql_fetch_assoc($showpaywayRec);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>商品支付訊息</title>

<!-------------------------運送須知------------------------------->
<table width="96%" height="10%" border="1" BORDERCOLOR="#000000" cellpadding="5" cellspacing="0" >
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="3" align="left">
      <font color="#3300FF">運送及保固說明 : </font><?php echo $row_showpaywayRec["warranty"];?></td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="3" align="left">
      <font color="#3300FF">寄送時間 : </font><?php echo $row_showpaywayRec["send_time"];?></td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="3" align="left">
      <font color="#3300FF">送貨方式 : </font><?php echo $row_showpaywayRec["delievery_way"];?></td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="3" align="left">
      <font color="#3300FF">支付說明 : </font><?php echo $row_showpaywayRec["delievery_explain"];?></td>
  </tr>
  <!-------------------------------------------------------------->
</table>
<?php
mysql_free_result($showpaywayRec);
?>