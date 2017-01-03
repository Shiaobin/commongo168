<?php
$currentPage = $_SERVER["PHP_SELF"];

$colname_carRec = "-1";
if (isset($_SESSION['MM_Username'])) {
    $colname_carRec = $_SESSION['MM_Username'];
	//---------------------------取得訂單資訊---------------------------------//
	$column = "*";
	$table_usermain		= SYS_DBNAME . ".usermain";
	$whereClause = "usernum={$colname_carRec}";

	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_usermain} LEFT JOIN orderlist ON usermain.UserId = orderlist.UserId WHERE {$whereClause} ORDER BY OrderTime DESC",
			'mssql'	=> "SELECT {$column} FROM {$table_usermain} LEFT JOIN orderlist ON usermain.UserId = orderlist.UserId WHERE {$whereClause} ORDER BY OrderTime DESC",
			'oci8'	=> "SELECT {$column} FROM {$table_usermain} LEFT JOIN orderlist ON usermain.UserId = orderlist.UserId WHERE {$whereClause} ORDER BY OrderTime DESC"
	);

	$row_subRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	  /*
	mysql_select_db($database_webshop, $webshop);
	$query_subRec = sprintf("SELECT * FROM usermain
	LEFT JOIN orderlist ON usermain.UserId = orderlist.UserId
	WHERE usernum=%s order by OrderTime DESC", GetSQLValueString($colname_carRec, "int"));
	$subRec = mysql_query($query_subRec, $webshop) or die(mysql_error());
	$row_subRec = mysql_fetch_assoc($subRec);
	$totalRows_subRec = mysql_num_rows($subRec);
	*/
}else if (isset($_SESSION['tempord_id'])) {
    $colname_carRec = $_SESSION['tempord_id'];
	$column = "*";
	$table_orderlist		= SYS_DBNAME . ".orderlist";
	$whereClause = "OrderNum='{$colname_carRec}'";

	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_orderlist} WHERE {$whereClause}",
			'mssql'	=> "SELECT {$column} FROM {$table_orderlist} WHERE {$whereClause}",
			'oci8'	=> "SELECT {$column} FROM {$table_orderlist} WHERE {$whereClause}"
	);

	$row_subRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	/*
	mysql_select_db($database_webshop, $webshop);
	$query_subRec = sprintf("SELECT * FROM orderlist WHERE OrderNum=%s", GetSQLValueString($colname_carRec, "text"));
	$subRec = mysql_query($query_subRec, $webshop) or die(mysql_error());
	$row_subRec = mysql_fetch_assoc($subRec);
	$totalRows_subRec = mysql_num_rows($subRec);
	*/
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
	<td align="center" valign="middle" height=60><h2>
	<p><br><br><font color="#FF3333"><p>恭喜，訂單提交成功！</p>
    <br><br><p>您的訂單號碼是：<b><?php echo $row_subRec['OrderNum']; ?></b></p>
    <br><br><p>本次交易金額為：<b><?php echo $row_subRec['OrderSum']+$row_subRec['fei']; ?></b>元</p></font>
    <!--<p><font color="#0000FF">***查詢訂單請記得訂單號碼***</font></p>--></p> </h2>
	</td>
</tr>
</table>
<?php
//mysql_free_result($subRec);
?>
