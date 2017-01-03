<?php  //---------------------------取出分頁資訊---------------------------------//
//$sysConnDebug = true;
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_showbannerRec = 15;
$pageNum_showbannerRec = 0;
if (isset($_GET['pageNum_showbannerRec'])) {
  $pageNum_showbannerRec = $_GET['pageNum_showbannerRec'];
}
$startRow_showbannerRec = $pageNum_showbannerRec * $maxRows_showbannerRec;

$table_banner		= SYS_DBNAME . ".banner";
$whereClause = "1=1";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause} ORDER BY po ASC LIMIT {$startRow_showbannerRec}, {$maxRows_showbannerRec}",
		'mssql'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause} ORDER BY po ASC LIMIT {$startRow_showbannerRec}, {$maxRows_showbannerRec}",
		'oci8'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause} ORDER BY po ASC LIMIT {$startRow_showbannerRec}, {$maxRows_showbannerRec}"
		);
$row_showbannerRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showbannerRec = "SELECT * FROM banner ORDER BY po ASC";
$query_limit_showbannerRec = sprintf("%s LIMIT %d, %d", $query_showbannerRec, $startRow_showbannerRec, $maxRows_showbannerRec);
$showbannerRec = mysql_query($query_limit_showbannerRec, $webshop) or die(mysql_error());
$row_showbannerRec = mysql_fetch_assoc($showbannerRec);
*/
if (isset($_GET['totalRows_showbannerRec'])) {
  $totalRows_showbannerRec = $_GET['totalRows_showbannerRec'];
} else {
  $all_showbannerRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showbannerRec = sizeof($all_showbannerRec);
}
$totalPages_showbannerRec = ceil($totalRows_showbannerRec/$maxRows_showbannerRec)-1;

$queryString_showbannerRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showbannerRec") == false &&
        stristr($param, "totalRows_showbannerRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showbannerRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showbannerRec = sprintf("&totalRows_showbannerRec=%d%s", $totalRows_showbannerRec, $queryString_showbannerRec);
?>
<?php  //---------------------------刪除功能---------------------------------//
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_banner'])){
      $select_num = count($_POST['select_banner']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."Notice_ID='".$_POST['select_banner'][$i]."'";
      }

	  //刪除圖片
	  $table_banner		= SYS_DBNAME . ".banner";
	  $whereClause = "CONCAT($delete_string)";
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause}",
			  'mssql'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause}",
			  'oci8'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause}"
			  );
	  $imgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  /*
	  mysql_select_db($database_webshop, $webshop);
	  $imgSQL = "SELECT * FROM banner  WHERE CONCAT($delete_string)";
      $imgRec = mysql_query($imgSQL, $webshop) or die(mysql_error());
	  */
	  foreach ($imgRec as $key => $array){
	    unlink("../images/bannerimg/".$array["banner"]);
      }

	  //刪除廣告資料

	  $table_banner		= SYS_DBNAME . ".banner";
	  $whereClause = "CONCAT($delete_string)";
	  dbDelete( $table_banner, $whereClause );
	  /*
	  mysql_select_db($database_webshop, $webshop);
	  $deleteSQL = "DELETE FROM banner  WHERE CONCAT($delete_string)";
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
	  */
	  $deleteGoTo = "adminbanner.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------加商品功能-------------------------------//
if ((isset($_POST["add_btn"])) && ($_POST["add_btn"] == "新增看板圖片")) {
	$addGoTo = "adminaddbanner.php";
	echo "<script type='text/javascript'>";
    echo "window.location.href='$addGoTo'";
    echo "</script>";
}
?>

<script>
function check_all(obj,cName) {
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
}

function editBanner(btn) {
  location.href="admineditbanner.php?Notice_ID="+btn.name;
}
</script>

<h3 class=ttl01 >看板廣告管理</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">

<form action="" name="edit_banner" method="POST" id="edit_banner" enctype="multipart/form-data">
<tr>
  <td align="right" colspan="4"><input name="add_btn" type="submit" value="新增看板圖片" style="margin:5px"></td>
</tr>
<!-------------------------------------------------------------->
<tr align="center" bgcolor="#DFDFDF">
  <td width="6%"><p>選</p></td>
  <td width="8%">順序</td>
  <td width="70%">看板廣告圖片</td>
  <td width="12%">編輯</td>
</tr>
<!-------------------------------------------------------------->
<?php foreach ($row_showbannerRec as $key => $array){ ?>
  <?php if ($totalRows_showbannerRec > 0) { // Show if recordset not empty ?>
  <tr align="center">
      <td><input name="select_banner[]" type="checkbox" value="<?php echo $array['Notice_ID']; ?>" /></td>
      <td><?php echo $array['po']; ?></td>
      <td>
        <img src="../../images/bannerimg/<?php echo $array['banner']; ?>" alt="" name="image"
         width="520px" height="160px" id="image" align="center" style="padding:5px;"/>
      </td>
      <td><input name="<?php echo $array['Notice_ID']; ?>" type="button" value="編輯" onclick="editBanner(this);" /></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } ?>
<!-------------------------------------------------------------->
<tr>
  <td colspan="3" align="left">
    <input type="checkbox" name="all" onclick="check_all(this,'select_banner[]')" />全選
    <input name="delete_btn" type="submit" value="刪除" />
  </td>
  <td align="center"><input name="add_btn" type="submit" value="新增看板圖片" style="margin:5px"></td>
</tr>
<!-----------------------------page control----------------------------->
<tr>
  <td colspan="7" align="right" bgcolor="#cfcfcf" >
    <table border="0">
      <tr>
        <td>共<?php echo $totalRows_showbannerRec ?> 張廣告圖片</td>
        <td align="right">
		  <?php if ($pageNum_showbannerRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showbannerRec=%d%s", $currentPage, 0, $queryString_showbannerRec); ?>"><img src="../../images/symbol/First.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showbannerRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showbannerRec=%d%s", $currentPage, max(0, $pageNum_showbannerRec - 1), $queryString_showbannerRec); ?>"><img src="../../images/symbol/Previous.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showbannerRec < $totalPages_showbannerRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showbannerRec=%d%s", $currentPage, min($totalPages_showbannerRec, $pageNum_showbannerRec + 1), $queryString_showbannerRec); ?>"><img src="../../images/symbol/Next.gif" class="img"/></a>
          <?php } // Show if not last page ?>
		  <?php if ($pageNum_showbannerRec < $totalPages_showbannerRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showbannerRec=%d%s", $currentPage, $totalPages_showbannerRec, $queryString_showbannerRec); ?>"><img src="../../images/symbol/Last.gif" class="img"/></a>
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
//mysql_free_result($showbannerRec);
?>
