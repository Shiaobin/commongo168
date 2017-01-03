<?php  //----------------------------顯示商品列表--------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_productTejiaRec = 4;
$pageNum_productTejiaRec = 0;
if (isset($_GET['pageNum_productTejiaRec'])) {
  $pageNum_productTejiaRec = $_GET['pageNum_productTejiaRec'];
}
$startRow_productTejiaRec = $pageNum_productTejiaRec * $maxRows_productTejiaRec;

$string = "Online='1'";
$string = $string."&& tejia='1'";

$table_prodmain		= SYS_DBNAME . ".prodmain";
$column = "*";
$whereClause = "CONCAT($string)";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productTejiaRec}, {$maxRows_productTejiaRec} ",
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productTejiaRec}, {$maxRows_productTejiaRec} ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productTejiaRec}, {$maxRows_productTejiaRec} "
);
$row_productTejiaRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

/*
mysql_select_db($database_webshop, $webshop);
$query_productTejiaRec = "SELECT * FROM prodmain
where CONCAT($string) ORDER BY ProdNum ASC";
$query_limit_productTejiaRec = sprintf("%s LIMIT %d, %d", $query_productTejiaRec, $startRow_productTejiaRec, $maxRows_productTejiaRec);
$productTejiaRec = mysql_query($query_limit_productTejiaRec, $webshop) or die(mysql_error());
$row_productTejiaRec = mysql_fetch_assoc($productTejiaRec);
*/
$total_productTejiaRec = sizeof($row_productTejiaRec);

if(isset($_GET['totalRows_productTejiaRec'])){
    $totalRows_productTejiaRec = $_GET['totalRows_productTejiaRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC ",
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC "
);
$all_productTejiaRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_productTejiaRec = sizeof($all_productTejiaRec);
}
$totalPages_productTejiaRec = ceil($totalRows_productTejiaRec/$maxRows_productTejiaRec)-1;

$queryString_productTejiaRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_productTejiaRec") == false &&
        stristr($param, "totalRows_productTejiaRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_productTejiaRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_productTejiaRec = sprintf("&totalRows_productTejiaRec=%d%s", $totalRows_productTejiaRec, $queryString_productTejiaRec);
?>
<!------------------------------------------------------------------------------>
<h2 >特價商品</h2 >

<table width="100%" height="94%" cellpadding="0" border="0" cellspacing="0">
  <!-------------------------------特價商品----------------------------------------->
  <?php if($total_productTejiaRec > 0)  {?>
  <tr>
    <td>
      <?php foreach ($row_productTejiaRec as $key => $array){ ?>
        <div id="showgoods" class="index_div_showgoods">
        <table border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td height="140px" width="130px" align="center">
            <?php
			$table_prodmain		= SYS_DBNAME . ".prodmain";
			  $column = "*";
			  $whereClause = "ProdNum={$array['ProdNum']}";

			  $sql['list']['select'] = array(
					  'mysql'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC ",
					  'mssql'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC ",
					  'oci8'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC "
			  );
			  $row_showTejialistRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
			  /*
			  $query_showTejialistRec = sprintf("SELECT * FROM prodmain
			  INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId
			  WHERE ProdNum=%s order by img_no ASC", GetSQLValueString($row_productTejiaRec['ProdNum'], "text"));
		      $showTejialistRec = mysql_query($query_showTejialistRec, $webshop) or die(mysql_error());
		      $row_showTejialistRec = mysql_fetch_assoc($showTejialistRec);
		      $totalRows_showTejialistRec = mysql_num_rows($showTejialistRec);
			  */
			?>
              <a href="gooddetail.php?LarCode=<?php echo $row_showTejialistRec['LarCode']; ?>&MidCode=<?php echo $row_showTejialistRec["MidCode"]; ?>&ProdNum=<?php echo $row_showTejialistRec["ProdNum"]; ?>&tabindex=<?php echo $nom;?>">
                <img src="images/goodsimg/small/<?php echo $row_showTejialistRec['img_name']; ?>" alt="" name="image" id="image" align="center" class="img"/>
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
          <?php if ($pageNum_productTejiaRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productTejiaRec=%d%s", $currentPage, 0, $queryString_productTejiaRec); ?>">
              <img src="images/symbol/First.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_productTejiaRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productTejiaRec=%d%s", $currentPage, max(0, $pageNum_productTejiaRec - 1), $queryString_productTejiaRec); ?>">
              <img src="images/symbol/Previous.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_productTejiaRec < $totalPages_productTejiaRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productTejiaRec=%d%s", $currentPage, min($totalPages_productTejiaRec, $pageNum_productTejiaRec + 1), $queryString_productTejiaRec); ?>">
              <img src="images/symbol/Next.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
          <td>
          <?php if ($pageNum_productTejiaRec < $totalPages_productTejiaRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productTejiaRec=%d%s", $currentPage, $totalPages_productTejiaRec, $queryString_productTejiaRec); ?>">
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
//mysql_free_result($productTejiaRec);
?>
