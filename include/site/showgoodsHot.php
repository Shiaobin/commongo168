<?php  //----------------------------顯示商品列表--------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_productHotRec = 4;
$pageNum_productHotRec = 0;
if (isset($_GET['pageNum_productHotRec'])) {
  $pageNum_productHotRec = $_GET['pageNum_productHotRec'];
}
$startRow_productHotRec = $pageNum_productHotRec * $maxRows_productHotRec;

$string = "Online='1'";

$table_prodmain		= SYS_DBNAME . ".prodmain";
$column = "*";
$whereClause = "CONCAT($string)";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ClickTimes DESC LIMIT {$startRow_productHotRec}, {$maxRows_productHotRec} ",
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ClickTimes DESC LIMIT {$startRow_productHotRec}, {$maxRows_productHotRec} ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ClickTimes DESC LIMIT {$startRow_productHotRec}, {$maxRows_productHotRec} "
);
$row_productHotRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_productHotRec = "SELECT * FROM prodmain
where CONCAT($string) ORDER BY ClickTimes DESC";
$query_limit_productHotRec = sprintf("%s LIMIT %d, %d", $query_productHotRec, $startRow_productHotRec, $maxRows_productHotRec);
$productHotRec = mysql_query($query_limit_productHotRec, $webshop) or die(mysql_error());
$row_productHotRec = mysql_fetch_assoc($productHotRec);
*/
$total_productHotRec = sizeof($row_productHotRec);


if(isset($_GET['totalRows_productHotRec'])){
    $totalRows_productHotRec = $_GET['totalRows_productHotRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ClickTimes DESC ",
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ClickTimes DESC ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ClickTimes DESC "
);
$all_productHotRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_productHotRec = sizeof($all_productHotRec);
}
$totalPages_productHotRec = ceil($totalRows_productHotRec/$maxRows_productHotRec)-1;

$queryString_productHotRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_productHotRec") == false &&
        stristr($param, "totalRows_productHotRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_productHotRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_productHotRec = sprintf("&totalRows_productHotRec=%d%s", $totalRows_productHotRec, $queryString_productHotRec);
?>
<!------------------------------------------------------------------------------>
<h2 >熱門商品</h2 >

<table width="100%" height="94%" cellpadding="0" border="0" cellspacing="0">
  <!-------------------------------熱門商品----------------------------------------->
  <?php if($total_productHotRec > 0)  {?>
  <tr>
  	<td align="left"></td>
  </tr>
  <tr>
    <td>
      <?php foreach ($row_productHotRec as $key => $array) { ?>
        <div id="showgoods" class="index_div_showgoods">
        <table border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td height="140px" width="130px" align="center">
            <?php
			$table_prodmain		= SYS_DBNAME . ".prodmain";
			  $column = "*";
			  $whereClause = "ProdNum={$array['ProdNum']}";

			  $sql['list']['select'] = array(
					  'mysql'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause}",
					  'mssql'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause}",
					  'oci8'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause}"
			  );
			  $row_showHotlistRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
			 /*
			  $query_showHotlistRec = sprintf("SELECT * FROM prodmain
			  INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId
			  WHERE ProdNum=%s", GetSQLValueString($row_productHotRec['ProdNum'], "text"));
		      $showHotlistRec = mysql_query($query_showHotlistRec, $webshop) or die(mysql_error());
		      $row_showHotlistRec = mysql_fetch_assoc($showHotlistRec);
		      $totalRows_showHotlistRec = mysql_num_rows($showHotlistRec);
			  */
			?>
              <a href="gooddetail.php?LarCode=<?php echo $row_showHotlistRec['LarCode']; ?>&MidCode=<?php echo $row_showHotlistRec["MidCode"]; ?>&ProdNum=<?php echo $row_showHotlistRec["ProdNum"]; ?>&tabindex=<?php echo $nom;?>">
                <img src="images/goodsimg/small/<?php echo $row_showHotlistRec['img_name']; ?>" alt="" name="image"  id="image" align="center" class="img"/>
              </a><br />
              <!-------------------------------------------------------------->
              <?php echo $array['ProdName']; ?>
            </td>
          </tr>
          <!-------------------------------------------------------------->
        </table>
      </div>
      <?php		$nom = $nom+1;
       		} ?>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="8%" colspan="3" align="center">&nbsp;
      <table border="0">
        <tr>
          <td>
          <?php if ($pageNum_productHotRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productHotRec=%d%s", $currentPage, 0, $queryString_productHotRec); ?>">
              <img src="images/symbol/First.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_productHotRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productHotRec=%d%s", $currentPage, max(0, $pageNum_productHotRec - 1), $queryString_productHotRec); ?>">
              <img src="images/symbol/Previous.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_productHotRec < $totalPages_productHotRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productHotRec=%d%s", $currentPage, min($totalPages_productHotRec, $pageNum_productHotRec + 1), $queryString_productHotRec); ?>">
              <img src="images/symbol/Next.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
          <td>
          <?php if ($pageNum_productHotRec < $totalPages_productHotRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productHotRec=%d%s", $currentPage, $totalPages_productHotRec, $queryString_productHotRec); ?>">
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
//mysql_free_result($productHotRec);
?>
