<?php  //-----------------------------取得留言資訊------------------------------------//
//$sysConnDebug = true;
$cloume_showmsgRec = "%";
if (isset($_GET['msg_no'])) {
  $cloume_showmsgRec = $_GET['msg_no'];
}

$table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
$column = "*";
$whereClause = "msg_no='{$cloume_showmsgRec}'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause}"
);
$row_showmsgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showmsgRec = sprintf("SELECT * FROM shop_member_msg WHERE msg_no=%s",
                               GetSQLValueString($cloume_showmsgRec, "int"));
$showmsgRec = mysql_query($query_showmsgRec, $webshop) or die(mysql_error());
$row_showmsgRec = mysql_fetch_assoc($showmsgRec);
$totalRows_showmsgRec = mysql_num_rows($showmsgRec);
*/
?>
<?php  //-----------------------------新增商品資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
 $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增") && ($_POST['mem_nickname'] != "")&& ($_POST['msg_send'] != "")) {  
  
    //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

	$img = date('his').".jpg";
	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "images/discussimg/".$img
        ) or die("Problems with upload");
        resize_discuss_img($img);
		
  }
  else {
	$img = "none.gif";
  }
  if($_POST['msg_title']==""){
		$_POST['msg_title']=iconv_substr($_POST['msg_send'],0,20,'utf-8');
	}
  $table="";
  $field="";
  $post_field="";
  $goto="";
  if($_SESSION["discuss"]=="true"){
	$table="shop_member_msg";
	$field="msg_title";
	$post_field=$_POST['msg_title'];
	$goto="../../discuss.php";
  }else{
	$table="shop_member_sub_msg";
	$field="msg_no";
	$post_field=$_POST['msg_no'];
	$goto="discussdetail.php";
  }

  $table_shop_member_msg		= SYS_DBNAME . ".{$table}";
  $record = array(
  				$field => $post_field,
				'mem_nickname' => $_POST['mem_nickname'],
				'msg_send' => $_POST['msg_send'],
				'msg_img' => $img
				);
  dbInsert( $table_shop_member_msg, $record );
  /*
  $insertSQL = sprintf("INSERT INTO $table ($field, mem_nickname, msg_send, msg_img) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($post_field, "text"),
                       GetSQLValueString($_POST['mem_nickname'], "text"),
					   GetSQLValueString($_POST['msg_send'], "text"),
                       GetSQLValueString($img, "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
*/
  $insertGoTo =$goto;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
 //echo "window.location.href='$insertGoTo'";
  echo "</script>";
  
}

//---------------discuss img-------------------//
function resize_discuss_img($file) {
$imM = new Imagick("images/discussimg/".$file);
$imS = new Imagick("images/discussimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(600, 500);
$frameM->setImagePage(600, 500, 0, 0);
}

foreach ($imS as $frameS) {
$frameS->thumbnailImage(120, 100);
$frameS->setImagePage(120, 100, 0, 0);
}

$imM->writeImages("images/discussimg/medium/".$file, true);
$imS->writeImages("images/discussimg/small/".$file, true);
unlink("images/discussimg/".$file);
}
?>


<?php  //-----------------------------重設商品資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $endItemRec = "";
}
?>

<!-------------------------------------------------------------->
<h2>討論主題新增</h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editmsg" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="editmsg">
  <!-------------------------------------------------------------->
<input name="msg_no" type="hidden" value="<?php echo $row_showmsgRec['msg_no']; ?>" />
  <!-----------------------------討論主題----------------------------->
  <tr>
    <td align="center">討論主題</td>
	<td align="left">
	<?php if($_SESSION["discuss"]=="true"){ ?>
	<input name="msg_title" type="text" style="width:60%; height:90%; margin: 3px"/>
	<?php 
	}else{ 
	echo $row_showmsgRec['msg_title']; }
	?>
	</td>
     <!--<td align="left"><?php echo $row_showmsgRec['msg_title']; ?></td>-->
  </tr> 
  <!-----------------------------留言人----------------------------->
  <tr>
    <td  align="center">發表人<font color="#FF3333">  *</font></td>
    <td  align="left"><input name="mem_nickname" type="text" style="width:60%; height:90%; margin: 3px"/></td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td width="10%" height="10%" align="center">頭像圖片</td>
     <td>
       <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/> 
     </td>
  </tr>
  <!----------------------------留言內容---------------------------->
  <tr>
    <td width="10%" height="50%" align="center">回應內容<font color="#FF3333">  *</font></td>
    <td width="40%" height="50%" align="left"><textarea cols='30' rows='10' name='msg_send'></textarea></td>
  </tr>
    <!------------------------新增按鈕---------------------------->
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%"  align="left">
      <input type="submit" name="MM_insert"  value="新增" style="width:10%; height:100%; margin: 3px"/>
      <input type="reset" name="MM_reset"  value="重設" style="width:10%; height:100%; margin: 3px"/>
    </td>
  </tr>
</form>
</table>
