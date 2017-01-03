<?php  //---------------------------取出最新消息資訊---------------------------------//
//$sysConnDebug = true;
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_shownewsRec = 10;
$pageNum_shownewsRec = 0;
if (isset($_GET['pageNum_shownewsRec'])) {
  $pageNum_shownewsRec = $_GET['pageNum_shownewsRec'];
}
$startRow_shownewsRec = $pageNum_shownewsRec * $maxRows_shownewsRec;
$column = "*";
$table_news		= SYS_DBNAME . ".news";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC LIMIT {$startRow_shownewsRec}, {$maxRows_shownewsRec}",
		'mssql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC LIMIT {$startRow_shownewsRec}, {$maxRows_shownewsRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC LIMIT {$startRow_shownewsRec}, {$maxRows_shownewsRec}"
);
$row_shownewsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC",
		'mssql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC",
		'oci8'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC"
);

/*
mysql_select_db($database_webshop, $webshop);
$query_shownewsRec = "SELECT * FROM news ORDER BY PubDate DESC";
$query_limit_shownewsRec = sprintf("%s LIMIT %d, %d", $query_shownewsRec, $startRow_shownewsRec, $maxRows_shownewsRec);
$shownewsRec = mysql_query($query_limit_shownewsRec, $webshop) or die(mysql_error());
$row_shownewsRec = mysql_fetch_assoc($shownewsRec);
*/
if (isset($_GET['totalRows_shownewsRec'])) {
  $totalRows_shownewsRec = $_GET['totalRows_shownewsRec'];
} else {
  $all_shownewsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_shownewsRec = sizeof($all_shownewsRec);
}
$totalnews_shownewsRec = ceil($totalRows_shownewsRec/$maxRows_shownewsRec)-1;

$queryString_shownewsRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_shownewsRec") == false &&
        stristr($param, "totalRows_shownewsRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_shownewsRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_shownewsRec = sprintf("&totalRows_shownewsRec=%d%s", $totalRows_shownewsRec, $queryString_shownewsRec);
?>
<?php  //---------------------------搜尋功能---------------------------------//
if ((isset($_POST["search_btn"])) && ($_POST["search_btn"] == "搜尋")) {
  $class = ($_POST["search_class"]);
  $name = trim($_POST["search_name"]);
  $open = $_POST["search_type"];

  $string = "";
  if($open == 0)
      $string = $string."Online = '0'";
  else if($open == 1)
      $string = $string."Online = '1'";
  else if($open == 2)
      $string = $string."(Online = '0' || Online = '1')";

  if($name != "") {
	$string = $string." && "."NewsTitle LIKE '%$name%'";
  }

  if($class != "-1") {
	 $string = $string." && "."NewsClass = '$class'";
  }

  $maxRows_shownewsRec = 10;
  $pageNum_shownewsRec = 0;
  if (isset($_GET['pageNum_shownewsRec'])) {
    $pageNum_shownewsRec = $_GET['pageNum_shownewsRec'];
  }
  $startRow_shownewsRec = $pageNum_shownewsRec * $maxRows_shownewsRec;

  $column = "*";
  $table_news		= SYS_DBNAME . ".news";
  $whereClause = "CONCAT($string)";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC",
		  'mssql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC",
		  'oci8'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY PubDate DESC"
  );
  $row_shownewsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_shownewsRec = sizeof($row_shownewsRec);
	/*
  mysql_select_db($database_webshop, $webshop);
  $query_shownewsRec = "SELECT * FROM news WHERE CONCAT($string) ORDER BY PubDate DESC";
  $query_limit_shownewsRec = sprintf("%s LIMIT %d, %d", $query_shownewsRec, $startRow_shownewsRec, $maxRows_shownewsRec);
  $shownewsRec = mysql_query($query_limit_shownewsRec, $webshop) or die(mysql_error());
  $row_shownewsRec = mysql_fetch_assoc($shownewsRec);
  $totalRows_shownewsRec = mysql_num_rows($shownewsRec);
  */
  if (isset($_GET['totalRows_shownewsRec'])) {
    $totalRows_shownewsRec = $_GET['totalRows_shownewsRec'];
  } else {
    $all_shownewsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_shownewsRec = sizeof($all_shownewsRec);
  }
  $totalnews_shownewsRec = ceil($totalRows_shownewsRec/$maxRows_shownewsRec)-1;
}
?>
<?php  //---------------------------上架功能---------------------------------//
if ((isset($_POST["open_btn"])) && ($_POST["open_btn"] == "上線")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."NewsID='".$_POST['select_page'][$i]."'";
      }

	  $record = array( 'Online' => '1' );
	  $table_news		= SYS_DBNAME . ".news";
	  $whereClause = "CONCAT($update_string)";

	  dbUpdate( $table_news, $record, $whereClause );
	  /*
	  $updateSQL = "UPDATE news SET Online='1' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
	  $updateGoTo = "adminnews.php";
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
		$update_string = $update_string."NewsID='".$_POST['select_page'][$i]."'";
      }

	  $record = array( 'Online' => '0' );
	  $table_news		= SYS_DBNAME . ".news";
	  $whereClause = "CONCAT($update_string)";

	  dbUpdate( $table_news, $record, $whereClause );
	  /*
	  $updateSQL = "UPDATE news SET Online='0' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
	  $updateGoTo = "adminnews.php";
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
		$delete_string = $delete_string."NewsID='".$_POST['select_page'][$i]."'";
      }

	  $column = "*";
	  $table_news		= SYS_DBNAME . ".news";
	  $whereClause = "CONCAT($delete_string)";

	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause}",
			  'mssql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause}"
	  );
	  $row_searchImg = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	  //刪除圖片
	  /*
      mysql_select_db($database_webshop, $webshop);
      $searchSQL = "SELECT * FROM news WHERE CONCAT($delete_string) ";
      $searchImg = mysql_query($searchSQL, $webshop) or die(mysql_error());
	  $row_searchImg = mysql_fetch_assoc($searchImg);
*/
      foreach ($row_searchImg as $key => $array){
	  if(($array['imgfull'] != "none.gif")){
          unlink("../images/newsimg/medium/".$array["imgfull"]);
  		  unlink("../images/newsimg/small/".$array["imgfull"]);}
      }


	  $table_news		= SYS_DBNAME . ".news";
	  $whereClause = "CONCAT($delete_string)";

	  dbDelete( $table_news, $whereClause );
	  /*
	  $deleteSQL = "DELETE FROM news WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
	  */

	  $deleteGoTo = "adminnews.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------加資料功能-------------------------------//
