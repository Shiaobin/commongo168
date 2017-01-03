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


  $updateSQL = sprintf("UPDATE shop_member_msg SET msg_title=%s, mem_nickname=%s, msg_send=%s, msg_img=%s where msg_no=%s",
					   GetSQLValueString($_POST['msg_title'], "text"),
					   GetSQLValueString($_POST['mem_nickname'], "text"),
					   GetSQLValueString($_POST['msg_send'], "text"),
					   GetSQLValueString($img, "text"),
					   GetSQLValueString($_POST['msg_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());

  $updateGoTo = "adminmembermsg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得留言資訊------------------------------------//
$cloume_showmsgRec = "%";
if (isset($_GET['msg_no'])) {
  $cloume_showmsgRec = $_GET['msg_no'];
}
mysql_select_db($database_webshop, $webshop);
$query_showmsgRec = sprintf("SELECT * FROM shop_member_msg WHERE msg_no=%s",
                               GetSQLValueString($cloume_showmsgRec, "text"));
$showmsgRec = mysql_query($query_showmsgRec, $webshop) or die(mysql_error());
$row_showmsgRec = mysql_fetch_assoc($showmsgRec);
$totalRows_showmsgRec = mysql_num_rows($showmsgRec);
?>
<?php  //-----------------------------取得回覆留言資訊------------------------------------//
$cloume_showmsgRec = "%";
if (isset($_GET['msg_no'])) {
  $cloume_showmsgRec = $_GET['msg_no'];
}
mysql_select_db($database_webshop, $webshop);
$query_showsubmsgRec = sprintf("SELECT * FROM shop_member_sub_msg WHERE msg_no=%s",
                               GetSQLValueString($cloume_showmsgRec, "text"));
$showsubmsgRec = mysql_query($query_showsubmsgRec, $webshop) or die(mysql_error());
$row_showsubmsgRec = mysql_fetch_assoc($showsubmsgRec);
$totalRows_showsubmsgRec = mysql_num_rows($showsubmsgRec);
?>
<?php  //-------------------------------刪除回覆留言------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if ((isset($_POST["del_subMsg"])) && ($_POST["del_subMsg"] == "刪除")) {
    if(isset($_POST['sub_msg_no'])){
	  $updateSQL = sprintf("DELETE FROM shop_member_sub_msg WHERE sub_msg_no=%s",GetSQLValueString($_POST['sub_msg_no'], "int"));
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());

	  $updateGoTo = "admineditmembermsg.php?msg_no=".$_POST["msg_no"];
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
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
<h3 class=ttl01 >編輯討論主題</h3>

<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editmsg" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editmsg">

        <input type="hidden" name="msg_no" id="msg_no" value="<?php echo $row_showmsgRec['msg_no']; ?>"/>

  <!----------------------------留言日期---------------------------->
  <tr>
    <td>1.公告日期:<?php echo $row_showmsgRec['msg_send_date']; ?></td>
  </tr>
  <!-----------------------------討論主題----------------------------->
  <tr>
    <td>2.討論主題:<input name="msg_title" type="text" class=sizeL value="<?php echo $row_showmsgRec['msg_title']; ?>"/></td>
  </tr>
  <!-----------------------------留言人----------------------------->
  <tr>
    <td>3.發表人:<input name="mem_nickname" type="text" class=sizeS value="<?php echo $row_showmsgRec['mem_nickname']; ?>"/></td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td>4.圖片:
     <p><img src="../../images/discussimg/small/<?php echo $row_showmsgRec['msg_img']; ?>" alt="" name="image"
           width="78px" height="65px" id="image" align="center" style="padding:5px;"/>
       <input name="msg_img" type="hidden" value="<?php echo $row_showmsgRec['msg_img']; ?>" />
       <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/> </p>
     </td>
  </tr>
  <!----------------------------留言內容---------------------------->
  <tr>
    <td>5.留言內容:<br>
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
<textarea cols='50' rows='10' class="ckeditor"  name='msg_send'><?php echo $row_showmsgRec['msg_send'];?></textarea></td>
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
<p>&nbsp;</p>


<?php if($totalRows_showsubmsgRec > 0) {?>
<!--------------------------回覆留言內容------------------------------------>
<table width="97%" border="0" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0">
<form name="editsubmsg" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="editsubmsg">
  <!-------------------------------------------------------------->
  <tr bgcolor="#999999">
    <td height="10%" colspan="4" align="center"><p><font color="#FFFFFF">編輯回覆討論</font></p></td>
  </tr>
  <!-------------------------------------------------------------->
  <?php do { ?>
  <tr>
    <td height="90%" colspan="2" align="center">
      <table width="100%" border="1" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0" class="admin_submsg_table">
        <!----------------------------留言日期---------------------------->
        <tr bgcolor="#CCCCCC">
          <td width="10%" height="20%" align="left" colspan="2">留言日期：<?php echo $row_showsubmsgRec['sub_msg_date']; ?></td>
        </tr>
        <!-----------------------------留言人----------------------------->
        <tr>
          <td width="10%" height="20%" align="center">留言人</td>
          <td width="40%" height="20%" align="left"><?php echo $row_showsubmsgRec['mem_nickname']; ?></td>
        </tr>
        <!----------------------------留言圖片---------------------------->
        <tr>
          <td width="10%" height="50%" align="center">留言圖片</td>
          <td width="40%" height="50%" align="left">
            <img src="../../images/discussimg/small/<?php echo $row_showsubmsgRec['msg_img']; ?>" alt="" name="image"
             width="78px" height="65px" id="image" align="center" style="padding:5px;"/>
          </td>
        </tr>
        <!----------------------------留言內容---------------------------->
        <tr>
          <td width="10%" height="20%" align="center">留言內容</td>
          <td width="40%" height="20%" align="left"><?php echo $row_showsubmsgRec['msg_send'];?></td>
        </tr>
        <!----------------------------------------------------------->
        <tr>
          <td width="10%" height="20%" align="center">
            <input id="sub_msg_no" name="sub_msg_no" type="hidden" value="<?php echo $row_showsubmsgRec['sub_msg_no'];?>" />
            <input id="msg_no" name="msg_no" type="hidden" value="<?php echo $row_showsubmsgRec['msg_no'];?>" />
          </td>
          <td width="40%" height="20%" align="left">
            <input id="del_subMsg" name="del_subMsg" type="submit" value="刪除"/></td>
        </tr>
        <!----------------------------------------------------------->
		<tr>
           <td colspan="2"><p>&nbsp;</p></td>
        </tr>
      </table>
    </td>
  </tr>

  <?php } while ($row_showsubmsgRec = mysql_fetch_assoc($showsubmsgRec)); ?>
</form>
</table>
<?php }?>
<?php
mysql_free_result($showmsgRec);
mysql_free_result($showsubmsgRec);
?>
