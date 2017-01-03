<?php
$currentPage = $_SERVER["PHP_SELF"];

//$sysConnDebug = true;
$ordName_mainRec = "a";
if (isset($_POST['RecName'])) {
  $ordName_mainRec = $_POST['RecName'];
}
$ordemail_mainRec = "b";
if (isset($_POST['RecMail'])) {
  $ordemail_mainRec = $_POST['RecMail'];
}
$ordPhone_mainRec = "c";
if (isset($_POST['RecPhone'])) {
  $ordPhone_mainRec = $_POST['RecPhone'];
}

$table_orderlist		= SYS_DBNAME . ".orderlist";
		$column = "*";
		$whereClause = "RecName='{$ordName_mainRec}' AND RecMail='{$ordemail_mainRec}' AND RecPhone='{$ordPhone_mainRec}'";

		$sql['list']['select'] = array(
				'mysql'	=> "SELECT * FROM {$table_orderlist} WHERE {$whereClause}",
				'mssql'	=> "SELECT * FROM {$table_orderlist} WHERE {$whereClause}",
				'oci8'	=> "SELECT * FROM {$table_orderlist} WHERE {$whereClause}"
		);
		$row_mainRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
		$totalRows_mainRec = sizeof($row_mainRec);

		/*
mysql_select_db($database_webshop, $webshop);
$query_mainRec = sprintf("SELECT * FROM orderlist WHERE RecName=%s AND RecMail=%s AND RecPhone=%s ORDER BY OrderTime DESC",
						GetSQLValueString($ordName_mainRec, "text"),
						GetSQLValueString($ordemail_mainRec, "text"),
						GetSQLValueString($ordPhone_mainRec, "text"));
$mainRec = mysql_query($query_mainRec, $webshop) or die(mysql_error());
$row_mainRec = mysql_fetch_assoc($mainRec);
$totalRows_mainRec = mysql_num_rows($mainRec);
*/
$table_orderdetail		= SYS_DBNAME . ".orderdetail";
		$column = "*";
		$whereClause = "OrderNum='{$row_mainRec['OrderNum']}'";

		$sql['list']['select'] = array(
				'mysql'	=> "SELECT * FROM {$table_orderdetail} WHERE {$whereClause}",
				'mssql'	=> "SELECT * FROM {$table_orderdetail} WHERE {$whereClause}",
				'oci8'	=> "SELECT * FROM {$table_orderdetail} WHERE {$whereClause}"
		);
		$row_subRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
		$totalRows_subRec = sizeof($row_subRec);
	/*
mysql_select_db($database_webshop, $webshop);
$query_subRec = sprintf("SELECT * FROM orderdetail WHERE OrderNum = %s", GetSQLValueString($row_mainRec['OrderNum'], "text"));
$subRec = mysql_query($query_subRec, $webshop) or die(mysql_error());
$row_subRec = mysql_fetch_assoc($subRec);
$totalRows_subRec = mysql_num_rows($subRec);
*/
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
?>

<!-------------------------錯誤訊息------------------------------->
<table width="96%"  height="30" border="0" BORDERCOLOR="#000000" cellpadding="0" id="error" class="chkord_serch_table">
  <?php if ($totalRows_mainRec == 0) { // Show if recordset empty ?>
    <?php if(isset($_POST['RecName'])){?>
      <tr>
        <td height="8%" align="center">
          <font color="#FF0000"><b>查無符合的訂單，請重新輸入訂單資料！</b></font>
        </td>
      </tr>
    <?php }?>
  <?php } // Show if recordset empty ?>
</table>
<!-------------------------訂單查詢------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<h3 class="ttl01">訂單查詢</h3>
<form action="" method="post" name="search">
<tr>
<th><p>收貨人姓名<b>※</b></p></th>
<td><input name="RecName" type="text" id="RecName" class="sizeM" /></td>
</tr>
<tr>
<th><p>收貨人電話<b>※</b></p></th>
<td><input name="RecPhone" type="text" id="RecPhone" class="sizeM" /></td>
</tr>
<tr>
<th><p>Email<b>※</b></p></th>
<td><input name="RecMail" type="text" id="RecMail" class="sizeM" /></td>
</tr>
<tr>
<td colspan="2" ><input name="search" type="submit" value="送出" class="submit03" /></td>
</tr>
</form>
</table>
<!-------------------------訂單資訊------------------------------->
<?php if ($totalRows_mainRec > 0) { // Show if recordset not empty ?>
<?php //do { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
          <!-------------------------------------------------------------->
          <tr>
            <th colspan="5"><p><b>訂單資訊</b></p></th>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <td>訂單編號</td>
            <td><?php echo $row_mainRec['OrderNum']; ?></td>
            <td>訂單日期</td>
            <td colspan="2"><?php echo $row_mainRec['OrderTime']; ?></td>
          </tr>
          <tr>
            <td>送達時間</td>
            <td> <?php echo $row_mainRec['Gettime']; ?></td>
            <td>訂單狀態</td>
            <td colspan="2"><font color="#0000FF"><?php echo $row_mainRec['Status']; ?></font></td>
          </tr>
          <tr>
            <td>收貨人姓名</td>
            <td><font color="#0000FF"><?php echo $row_mainRec['RecName']; ?></font></td>
            <td>聯絡電話</td>
            <td colspan="2"><?php echo $row_mainRec['RecPhone']; ?></td>
          </tr>
          <tr>
            <td>收貨人信箱</td>
            <td><?php echo $row_mainRec['RecMail']; ?></td>
            <td>運送方式</td>
            <td colspan="2"><?php echo $row_mainRec['pei']; ?></td>
          </tr>
          <tr>
            <td>收貨人地址</td>
            <td colspan="4"><?php echo $row_mainRec['RecAddress']; ?></td>
          </tr>

        <!-------------------------商品明細------------------------------->

          <tr>
            <th colspan="5" ><p><b>商品明細</b></p></th>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <td>商品名稱</td>
            <td>商品貨號</td>
            <td>數量</td>
            <td>商品售價</td>
            <td>小計</td>
          </tr>
          <!-------------------------------------------------------------->
          <?php
		  		$total = 0;
		  		foreach ($row_subRec as $key => $array){
		  ?>
            <tr>
              <td><?php echo $array['ProdName']; ?></td>
              <td><?php echo $array['OrderNum']; ?></td>
              <td><?php echo $array['ProdUnit']; ?></td>
              <td>NT$<?php echo $array['BuyPrice']; ?></td>
              <td>NT$<?php echo $array['BuyPrice']*$array['ProdUnit']; ?></td>
            </tr>
          <?php
		  			$sum = $array['BuyPrice']*$array['ProdUnit'];
		  			$total=$total+$sum;
		  		}
		  ?>
          <!-------------------------------------------------------------->
          <tr>
            <th colspan="5" >共訂購<?php echo $totalRows_subRec ?> 種商品</th>
          </tr>
          <tr>
          <td colspan="5">
          	<p><b>運費：<?php echo $row_mainRec['fei']; ?> 元</b><br />
            <font color="#FF3333"><b>您選購的商品總價為：<?php echo $total + $row_mainRec['fei']; ?> 元</b></font></p>

      </td>
    </tr>
  </table>
<?php //} while ($row_mainRec = mysql_fetch_assoc($mainRec)); ?>
<?php } // Show if recordset not empty
//mysql_free_result($mainRec);
//mysql_free_result($subRec);
?>