if ((isset($_POST["add_btn"])) && ($_POST["add_btn"] == "加新聞")) {
	  $addGoTo = "adminaddnews.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$addGoTo'";
      echo "</script>";
}
?>
<!--------------------------------------------------------------------------------->
<Script>
  function searchclass(){
    var search_class;
    search_class=document.search_class.value;
	location.href="adminnews.php?search_class="+search_class;
  }
</Script>

<script>
function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
}
</script>

<h3 class=ttl01 >最新消息管理</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
<tr>
  <td width="100%" height="35%" colspan="6" bgcolor="#cfcfcf">
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable1">
    <form action="" method="POST" name="search_goods" id="search_goods" enctype="multipart/form-data">
      <tr>
        <td align="center">狀態
          <select id="search_class" name="search_class" onchange="searchclass();" style="width:150px">
          <option value="-1" selected>-------所有類別-------</option>
          <option value="最新消息">最新消息</option>
          <option value="優惠消息">優惠消息</option>
 		  <option value="特價消息">特價消息</option>
          </select>
        </td>
        <td align="center">關鍵字 <input name="search_name" type="text" class=sizeS /></td>
        <td align="center">
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
        <td align="center"><input type="submit" name="search_btn"  value="搜尋" style="font-size:16px;width:60px;height:30px" /></td>
      </tr>
    </form>
    </table>
  </td>
</tr>
<!-------------------------------------------------------------->
<form action="" name="edit_web" method="POST" id="edit_web" enctype="multipart/form-data">
<tr>
  <td align="left"colspan="5"><font color="blue">注意：若要發佈固頂信息，請先發佈信息，再修改信息時設置為固頂。</font></td>
  <td align="center"><input name="add_btn" type="submit" value="加新聞" style="margin:5px"></td>
</tr>
<!-------------------------------------------------------------->
<tr align="center" bgcolor="#DFDFDF">
  <td width="5%"><p>選擇</p></td>
  <td width="9%">圖片</td>
  <td width="15%">類別</td>
  <td width="43%">標題（單擊標題編輯新聞）</td>
  <td width="25%">發佈時間</td>
  <td width="12%">狀態</td>
</tr>
<!-------------------------------------------------------------->
<?php foreach ($row_shownewsRec as $key => $array){  ?>
  <?php if ($totalRows_shownewsRec > 0) { // Show if recordset not empty ?>
  <tr align="center">
      <td><input name="select_page[]" type="checkbox" value="<?php echo $array['NewsID']; ?>" /></td>
      <td height="50%">
        <a href="admineditnews.php?NewsID=<?php echo $array['NewsID']; ?>"><img src="../../images/newsimg/small/<?php echo $array['imgfull']; ?>" alt="" name="image"
         width="75px" height="75px" id="image" align="center" style="padding:5px;"/></a>
      </td>
      <td><?php echo $array['NewsClass']; ?></td>
      <td align="left">
	    <a href="admineditnews.php?NewsID=<?php echo $array['NewsID']; ?>"><?php echo $array['NewsTitle']; ?></a>
      </td>
      <td><?php echo $array['PubDate']; ?></td>
      <td><?php if($array['Online'] == 0) echo "離線"; else echo "上線";?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } ?>
<!-------------------------------------------------------------->
<tr>
  <td height="10%" colspan="5" align="left">
    <input type="checkbox" name="all" onclick="check_all(this,'select_page[]')" />全選
    <input name="delete_btn" type="submit" value="刪除" />
    <input name="close_btn" type="submit" value="下線" />
    <input name="open_btn" type="submit" value="上線" />
  </td>
  <td align="center"><input name="add_btn" type="submit" value="加新聞" style="margin:5px"></td>
</tr>
<!-----------------------------page control----------------------------->
<tr>
  <td colspan="6" align="right" bgcolor="#cfcfcf">
    <table border="0">
      <tr>
        <td>共<?php echo $totalRows_shownewsRec ?> 筆資料</td>
        <td align="right">
		  <?php if ($pageNum_shownewsRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_shownewsRec=%d%s", $currentPage, 0, $queryString_shownewsRec); ?>"><img src="../../images/symbol/First.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_shownewsRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_shownewsRec=%d%s", $currentPage, max(0, $pageNum_shownewsRec - 1), $queryString_shownewsRec); ?>"><img src="../../images/symbol/Previous.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_shownewsRec < $totalnews_shownewsRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_shownewsRec=%d%s", $currentPage, min($totalnews_shownewsRec, $pageNum_shownewsRec + 1), $queryString_shownewsRec); ?>"><img src="../../images/symbol/Next.gif" class="img"/></a>
          <?php } // Show if not last page ?>
		  <?php if ($pageNum_shownewsRec < $totalnews_shownewsRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_shownewsRec=%d%s", $currentPage, $totalnews_shownewsRec, $queryString_shownewsRec); ?>"><img src="../../images/symbol/Last.gif" class="img"/></a>
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
//mysql_free_result($shownewsRec);
?>
