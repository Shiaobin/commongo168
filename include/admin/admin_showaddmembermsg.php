<?php  //-----------------------------新增商品資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增") && ($_POST['msg_title'] != "") && ($_POST['mem_nickname'] != "")) {

    //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

	$img = date('his').".jpg";
	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/discussimg/".$img
        ) or die("Problems with upload");
        resize_new_image($img);
  }
  else {
	$img = "none.gif";
  }


  $insertSQL = sprintf("INSERT INTO shop_member_msg (msg_title, mem_nickname, msg_send, msg_img) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['msg_title'], "text"),
                       GetSQLValueString($_POST['mem_nickname'], "text"),
					   GetSQLValueString($_POST['msg_send'], "text"),
                       GetSQLValueString($img, "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());

  $insertGoTo = "adminmembermsg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}

//---------------discuss img-------------------//
function resize_new_image($file) {
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

$imM->writeimages("../images/discussimg/medium/".$file, true);
$imS->writeimages("../images/discussimg/small/".$file, true);
unlink("../images/discussimg/".$file);
}
?>

<?php  //-----------------------------重設商品資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $endItemRec = "";
}
?>
<h3 class=ttl01 >新增討論主題</h3>

<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editmsg" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editmsg">

  <!-----------------------------討論主題----------------------------->
  <tr>
    <td>1.討論主題<font color="#FF3333">  *</font>:<input name="msg_title" type="text" class=sizeL /></td>
  </tr>
  <!-----------------------------留言人----------------------------->
  <tr>
    <td>2.發表人<font color="#FF3333">  *</font>:<input name="mem_nickname" type="text" class=sizeS /></td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td>3.圖片:
       <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/>
     </td>
  </tr>
  <!----------------------------留言內容---------------------------->
  <tr>
    <td>4.留言內容:
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
<textarea  class=ckeditor cols='50' rows='10' name='msg_send'></textarea></td>
  </tr>
    <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input type="submit" name="MM_insert"  value="新增" style="font-size:16px;width:60px;height:30px" />
      <input type="reset" name="MM_reset"  value="重設" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
</form>
</table>
