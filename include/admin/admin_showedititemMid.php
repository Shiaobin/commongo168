<?php include("small.php"); ?>
<?php  //--------------------------修改分頁類別(中類)-----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_item"])) && ($_POST["update_item"] == "更新")) {
  
  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

    if($_POST['pic']=="none.gif" ) $img = date('his').".jpg"; 
	else                      $img = $_POST['pic'];
	
	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/app/".$img);
        resize_midcode_image($img);
  }
  else {
    $img = $_POST['pic'];
  }
  
  
  //更新中項內容
  $updateSQL = sprintf("UPDATE prodclass SET MidSeq=%s, MidCode=%s, pic=%s WHERE MidSeq=%s AND LarSeq=%s",
                       GetSQLValueString($_POST['upd_MidSeq'], "int"),
					   GetSQLValueString($_POST['MidCode'], "text"),
					   GetSQLValueString($img, "text"),               
					   GetSQLValueString($_POST['MidSeq'], "int"),
					   GetSQLValueString($_POST['LarSeq'], "int"));

  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  
 
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

<?php  //-----------------------------取得中類資訊------------------------------------//
$cloume_showitemLarRec = "-1";
$cloume_showitemMidRec = "-1";
if ((isset($_GET['LarSeq']) && ($_GET['MidSeq']))) {
  $cloume_showitemLarRec = $_GET['LarSeq'];
  $cloume_showitemMidRec = $_GET['MidSeq'];
}
mysql_select_db($database_webshop, $webshop);
$query_showitemMidRec = sprintf("SELECT * FROM prodclass WHERE LarSeq=%s AND MidSeq=%s",
                               GetSQLValueString($cloume_showitemLarRec, "int"),
							   GetSQLValueString($cloume_showitemMidRec, "int"));
$showitemMidRec = mysql_query($query_showitemMidRec, $webshop) or die(mysql_error());
$row_showitemMidRec = mysql_fetch_assoc($showitemMidRec);
$totalRows_showitemMidRec = mysql_num_rows($showitemMidRec);
?>
<h3 class=ttl01 >編輯商品中類</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <form action="<?php echo $editFormAction; ?>" name="additem" method="POST"
   enctype="multipart/form-data" id="additem">

  <tr align="left">
    <td width="100%">名稱:
      <input id="MidCode" name="MidCode" type="text" class=sizeM value="<?php echo $row_showitemMidRec['MidCode']; ?>"/>
    </td>
  </tr>
  
  <tr align="left">
    <td width="100%">排序:
   	  <input type="int" name="upd_MidSeq" id="upd_MidSeq" class=sizeSss value="<?php echo $row_showitemMidRec['MidSeq']; ?>"/>
   	  [不能與同一大類下其它中類的排序號重複]    
    </td>
  </tr>
  <!----------------------------圖片---------------------------->
  <tr>
     <td width="12%" height="10%" align="left">
       <img src="../../images/app/<?php echo $row_showitemMidRec['pic']; ?>" alt="" name="image" 
           width="78px" height="65px" id="image" align="center" style="padding:5px;"/>
       <input name="pic" type="hidden" value="<?php echo $row_showitemMidRec['pic']; ?>" />
     </td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td width="10%" height="10%" align="left">圖片[有手機板APP才需上傳圖片]
       <input name="upload_img" type="file" value="Select a File..." class=sizeM /> 
     </td>
  </tr>
  
  <tr align="left">
    <td width="100%">
      <input name="MidSeq" type="hidden" value="<?php echo $row_showitemMidRec['MidSeq']; ?>" />
      <input name="LarSeq" type="hidden" value="<?php echo $row_showitemMidRec['LarSeq']; ?>" />
   	  <input type="submit" name="update_item" id="update_item" value="更新" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  </form>
</table>

