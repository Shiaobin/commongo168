<?php include("small.php"); ?>
<?php  //-----------------------------取得索引標籤------------------------------------//
$tabindex = "%";
if (isset($_GET['tabindex'])) {
  $tabindex = $_GET['tabindex'];
}
?>
<?php  //-----------------------------更新商品資訊------------------------------------//
if ((isset($_POST["update_slide"])) && ($_POST["update_slide"] == "更新")) {	

  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

    if($_POST['slide_img']=="none.gif" ) $img = date('his').".jpg"; 
	else                     $img = $_POST['slide_img'];
	
	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/slideimg/".$img);
        resize_slide_image($img);
  }
  else {
    $img = $_POST['slide_img'];
  }
  
  //更新商品資訊
  $table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
  $record = array(
  				'slide_index' => $_POST['slide_index'],
				'slide_img' => $img,
				'slide_url' => $_POST['slide_url'],
				'slide_text' => $_POST['slide_text']
				);
  $whereClause = "slide_no='{$_POST['slide_no']}'";
		
  dbUpdate( $table_index_image_slide, $record, $whereClause );
				/*
  $updateSQL = sprintf("UPDATE index_image_slide SET slide_index=%s, slide_img=%s, slide_url=%s, slide_text=%s WHERE slide_no=%s",
                        GetSQLValueString($_POST['slide_index'], "int"),
                        GetSQLValueString($img, "text"),
						GetSQLValueString($_POST['slide_url'], "text"),
						GetSQLValueString($_POST['slide_text'], "text"),
						GetSQLValueString($_POST['slide_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
	*/
  $updateGoTo = sprintf("adminimageslide.php?tabindex=%s",$tabindex);
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>"; 
}
?>
<?php  //-----------------------------取得商品資訊------------------------------------//
$cloume_showbannerRec = "%";
if (isset($_GET['slide_no'])) {
  $cloume_showbannerRec = $_GET['slide_no'];
}

$table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
$whereClause = "slide_no='{$cloume_showbannerRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}"
		);
$row_showbannerRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
$totalRows_showbannerRec = sizeof($row_showbannerRec);
/*	
mysql_select_db($database_webshop, $webshop);
$query_showbannerRec = sprintf("SELECT * FROM index_image_slide WHERE slide_no=%s", GetSQLValueString($cloume_showbannerRec, "text"));
$showbannerRec = mysql_query($query_showbannerRec, $webshop) or die(mysql_error());
$row_showbannerRec = mysql_fetch_assoc($showbannerRec);
$totalRows_showbannerRec = mysql_num_rows($showbannerRec);
*/
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >修改廣告圖片資訊</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editslide" action="" method="POST" enctype="multipart/form-data" id="editslide">
  <tr>
    <td>1.顯示順序:
      <input id="slide_index" name="slide_index" type="text" class=sizeSss 
       value="<?php echo $row_showbannerRec['slide_index']; ?>" />
    </td>
  </tr>
  <!----------------------------廣告圖片---------------------------->
  <tr>
    <td>2.廣告圖片:
      <img src="../../images/slideimg/<?php echo $row_showbannerRec['slide_img']; ?>" alt="" name="image" 
       width="300px" height="150px" id="image" align="center" style="padding:5px;"/>
       <input name="slide_img" type="hidden" value="<?php echo $row_showbannerRec['slide_img']; ?>" />
    </td>
  </tr>
  <!----------------------------更新圖片---------------------------->
  <tr>
    <td>3.更新圖片:
      <input type="file" name="upload_img" style="width:50%; height:90%; margin: 3px"/>
    </td>
  </tr>
  <!---------------------------圖片連結網址-------------------------->
  <tr>
    <td>4.連結網址:
      <input id="slide_url" name="slide_url" type="text" class=sizeL 
       value="<?php echo $row_showbannerRec['slide_url']; ?>" />
    </td>
  </tr>
  <!---------------------------說明文字-------------------------->
  <tr>
    <td>5.說明文字:
      <input id="slide_text" name="slide_text" type="text" class=sizeML 
       value="<?php echo $row_showbannerRec['slide_text']; ?>" />
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="slide_no" type="hidden" value="<?php echo $row_showbannerRec['slide_no']; ?>" />
      <input type="submit" name="update_slide"  value="更新" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($showbannerRec);
?>
