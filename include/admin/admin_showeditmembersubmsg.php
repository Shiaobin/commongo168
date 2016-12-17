<?php  //-----------------------------更新留言資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_msg"])) && ($_POST["update_msg"] == "更新")) {	

    //上傳圖片
  if($_FILES['upload_img']['name'] != "") {

	$img = date('his').".jpg";
	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/discussimg/".$img) or die("Problems with upload");
	
    resize_discuss_image($img);
	
	if($_POST['msg_img'] != "none.gif"){ 
		 unlink("../images/discussimg/medium/".$_POST['msg_img']);
		 unlink("../images/discussimg/small/".$_POST['msg_img']);
		}
  }
  else {
    $img = $_POST['msg_img'];
  }
  
  $table_shop_member_sub_msg		= SYS_DBNAME . ".shop_member_sub_msg";
  $record = array(
  				'mem_nickname' => $_POST['mem_nickname'],
				'msg_send' => $_POST['msg_send'],
				'msg_img' => $img
				);
  $whereClause = "sub_msg_no={$_POST['sub_msg_no']}";
		
  dbUpdate( $table_shop_member_sub_msg, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE shop_member_sub_msg SET mem_nickname=%s, msg_send=%s, msg_img=%s where sub_msg_no=%s", 
					   GetSQLValueString($_POST['mem_nickname'], "text"),
					   GetSQLValueString($_POST['msg_send'], "text"),
					   GetSQLValueString($img, "text"), 
					   GetSQLValueString($_POST['sub_msg_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
  $updateGoTo = "adminmembersubmsg.php?msg_no=".$_POST["msg_no"];
  //if (isset($_SERVER['QUERY_STRING'])) {
  //  $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
  //  $updateGoTo .= $_SERVER['QUERY_STRING'];
  //}
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>

<?php  //-----------------------------取得回覆留言資訊------------------------------------//
$cloume_showmsgRec = "%";
if (isset($_GET['sub_msg_no'])) {
  $cloume_showmsgRec = $_GET['sub_msg_no'];
}

$table_shop_member_sub_msg		= SYS_DBNAME . ".shop_member_sub_msg";
$whereClause = "sub_msg_no='{$cloume_showmsgRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause}"
		);
$row_showsubmsgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showsubmsgRec = sprintf("SELECT * FROM shop_member_sub_msg WHERE sub_msg_no=%s",
                               GetSQLValueString($cloume_showmsgRec, "text"));
$showsubmsgRec = mysql_query($query_showsubmsgRec, $webshop) or die(mysql_error());
$row_showsubmsgRec = mysql_fetch_assoc($showsubmsgRec);
$totalRows_showsubmsgRec = mysql_num_rows($showsubmsgRec);
*/
?>
<?php  //-----------------------------取得留言資訊------------------------------------//

$table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
$whereClause = "msg_no='{$row_showsubmsgRec['msg_no']}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause}"
		);
$row_showmsgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showmsgRec = sprintf("SELECT * FROM shop_member_msg WHERE msg_no=%s",
                               GetSQLValueString($row_showsubmsgRec['msg_no'], "text"));
$showmsgRec = mysql_query($query_showmsgRec, $webshop) or die(mysql_error());
$row_showmsgRec = mysql_fetch_assoc($showmsgRec);

*/?>

<?php 
//---------------discuss img-------------------//
function resize_discuss_image($file) {
$imM = new Imagick("../images/discussimg/".$file);
$imS = new Imagick("../images/discussimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(600, 500);
$frameM->setImagePage(600, 500, 0, 0);
}

foreach ($imS as $frameS) {
$frameS->thumbnailImage(120, 100);
$frameS->setImagePage(120, 100, 0, 0);
}

$imM->writeImages("../images/discussimg/medium/".$file, true);
$imS->writeImages("../images/discussimg/small/".$file, true);
unlink("../images/discussimg/".$file);
}
?>
<h3 class=ttl01 >修改回覆內容</h3>

<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editmsg" action="<?php echo $editFormAction; ?>" method="POST" 
 enctype="multipart/form-data" id="editmsg">

  <input type="hidden" name="sub_msg_no" id="sub_msg_no" value="<?php echo $row_showsubmsgRec['sub_msg_no']; ?>"/>
  <input type="hidden" name="msg_no" id="msg_no" value="<?php echo $row_showmsgRec['msg_no']; ?>"/>
  <!----------------------------留言日期---------------------------->
  <tr>
    <td>1.回覆日期:<?php echo $row_showsubmsgRec['sub_msg_date']; ?></td>
  </tr> 
  <!-----------------------------討論主題----------------------------->
  <tr>
    <td>2.討論主題:<?php echo $row_showmsgRec['msg_title']; ?></td>
  </tr> 
  <!-----------------------------留言人----------------------------->
  <tr>
    <td>3.回覆留言人:<input name="mem_nickname" type="text" class=sizeS value="<?php echo $row_showsubmsgRec['mem_nickname']; ?>"/></td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td>4.圖片:
     <p><img src="../../images/discussimg/small/<?php echo $row_showsubmsgRec['msg_img']; ?>" alt="" name="image" 
           width="78px" height="65px" id="image" align="center" style="padding:5px;"/>
       <input name="msg_img" type="hidden" value="<?php echo $row_showsubmsgRec['msg_img']; ?>" />
       <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/> </p>
     </td>
  </tr>
  <!----------------------------留言內容---------------------------->
  <tr>
    <td>5.回覆留言內容:<br>
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
<textarea cols='50' rows='10' class="ckeditor"  name='msg_send'><?php echo $row_showsubmsgRec['msg_send'];?></textarea></td>
  </tr>
    <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input type="submit" name="update_msg"  value="更新" style="font-size:16px;width:60px;height:30px"/>
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
</form>
</table>
<?php
///mysql_free_result($showmsgRec);
//mysql_free_result($showsubmsgRec);
?>
