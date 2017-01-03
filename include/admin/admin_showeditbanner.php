<?php include("small.php"); ?>
<?php  //-----------------------------更新商品資訊------------------------------------//
if ((isset($_POST["update_banner"])) && ($_POST["update_banner"] == "更新")) {

  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

    if($_POST['banner']=="" ) $img = date('his').".jpg";
	else                      $img = $_POST['banner'];

	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/bannerimg/".$img);
        resize_banner_image($img);
  }
  else {
    $img = $_POST['banner'];
  }

  //更新商品資訊
  $updateSQL = sprintf("UPDATE banner SET po=%s, banner=%s WHERE Notice_ID=%s",
                        GetSQLValueString($_POST['po'], "int"),
                        GetSQLValueString($img, "text"),
						GetSQLValueString($_POST['Notice_ID'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());

  $updateGoTo = "adminbanner.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得商品資訊------------------------------------//
$cloume_showbannerRec = "%";
if (isset($_GET['Notice_ID'])) {
  $cloume_showbannerRec = $_GET['Notice_ID'];
}
mysql_select_db($database_webshop, $webshop);
$query_showbannerRec = sprintf("SELECT * FROM banner WHERE Notice_ID=%s", GetSQLValueString($cloume_showbannerRec, "text"));
$showbannerRec = mysql_query($query_showbannerRec, $webshop) or die(mysql_error());
$row_showbannerRec = mysql_fetch_assoc($showbannerRec);
$totalRows_showbannerRec = mysql_num_rows($showbannerRec);
?>
<h3 class=ttl01 >修改上架商品資訊</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editbanner" action="" method="POST" enctype="multipart/form-data" id="editbanner">
  <tr>
    <td>顯示順序:
      <input id="po" name="po" type="text" class=sizeSss
       value="<?php echo $row_showbannerRec['po']; ?>" />
    </td>
  </tr>
  <!----------------------------廣告圖片---------------------------->
  <tr>
    <td>廣告圖片:
      <img src="../../images/bannerimg/<?php echo $row_showbannerRec['banner']; ?>" alt="" name="image"
       width="520px" id="image" align="center" style="padding:5px;"/>
       <input name="banner" type="hidden" value="<?php echo $row_showbannerRec['banner']; ?>" />
    </td>
  </tr>
  <!----------------------------更新圖片---------------------------->
  <tr>
    <td>更新圖片:
      <input type="file" name="upload_img" style="width:50%; height:90%; margin: 3px"/>
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="Notice_ID" type="hidden" value="<?php echo $row_showbannerRec['Notice_ID']; ?>" />
      <input type="submit" name="update_banner"  value="更新" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
mysql_free_result($showbannerRec);
?>
