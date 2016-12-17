<?php include("small.php"); ?>
<?php  //-----------------------------新增商品資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增")) {
  $img_string = array();
  if($_POST['end_item_id']=="") $_POST['end_item_id'] = 0;	

  //上傳圖片
  foreach ($_FILES["list_imgs"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {	 
      echo"$error_codes[$error]";
	  $num =  date('his') + $key;
	  $img_string[$key] = $_POST['list_id'].$num.".jpg";

      move_uploaded_file(
        realpath($_FILES["list_imgs"]["tmp_name"][$key]), 
        "../images/albumimg/".$img_string[$key]
      ) or die("Problems with upload");

      resize_album_image($img_string[$key]);
    }
  }	
  
  //上傳封面圖片
  $img = "";

  if($_FILES["list_img"]["error"] == UPLOAD_ERR_OK) {
      $img = $_POST['list_id'].date('his').".jpg";

      move_uploaded_file(realpath($_FILES["list_img"]["tmp_name"]), "../images/albumimg/".$img);
      resize_album_image($img);
  }
  
  //更新商品資訊
  $insertSQL = sprintf("INSERT INTO album_list (list_id, list_name, list_img, item_id, end_item_id) VALUES (%s, %s, %s, %s, %s)",
                        GetSQLValueString($_POST['list_id'], "text"),
                        GetSQLValueString($_POST['list_name'], "text"),
			GetSQLValueString($img, "text"),
                        GetSQLValueString($_POST['item_id'], "int"),
		        GetSQLValueString($_POST['end_item_id'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  
  //更新圖片資訊
  for($i=0; $i<count($img_string); $i++){
    $insertSQL = sprintf("INSERT INTO album_list_img (list_id, img_name) VALUES (%s, %s)",
                          GetSQLValueString($_POST['list_id'], "text"),
		     			  GetSQLValueString($img_string[$i], "text"));

    mysql_select_db($database_webshop, $webshop);
    $Result2 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  }

  $insertGoTo = "adminalbum.php";
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
  $insertGoTo = "adminaddalbum.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>"; 
}
?>
<?php  //---------------------------取得商品類別(大類)---------------------------------//
  mysql_select_db($database_webshop, $webshop);
  $query_itemRec = "SELECT * FROM album_item";
  $itemRec = mysql_query($query_itemRec, $webshop) or die(mysql_error());
  $row_itemRec = mysql_fetch_assoc($itemRec);
  $totalRows_itemRec = mysql_num_rows($itemRec);
?>
<?php  //---------------------------更新商品類別(中類)---------------------------------//
$row_endItemRec = -1;
if(isset($_POST['item_id'])){
  $class = $_POST['item_id'];
  mysql_select_db($database_webshop, $webshop);
  $query_endItemRec = sprintf("SELECT * FROM album_end_item where item_id = %s",
                               GetSQLValueString($_POST['item_id'], "int"));
  $endItemRec = mysql_query($query_endItemRec, $webshop) or die(mysql_error());
  $row_endItemRec = mysql_fetch_assoc($endItemRec);
  $totalRows_endItemRec = mysql_num_rows($endItemRec);
}
else{
  $class = -1;
}
?>
<!--------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>新增相簿頁面</title>
<!-------------------------------------------------------------->
<table width="97%" height="90%" border="1" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0">
<form name="addalbum" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="addalbum">
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="4" align="center"><p>新增相簿</p></td>
  </tr>
  <!----------------------------上傳相片---------------------------->
  <tr>
    <td width="10%" align="center">上傳相片</td>
    <td width="40%" colspan="2" align="left">
      <input name="list_imgs[]" type="file" value="Select a File..." style="width:50%; height:90%; margin: 3px" multiple/>
    </td>
  </tr>
  <!--------------------------上傳相簿封面圖片------------------------>
  <tr>
    <td width="10%" align="center">上傳相簿封面圖片</td>
    <td width="40%" colspan="2" align="left">
      <input name="list_img" type="file" value="Select a File..." style="width:50%; height:90%; margin: 3px"/>
    </td>
  </tr>
  <!----------------------------所屬大類---------------------------->
  <tr>
    <td width="10%" height="10%" align="center">所屬大類</td>
    <td width="40%" height="10%" colspan="3" align="left">
      <select id="item_id" name="item_id" onchange="this.form.submit()" 
              style="width:50%; height:90%; margin: 3px">
      <option value="0"></option> 
      <?php
	    do {  
	  ?>
        <option value="<?php echo $row_itemRec['item_id']?>" <?php if($row_itemRec['item_id'] == $class) {echo "selected=\"selected\"";} ?>>
		<?php echo $row_itemRec['item_name']?></option>
      <?php
      } while ($row_itemRec = mysql_fetch_assoc($itemRec));
      $rows = mysql_num_rows($itemRec);
      if($rows > 0) {
        mysql_data_seek($itemRec, 0);
	    $row_itemRec = mysql_fetch_assoc($itemRec);
      }
      ?>
      </select>
    </td>
  </tr>
  <!----------------------------所屬中類---------------------------->
  <tr>
    <td width="10%" height="10%" align="center">所屬中類</td>
    <td width="40%" height="10%" colspan="3" align="left">
      <select id="end_item_id" name="end_item_id" style="width:50%; height:90%; margin: 3px">
      <?php
	    do {  
	  ?>
        <option value="<?php echo $row_endItemRec['end_item_id']?>"><?php echo $row_endItemRec['end_item_name']?></option>
      <?php
      } while ($row_endItemRec = mysql_fetch_assoc($endItemRec));
      $rows = mysql_num_rows($endItemRec);
      if($rows > 0) {
        mysql_data_seek($endItemRec, 0);
	    $row_endItemRec = mysql_fetch_assoc($endItemRec);
      }
      ?>
      </select>
    </td>
  </tr>
  <!----------------------------相簿編號---------------------------->
  <tr>
    <td width="10%" height="10%" align="center">相簿編號</td>
    <td width="40%" height="10%" colspan="3" align="left">
      <input id="list_id" name="list_id" type="text" style="width:50%; height:70%; margin: 3px"/>[一旦確定將不能修改]</td>
  </tr>
  <!----------------------------相簿名稱---------------------------->
  <tr>
    <td width="10%" height="10%" align="center">相簿名稱</td>
    <td width="40%" height="10%" colspan="3" align="left">
      <input id="list_name" name="list_name" type="text" style="width:50%; height:70%; margin: 3px"/></td>
  </tr>

  <!------------------------新增按鈕---------------------------->
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" colspan="3" align="left">
      <input type="submit" name="MM_insert"  value="新增" style="width:8%; height:100%; margin: 3px"/>
      <input type="submit" name="MM_reset"  value="重設" style="width:8%; height:100%; margin: 3px"/>
    </td>
  </tr>
</form>
<!---<script>document.addgoods.item_id.value = '<?=$class?>';</script>--->
</table>
<!--------------------------release--------------------------->
<?php
mysql_free_result($itemRec);
if(isset($endItemRec)) mysql_free_result($endItemRec);
?>
