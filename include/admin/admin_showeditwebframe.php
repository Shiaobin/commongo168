<?php  //-----------------------------更新商品資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_pages"])) && ($_POST["update_pages"] == "更新") && ($_POST['frame_name'] != "")) {
	$table_index_frame		= SYS_DBNAME . ".index_frame";
  $record = array(
  				'frame_text' => $_POST['frame_text'],
				'frame_name' => $_POST['frame_name'],
				'set_open' => $_POST['set_open']
				);
  $whereClause = "frame_no={$_POST['frame_no']}";

  dbUpdate( $table_index_frame, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE index_frame SET frame_text=%s, frame_name=%s, set_open=%s where frame_no=%s",
					   GetSQLValueString($_POST['frame_text'], "text"),
					   GetSQLValueString($_POST['frame_name'], "text"),
					   GetSQLValueString($_POST['set_open'], "int"),
					   GetSQLValueString($_POST['frame_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
  $updateGoTo = "adminwebframe.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得自助頁面資訊------------------------------------//
$cloume_showpagesRec = "%";
if (isset($_GET['frame_no'])) {
  $cloume_showpagesRec = $_GET['frame_no'];
}
$table_index_frame		= SYS_DBNAME . ".index_frame";
$whereClause = "frame_no='{$cloume_showpagesRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_index_frame} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_index_frame} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_index_frame} WHERE {$whereClause}"
		);
$row_showpagesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showpagesRec = sprintf("SELECT * FROM index_frame WHERE frame_no=%s", GetSQLValueString($cloume_showpagesRec, "text"));
$showpagesRec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
$row_showpagesRec = mysql_fetch_assoc($showpagesRec);
$totalRows_showpagesRec = mysql_num_rows($showpagesRec);
*/
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >編輯自助頁面</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editpages" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editpages">

  <tr>
    <td>自助頁面名稱<font color="#FF3333"> *</font><input type="text" name="frame_name" value="<?php echo $row_showpagesRec['frame_name']; ?>"/></td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>是否顯示<font color="#FF3333"> *</font>
      <label>
        <input type="radio" name="set_open" value="0" style="margin-left: 3px"
		<?php if ($row_showpagesRec['set_open'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="set_open" value="1" style="margin-left: 3px"
        <?php if ($row_showpagesRec['set_open'] == '1'): ?>checked='checked'<?php endif; ?> />
        是</label>
    </td>
  </tr>
  <!----------------------------詳細說明---------------------------->
  <tr>
   <td >
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
    <textarea id="frame_text" name="frame_text" class="ckeditor" cols="50" rows="30" ><?php echo $row_showpagesRec['frame_text']; ?></textarea></td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
      <input type="hidden" name="frame_no" id="frame_no" value="<?php echo $row_showpagesRec['frame_no']; ?>"/>
    <td>
      <input type="submit" name="update_pages"  value="更新" style="font-size:16px;width:60px;height:30px"/>
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
mysql_free_result($showpagesRec);
?>
