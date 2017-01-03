<?php  //--------------------------新增修改分頁類別(大類)-----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_item"])) && ($_POST["update_item"] == "更新")) {
  //更新大項內容
  $table_prodclass		= SYS_DBNAME . ".prodclass";
  $record = array(
  				'LarSeq' => $_POST['upd_LarSeq'],
				'LarCode' => $_POST['LarCode']
				);
  $whereClause = "LarSeq={$_POST['LarSeq']}";

  dbUpdate( $table_prodclass, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE prodclass SET LarSeq=%s, LarCode=%s WHERE LarSeq=%s",
                       GetSQLValueString($_POST['upd_LarSeq'], "int"),
					   GetSQLValueString($_POST['LarCode'], "text"),
					   GetSQLValueString($_POST['LarSeq'], "int"));

  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */

  $updateGoTo = "adminitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>

<?php  //-----------------------------取得大類資訊------------------------------------//
$cloume_showitemLarRec = "-1";
if (isset($_GET['LarSeq'])) {
  $cloume_showitemLarRec = $_GET['LarSeq'];
}

$table_prodclass		= SYS_DBNAME . ".prodclass";
$whereClause = "LarSeq='{$cloume_showitemLarRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}"
		);
$row_showitemLarRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showitemLarRec = sprintf("SELECT * FROM prodclass WHERE LarSeq=%s",
                               GetSQLValueString($cloume_showitemLarRec, "int"));
$showitemLarRec = mysql_query($query_showitemLarRec, $webshop) or die(mysql_error());
$row_showitemLarRec = mysql_fetch_assoc($showitemLarRec);
$totalRows_showitemLarRec = mysql_num_rows($showitemLarRec);
*/
?>


<!---------------------新增類別--------------------------------->
<h3 class=ttl01 >編輯商品大類</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <form action="<?php echo $editFormAction; ?>" name="additem" method="POST"
   enctype="multipart/form-data" id="additem">

  <tr align="left">
    <td width="100%">名稱:
      <input id="LarCode" name="LarCode" type="text" class=sizeM value="<?php echo $row_showitemLarRec['LarCode']; ?>"/>
    </td>
  </tr>

  <tr align="left">
    <td width="100%">排序:
   	  <input type="int" name="upd_LarSeq" id="upd_LarSeq" class=sizeSss value="<?php echo $row_showitemLarRec['LarSeq']; ?>"/>
   	  [不能與其它大類的排序號重複，否則會出錯]
    </td>
  </tr>

  <tr align="left">
    <td width="100%">
   <input name="LarSeq" type="hidden" value="<?php echo $row_showitemLarRec['LarSeq']; ?>" />
   <input type="submit" name="update_item" id="update_item" value="更新" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  </form>
</table>
