<?php  //---------------------------取出留言資訊---------------------------------//
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_showmsgRec = 10;
$pageNum_showmsgRec = 0;
if (isset($_GET['pageNum_showmsgRec'])) {
  $pageNum_showmsgRec = $_GET['pageNum_showmsgRec'];
}
$startRow_showmsgRec = $pageNum_showmsgRec * $maxRows_showmsgRec;
/*
mysql_select_db($database_webshop, $webshop);
$query_showmsgRec = "SELECT * FROM shop_member_msg ORDER BY msg_send_date DESC";
$query_limit_showmsgRec = sprintf("%s LIMIT %d, %d", $query_showmsgRec, $startRow_showmsgRec, $maxRows_showmsgRec);
$showmsgRec = mysql_query($query_limit_showmsgRec, $webshop) or die(mysql_error());
$row_showmsgRec = mysql_fetch_assoc($showmsgRec);
*/
$column = "*";
$table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}", 
		'mssql'	=> "SELECT {$column} FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}"
);
$row_showmsgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

if (isset($_GET['totalRows_showmsgRec'])) {
  $totalRows_showmsgRec = $_GET['totalRows_showmsgRec'];
} else {
  $all_showmsgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showmsgRec = sizeof($all_showmsgRec);
}
$totalmsg_showmsgRec = ceil($totalRows_showmsgRec/$maxRows_showmsgRec)-1;

$queryString_showmsgRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showmsgRec") == false && 
        stristr($param, "totalRows_showmsgRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showmsgRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showmsgRec = sprintf("&totalRows_showmsgRec=%d%s", $totalRows_showmsgRec, $queryString_showmsgRec);
?>
<?php  //---------------------------上架功能---------------------------------//
if ((isset($_POST["open_btn"])) && ($_POST["open_btn"] == "公開")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."msg_no='".$_POST['select_page'][$i]."'";
      }
	  
	  $record = array( 'set_open' => '1' );
	  $table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
	  $whereClause = "CONCAT($update_string)";
	  
	  dbUpdate( $table_shop_member_msg, $record, $whereClause );
	  /*
	  $updateSQL = "UPDATE shop_member_msg SET set_open='1' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
	  $updateGoTo = "adminmembermsg.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------下架功能---------------------------------//
if ((isset($_POST["close_btn"])) && ($_POST["close_btn"] == "隱藏")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."msg_no='".$_POST['select_page'][$i]."'";
      }
	  
	  $record = array( 'set_open' => '0' );
	  $table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
	  $whereClause = "CONCAT($update_string)";
	  
	  dbUpdate( $table_shop_member_msg, $record, $whereClause );
	  /*
	  $updateSQL = "UPDATE shop_member_msg SET set_open='0' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
	  $updateGoTo = "adminmembermsg.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------刪除功能---------------------------------//
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."msg_no='".$_POST['select_page'][$i]."'";
      }
	  
	  //刪除圖片
	  $column = "*";
	  $table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
	  $whereClause = "CONCAT($string)";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_shop_member_msg} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_shop_member_msg} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_shop_member_msg} WHERE {$whereClause}"
	  );
	  $row_searchImg = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  /*
      mysql_select_db($database_webshop, $webshop);
      $searchSQL = "SELECT * FROM shop_member_msg WHERE CONCAT($delete_string) ";
      $searchImg = mysql_query($searchSQL, $webshop) or die(mysql_error());
	  $row_searchImg = mysql_fetch_assoc($searchImg);
		*/
      foreach ($row_searchImg as $key => $array){ 
	  if(($array['msg_img'] != "none.gif")){ 
          unlink("../images/discussimg/medium/".$array["msg_img"]);
  		  unlink("../images/discussimg/small/".$array["msg_img"]);}
      }
	  
	  $table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
	  $whereClause = "CONCAT($delete_string)";
					
	  dbDelete( $table_shop_member_msg, $whereClause );
	  /*
	  $deleteSQL = "DELETE FROM shop_member_msg WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
	  */
	  //刪除子留言及圖片
	  
	  $column = "*";
	  $table_shop_member_sub_msg		= SYS_DBNAME . ".shop_member_sub_msg";
	  $whereClause = "CONCAT($string)";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_shop_member_sub_msg} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_shop_member_sub_msg} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_shop_member_sub_msg} WHERE {$whereClause}"
	  );
	  $row_subImg = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  /*
	  $subSQL = "SELECT * FROM shop_member_sub_msg WHERE CONCAT($delete_string) ";
	  $subImg = mysql_query($subSQL, $webshop) or die(mysql_error());
	  $row_subImg = mysql_fetch_assoc($subImg);
	  */
	  foreach ($row_subImg as $key => $array){ 
	  if(($array['msg_img'] != "none.gif")){ 
          unlink("../images/discussimg/medium/".$array["msg_img"]);
  		  unlink("../images/discussimg/small/".$array["msg_img"]);}
      }
	  
	  $table_shop_member_sub_msg		= SYS_DBNAME . ".shop_member_sub_msg";
	  $whereClause = "CONCAT($delete_string)";
					
	  dbDelete( $table_shop_member_sub_msg, $whereClause );
	  /*
	  $deleteSubSQL = "DELETE FROM shop_member_sub_msg WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $subResult = mysql_query($deleteSubSQL, $webshop) or die(mysql_error());
	  */
	  
	  $deleteGoTo = "adminmembermsg.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------加新話題功能-------------------------------//
