<?php include("small.php"); ?>
<?php  //-----------------------------新增banner資訊------------------------------------//
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增") && ($_POST['po'] != "")) {	

  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

	$img = date('his').".jpg";
	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/bannerimg/".$img
        ) or die("Problems with upload");
        resize_banner_image($img);
  }
  else {
	$img = "";
  }
  
  $record = array( 'banner' => $img
  					, 'po' => $_POST['po']);
  $table_banner		= SYS_DBNAME . ".banner";
  dbInsert( $table_banner, $record );
  //新增廣告資訊
  /*
  $insertSQL = sprintf("INSERT INTO banner (banner, po) VALUES (%s, %s)",
					    GetSQLValueString($img, "text"),
					    GetSQLValueString($_POST['po'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
*/
  $insertGoTo = "adminbanner.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}

?>

<?php  //-----------------------------重設商品資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $insertGoTo = "adminaddbanner.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>
<h3 class=ttl01 >新增看板廣告</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="addbanner" action="" method="POST" enctype="multipart/form-data" id="addbanner">

  <tr>
    <td>圖片顯示順序:<font color="#FF3333">  *</font>
      <input id="po" name="po" type="text" class=sizeSss />
    </td>
  </tr>
  <!----------------------------上傳廣告圖片---------------------------->
  <tr>
    <td>上傳廣告圖片:
      <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/>
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input type="submit" name="MM_insert"  value="新增" style="font-size:16px;width:60px;height:30px" />
      <input type="submit" name="MM_reset"  value="重設" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
</form>
</table>
