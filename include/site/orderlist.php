<?php  //----------------------------取得訂單列表---------------------------------//
//$sysConnDebug = true;
$currentPage = $_SERVER["PHP_SELF"];
if(isset($_SESSION['MM_Username'])) {
	if (isset($_GET['mem_no'])) {
  		$mem_no = $_GET['mem_no'];

		$table_orderlist		= SYS_DBNAME . ".orderlist";
		$column = "*";
		$whereClause = "usernum='{$mem_no}'";

		$sql['list']['select'] = array(
				'mysql'	=> "SELECT * FROM {$table_orderlist} LEFT JOIN usermain ON usermain.UserId = orderlist.UserId WHERE {$whereClause}",
				'mssql'	=> "SELECT * FROM {$table_orderlist} LEFT JOIN usermain ON usermain.UserId = orderlist.UserId WHERE {$whereClause}",
				'oci8'	=> "SELECT * FROM {$table_orderlist} LEFT JOIN usermain ON usermain.UserId = orderlist.UserId WHERE {$whereClause}"
		);
		$row_mainRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
		$totalRows_mainRec = sizeof($row_mainRec);
		/*
		$query_mainRec = sprintf("SELECT * FROM orderlist
		LEFT JOIN usermain ON usermain.UserId = orderlist.UserId
		WHERE usernum=%s", GetSQLValueString($mem_no, "text"));
		$mainRec = mysql_query($query_mainRec, $webshop) or die(mysql_error());
		$row_mainRec = mysql_fetch_assoc($mainRec);
		$totalRows_mainRec = mysql_num_rows($mainRec);*/}
}else{
	echo "<script language=\"javascript\">";
	echo "window.alert(\"請先登入會員\");";
	echo "</script>";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<!-------------------------訂單資訊------------------------------->
<?php if ($totalRows_mainRec > 0) { // Show if recordset not empty ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
  <!-------------------------------------------------------------->
    <tr>
       <td align="center" colspan=4 ><p><b><span class="new" style="font-size: 16px" >訂單資訊</b></p></td>
    </tr>

          <!-------------------------------------------------------------->
          <tr>
            <th>訂單日期</th>
            <th>訂單編號</th>
            <th>總金額</th>
            <th>收貨人</th>
          </tr>
          <!-------------------------------------------------------------->
          <?php foreach ($row_mainRec as $key => $array){ ?>
          <tr>
            <td><?php echo date('Y-m-d',strtotime($array['OrderTime']));?></td>
            <td><a href="chkord1.php?OrderNum=<?php echo $array["OrderNum"]; ?>"><?php echo $array['OrderNum']; ?></a></td>
            <td>$NT<?php echo $array['OrderSum']; ?></td>
            <td><?php echo $array['RecName']; ?></td>
          </tr>
          <?php } ?>
          <!-------------------------------------------------------------->

  </table>
<?php }// Show if recordset not empty
//mysql_free_result($mainRec);
?>
