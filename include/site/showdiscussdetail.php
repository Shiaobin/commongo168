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
<?php  //-----------------------------取得回覆留言資訊------------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_msgRec = 5;
$pageNum_msgRec = 0;
if (isset($_GET['pageNum_msgRec'])) {
  $pageNum_msgRec = $_GET['pageNum_msgRec'];
}
$startRow_msgRec = $pageNum_msgRec * $maxRows_msgRec;


$cloume_showmsgRec = "%";
if (isset($_GET['msg_no'])) {
  $cloume_showmsgRec = $_GET['msg_no'];
}

$table_shop_member_sub_msg		= SYS_DBNAME . ".shop_member_sub_msg";
$column = "*";
$whereClause = "msg_no='{$cloume_showmsgRec}'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause} ORDER BY sub_msg_date ASC LIMIT {$startRow_msgRec}, {$maxRows_msgRec}", 
		'mssql'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause} ORDER BY sub_msg_date ASC LIMIT {$startRow_msgRec}, {$maxRows_msgRec}",
		'oci8'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause} ORDER BY sub_msg_date ASC LIMIT {$startRow_msgRec}, {$maxRows_msgRec}"
);
$row_msgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$total_msgRec = sizeof($row_msgRec);
/*
mysql_select_db($database_webshop, $webshop);
$query_msgRec = "SELECT * FROM shop_member_sub_msg WHERE msg_no='$cloume_showmsgRec' ORDER BY sub_msg_date ASC";
$query_limit_msgRec = sprintf("%s LIMIT %d, %d", $query_msgRec, $startRow_msgRec, $maxRows_msgRec);
$msgRec = mysql_query($query_limit_msgRec, $webshop) or die(mysql_error());
$row_msgRec = mysql_fetch_assoc($msgRec);
$total_msgRec = mysql_num_rows($msgRec);

*/

if (isset($_GET['totalRows_msgRec'])) {
  $totalRows_msgRec = $_GET['totalRows_msgRec'];
} else {
  $all_msgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_msgRec = sizeof($all_msgRec);
}
$totalPages_msgRec = ceil($totalRows_msgRec/$maxRows_msgRec)-1;

