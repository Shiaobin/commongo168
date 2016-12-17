<?php include("small.php"); ?>
<?php  //-----------------------------取得圖片類別------------------------------------//
$cloume_showidRec = "%";
if (isset($_GET['img_class_id'])) {
  $cloume_showidRec = $_GET['img_class_id'];
}
?>
<?php  //-----------------------------取得索引標籤------------------------------------//
$tabindex = "%";
if (isset($_GET['tabindex'])) {
  $tabindex = $_GET['tabindex'];
}
?>
<?php  //-----------------------------新增廣告資訊------------------------------------//
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增")) {	

  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {
	$img = date('his').".jpg";
	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/slideimg/".$img);
        resize_slide_image($img);
  }
  else {
	$img = "none.gif";
  }
  //新增廣告資訊
  $table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
  $record = array(
  				'slide_index' => $_POST['slide_index'],
				'slide_img' => $img,
				'slide_url' => $_POST['slide_url'],
				'slide_text' => $_POST['slide_text'],
				'img_class_id' => $cloume_showidRec
				);
  dbInsert( $table_index_image_slide, $record );
  
  /*
  $insertSQL = sprintf("INSERT INTO index_image_slide (slide_index, slide_img, slide_url, slide_text, img_class_id) VALUES (%s, %s, %s, %s, %s)",
					    GetSQLValueString($_POST['slide_index'], "int"),
					    GetSQLValueString($img, "text"),
						GetSQLValueString($_POST['slide_url'], "text"),
						GetSQLValueString($_POST['slide_text'], "text"),
						GetSQLValueString($cloume_showidRec, "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());

  $insertGoTo = sprintf("adminimageslide.php?tabindex=%s",$tabindex);*/
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------重設商品資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $insertGoTo = "adminaddimageslide.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >新增連結圖片</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="addbanner" action="" method="POST" enctype="multipart/form-data" id="addbanner">
  <tr>
    <td>1.圖片顯示順序:
      <input id="slide_index" name="slide_index" type="text" class=sizeSss />
    </td>
  </tr>
  <!----------------------------上傳廣告圖片---------------------------->
  <tr>
    <td>2.上傳連結圖片:
      <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/>
    </td>
  </tr>
  <!--------------------------圖片連結網址-------------------------->
  <tr>
    <td>3.圖片連結網址:
      <input id="slide_url" name="slide_url" type="text" class=sizeML />
    </td>
  </tr>
  <!--------------------------說明文字-------------------------->
  <tr>
    <td>4.說明文字:
      <input id="slide_text" name="slide_text" type="text" class=sizeML />
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
