<?php  //-----------------------------更新留言資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


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
	  $subpic =	sprintf("SELECT * FROM shop_member_sub_msg WHERE sub_msg_no=%s",GetSQLValueString($_POST['sub_msg_no'], "int"));
	  $delpic = mysql_query($subpic, $webshop) or die(mysql_error());
	  $pic = mysql_fetch_assoc($delpic);
	   if($pic['msg_img'] != "none.gif"){ 
		 unlink("../images/discussimg/medium/".$pic["msg_img"]);
		 unlink("../images/discussimg/small/".$pic["msg_img"]);
		}
	  
	  $updateSQL = sprintf("DELETE FROM shop_member_sub_msg WHERE sub_msg_no=%s",GetSQLValueString($_POST['sub_msg_no'], "int"));
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  
	  $updateGoTo = "adminmembersubmsg.php?msg_no=".$_POST["msg_no"];
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>

<?php  //---------------checkbox delete---------------//
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."sub_msg_no='".$_POST['select_page'][$i]."'";
      }
	  
	  mysql_select_db($database_webshop, $webshop);
	  $subSQL = "SELECT * FROM shop_member_sub_msg WHERE CONCAT($delete_string) ";
	  $subImg = mysql_query($subSQL, $webshop) or die(mysql_error());
	  $row_subImg = mysql_fetch_assoc($subImg);
	  
	  do{ 
	  if(($row_subImg['msg_img'] != "none.gif")){ 
          unlink("../images/discussimg/medium/".$row_subImg["msg_img"]);
  		  unlink("../images/discussimg/small/".$row_subImg["msg_img"]);}
      }while ($row_subImg = mysql_fetch_assoc($subImg));
	  
	  
	  $deleteSubSQL = "DELETE FROM shop_member_sub_msg WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $subResult = mysql_query($deleteSubSQL, $webshop) or die(mysql_error());
	  
	  
	  $deleteGoTo = "adminmembersubmsg.php?msg_no=".$_POST["no"];
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }else{
	  $deleteGoTo = "adminmembersubmsg.php?msg_no=".$_POST["no"];
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
	}
}
?>
<script>
function check_all(obj,cName) 
{ 
    var checkboxs = document.getElementsByName(cName); 
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
</script>

<h3 class=ttl01 >回覆內容列表</h3>




<!--------------------------回覆留言內容------------------------------------>
<table width="100%" border="1" BORDERCOLOR="grey" cellpadding="0" cellspacing="0" class="tableLayout01">
<form name="editsubmsg" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="editsubmsg">
  <!-------------------------------------------------------------->
  <tr align="center" bgcolor="#91FEFF">
    <!--<td height="10%" colspan="4" align="center"><p><font color="#FFFFFF">編輯回覆討論</font></p></td>-->
	<td width="3%">選擇</td>
	<td width="18%">留言日期</td>
	<td width="14%">留言人</td>
	<td width="10%">留言圖片</td>
	<td width="30%">留言內容</td>
	<td width="5%">修改</td>
	<td width="5%">刪除</td>
  </tr>
  <!-------------------------------------------------------------->
  <?php if($totalRows_showsubmsgRec > 0) {?>
  <?php do { ?>
  <tr align="center">
    <td><input name="select_page[]" type="checkbox" value="<?php echo $row_showsubmsgRec['sub_msg_no']; ?>" /></td>
    <td><?php echo $row_showsubmsgRec['sub_msg_date']; ?></td>
	<td><?php echo $row_showsubmsgRec['mem_nickname']; ?></td>
	<td><a href="admineditmembersubmsg.php?sub_msg_no=<?php echo $row_showsubmsgRec['sub_msg_no']; ?>"><img src="../../images/discussimg/small/<?php echo $row_showsubmsgRec['msg_img']; ?>" alt="" name="image" width="78px" height="65px" id="image" align="center" style="padding:5px;"/></a></td>
	<td align="left"><a href="admineditmembersubmsg.php?sub_msg_no=<?php echo $row_showsubmsgRec['sub_msg_no']; ?>"><?php echo iconv_substr($row_showsubmsgRec['msg_send'],0,30,'utf-8');?></a></td>
	<td><a href="admineditmembersubmsg.php?sub_msg_no=<?php echo $row_showsubmsgRec['sub_msg_no']; ?>">修改</a></td>
	<td>
		<input id="sub_msg_no" name="sub_msg_no" type="hidden" value="<?php echo $row_showsubmsgRec['sub_msg_no'];?>" />
        <input id="msg_no" name="msg_no" type="hidden" value="<?php echo $row_showsubmsgRec['msg_no'];?>" />
		<input id="del_subMsg" name="del_subMsg" type="submit" value="刪除"/>
	</td>
  </tr>
  <?php } while ($row_showsubmsgRec = mysql_fetch_assoc($showsubmsgRec)); ?>
  <tr>
   <td colspan="7" >
    <input type="checkbox" name="all" onclick="check_all(this,'select_page[]')" />全選
    <input id="no" name="no" type="hidden" value="<?php echo $_GET['msg_no'];?>" />
    <input name="delete_btn" type="submit" value="刪除" />
   </td>
  </tr>
  <?php }?>
  <tr bgcolor="#EBFFFF">
   <td colspan="7" align="right">共<?php echo $totalRows_showsubmsgRec ?> 筆回覆</td>
  </tr>
</form>
</table>
<?php
mysql_free_result($showsubmsgRec);
?>
