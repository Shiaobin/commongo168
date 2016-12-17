<?php  //-----------------------------取得檔案資訊----------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_filesRec = 5;
$pageNum_filesRec = 0;
if (isset($_GET['pageNum_filesRec'])) {
  $pageNum_filesRec = $_GET['pageNum_filesRec'];
}
$startRow_filesRec = $pageNum_filesRec * $maxRows_filesRec;

/*$class_id = "-1";
if (isset($_GET['class_id'])) {
  $class_id = $_GET['class_id'];
}*/

$table_download		= SYS_DBNAME . ".download";
$column = "*";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_filesRec}, {$maxRows_filesRec} ", 
		'mssql'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_filesRec}, {$maxRows_filesRec} ",
		'oci8'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC LIMIT {$startRow_filesRec}, {$maxRows_filesRec} "
);
$row_filesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

/*
mysql_select_db($database_webshop, $webshop);
$query_filesRec = "SELECT * FROM download ORDER BY Dow_date DESC";
$query_limit_filesRec = sprintf("%s LIMIT %d, %d", $query_filesRec, $startRow_filesRec, $maxRows_filesRec);
$filesRec = mysql_query($query_limit_filesRec, $webshop) or die(mysql_error());
$row_filesRec = mysql_fetch_assoc($filesRec);
*/
$total_filesRec = sizeof($row_filesRec); 

if(isset($_GET['totalRows_filesRec'])){
    $totalRows_filesRec = $_GET['totalRows_filesRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC ", 
		'mssql'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC ",
		'oci8'	=> "SELECT * FROM {$table_download} WHERE {$whereClause} ORDER BY Dow_date DESC "
);
$all_filesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_filesRec = sizeof($all_filesRec);
}

$totalPages_filesRec = ceil($totalRows_filesRec/$maxRows_filesRec)-1;

$queryString_filesRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_filesRec") == false && 
        stristr($param, "totalRows_filesRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_filesRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_filesRec = sprintf("&totalRows_filesRec=%d%s", $totalRows_filesRec, $queryString_filesRec);
?>
<!--------------------------------------------------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
  <!-------------------------------------------------------------->
  <tr>
    <th colspan="3" align="left"><h3 class="ttl01">檔案下載</h3></th>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="center">日期</td>
    <td width="70%" align="center">相關文件</td>
    <td width="10%" align="center">下載</td>
  </tr>
  <!-------------------------------------------------------------->
  <?php if ($total_filesRec > 0) { // Show if recordset not empty ?>
    <?php 
	     foreach ($row_filesRec as $key => $array){ ?>
         <form name="updatePop" id="updatePop" action="" method="post">  
          <tr>
            <td width="20%" align="center">
			  <?php echo date('Y-m-d',strtotime($array["Dow_date"]));?>
              <input type="hidden" name="Dow_ID" id="Dow_ID" value="<?php echo $array['Dow_ID']; ?>"/>
            </td>
            <!-------------------------------------------------------------->
            <td width="70%" align="left">
              <a style="text-decoration: none" href="files/<?php echo $array['Dow_Path'];?>" target="_blank"><?php echo $array['Dow_Name']; ?></a>
            </td>
            <!-------------------------------------------------------------->

            <td width="10%" align="center">
              <a href="files/<?php echo $array['Dow_Path'];?>" target="_blank"><img src="images/button/download.gif" class="img"/></a>
            </td>
          </tr>
          </form> 	
    <?php 
	} ?>	
  <?php } // Show if recordset not empty ?>
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="4" align="right">
      <?php if ($pageNum_filesRec > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_filesRec=%d%s", $currentPage, 0, $queryString_filesRec); ?>">
          <img src="images/symbol/First.gif" class="img"/></a>
      <?php } // Show if not first page ?>
      <?php if ($pageNum_filesRec > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_filesRec=%d%s", $currentPage, max(0, $pageNum_filesRec - 1), $queryString_filesRec); ?>">
          <img src="images/symbol/Previous.gif" class="img"/></a>
      <?php } // Show if not first page ?>

      <?php if ($pageNum_filesRec < $totalPages_filesRec) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_filesRec=%d%s", $currentPage, min($totalPages_filesRec, $pageNum_filesRec + 1), $queryString_filesRec); ?>">
          <img src="images/symbol/Next.gif" class="img"/></a>
      <?php } // Show if not last page ?>
 
      <?php if ($pageNum_filesRec < $totalPages_filesRec) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_filesRec=%d%s", $currentPage, $totalPages_filesRec, $queryString_filesRec); ?>">
          <img src="images/symbol/Last.gif" class="img"/></a>
      <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<?php
//mysql_free_result($filesRec);
//mysql_free_result($classRec);
?>
