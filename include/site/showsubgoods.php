<?php  //----------------------------顯示商品列表--------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

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


mysql_select_db($database_webshop, $webshop);
$query_productRec = "SELECT * FROM prodmain
where CONCAT($string) ORDER BY ProdNum ASC";
$query_limit_productRec = sprintf("%s LIMIT %d, %d", $query_productRec, $startRow_productRec, $maxRows_productRec);
$productRec = mysql_query($query_limit_productRec, $webshop) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);
$total_productRec = mysql_num_rows($productRec);

if (isset($_GET['totalRows_productRec'])) {
  $totalRows_productRec = $_GET['totalRows_productRec'];
} else {
  $all_productRec = mysql_query($query_productRec);
  $totalRows_productRec = mysql_num_rows($all_productRec);
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

<?php if($total_productRec > 0)  {?>

      <?php do { ?>

            <?php
			  $query_showsublistRec = sprintf("SELECT * FROM prodmain
			  INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId
			  WHERE ProdNum=%s order by img_no ASC", GetSQLValueString($row_productRec['ProdNum'], "text"));
		      $showsublistRec = mysql_query($query_showsublistRec, $webshop) or die(mysql_error());
		      $row_showsublistRec = mysql_fetch_assoc($showsublistRec);
		      $totalRows_showsublistRec = mysql_num_rows($showsublistRec);
			?>

<h3 class="ttl01"><?php echo $row_productRec['ProdName']; ?></h3>


<div class="box cf">
<p class="img">
<a href="gooddetail.php?LarCode=<?php echo $row_showsublistRec['LarCode']; ?>&MidCode=<?php echo $row_showsublistRec["MidCode"]; ?>&ProdNum=<?php echo $row_showsublistRec["ProdNum"]; ?>&tabindex=<?php echo $num;?>">

<img src="images/goodsimg/medium/<?php echo $row_showsublistRec['img_name']; ?>" alt="" name="image" width="220px"  id="image" align="center" class="img"/>

</a></p>
<p class="txt"><?php echo $row_productRec['ProdDisc']; ?></p>
<p class="btn"><a href="gooddetail.php?LarCode=<?php echo $row_showsublistRec['LarCode']; ?>&MidCode=<?php echo $row_showsublistRec["MidCode"]; ?>&ProdNum=<?php echo $row_showsublistRec["ProdNum"]; ?>&tabindex=<?php echo $num;?>"><img src="img/cont_btn02.gif" alt="細節請點我" /></a></p>
</div>



      <?php		$num = $num+1;
       		} while ($row_productRec = mysql_fetch_assoc($productRec)); ?>

  <!-------------------------------------------------------------->

          <?php if ($pageNum_productRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productRec=%d%s", $currentPage, 0, $queryString_productRec); ?>">
              <img src="images/symbol/First.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>

          <?php if ($pageNum_productRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_productRec=%d%s", $currentPage, max(0, $pageNum_productRec - 1), $queryString_productRec); ?>">
              <img src="images/symbol/Previous.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>

          <?php if ($pageNum_productRec < $totalPages_productRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productRec=%d%s", $currentPage, min($totalPages_productRec, $pageNum_productRec + 1), $queryString_productRec); ?>">
              <img src="images/symbol/Next.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>

          <?php if ($pageNum_productRec < $totalPages_productRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_productRec=%d%s", $currentPage, $totalPages_productRec, $queryString_productRec); ?>">
              <img src="images/symbol/Last.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>

<?php } ?>
<?php
//mysql_free_result($showitemRec);
mysql_free_result($productRec);
mysql_free_result($showconfigRec);
?>