$queryString_msgRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_msgRec") == false && 
        stristr($param, "totalRows_msgRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_msgRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_msgRec = sprintf("&totalRows_msgRec=%d%s", $totalRows_msgRec, $queryString_msgRec);
?>
<?php //-------------------------------更新人氣值------------------------------------//
if (isset($_GET["msg_no"])) {	
  $table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
  $record = array(
  			'cktimes' => $row_showmsgRec['cktimes']+1
			); 
	$whereClause = "msg_no='{$_GET['msg_no']}'";
	dbUpdate( $table_shop_member_msg, $record, $whereClause );
	/*
  $updateSQL = sprintf("UPDATE shop_member_msg SET cktimes=cktimes+1 where msg_no=%s", 
					    GetSQLValueString($_GET['msg_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
}
?>
<?php  //---------------------------我要回覆功能-------------------------------//
if ((isset($_POST["add_btn"])) && ($_POST["add_btn"] == "我要回覆")) {
	if(isset($_SESSION['MM_Username'])) {
		$addGoTo = "adddiscuss.php?msg_no=".$row_showmsgRec['msg_no'];
		echo "<script type='text/javascript'>";
		echo "window.location.href='$addGoTo'";
		echo "</script>"; 
	}else{
		echo "<script language=\"javascript\">";
		echo "window.alert(\"請先登入會員\");";
		echo "</script>";
    }
}
?>
<!----------------------------------------------------------------------------------->
<h2>編輯討論主題</h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
<!--<form name="editmsg" action="" method="POST" 
 enctype="multipart/form-data" id="editmsg">-->
<form name="editmsg" action="<?php echo $editFormAction; ?>" method="POST" 
 enctype="multipart/form-data" id="editmsg">
  <!-------------------------------------------------------------->

        <input type="hidden" name="msg_no" id="msg_no" value="<?php echo $row_showmsgRec['msg_no']; ?>"/>


  <!----------------------------留言日期---------------------------->
  <tr>
    <td height="30" align="right" colspan="2">
    	<?php echo $row_showmsgRec['msg_send_date']; ?>
    </td>
  </tr> 
  <!-----------------------------討論主題----------------------------->
  <tr>
    <td height="30" align="left" colspan="2">
    	<font color="#0000FF">討論主題：<?php echo $row_showmsgRec['msg_title']; ?></font><br>
		發表人：<?php echo $row_showmsgRec['mem_nickname']; ?>
    </td>
  </tr> 
  <!----------------------------圖片---------------------------->  
  <tr>
     <td align="left" width="90px" height="30">
     <p><img src="../../images/discussimg/medium/<?php  echo $row_showmsgRec['msg_img']; ?>" alt="" name="image" width="90px" height="75px" id="image" align="center" style="padding:5px;"/>
       <input name="msg_img" type="hidden" value="<?php echo $row_showmsgRec['msg_img']; ?>" />
     </p>
     </td>
  <!----------------------------留言內容---------------------------->
     <td align="left" height="30"><?php echo $row_showmsgRec['msg_send'];?></td>
  </tr>
  <tr>
    <td height="30" align="right" colspan="2">
    	<font color="#0000FF">本頁瀏覽次數:<?php echo $row_showmsgRec['cktimes']; ?>次</font>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left" height="30"><input name="add_btn" type="submit" value="我要回覆" style="margin:5px"></td>
  </tr>
 
</form>
</table>
<p>&nbsp;</p>


<?php if($totalRows_msgRec > 0) {?>
<!--------------------------回覆留言內容------------------------------------>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
<!--<form name="editsubmsg" action="" method="POST" enctype="multipart/form-data" id="editsubmsg">-->
<form name="editsubmsg" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="editsubmsg">
  <!-------------------------------------------------------------->
  <tr bgcolor="#999999">
    <td width="60px" height="10%" align="center"><font color="#FFFFFF">回覆人</font></td>
    <td height="10%" align="center" height="30"><font color="#FFFFFF">文章內容</font></td>
  </tr>
  <!-------------------------------------------------------------->
  <?php foreach ($row_msgRec as $key => $array){  ?>
        <!----------------------------留言日期---------------------------->
        <tr bgcolor="#CCCCCC">
        <td height="30" align="left">留言人：<?php echo $array['mem_nickname']; ?></td>
          <td height="30" align="right">留言日期：<?php echo $array['sub_msg_date']; ?></td>
        </tr>  
        <!----------------------------留言圖片---------------------------->
        <tr>
          <td height="60%" align="left" width="60px">
            <img src="../../images/discussimg/medium/<?php echo $array['msg_img']; ?>" alt="" name="image" width="90px" height="75px" id="image" align="center" style="padding:5px;"/>
          </td>
          <td align="left" height="60%"><?php echo $array['msg_send'];?></td>
        </tr>
        <!----------------------------留言內容---------------------------->

  <?php } ?>
  <tr>
    <td height="8%" colspan="5" align="right">&nbsp;
      <table border="0">
        <tr>
          <td>
          <?php if ($pageNum_msgRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_msgRec=%d%s", $currentPage, 0, $queryString_msgRec); ?>">
              <img src="../../images/symbol/First.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_msgRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_msgRec=%d%s", $currentPage, max(0, $pageNum_msgRec - 1), $queryString_msgRec); ?>">
              <img src="../../images/symbol/Previous.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_msgRec < $totalPages_msgRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_msgRec=%d%s", $currentPage, min($totalPages_msgRec, $pageNum_msgRec + 1), $queryString_msgRec); ?>">
              <img src="../../images/symbol/Next.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
          <td>
          <?php if ($pageNum_msgRec < $totalPages_msgRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_msgRec=%d%s", $currentPage, $totalPages_msgRec, $queryString_msgRec); ?>">
              <img src="../../images/symbol/Last.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</form>
</table>
<?php }?>
<?php
//mysql_free_result($newsRec);
?>
