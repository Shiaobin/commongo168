<?php  //-----------------------------新增商品資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_pages"])) && ($_POST["update_pages"] == "新增")&& ($_POST['frame_name'] != "")) {
	$table_index_frame		= SYS_DBNAME . ".index_frame";
  $record = array(
  				'frame_text' => $_POST['frame_text'],
				'frame_name' => $_POST['frame_name'],
				'set_open' => $_POST['set_open']
				);
  dbInsert( $table_index_frame, $record );
  /*
$insertSQL = sprintf("INSERT INTO index_frame (frame_text, frame_name, set_open) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['frame_text'], "text"),
					   GetSQLValueString($_POST['frame_name'], "text"),
					   GetSQLValueString($_POST['set_open'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
*/
  $insertGoTo = "adminwebframe.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >新增自助頁面</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<!---------------------編輯上架商品--------------------------------->
<form name="editpages" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editpages">

  <tr>
    <td >自助頁面名稱<font color="#FF3333"> *</font><input type="text" name="frame_name" class=sizeS /></td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
  	 <td>是否顯示<font color="#FF3333"> *</font>
      <input type="radio" value="1" checked name="set_open">是
      <input type="radio" name="set_open" value="0">否
     </td>
  </tr>
  <!----------------------------詳細說明---------------------------->
  <tr>
   <td>
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
    <textarea id="frame_text" name="frame_text" class="ckeditor" cols="" rows="" style="width:70%; height:100%; margin:3px"></textarea></td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td width="40%" colspan="2" align="center">
      <input type="submit" name="update_pages"  value="新增" style="font-size:16px;width:60px;height:30px"/>
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($showpagesRec);
?>
