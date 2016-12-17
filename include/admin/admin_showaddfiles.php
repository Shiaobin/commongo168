<?php  //-----------------------------新增檔案資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增") && ($_POST['Dow_Name'] != "") && ($_FILES["files"]["tmp_name"] != "")) {  
  move_uploaded_file(realpath($_FILES["files"]["tmp_name"]), "../files/".$_FILES["files"]["name"]) or die("Problems with upload");
  
  $table_download		= SYS_DBNAME . ".download";
  $record = array(
  				'Dow_Path' => $_FILES["files"]["name"],
				'Dow_Name' => $_POST['Dow_Name'],
				'set_open' => $_POST['set_open']
				);
  dbInsert( $table_download, $record );
  /*
  $insertSQL = sprintf("INSERT INTO download (Dow_Path, Dow_Name, set_open) VALUES (%s, %s, %s)",
                       GetSQLValueString($_FILES["files"]["name"], "text"),
                       GetSQLValueString($_POST['Dow_Name'], "text"),
					   GetSQLValueString($_POST['set_open'], "tinyint"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
*/
  $insertGoTo = "adminfiles.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------重設檔案資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $endItemRec = "";
}
?>
<h3 class=ttl01 >新增檔案</h3>
<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="addfiles" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="addfiles">
  <tr>
    <td>1.上傳檔案<font color="#FF3333">  *</font>:
      <input name="files" type="file" value="Select a File..." style="width:50%; height:90%; margin: 3px"/>
    </td>
  </tr>
  <!----------------------------檔案說明--------------------------->
  <tr>
    <td>2.檔案說明<font color="#FF3333">  *</font>:
      <input name="Dow_Name" type="text" class=sizeL />
    </td>
  </tr>
  <!----------------------------是否在線---------------------------->
  <tr>
    <td>3.是否在線:
      <label>
        <input type="radio" name="set_open" value="1" id="set_open_1" checked/>是</label>
      <label>
        <input type="radio" name="set_open" value="0" id="set_open_0" />否</label>
    </td>
  </tr>
  <!----------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input type="submit" name="MM_insert"  value="新增" style="font-size:16px;width:60px;height:30px" />
      <input type="reset" name="MM_reset"  value="重設" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
</form>
</table>

