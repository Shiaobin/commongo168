<?php  //---------------------------取出檔案資訊---------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_showfilesRec = 10;
$pageNum_showfilesRec = 0;
if (isset($_GET['pageNum_showfilesRec'])) {
  $pageNum_showfilesRec = $_GET['pageNum_showfilesRec'];
}
$startRow_showfilesRec = $pageNum_showfilesRec * $maxRows_showfilesRec;

$table_download		= SYS_DBNAME . ".download";
$whereClause = "1=1";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_showfilesRec}, {$maxRows_showfilesRec}",
		'mssql'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_showfilesRec}, {$maxRows_showfilesRec}",
		'oci8'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_showfilesRec}, {$maxRows_showfilesRec}"
		);
$row_showfilesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

/*
mysql_select_db($database_webshop, $webshop);
$query_showfilesRec = "SELECT * FROM download ORDER BY Dow_date DESC";
$query_limit_showfilesRec = sprintf("%s LIMIT %d, %d", $query_showfilesRec, $startRow_showfilesRec, $maxRows_showfilesRec);
$showfilesRec = mysql_query($query_limit_showfilesRec, $webshop) or die(mysql_error());
$row_showfilesRec = mysql_fetch_assoc($showfilesRec);
*/
if (isset($_GET['totalRows_showfilesRec'])) {
  $totalRows_showfilesRec = $_GET['totalRows_showfilesRec'];
} else {
  $all_showfilesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showfilesRec = sizeof($all_showfilesRec);
}
$totalfiles_showfilesRec = ceil($totalRows_showfilesRec/$maxRows_showfilesRec)-1;

$queryString_showfilesRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showfilesRec") == false &&
        stristr($param, "totalRows_showfilesRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showfilesRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showfilesRec = sprintf("&totalRows_showfilesRec=%d%s", $totalRows_showfilesRec, $queryString_showfilesRec);
?>

<?php  //---------------------------搜尋功能---------------------------------//
if ((isset($_POST["search_btn"])) && ($_POST["search_btn"] == "搜尋")) {
  $class = ($_POST["search_class"]);
  $name = trim($_POST["search_name"]);
  $open = $_POST["search_type"];

  $string = "";
  if($open == 0)
      $string = $string."set_open = '0'";
  else if($open == 1)
      $string = $string."set_open = '1'";
  else if($open == 2)
      $string = $string."(set_open = '0' || set_open = '1')";

  if($name != "") {
	$string = $string." && "."Dow_Name LIKE '%$name%'";
  }

  if($class != "-1") {
	 $string = $string." && "."download.class_id = '$class'";
  }

  $maxRows_showfilesRec = 8;
  $pageNum_showfilesRec = 0;
  if (isset($_GET['pageNum_showfilesRec'])) {
    $pageNum_showfilesRec = $_GET['pageNum_showfilesRec'];
  }
  $startRow_showfilesRec = $pageNum_showfilesRec * $maxRows_showfilesRec;

$table_download		= SYS_DBNAME . ".download";
	$whereClause = "CONCAT($string)";
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT * FROM {$table_download} LEFT JOIN index_files_class ON download.class_id = index_files_class.class_id WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_showfilesRec}, {$maxRows_showfilesRec}",
			'mssql'	=> "SELECT * FROM {$table_download} LEFT JOIN index_files_class ON download.class_id = index_files_class.class_id WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_showfilesRec}, {$maxRows_showfilesRec}",
			'oci8'	=> "SELECT * FROM {$table_download} LEFT JOIN index_files_class ON download.class_id = index_files_class.class_id WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_showfilesRec}, {$maxRows_showfilesRec}"
			);
	$row_showfilesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showfilesRec = sizeof($row_showfilesRec);
	/*
  mysql_select_db($database_webshop, $webshop);
  $query_showfilesRec = "SELECT * FROM download LEFT JOIN index_files_class ON download.class_id = index_files_class.class_id
	                    WHERE CONCAT($string) ORDER BY Dow_date DESC";
  $query_limit_showfilesRec = sprintf("%s LIMIT %d, %d", $query_showfilesRec, $startRow_showfilesRec, $maxRows_showfilesRec);
  $showfilesRec = mysql_query($query_limit_showfilesRec, $webshop) or die(mysql_error());
  $row_showfilesRec = mysql_fetch_assoc($showfilesRec);
  $totalRows_showfilesRec = mysql_num_rows($showfilesRec);
  */
  if (isset($_GET['totalRows_showfilesRec'])) {
    $totalRows_showfilesRec = $_GET['totalRows_showfilesRec'];
  } else {
    $all_showfilesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_showfilesRec = sizeof($all_showfilesRec);
  }
  $totalfiles_showfilesRec = ceil($totalRows_showfilesRec/$maxRows_showfilesRec)-1;
}
?>
<?php  //---------------------------上架功能---------------------------------//
if ((isset($_POST["open_btn"])) && ($_POST["open_btn"] == "上線")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."Dow_ID='".$_POST['select_page'][$i]."'";
      }

	  $table_download		= SYS_DBNAME . ".download";
	  $record = array( 'Online' => '1' );
	  $whereClause = "CONCAT($update_string)";
	  $is_update = dbUpdate( $table_download, $record, $whereClause );
	  /*
	  $updateSQL = "UPDATE download SET set_open='1' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
	  $updateGoTo = "adminfiles.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------下架功能---------------------------------//
if ((isset($_POST["close_btn"])) && ($_POST["close_btn"] == "下線")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."Dow_ID='".$_POST['select_page'][$i]."'";
      }

	  $table_download		= SYS_DBNAME . ".download";
	  $record = array( 'Online' => '0' );
	  $whereClause = "CONCAT($update_string)";
	  $is_update = dbUpdate( $table_download, $record, $whereClause );
	  /*
	  $updateSQL = "UPDATE download SET set_open='0' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
	  $updateGoTo = "adminfiles.php";
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
		$delete_string = $delete_string."Dow_ID='".$_POST['select_page'][$i]."'";
      }

	  $table_download		= SYS_DBNAME . ".download";
	  $whereClause = "CONCAT($delete_string)";
	  dbDelete( $table_download, $whereClause );
	  /*
	  $deleteSQL = "DELETE FROM download WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
	  */
	  $deleteGoTo = "adminfiles.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------加資料功能-------------------------------//
