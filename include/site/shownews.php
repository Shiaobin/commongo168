<?php  //-----------------------------取得最新消息資訊----------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_NewsRec = 10;
$pageNum_NewsRec = 0;
if (isset($_GET['pageNum_NewsRec'])) {
  $pageNum_NewsRec = $_GET['pageNum_NewsRec'];
}
$startRow_NewsRec = $pageNum_NewsRec * $maxRows_NewsRec;

$class_id = "-1";
if (isset($_GET['class_id'])) {
  $class_id = $_GET['class_id'];
}
  $column = "*";
  $table_news		= SYS_DBNAME . ".news";
  $whereClause = "Online='1'";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY uup DESC", 
		  'mssql'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY uup DESC",
		  'oci8'	=> "SELECT {$column} FROM {$table_news} WHERE {$whereClause} ORDER BY uup DESC"
  );
  
  $row_newsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
 /* 
mysql_select_db($database_webshop, $webshop);
$query_NewsRec = "SELECT * FROM news WHERE Online='1' ORDER BY uup, PubDate DESC";
$query_limit_NewsRec = sprintf("%s LIMIT %d, %d", $query_NewsRec, $startRow_NewsRec, $maxRows_NewsRec);
$newsRec = mysql_query($query_limit_NewsRec, $webshop) or die(mysql_error());
$row_newsRec = mysql_fetch_assoc($newsRec);
*/
$total_newsRec = sizeof($row_newsRec); 

if(isset($_GET['totalRows_NewsRec'])){
    $totalRows_NewsRec = $_GET['totalRows_NewsRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC ", 
		'mssql'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC ",
		'oci8'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC "
);
$row_newsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_NewsRec = sizeof($row_newsRec);
}
$totalPages_NewsRec = ceil($totalRows_NewsRec/$maxRows_NewsRec)-1;

$queryString_NewsRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_NewsRec") == false && 
        stristr($param, "totalRows_NewsRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_NewsRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_NewsRec = sprintf("&totalRows_NewsRec=%d%s", $totalRows_NewsRec, $queryString_NewsRec);
?>
<!--------------------------------------------------------------------------------->
<h2>最新消息</h2>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout02">
 
  <?php if (sizeof( $row_newsRec ) > 0)  { // Show if recordset not empty ?>
  <form name="updatePop" id="updatePop" action="" method="post">  
    <?php 
	    foreach ($row_newsRec as $key => $array) { ?>
          <tr>
            <td width="5%" align="left">
<a href="shownewsdetail.php?NewsID=<?php echo $array['NewsID']; ?>" >
<img src="../../images/newsimg/small/<?php echo $array['imgfull']; ?>" alt="" name="image"  width="35px" id="image" align="center" style="padding:5px;"/></a>
            </td>
            <!-------------------------------------------------------------->
            <td width="15%" align="center">
			  <font color=#0000ff><?php echo date('Y-m-d',strtotime($array["PubDate"]));?></font>
              <input type="hidden" name="NewsID" id="NewsID" value="<?php echo $array['NewsID']; ?>"/>
            </td>
            <!-------------------------------------------------------------->
            <td width="65%" align="left">
              <a href="shownewsdetail.php?NewsID=<?php echo $array['NewsID']; ?>" >
	            <?php echo $array['NewsTitle']; ?>
              </a>
            </td>
            <!-------------------------------------------------------------->
            <td width="15%" align="left">人氣值:<?php echo $array["cktimes"];?></td>
          </tr>
    <?php 
	} ?>

  </form> 		
  <?php } // Show if recordset not empty ?>
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="4" align="right">
      <?php if ($pageNum_NewsRec > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_NewsRec=%d%s", $currentPage, 0, $queryString_NewsRec); ?>">
          <img src="images/symbol/First.gif" class="img"/></a>
      <?php } // Show if not first page ?>
      <?php if ($pageNum_NewsRec > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_NewsRec=%d%s", $currentPage, max(0, $pageNum_NewsRec - 1), $queryString_NewsRec); ?>">
          <img src="images/symbol/Previous.gif" class="img"/></a>
      <?php } // Show if not first page ?>

      <?php if ($pageNum_NewsRec < $totalPages_NewsRec) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_NewsRec=%d%s", $currentPage, min($totalPages_NewsRec, $pageNum_NewsRec + 1), $queryString_NewsRec); ?>">
          <img src="images/symbol/Next.gif" class="img"/></a>
      <?php } // Show if not last page ?>
 
      <?php if ($pageNum_NewsRec < $totalPages_NewsRec) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_NewsRec=%d%s", $currentPage, $totalPages_NewsRec, $queryString_NewsRec); ?>">
          <img src="images/symbol/Last.gif" class="img"/></a>
      <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<?php
//mysql_free_result($newsRec);
?>
