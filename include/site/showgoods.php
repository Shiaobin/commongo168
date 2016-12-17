<?php  //----------------------------顯示商品列表--------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_productRec = 4;
$pageNum_productRec = 0;
if (isset($_GET['pageNum_productRec'])) {
  $pageNum_productRec = $_GET['pageNum_productRec'];
}
$startRow_productRec = $pageNum_productRec * $maxRows_productRec;

$string = "Online='1'";

$table_prodmain		= SYS_DBNAME . ".prodmain";
$column = "*";
$whereClause = "CONCAT($string)";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRec}, {$maxRows_productRec} ", 
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRec}, {$maxRows_productRec} ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC LIMIT {$startRow_productRec}, {$maxRows_productRec} "
);
$productRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_productRec = "SELECT * FROM prodmain  
where CONCAT($string) ORDER BY ProdNum ASC";
$query_limit_productRec = sprintf("%s LIMIT %d, %d", $query_productRec, $startRow_productRec, $maxRows_productRec);
$productRec = mysql_query($query_limit_productRec, $webshop) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);
*/
$total_productRec = sizeof($productRec); 

if(isset($_GET['totalRows_productRec'])){
    $totalRows_productRec = $_GET['totalRows_productRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC ", 
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY ProdNum ASC "
);
$all_productRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_productRec = sizeof($all_productRec);
}

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
<!------------------------------------------------------------------------------>
<h2 >最新商品</h2>

<table width="100%" height="94%" cellpadding="0" border="0" cellspacing="0">
  <!-------------------------------最新商品----------------------------------------->
  <?php $nom = "0"; 
  	if($total_productRec > 0)  {?>
  <tr>
    <td>
      <?php foreach ($productRec as $key => $array) {?>
        <div id="showgoods" class="index_div_showgoods">
        <table border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td height="140px" width="130px" align="center">
            <?php
			  $table_prodmain		= SYS_DBNAME . ".prodmain";
			  $column = "*";
			  $whereClause = "ProdNum={$array['ProdNum']}";
			  
			  $sql['list']['select'] = array(
					  'mysql'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY AddDate DESC ", 
					  'mssql'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY AddDate DESC ",
					  'oci8'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY AddDate DESC "
			  );
			  $row_showLatstlistRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
			  /*
			  $query_showLatstlistRec = sprintf("SELECT * FROM prodmain 
			  INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId 
			  WHERE ProdNum=%s order by AddDate DESC", GetSQLValueString($row_productRec['ProdNum'], "text"));
		      $showLatstlistRec = mysql_query($query_showLatstlistRec, $webshop) or die(mysql_error());
		      $row_showLatstlistRec = mysql_fetch_assoc($showLatstlistRec);
		      $totalRows_showLatstlistRec = mysql_num_rows($showLatstlistRec);
			  */
			?>
              <a href="gooddetail.php?LarCode=<?php echo $row_showLatstlistRec['LarCode']; ?>&MidCode=<?php echo $row_showLatstlistRec["MidCode"]; ?>&ProdNum=<?php echo $row_showLatstlistRec["ProdNum"]; ?>&tabindex=<?php echo $nom;?>">
                <img src="images/goodsimg/small/<?php echo $row_showLatstlistRec['img_name']; ?>" alt="" name="image" id="image" align="center" class="img"/>
              </a><br />
              <!-------------------------------------------------------------->
              <?php echo $array['ProdName']; ?>
            </td>
          </tr>
          <!-------------------------------------------------------------->
        </table>
      </div>
      <?php		$nom = $nom+1;
       		}?>
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
?>
