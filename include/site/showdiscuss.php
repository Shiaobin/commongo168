<?php  //-----------------------------取得討論區資訊----------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_msgRec = 20;
$pageNum_msgRec = 0;
if (isset($_GET['pageNum_msgRec'])) {
  $pageNum_msgRec = $_GET['pageNum_msgRec'];
}
$startRow_msgRec = $pageNum_msgRec * $maxRows_msgRec;

$table_shop_member_msg		= SYS_DBNAME . ".shop_member_msg";
$column = "*";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_msgRec}, {$maxRows_msgRec} ",
		'mssql'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_msgRec}, {$maxRows_msgRec} ",
		'oci8'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_msgRec}, {$maxRows_msgRec} "
);
$row_msgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

/*
mysql_select_db($database_webshop, $webshop);
$query_msgRec = "SELECT * FROM shop_member_msg ORDER BY msg_send_date DESC";
$query_limit_msgRec = sprintf("%s LIMIT %d, %d", $query_msgRec, $startRow_msgRec, $maxRows_msgRec);
$msgRec = mysql_query($query_limit_msgRec, $webshop) or die(mysql_error());
$row_msgRec = mysql_fetch_assoc($msgRec);
*/
$total_msgRec = sizeof($row_msgRec);

if(isset($_GET['totalRows_msgRec'])){
    $totalRows_msgRec = $_GET['totalRows_msgRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC ",
		'mssql'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC ",
		'oci8'	=> "SELECT * FROM {$table_shop_member_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC "
);
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
<?php  //-----------------------------取得使用者IP---------------------------------//
if (!empty($_SERVER['HTTP_CLIENT_IP']))
{
  $ip=$_SERVER['HTTP_CLIENT_IP'];
}
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
  $ip=$_SERVER['REMOTE_ADDR'];
}
?>
<?php

	$_SESSION["discuss"]="true";

?>
<!--會員登入檢查-->
<?php
if ((isset($_POST["check"]))&&($_POST["check"]=="會員登入檢查")) {
	if(isset($_SESSION['MM_Username'])) {
		$addGoTo = "adddiscuss.php";
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
<!--------------------------------------------------------------------------------->
<h3 class="ttl01">討論區</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
<form name="showdiscuss" action="" method="POST"  id="showdiscuss">
 <tr><td colspan=5 ><input type="image" name="check" value="會員登入檢查" src="../../img/recruit_btn04.jpg"></a></td></tr>
  <tr>
    <th >公告時間</th>
    <th >文章標題</th>
    <th >發表人</th>
    <th >回應</th>
    <th >點閱</th>
  </tr>
  <!-------------------------------------------------------------->
  <?php if ($total_msgRec > 0) { // Show if recordset not empty ?>
    <?php
	    foreach ($row_msgRec as $key => $array){  ?>
          <tr>
            <td bgcolor="#CCCCCC">
              <?php echo date('Y-m-d',strtotime($array['msg_send_date']));?>
            </td>
            <!-------------------------------------------------------------->
            <td >
              <a href="../discussdetail.php?msg_no=<?php echo $array["msg_no"];?>">
	            <?php echo $array["msg_title"];?>
              </a>
            </td>
            <!-------------------------------------------------------------->
            <td bgcolor="#CCCCCC">
              <?php echo $array["mem_nickname"];?>
            </td>
            <!-------------------------------------------------------------->
            <td >
            <?php
				$table_shop_member_sub_msg		= SYS_DBNAME . ".shop_member_sub_msg";
				$column = "*";
				$whereClause = "msg_no={$array['msg_no']}";

				$sql['list']['select'] = array(
						'mysql'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause}",
						'mssql'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause}",
						'oci8'	=> "SELECT * FROM {$table_shop_member_sub_msg} WHERE {$whereClause}"
				);
				$row_subRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

				/*
				mysql_select_db($database_webshop, $webshop);
				$query_subRec = sprintf("SELECT * FROM shop_member_sub_msg WHERE msg_no = %s", GetSQLValueString($row_msgRec['msg_no'], "int"));
				$subRec = mysql_query($query_subRec, $webshop) or die(mysql_error());
				$row_subRec = mysql_fetch_assoc($subRec);
				*/
				$totalRows_subRec = sizeof($row_subRec);

				 echo $totalRows_subRec;?>
            </td>
            <!-------------------------------------------------------------->
            <td bgcolor="#CCCCCC">
              <?php echo $array["cktimes"];?>
            </td>
          </tr>
    <?php
	} ?>
  <?php } // Show if recordset not empty ?>
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="5" align="right" bgcolor="#dddddd">
      <table width="10%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
        <tr><td><input type="image" name="check" value="會員登入檢查" src="../../img/recruit_btn04.jpg"></td>
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
  <tr>
  </form>
  </table>

<?php
//mysql_free_result($msgRec);
?>
