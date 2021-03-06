<?php  //----------------------------顯示商品列表--------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_productRemarkRec = 4;
$pageNum_productRemarkRec = 0;
if (isset($_GET['pageNum_productRemarkRec'])) {
  $pageNum_productRemarkRec = $_GET['pageNum_productRemarkRec'];
}
$startRow_productRemarkRec = $pageNum_productRemarkRec * $maxRows_productRemarkRec;

$string = "Online='1'";
$string = $string."&& Remark='1'";

$table_prodmain		= SYS_DBNAME . ".prodmain";
$column = "*";
$whereClause = "CONCAT($string)";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRemarkRec}, {$maxRows_productRemarkRec} ",
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRemarkRec}, {$maxRows_productRemarkRec} ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRemarkRec}, {$maxRows_productRemarkRec} "
);
$row_productRemarkRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_productRemarkRec = "SELECT * FROM prodmain
where CONCAT($string) ORDER BY ProdNum ASC";
$query_limit_productRemarkRec = sprintf("%s LIMIT %d, %d", $query_productRemarkRec, $startRow_productRemarkRec, $maxRows_productRemarkRec);
$productRemarkRec = mysql_query($query_limit_productRemarkRec, $webshop) or die(mysql_error());
$row_productRemarkRec = mysql_fetch_assoc($productRemarkRec);
*/
$total_productRemarkRec = sizeof($row_productHotRec);

if(isset($_GET['totalRows_productRemarkRec'])){
    $totalRows_productRemarkRec = $_GET['totalRows_productRemarkRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC ",
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC "
);
$all_productRemarkRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_productRemarkRec = sizeof($all_productRemarkRec);
}

$totalPages_productRemarkRec = ceil($totalRows_productRemarkRec/$maxRows_productRemarkRec)-1;

$queryString_productRemarkRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_productRemarkRec") == false &&
        stristr($param, "totalRows_productRemarkRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_productRemarkRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_productRemarkRec = sprintf("&totalRows_productRemarkRec=%d%s", $totalRows_productRemarkRec, $queryString_productRemarkRec);
?>
<!------------------------------------------------------------------------------>
<h2 >推薦商品</h2 >

<table width="100%" height="94%" cellpadding="0" border="0" cellspacing="0">
  <!-------------------------------推薦商品----------------------------------------->
  <?php if($total_productRemarkRec > 0)  {?>

  <tr>
    <td>
      <?php foreach ($row_productRemarkRec as $key => $array){ ?>
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
			  $row_showRemarklistRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

			  /*
			  $query_showRemarklistRec = sprintf("SELECT * FROM prodmain
			  INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId
			  WHERE ProdNum=%s order by img_no ASC", GetSQLValueString($row_productRemarkRec['ProdNum'], "text"));
		      $showRemarklistRec = mysql_query($query_showRemarklistRec, $webshop) or die(mysql_error());
		      $row_showRemarklistRec = mysql_fetch_assoc($showRemarklistRec);
		      $totalRows_showRemarklistRec = mysql_num_rows($showRemarklistRec);
			  */
			?>
              <a href="gooddetail.php?LarCode=<?php echo $row_showRemarklistRec['LarCode']; ?>&MidCode=<?php echo $row_showRemarklistRec["MidCode"]; ?>&ProdNum=<?php echo $row_showRemarklistRec["ProdNum"]; ?>&tabindex=<?php echo $nom;?>">
                <img src="images/goodsimg/small/<?php echo $row_showRemarklistRec['img_name']; ?>" alt="" name="image" id="image" align="center" class="img"/>
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
          <?php if ($pageNum_productRemarkRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productRemarkRec=%d%s", $currentPage, 0, $queryString_productRemarkRec); ?>">
              <img src="images/symbol/First.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_productRemarkRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productRemarkRec=%d%s", $currentPage, max(0, $pageNum_productRemarkRec - 1), $queryString_productRemarkRec); ?>">
              <img src="images/symbol/Previous.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td>
          <?php if ($pageNum_productRemarkRec < $totalPages_productRemarkRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productRemarkRec=%d%s", $currentPage, min($totalPages_productRemarkRec, $pageNum_productRemarkRec + 1), $queryString_productRemarkRec); ?>">
              <img src="images/symbol/Next.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
          <td>
          <?php if ($pageNum_productRemarkRec < $totalPages_productRemarkRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productRemarkRec=%d%s", $currentPage, $totalPages_productRemarkRec, $queryString_productRemarkRec); ?>">
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
//mysql_free_result($productRemarkRec);
?>
