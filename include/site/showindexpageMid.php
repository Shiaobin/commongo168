<?php  //----------------------------顯示網頁列表--------------------------------//
$currentPage = $_SERVER["PHP_SELF"];
//$sysConnDebug = true;
$maxRows_productRec = 6;
$pageNum_productRec = 0;
if (isset($_GET['pageNum_productRec'])) {
  $pageNum_productRec = $_GET['pageNum_productRec'];
}
$startRow_productRec = $pageNum_productRec * $maxRows_productRec;

$string = "Online='1'";
if (isset($_GET['LarCode'])) {
   $LarCode = $_GET['LarCode'];
   $string = $string."&& LarCode='$LarCode'";
}
if (isset($_GET['MidCode'])) {
  $MidCode = $_GET['MidCode'];
  $string = $string."&& MidCode='$MidCode'";
}

$table_compmain		= SYS_DBNAME . ".compmain";
$column = "*";
$whereClause = "CONCAT($string)";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRec}, {$maxRows_productRec}",
		'mssql'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRec}, {$maxRows_productRec}",
		'oci8'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRec}, {$maxRows_productRec}"
);
$row_productRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$total_productRec = sizeof($row_productRec);

/*
mysql_select_db($database_webshop, $webshop);
$query_productRec = "SELECT * FROM compmain
where CONCAT($string) ORDER BY ProdNum ASC";
$query_limit_productRec = sprintf("%s LIMIT %d, %d", $query_productRec, $startRow_productRec, $maxRows_productRec);
$productRec = mysql_query($query_limit_productRec, $webshop) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);
$total_productRec = mysql_num_rows($productRec);
*/
if(isset($_GET['totalRows_productRec'])){
    $totalRows_NewsRec = $_GET['totalRows_productRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause} ORDER BY ProdNum ASC",
		'mssql'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause} ORDER BY ProdNum ASC",
		'oci8'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause} ORDER BY ProdNum ASC"
);
$all_productRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_productRec = sizeof($all_productRec);
}
/*
if (isset($_GET['totalRows_productRec'])) {
  $totalRows_productRec = $_GET['totalRows_productRec'];
} else {
  $all_productRec = mysql_query($query_productRec);
  $totalRows_productRec = mysql_num_rows($all_productRec);
}
*/
$totalPages_productRec = ceil($totalRows_productRec/$maxRows_productRec)-1;

$queryString_productRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_productRec") == false &&
        stristr($param, "totalRows_productRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_productRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_productRec = sprintf("&totalRows_productRec=%d%s", $totalRows_productRec, $queryString_productRec);
?>
<?php  //------------------------------取得網頁大項資訊------------------------------//
  $column = "*";
  $table_compclass		= SYS_DBNAME . ".compclass";
  $whereClause = "LarCode='{$LarCode}' AND MidCode='{$MidCode}'";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}",
		  'mssql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}",
		  'oci8'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}"
  );

  $row_showClassRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
  /*
mysql_select_db($database_webshop, $webshop);
$query_showClassRec = sprintf("SELECT * FROM compclass WHERE LarCode=%s AND MidCode=%s",GetSQLValueString($LarCode, "text"),GetSQLValueString($MidCode, "text"));
$showClassRec = mysql_query($query_showClassRec, $webshop) or die(mysql_error());
$row_showClassRec = mysql_fetch_assoc($showClassRec);
*/
?>

<!------------------------------------------------------------------------------>
<h3 class="ttl01">目前位置:<a href="index.php">首頁</a>>><?php echo $row_showClassRec["LarCode"];?>>><?php echo $row_showClassRec["MidCode"];?></h3>
<?php if($total_productRec > 0)  {?>
<table width="100%" height="94%" cellpadding="0" border="0" cellspacing="0">
  <!------------------------------------------------------------------------>
  <tr>
    <td>
      <?php foreach ($row_productRec as $key => $array) {  ?>
        <div id="showgoods" class="index_div_showgoods">
        <table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td height="250px" width="280px" align="center">
            <?php
				$table_compmain		= SYS_DBNAME . ".compmain";
$column = "*";
$whereClause = "ProdNum={$array['ProdNum']}";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_compmain} INNER JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC",
		'mssql'	=> "SELECT * FROM {$table_compmain} INNER JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC",
		'oci8'	=> "SELECT * FROM {$table_compmain} INNER JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC"
);
$row_showsublistRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
			  $query_showsublistRec = sprintf("SELECT * FROM compmain
			  INNER JOIN comp_img ON comp_img.ProdId = compmain.ProdId
			  WHERE ProdNum=%s order by img_no ASC", GetSQLValueString($row_productRec['ProdNum'], "text"));
		      $showsublistRec = mysql_query($query_showsublistRec, $webshop) or die(mysql_error());
		      $row_showsublistRec = mysql_fetch_assoc($showsublistRec);
		      $totalRows_showsublistRec = mysql_num_rows($showsublistRec);
			  */
			?>
              <a href="indexpage.php?LarCode=<?php echo $row_showsublistRec['LarCode']; ?>&MidCode=<?php echo $row_showsublistRec["MidCode"]; ?>&ProdNum=<?php echo $row_showsublistRec["ProdNum"]; ?>&snum=1&tabindex=<?php echo $no;?>">
                <img src="images/webimg/medium/<?php echo $row_showsublistRec['img_name']; ?>" alt="" name="image" width="240px" height="200px" id="image" align="center" class="img"/>
              </a><br />
              <!-------------------------------------------------------------->
              <?php echo $array['ProdDisc']; ?>
            </td>
          </tr>
          <!-------------------------------------------------------------->
        </table>
      </div>
      <?php		$no = $no+1;
       		} ?>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="8%" colspan="3" align="center">&nbsp;
      <table border="0">
        <tr>
          <td>
          <?php if ($pageNum_productRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productRec=%d%s", $currentPage, 0, $queryString_productRec); ?>">
              <img src="images/symbol/First.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_productRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productRec=%d%s", $currentPage, max(0, $pageNum_productRec - 1), $queryString_productRec); ?>">
              <img src="images/symbol/Previous.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_productRec < $totalPages_productRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productRec=%d%s", $currentPage, min($totalPages_productRec, $pageNum_productRec + 1), $queryString_productRec); ?>">
              <img src="images/symbol/Next.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
          <td>
          <?php if ($pageNum_productRec < $totalPages_productRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productRec=%d%s", $currentPage, $totalPages_productRec, $queryString_productRec); ?>">
              <img src="images/symbol/Last.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <!-------------------------------------------------------------->
</table>
<?php } ?>
<?php
//mysql_free_result($showitemRec);
//mysql_free_result($productRec);
//mysql_free_result($showconfigRec);
?>
