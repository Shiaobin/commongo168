<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "delform")) {
  /*$updateSQL = sprintf("UPDATE shop_car SET goods_price=%s, ord_num=%s, ord_sum=%s WHERE temp_no=%s",
                       GetSQLValueString($_POST['goods_price'], "int"),
                       GetSQLValueString($_POST['ord_num'], "int"),
					   GetSQLValueString($_POST['goods_price']*$_POST['ord_num'], "int"),
                       GetSQLValueString($_POST['temp_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
	$Cart->updateItem($_POST['car_num'], $_POST['ord_num']);
  $updateGoTo = "car.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  $url = $updateGoTo;
  echo "<script type='text/javascript'>";
  echo "window.location.href='$url'";
  echo "</script>";
}

if ((isset($_GET['car_num'])) && ($_GET['car_num'] != "") && (isset($_GET['del']))) {
  /*$deleteSQL = sprintf("DELETE FROM shop_car WHERE temp_no=%s",
                       GetSQLValueString($_GET['temp_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($deleteSQL, $webshop) or die(mysql_error());
*/
  $Cart->removeItem($_GET['car_num']);
  $deleteGoTo = "car.php";
  /*
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  */

  $url = $deleteGoTo;
  echo "<script type='text/javascript'>";
  echo "window.location.href='$url'";
  echo "</script>";
}

$currentPage = $_SERVER["PHP_SELF"];


$maxRows_productRec = 6;
$pageNum_productRec = 0;
if (isset($_GET['pageNum_productRec'])) {
  $pageNum_productRec = $_GET['pageNum_productRec'];
}
$startRow_productRec = $pageNum_productRec * $maxRows_productRec;

$LarCode = "-1";
if (isset($_GET['LarCode'])) {
  $LarCode = $_GET['LarCode'];
}
$MidCode = "-1";
if (isset($_GET['MidCode'])) {
  $MidCode = $_GET['MidCode'];
}
$ProdNum = "-1";
if (isset($_GET['ProdNum'])) {
  $ProdNum = $_GET['ProdNum'];
}



/*
mysql_select_db($database_webshop, $webshop);
$query_productRec = sprintf("SELECT * FROM ProdMain
LEFT JOIN Prod_img ON Prod_img.ProdId = ProdMain.ProdId
WHERE LarCode=%s && MidCode=%s && ProdNum=%s && Online='1'
order by img_no ASC", GetSQLValueString($LarCode, "text"),GetSQLValueString($MidCode, "text"),GetSQLValueString($ProdNum, "int"));
$query_limit_productRec = sprintf("%s LIMIT %d, %d", $query_productRec, $startRow_productRec, $maxRows_productRec);
$productRec = mysql_query($query_limit_productRec, $webshop) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);


if (isset($_GET['totalRows_productRec'])) {
  $totalRows_productRec = $_GET['totalRows_productRec'];
} else {
  $all_productRec = mysql_query($query_productRec);
  $totalRows_productRec = mysql_num_rows($all_productRec);
}
$totalPages_productRec = ceil($totalRows_productRec/$maxRows_productRec)-1;

$colname_carRec = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_carRec = $_SESSION['MM_Username'];
  $query_carRec = sprintf("SELECT * FROM shop_car WHERE mem_no = %s ORDER BY temp_no DESC", GetSQLValueString($colname_carRec, "text"));
}
else if (isset($_SESSION['tempord_id'])) {
  $colname_carRec = $_SESSION['tempord_id'];
  $query_carRec = sprintf("SELECT * FROM shop_car WHERE ord_id = %s ORDER BY temp_no DESC", GetSQLValueString($colname_carRec, "text"));
}
mysql_select_db($database_webshop, $webshop);
$carRec = mysql_query($query_carRec, $webshop) or die(mysql_error());
$row_carRec = mysql_fetch_assoc($carRec);
$totalRows_carRec = mysql_num_rows($carRec);
if($totalRows_carRec == 0) {
  $url = "index.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$url'";
  echo "</script>";
}

$queryString_productRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_productRec") == false &&
        stristr($param, "totalRows_productRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_productRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_productRec = sprintf("&totalRows_productRec=%d%s", $totalRows_productRec, $queryString_productRec);*/

?>


<p><font color="#FF3333"><b>您選擇的商品已經放入購物車，您現在可以前往收銀台支付，也可以繼續購物。<br> &nbsp; </b></font></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

  <!-------------------------------------------------------------->
  <?php if (sizeof( $car_items ) > 0) { // Show if recordset not empty ?>
    <tr bgcolor="#DFDFDF">
   	<td width="37%" align="center">商品名稱</td>
      <td width="6%" align="center">數量</td>
      <td width="16%" align="center">單價</td>
      <td width="19%" align="center">合計</td>
      <td width="19%" align="center">選項</td>
      <td width="15%" align="center">&nbsp;</td>
  	</tr>
    <!-------------------------------------------------------------->
    <?php
	  $total = 0;

	    foreach ($car_items as $key => $car_item )
		{ ?>
          <tr>
            <form method="POST" action="<?php echo $editFormAction; ?>" name="delform" id="delform">
            <td align="center"><font color="#0000FF"><?php echo $car_item->_goods_name; ?></font></td>
            <td align="center">
              <input id="ord_num" name="ord_num" type="text" style="width:20%; margin-right:2px" value="<?php echo $car_item->_goods_quantity; ?>"/>
            </td>
            <td align="center">NT$<?php echo $car_item->_goods_price; ?></td>
            <td align="center">NT$<?php echo $car_item->_goods_total; ?></td>
            <td align="center"><?php echo $car_item->_goods_spec_1; ?><br> <?php echo $car_item->_goods_spec_2; ?></td>
            <td align="center">
              <input name="goods_id" type="hidden" id="goods_id" value="<?php echo $car_item->_goods_id; ?>" />
              <input name="car_num" type="hidden" id="car_num" value="<?php echo $car_item->_car_num; ?>" />
              <input name="goods_price" type="hidden" id="goods_price" value="<?php echo $car_item->_goods_price; ?>" />
              <input type="submit" name="update" id="update" value="更新商品數量" /><p> </p>
              <input name="delete" type="submit" id="delete" onclick="MM_goToURL('parent','car.php?del=true&amp;car_num=<?php echo $car_item->_car_num;?>');return document.MM_returnValue" value="刪除此類商品" />
            </td>
            <input type="hidden" name="MM_update" value="delform" />
            </form>
          </tr>
      <?php
      $total=$total+($car_item->_goods_quantity*$car_item->_goods_price);
	} ?>
    <!-------------------------------------------------------------->
    <tr>
      <td align="right" colspan="6">總計NT$<?php echo $total; ?></td>
    </tr>
    <!-------------------------------------------------------------->
    <tr>
      <td align="left" colspan="6"><p style="line-height: 200%">如需修改商品數量，請填寫好新的數量，請點擊每項商品後方按鈕"<img src="../../images/goodsimg/button.PNG" alt="" name="image"
          id="image" align="center" style="padding:5px;"/>"</td>
    </tr>
  <?php } // Show if recordset not empty ?>
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="6" align="center">
      <input name="shopping" type="submit" id="shopping"
             onclick="MM_goToURL('parent','goods.php');return document.MM_returnValue" value="繼續購物" style="font-size:16px;width:150px;height:30px"/>
      <input name="buy" type="submit" id="buy"
             onclick="MM_goToURL('parent','order.php');return document.MM_returnValue" value="立即結帳" style="font-size:16px;width:150px;height:30px"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
</table>
<?php
//mysql_free_result($productRec);
//mysql_free_result($carRec);
?>
