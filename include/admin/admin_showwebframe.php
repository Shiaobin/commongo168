<?php  //---------------------------取出自助頁面資訊---------------------------------//
$maxRows_showpagesRec = 100;
$pageNum_showpagesRec = 0;
if (isset($_GET['pageNum_showpagesRec'])) {
  $pageNum_showpagesRec = $_GET['pageNum_showpagesRec'];
}
$startRow_showpagesRec = $pageNum_showpagesRec * $maxRows_showpagesRec;
$column = "*";
$table_index_frame		= SYS_DBNAME . ".index_frame";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_index_frame} LIMIT {$startRow_showpagesRec}, {$maxRows_showpagesRec}", 
		'mssql'	=> "SELECT {$column} FROM {$table_index_frame} LIMIT {$startRow_showpagesRec}, {$maxRows_showpagesRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_index_frame} LIMIT {$startRow_showpagesRec}, {$maxRows_showpagesRec}"
);
$row_showpagesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
//$totalRows_showitemRec = sizeof($row_showitemRec);

/*
mysql_select_db($database_webshop, $webshop);
$query_showpagesRec = "SELECT * FROM index_frame";
$query_limit_showpagesRec = sprintf("%s LIMIT %d, %d", $query_showpagesRec, $startRow_showpagesRec, $maxRows_showpagesRec);
$showpagesRec = mysql_query($query_limit_showpagesRec, $webshop) or die(mysql_error());
$row_showpagesRec = mysql_fetch_assoc($showpagesRec);
*/
if (isset($_GET['totalRows_showpagesRec'])) {
  $totalRows_showpagesRec = $_GET['totalRows_showpagesRec'];
} else {
  $all_showpagesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showpagesRec = sizeof($all_showpagesRec);
}
$totalPages_showpagesRec = ceil($totalRows_showpagesRec/$maxRows_showpagesRec)-1;

$queryString_showpagesRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showpagesRec") == false && 
        stristr($param, "totalRows_showpagesRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showpagesRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showpagesRec = sprintf("&totalRows_showpagesRec=%d%s", $totalRows_showpagesRec, $queryString_showpagesRec);


//------------------------------------刪除---------------------------------//
$action=isset($_GET["action"])? $_GET["action"] : ""; 
switch ($action){ 
 case "delLar": 
 	delLar();
 break; 
}

function delLar(){
  $cloume_showitemLarRec = "-1";
  if (isset($_GET['frame_no'])) {
  	$cloume_showitemLarRec = $_GET['frame_no'];
  }
  
  $table_index_frame		= SYS_DBNAME . ".index_frame";
	  $whereClause = "frame_no='{$cloume_showitemLarRec}'";
	  dbDelete( $table_index_frame, $whereClause );
	  
  /*
  $deleteSQL = sprintf("DELETE FROM index_frame WHERE frame_no=%s",
                       GetSQLValueString($cloume_showitemLarRec, "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result = mysql_query($deleteSQL) or die(mysql_error());
  */
  $deleteGoTo = "adminwebframe.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$deleteGoTo'";
  echo "</script>";
}
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >自助頁面管理</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
  <?php foreach ($row_showpagesRec as $key => $array){   ?>
  	<tr>
  		<td>
      <?php if ($totalRows_showpagesRec > 0) { // Show if recordset not empty ?>&nbsp;&nbsp;&nbsp;
        	●<?php echo $array["frame_name"];?>
  		</td>
        <td align="center"><font color="#0000FF"><?php if($array["set_open"] == 1) echo "顯示"; else echo "隱藏";?></font></td>
  		<td align="center" width="23%">
        	<a href="admineditwebframe.php?frame_no=<?php echo $array["frame_no"];?>">修改</a> |
        	<a href="adminaddwebframe.php?frame_no=<?php echo $array["frame_no"];?>">增加</a> |
        	<a href="adminwebframe.php?action=delLar&frame_no=<?php echo $array["frame_no"];?>">刪除</a>
 		</td>
    </tr>
   	  <?php } // Show if recordset not empty ?>
    <?php } ?>
  </table>

<?php
//mysql_free_result($showpagesRec);
?>
