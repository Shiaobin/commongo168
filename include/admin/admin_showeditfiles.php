<?php  //-----------------------------更新檔案資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_files"])) && ($_POST["update_files"] == "更新")) {
  //move_uploaded_file($_FILES["files_img"]["tmp_name"], "filesimg\\".$_FILES["files_img"]["name"].".jpg");
	$table_download		= SYS_DBNAME . ".download";
  $record = array(
  				'Dow_Name' => $_POST['Dow_Name'],
				'set_open' => $_POST['set_open']
				);
  $whereClause = "Dow_ID={$_POST['Dow_ID']}";

  dbUpdate( $table_download, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE download SET Dow_Name=%s, set_open=%s where Dow_ID=%s",
					   GetSQLValueString($_POST['Dow_Name'], "text"),
                       GetSQLValueString($_POST['set_open'], "tinyint"),
					   GetSQLValueString($_POST['Dow_ID'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
  $updateGoTo = "adminfiles.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得檔案資訊------------------------------------//
$cloume_showfilesRec = "%";
if (isset($_GET['Dow_ID'])) {
  $cloume_showfilesRec = $_GET['Dow_ID'];
}

$table_download		= SYS_DBNAME . ".download";
$whereClause = "download.Dow_ID='{$cloume_showfilesRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_download} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_download} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_download} WHERE {$whereClause}"
		);
$row_showfilesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showfilesRec = sprintf("SELECT * FROM download WHERE download.Dow_ID=%s",
                               GetSQLValueString($cloume_showfilesRec, "text"));
$showfilesRec = mysql_query($query_showfilesRec, $webshop) or die(mysql_error());
$row_showfilesRec = mysql_fetch_assoc($showfilesRec);
$totalRows_showfilesRec = mysql_num_rows($showfilesRec);
*/
?>
<h3 class=ttl01 >編輯檔案</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
<!---------------------編輯檔案--------------------------------->
<form name="editfiles" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="editfiles">
      <input type="hidden" name="Dow_ID" id="Dow_ID" value="<?php echo $row_showfilesRec['Dow_ID']; ?>"/>
  <tr>
    <td >1.檔案說明:
      <input name="Dow_Name" type="text" value="<?php echo $row_showfilesRec['Dow_Name']; ?>" class=sizeL />
    </td>
  </tr>
    <!---------------------------檔案名稱---------------------------->
  <tr>
    <td>2.檔案名稱:
      <?php echo $row_showfilesRec['Dow_Path']; ?>
    </td>
  </tr>
  <!----------------------------是否在線---------------------------->
  <tr>
    <td>3.是否在線:
      <label>
        <input type="radio" name="set_open" value="1" id="set_open_1"
		<?php if ($row_showfilesRec['set_open'] == '1'): ?>checked='checked'<?php endif; ?>/>是</label>
      <label>
        <input type="radio" name="set_open" value="0" id="set_open_0"
        <?php if ($row_showfilesRec['set_open'] == '0'): ?>checked='checked'<?php endif; ?>/>否</label>
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="Dow_ID" type="hidden" value="<?php echo $row_showfilesRec['Dow_ID']; ?>" />
      <input type="submit" name="update_files"  value="更新" style="font-size:16px;width:60px;height:30px" />
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($showfilesRec);
?>