if ((isset($_POST["add_btn"])) && ($_POST["add_btn"] == "加新話題")) {
	$addGoTo = "adminaddmembermsg.php";
    echo "<script type='text/javascript'>";
    echo "window.location.href='$addGoTo'";
    echo "</script>"; 
}
?>


<script>
function check_all(obj,cName) 
{ 
    var checkboxs = document.getElementsByName(cName); 
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
</script>
<h3 class=ttl01 >討論區管理</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">

<form action="" name="edit_msg" method="POST" id="edit_msg" enctype="multipart/form-data">
<tr>
  <td align="right" colspan="8"><input name="add_btn" type="submit" value="加新話題" style="margin:5px"></td>
</tr>
<!-------------------------------------------------------------->
<tr align="center" bgcolor="#99CCFF">
  <td width="3%">選擇</td>
  <td width="20%">公告日期</td>
  <td width="30%">討論話題</td>
  <td width="9%">圖片</td>
  <td width="14%">刊登者</td>
  <td width="8%">在線</td>
  <td width="9%">詳細內容</td>
  <td width="5%">回覆內容</td>
</tr>
<!-------------------------------------------------------------->
<?php foreach ($row_showmsgRec as $key => $array){  ?>
  <?php if ($totalRows_showmsgRec > 0) { // Show if recordset not empty ?>
  <tr align="center">
      <td width="3%"><input name="select_page[]" type="checkbox" value="<?php echo $array['msg_no']; ?>" /></td>
      <td width="20%">
	    <?php echo $array['msg_send_date']; ?>
      </td>
      <td align="left" ><a href="admineditmembermsg.php?msg_no=<?php echo $array['msg_no']; ?>"><?php echo $array['msg_title']; ?></a></td>
      <td height="50%"><a href="admineditmembermsg.php?msg_no=<?php echo $array['msg_no']; ?>">
        <img src="../images/discussimg/small/<?php echo $array['msg_img']; ?>" alt="" name="image" 
           width="78px" height="65px" id="image" align="center" style="padding:5px;"/></a>
      </td>
      <td width="14%"><?php echo $array['mem_nickname']; ?></td>
      <td width="8%"><?php if($array['set_open'] == 1)echo "公開"; else echo "隱藏";?></td>
      <td width="9%"><a href="admineditmembermsg.php?msg_no=<?php echo $array['msg_no']; ?>">查看</a></td>
	  <td width="5%"><a href="adminmembersubmsg.php?msg_no=<?php echo $array['msg_no']; ?>">回覆內容</a></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } ?>
<!-------------------------------------------------------------->
<tr>
  <td colspan="8" align="left">
    <input type="checkbox" name="all" onclick="check_all(this,'select_page[]')" />全選
    <input name="delete_btn" type="submit" value="刪除" />
    <input name="close_btn" type="submit" value="隱藏" />
    <input name="open_btn" type="submit" value="公開" />
  </td>
</tr>
<!-----------------------------page control----------------------------->
<tr> 
  <td colspan="8" align="right" bgcolor="#cfcfcf">
    <table border="0">
      <tr>
        <td>共<?php echo $totalRows_showmsgRec ?> 筆資料</td>
        <td align="right">
		  <?php if ($pageNum_showmsgRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showmsgRec=%d%s", $currentPage, 0, $queryString_showmsgRec); ?>"><img src="../../images/symbol/First.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showmsgRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showmsgRec=%d%s", $currentPage, max(0, $pageNum_showmsgRec - 1), $queryString_showmsgRec); ?>"><img src="../../images/symbol/Previous.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showmsgRec < $totalmsg_showmsgRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showmsgRec=%d%s", $currentPage, min($totalmsg_showmsgRec, $pageNum_showmsgRec + 1), $queryString_showmsgRec); ?>"><img src="../../images/symbol/Next.gif" class="img"/></a>
          <?php } // Show if not last page ?>
		  <?php if ($pageNum_showmsgRec < $totalmsg_showmsgRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showmsgRec=%d%s", $currentPage, $totalmsg_showmsgRec, $queryString_showmsgRec); ?>"><img src="../../images/symbol/Last.gif" class="img"/></a>
          <?php } // Show if not last page ?>
        </td>
      </tr>
    </table>
  </td>
</tr>
</form>
<!-------------------------------------------------------------->
</table>
<?php
//mysql_free_result($showmsgRec);
?>
