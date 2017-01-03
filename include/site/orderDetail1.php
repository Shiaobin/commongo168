<?php
$currentPage = $_SERVER["PHP_SELF"];


if (isset($_GET['OrderNum'])) {
  $OrderNum = $_GET['OrderNum'];
}

		$table_orderlist		= SYS_DBNAME . ".orderlist";
		$column = "*";
		$whereClause = "OrderNum='{$OrderNum}'";

		$sql['list']['select'] = array(
				'mysql'	=> "SELECT * FROM {$table_orderlist} WHERE {$whereClause}",
				'mssql'	=> "SELECT * FROM {$table_orderlist} WHERE {$whereClause}",
				'oci8'	=> "SELECT * FROM {$table_orderlist} WHERE {$whereClause}"
		);
		$row_mainRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
		$totalRows_mainRec = sizeof($row_mainRec);
		/*
mysql_select_db($database_webshop, $webshop);
$query_mainRec = sprintf("SELECT * FROM orderlist WHERE OrderNum=%s", GetSQLValueString($OrderNum, "text"));
$mainRec = mysql_query($query_mainRec, $webshop) or die(mysql_error());
$row_mainRec = mysql_fetch_assoc($mainRec);
$totalRows_mainRec = mysql_num_rows($mainRec);
*/
$table_orderdetail		= SYS_DBNAME . ".orderdetail";
		$column = "*";
		$whereClause = "OrderNum='{$OrderNum}'";

		$sql['list']['select'] = array(
				'mysql'	=> "SELECT * FROM {$table_orderdetail} WHERE {$whereClause}",
				'mssql'	=> "SELECT * FROM {$table_orderdetail} WHERE {$whereClause}",
				'oci8'	=> "SELECT * FROM {$table_orderdetail} WHERE {$whereClause}"
		);
		$row_subRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
		$totalRows_subRec = sizeof($row_subRec);
		/*
mysql_select_db($database_webshop, $webshop);
$query_subRec = sprintf("SELECT * FROM orderdetail WHERE OrderNum = %s", GetSQLValueString($OrderNum, "text"));
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>訂單明細</title>

<!-------------------------訂單資訊------------------------------->
<?php if ($totalRows_mainRec > 0) { // Show if recordset not empty ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
          <!-------------------------------------------------------------->
          <tr>
            <td colspan="4" align="center" ><p><b><span class="new" style="font-size: 16px" >訂單資訊</b></p></td>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <th>訂單編號</th>
            <td><?php echo $row_mainRec['OrderNum']; ?></td>
            <th>訂單日期</td>
            <td><?php echo $row_mainRec['OrderTime']; ?></td>
          </tr>
          <tr>
            <th>送達時間</th>
            <td><?php echo $row_mainRec['Gettime']; ?></td>
            <th>訂單狀態</th>
            <td><font color="#0000FF"><?php echo $row_mainRec['Status']; ?></font></td>
          </tr>
          <tr>
            <th>收貨人姓名</th>
            <td><font color="#0000FF"><?php echo $row_mainRec['RecName']; ?></font></td>
            <th>聯絡電話</th>
            <td><?php echo $row_mainRec['RecPhone']; ?></td>
          </tr>
          <tr>
            <th>收貨人信箱</th>
            <td><?php echo $row_mainRec['RecMail']; ?></td>
            <th>運送方式</th>
            <td><?php echo $row_mainRec['pei']; ?></td>
          </tr>
          <tr>
            <th>收貨人地址</th>
            <td colspan=3 ><?php echo $row_mainRec['RecAddress']; ?></td>
          </tr>
          <!-------------------------------------------------------------->
        </table>
        <!-------------------------商品明細------------------------------->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
          <!-------------------------------------------------------------->
          <tr>
            <td colspan="5" align="center"><p><b><span class="new" style="font-size: 16px" >商品明細</b></p></td>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <th>商品貨號</th>
            <th>商品名稱</th>
            <th>數量</th>
            <th>商品售價</th>
            <th>小計</th>
          </tr>
          <!-------------------------------------------------------------->
          <?php
		  		$total = 0;
		  		foreach ($row_subRec as $key => $array){
		  ?>
            <tr>
              <td><?php echo $array['OrderNum']; ?></td>
              <td><?php echo $array['ProdName']; ?></td>
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
          <!-------------------------------------------------------------->

  </table>
<?php } // Show if recordset not empty
//mysql_free_result($mainRec);
//mysql_free_result($subRec);
?>
