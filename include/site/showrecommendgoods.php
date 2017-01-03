<?php  //----------------------------取得設置資訊--------------------------------//
  mysql_select_db($database_webshop, $webshop);
  $query_showconfigRec = "SELECT allow_shop,price_label,sale_label FROM web_info";
  $showconfigRec = mysql_query($query_showconfigRec, $webshop) or die(mysql_error());
  $row_showconfigRec = mysql_fetch_assoc($showconfigRec);
  $totalRows_showconfigRec = mysql_num_rows($showconfigRec);
?>
<?php  //----------------------------顯示全商品列表--------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_productRec = 4;
$pageNum_productRec = 0;
if (isset($_GET['pageNum_productRec'])) {
  $pageNum_productRec = $_GET['pageNum_productRec'];
}
$startRow_productRec = $pageNum_productRec * $maxRows_productRec;

$string = "set_open='1' && recommend='1'";
if (isset($_GET['item_id'])) {
   $ID = $_GET['item_id'];
   $string = $string."&& item_id='$ID'";
}

mysql_select_db($database_webshop, $webshop);
$query_productRec = "SELECT * FROM shop_goods where CONCAT($string) ORDER BY goods_date ASC";
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
<?php  //-----------------------------新增商品至購物車------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addgoods")) {
  if((!$webInfo->isAllowNotMember() && isset($_SESSION['MM_Username'])) || $webInfo->isAllowNotMember()) {
      $insertSQL = sprintf("INSERT INTO shop_car (ord_id, mem_no, goods_id, goods_name, goods_price, goods_stand, goods_img, ord_sum) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($_POST['ord_id'], "text"),
                            GetSQLValueString($_SESSION['MM_Username'], "text"),
					        GetSQLValueString($_POST['goods_id'], "text"),
                            GetSQLValueString($_POST['goods_name'], "text"),
                            GetSQLValueString($_POST['goods_price'], "int"),
                            GetSQLValueString($_POST['goods_stand'], "text"),
                            GetSQLValueString($_POST['goods_img'], "text"),
					        GetSQLValueString($_POST['goods_price'], "int"));

      mysql_select_db($database_webshop, $webshop);
      $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());

      $insertGoTo = "car.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }

      $url = $insertGoTo;
      echo "<script type='text/javascript'>";
      echo "window.location.href='$url'";
      echo "</script>";
  }
  else {
	echo "<script language=\"javascript\">";
    echo "window.alert(\"請先登入會員\");";
    echo "</script>";
  }
}
?>
<?php  //-------------------------------搜尋商品---------------------------------//
if ((isset($_POST["search"])) && ($_POST["search"] == "搜索")) {
  $name = trim($_POST["search_name"]);

  $string = "set_open = '1'";

  if($name != "") {
	$string = $string." && "."goods_name LIKE '%$name%'";
  }

  $query_productRec = "SELECT * FROM shop_goods where CONCAT($string) ORDER BY goods_date ASC";
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
}
?>
<!------------------------------------------------------------------------------>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>顯示全商品列表</title>
<?php if($total_productRec > 0)  {?>
<table width="94%" height="94%" cellpadding="0" border="0">
  <!-------------------------------------------------------------->
  <form action="" method="POST" name="search_goods" id="search_goods" enctype="multipart/form-data">
  <tr>
    <td align="left" ><input name="search_name" type="text" /><input name="search" type="submit" value="搜索"/></td>
  </tr>
  </form>
  <!------------------------------------------------------------------------>
  <tr>
    <td>
      <?php do { ?>
      <div id="showgoods" class="index_div_showgoods">
        <table border="1">
          <form action="<?php echo $editFormAction; ?>" name="addgoods" method="POST" enctype="multipart/form-data" id="addgoods">
          <tr>
            <td height="100%">
              <a href="gooddetail.php?goods_id=<?php echo $row_productRec['goods_id']; ?>">
                <img src="images/goodsimg/medium/<?php echo $row_productRec['goods_img']; ?>" alt=""
                     name="image" width="300px" height="200px" id="image" align="center" class="img"/>
              </a>
            </td>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <td height="8%" align="center"><?php echo $row_productRec['goods_name']; ?></td>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <td height="8%" align="center">
              <?php if($row_productRec['bargain']) { echo $row_showconfigRec['sale_label']; ?>:<font color="#CC0000"><?php echo $row_productRec['sale_price']; ?></font>元
			  <?php	}else  {                         echo $row_showconfigRec['price_label'];?>:<?php echo $row_productRec['goods_price']; ?>元
              <?php }?>
		    </td>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <td height="8%" align="right">
              <input name="goods_id" type="hidden" id="goods_id" value="<?php echo $row_productRec['goods_id']; ?>"/>
              <input name="goods_name" type="hidden" id="goods_name" value="<?php echo $row_productRec['goods_name']; ?>"/>
              <input name="goods_stand" type="hidden" id="goods_stand" value="<?php echo $row_productRec['goods_stand']; ?>"/>
              <input name="goods_price" type="hidden" id="goods_price" value="<?php echo $row_productRec['goods_price']; ?>"/>
              <input name="goods_img" type="hidden" id="goods_img" value="<?php echo $row_productRec['goods_img']; ?>" />
              <input name="ord_id" type="hidden" id="ord_id" value="<?php if(isset($_SESSION['MM_Username'])) echo date('Ymdhis').$_SESSION['MM_Username'];
							                                              else echo $_SESSION['tempord_id'];?>" />
              <input name="buy" type="submit" value="立即購買" />
            </td>
          </tr>
              <input type="hidden" name="MM_insert" value="addgoods" />
          </form>
        </table>
      </div>
      <?php } while ($row_productRec = mysql_fetch_assoc($productRec)); ?>
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
<?php }else echo "暫無商品資料"; ?>
<?php
//mysql_free_result($showitemRec);
mysql_free_result($productRec);
mysql_free_result($showconfigRec);
?>