if ((isset($_POST["add_btn"])) && ($_POST["add_btn"] == "新增檔案")) {
	  $addGoTo = "adminaddfiles.php";
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
<h3 class=ttl01 >檔案管理</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
<tr>
  <td width="100%" height="35%" colspan="5" bgcolor="#cfcfcf">
    <table width="100%" border="0">
    <form action="" method="POST" name="search_files" id="search_files" enctype="multipart/form-data">
      <tr>
        <td align="left">關鍵字 <input name="search_name" type="text" class=sizeM /></td>
        <td align="left">
          <label>
            <input type="radio" name="search_type" value="0" id="search_type_0" />
            離線</label>
          <label>
            <input type="radio" name="search_type" value="1" id="search_type_1" />
            在線</label>
          <label>
            <input type="radio" name="search_type" value="2" id="search_type_2" checked/>
            全部</label>
        </td>
        <td align="left"><input type="submit" name="search_btn"  value="搜尋"/></td>
      </tr>
    </form>
    </table>
  </td>
</tr>
<!-------------------------------------------------------------->
<form action="" name="edit_files" method="POST" id="edit_files" enctype="multipart/form-data">
<tr>
  <td align="left"colspan="3"><font color="blue"></font></td>
  <td align="center"><input name="add_btn" type="submit" value="新增檔案" style="margin:5px"></td>
</tr>
<!-------------------------------------------------------------->
<tr align="center" bgcolor="#DFDFDF">
  <td width="5%"><p>選擇</p></td>
  <td width="55%">檔案說明</td>
  <td width="25%">日期</td>
  <td width="15%">狀態</td>
</tr>
<!-------------------------------------------------------------->
<?php foreach ($row_showfilesRec as $key => $array){   ?>
  <?php if ($totalRows_showfilesRec > 0) { // Show if recordset not empty ?>
  <tr align="center">
      <td><input name="select_page[]" type="checkbox" value="<?php echo $array['Dow_ID']; ?>" /></td>
      <td width="14%" align="left">
	    <a href="admineditfiles.php?Dow_ID=<?php echo $array['Dow_ID']; ?>"><?php echo $array['Dow_Name']; ?></a>
      </td>
      <td><?php echo $array['Dow_date']; ?></td>
      <td><?php if($array['set_open'] == 0) echo "離線"; else echo "上線";?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } ?>
<!-------------------------------------------------------------->
<tr>
  <td height="10%" colspan="3" align="left">
    <input type="checkbox" name="all" onclick="check_all(this,'select_page[]')" />全選
    <input name="delete_btn" type="submit" value="刪除" />
    <input name="close_btn" type="submit" value="下線" />
    <input name="open_btn" type="submit" value="上線" />
  </td>
  <td align="center"><input name="add_btn" type="submit" value="新增檔案" style="margin:5px"></td>
</tr>
<!-----------------------------page control----------------------------->
<tr>
  <td colspan="5" align="right" bgcolor="#cfcfcf">
    <table border="0">
      <tr>
        <td>共<?php echo $totalRows_showfilesRec ?> 筆資料</td>
        <td align="right">
		  <?php if ($pageNum_showfilesRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showfilesRec=%d%s", $currentPage, 0, $queryString_showfilesRec); ?>"><img src="../../images/symbol/First.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showfilesRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showfilesRec=%d%s", $currentPage, max(0, $pageNum_showfilesRec - 1), $queryString_showfilesRec); ?>"><img src="../../images/symbol/Previous.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showfilesRec < $totalfiles_showfilesRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showfilesRec=%d%s", $currentPage, min($totalfiles_showfilesRec, $pageNum_showfilesRec + 1), $queryString_showfilesRec); ?>"><img src="../../images/symbol/Next.gif" class="img"/></a>
          <?php } // Show if not last page ?>
		  <?php if ($pageNum_showfilesRec < $totalfiles_showfilesRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showfilesRec=%d%s", $currentPage, $totalfiles_showfilesRec, $queryString_showfilesRec); ?>"><img src="../../images/symbol/Last.gif" class="img"/></a>
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
//mysql_free_result($showfilesRec);
?>
