<?php
$currentPage = $_SERVER["PHP_SELF"];//獲取當前頁面的地址

if ((isset($_GET['OrderNum'])) && ($_GET['OrderNum'] != "") && (isset($_GET['del']))) {
  //if ((isset($_POST['OrderNum'])) && ($_POST['OrderNum'] != "")) {
	  /*
  $deleteSQL = sprintf("DELETE FROM orderlist WHERE OrderNum=%s",
                       GetSQLValueString($_GET['OrderNum'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($deleteSQL, $webshop) or die(mysql_error());
  */
  $table_orderlist		= SYS_DBNAME . ".orderlist";
  $whereClause = "OrderNum='{$_GET['OrderNum']}'";

  dbDelete( $table_orderlist, $whereClause );

/*同步資料庫刪除orderlist+orderdetail*/
/*
  $deleteSQL = sprintf("DELETE FROM orderdetail WHERE OrderNum=%s",
                       GetSQLValueString($_GET['OrderNum'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result2 = mysql_query($deleteSQL, $webshop) or die(mysql_error());
*/
  $table_orderdetail		= SYS_DBNAME . ".orderdetail";
  $whereClause = "OrderNum='{$_GET['OrderNum']}'";

  dbDelete( $table_orderdetail, $whereClause );

  $deleteGoTo = "adminord.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  echo "<script type='text/javascript'>";
  echo "window.location.href='$deleteGoTo'";
  echo "</script>";
}

//------------------------分頁功能-------------------------------------------------------------------------------------------------
$maxRows_showordRec = 30;
$pageNum_showordRec = 0;

if (isset($_GET['pageNum_showordRec']))
{
	//確定變數是否有被設置，簡單講就是判斷是不是null
  $pageNum_showordRec = $_GET['pageNum_showordRec'];
}
$startRow_showordRec = $pageNum_showordRec * $maxRows_showordRec;

$column = "*";
$table_orderlist		= SYS_DBNAME . ".orderlist";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_orderlist} ORDER BY OrderTime DESC LIMIT {$startRow_showordRec}, {$maxRows_showordRec}",
		'mssql'	=> "SELECT {$column} FROM {$table_orderlist} ORDER BY OrderTime DESC LIMIT {$startRow_showordRec}, {$maxRows_showordRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_orderlist} ORDER BY OrderTime DESC LIMIT {$startRow_showordRec}, {$maxRows_showordRec}"
);
$row_showordRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

/*
mysql_select_db($database_webshop, $webshop);
$query_showordRec = "SELECT * FROM orderlist ORDER BY OrderTime DESC";
$query_limit_showordRec = sprintf("%s LIMIT %d, %d", $query_showordRec, $startRow_showordRec, $maxRows_showordRec);
$showordRec = mysql_query($query_limit_showordRec, $webshop) or die(mysql_error());
$row_showordRec = mysql_fetch_assoc($showordRec);//從資料集取得的陣列，索引值只能是字串(關聯索引)
*/

//$totalPages_showordRec_pages總頁數 $pageNum_showordRec+1當次頁數


if (isset($_GET['totalRows_showordRec'])) {
  $totalRows_showordRec = $_GET['totalRows_showordRec'];
} else {
  $all_showordRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showordRec = sizeof($all_showordRec);//取得結果中列的數目
}
$totalPages_showordRec = ceil($totalRows_showordRec/$maxRows_showordRec)-1;//取得大於指定數的最小整數值(可變成兩頁)
$totalPages_showordRec_pages = ceil($totalRows_showordRec/$maxRows_showordRec);

$queryString_showordRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);//切割字串並放入Array陣列中
  $newParams = array();
  foreach ($params as $param) {//將所有資料列出
    if (stristr($param, "pageNum_showordRec") == false &&
        stristr($param, "totalRows_showordRec") == false) {
      array_push($newParams, $param);//不分大小寫找出字串第一次出現的地方
    }//一個或多個單元加入陣列末尾
  }
  if (count($newParams) != 0) {
    $queryString_showordRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showordRec = sprintf("&totalRows_showordRec=%d%s", $totalRows_showordRec, $queryString_showordRec);
?>


<!------------------------搜尋功能--------------------------------------------------------------------------------------------------->
<?php
if ((isset($_POST["search_btn"])) && ($_POST["search_btn"] == "搜尋")) {
	/*mysql_select_db($database_webshop, $webshop);
	$sql="CREATE TABLE shop_temp AS SELECT * FROM orderlist;";
	mysql_query($sql); */

	$sysConnDebug = true;
  $nameID = trim($_POST["search_nameID"]);//去除字符串首尾空白等特殊符號或指定字符序列
  $name = trim($_POST["search_name"]);
  $orderID = trim($_POST["search_orderID"]);
  $search_order = ($_POST["search_order"]);//
  $date = $_POST["search_type"];

  $date_yesterday = date("Y-m-d", strtotime('-1 day'));
  $date_today = date("Y-m-d", strtotime('0 day'));
  $date_tomorrow = date("Y-m-d", strtotime('1 day'));


  $string = "";
  		if($date == "0")
      		$string = $string."OrderTime >= '$date_yesterday' && OrderTime <= '$date_today'";
  		else if($date == "1")
      		$string = $string."OrderTime >= '$date_today' ";
  		else if($date == "2")
      		$string = $string."OrderTime <= '$date_tomorrow'";


  if($search_order != "-1") {
	$string = $string." && "."Status = '$search_order'";
  }


  if($nameID != "") {
    $string = $string." && "."UserId LIKE '%$nameID%'";//
  }
  if($name != "") {
    $string = $string." && "."RecName LIKE '%$name%'";
  }
  if($orderID != "") {
    $string = $string." && "."OrderNum LIKE '%$orderID%'";
  }


  $maxRows_showordRec = 30;
  $pageNum_showordRec = 0;//確定變數是否有被設置，簡單講就是判斷是不是null
  if (isset($_GET['pageNum_showordRec'])) {
     $pageNum_showordRec = $_GET['pageNum_showordRec'];
  }
  $startRow_showordRec = $pageNum_showordRec * $maxRows_showordRec;

$column = "*";
$table_orderlist		= SYS_DBNAME . ".orderlist";
$whereClause = "CONCAT($string)";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_orderlist} WHERE {$whereClause} ORDER BY OrderTime DESC LIMIT {$startRow_showordRec}, {$maxRows_showordRec}",
		'mssql'	=> "SELECT {$column} FROM {$table_orderlist} WHERE {$whereClause} ORDER BY OrderTime DESC LIMIT {$startRow_showordRec}, {$maxRows_showordRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_orderlist} WHERE {$whereClause} ORDER BY OrderTime DESC LIMIT {$startRow_showordRec}, {$maxRows_showordRec}"
);
$row_showordRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
  mysql_select_db($database_webshop, $webshop);
  $query_showordRec = "SELECT * FROM orderlist WHERE CONCAT($string) ORDER BY OrderTime DESC";
  $query_limit_showordRec = sprintf("%s LIMIT %d, %d", $query_showordRec, $startRow_showordRec, $maxRows_showordRec);
  $showordRec = mysql_query($query_limit_showordRec, $webshop) or die(mysql_error());
  $row_showordRec = mysql_fetch_assoc($showordRec);//從資料集取得的陣列，索引值只能是字串(關聯索引)
 */
  if (isset($_GET['totalRows_showordRec'])) {
     $totalRows_showordRec = $_GET['totalRows_showordRec'];
  } else {
     $all_showordRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
     $totalRows_showordRec = sizeof($all_showordRec);//取得結果中列的數目
  }
  $totalPages_showordRec = ceil($totalRows_showordRec/$maxRows_showordRec)-1;//取得大於指定數的最小整數值(可變成兩頁)
}
?>
<!------------------------取出商品--------------------------------------------------------------------------------------------------->
<?php
$currentPage = $_SERVER["PHP_SELF"];
/*
mysql_select_db($database_webshop, $webshop);
$query_showOrderStatus = "SELECT * FROM orderlist";
$showOrderStatus = mysql_query($query_showOrderStatus, $webshop) or die(mysql_error());
$row_showOrderStatus = mysql_fetch_assoc($showOrderStatus);
$totalRows_showOrderStatus = mysql_num_rows($showOrderStatus);//取得結果中列的數目
*/
$column = "*";
$table_orderlist		= SYS_DBNAME . ".orderlist";
//$whereClause = "CONCAT($string)";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_orderlist}",
		'mssql'	=> "SELECT {$column} FROM {$table_orderlist}",
		'oci8'	=> "SELECT {$column} FROM {$table_orderlist}"
);
$row_showOrderStatus = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$totalRows_showOrderStatus = sizeof($row_showOrderStatus);
?>
<!------------------------刪除訂單--------------------------------------------------------------------------------------------------->
<?php
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_good'])){
      $select_num = count($_POST['select_good']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."OrderNum='".$_POST['select_good'][$i]."'";
      }
	  $table_orderlist		= SYS_DBNAME . ".orderlist";
	  $whereClause = "CONCAT($delete_string)";

	  dbDelete( $table_orderlist, $whereClause );

	  $table_orderdetail		= SYS_DBNAME . ".orderdetail";
	  $whereClause = "CONCAT($delete_string)";

	  dbDelete( $table_orderdetail, $whereClause );

  /*
	  $deleteOrderSQL = "DELETE FROM orderlist WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteOrderSQL, $webshop) or die(mysql_error());

	  $deleteSubOrderSQL = "DELETE FROM orderdetail WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteSubOrderSQL, $webshop) or die(mysql_error());
	  */
	  $deleteGoTo = "adminord.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>

  <Script>
  function serchOrder(){
    var search_order;
    search_order=document.search_order.value;
	location.href="adminord.php?search_order="+search_order;
  }
</Script>
<script>
function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
}
</script>

<h3 class=ttl01 >客戶訂單管理</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
  <tr>
  <td width="100%" colspan="9" bgcolor="#cfcfcf" >
    <table width="100%" border="0"  class="formTable1">
    <form action="" method="POST" name="search_goods" id="search_goods" enctype="multipart/form-data">
      <tr>
        <td align="center">按會員ID搜索 <input name="search_nameID" type="text" class=sizeSs /></td>
        <td align="center">按收貨人搜索 <input name="search_name" type="text"  class=sizeSs /></td>
        <td align="center">按訂單編號搜索 <input name="search_orderID" type="text"  class=sizeSs /></td>
      </tr>
      <tr>
        <td align="center">狀態
          <select id="search_order" name="search_order" onchange="serchOrder();" style="width:150px">
          <option value="-1" selected>-------所有訂單-------</option>
          <option value="新訂單">新訂單</option>
 		  <option value="自行取消">自行取消</option>
		  <option value="無效單，被取消">無效單，被取消</option>
          <option value="已確認，待結款">已確認，待結款</option>
		  <option value="已發貨，待收貨">已發貨，待收貨</option>
 		  <option value="訂單完成">訂單完成</option>
          </select>
        </td>
        <td align="center">
          <label>
            <input type="radio" name="search_type" value="0" id="search_type_0" />
            昨天</label>
          <label>
            <input type="radio" name="search_type" value="1" id="search_type_1" />
            今天</label>
          <label>
            <input type="radio" name="search_type" value="2" id="search_type_2" checked/>
            所有</label>
        </td>
        <td align="center"><input type="submit" name="search_btn"  value="搜尋" style="font-size:16px;width:60px;height:30px" /></td>
      </tr>
    </form>
    </table>
  </td>
  </tr>
<!---------------------------------------------------------------------------------------------------------------------------------->
  <tr align="center">
   	<td width="20%"  bgcolor="#EBEBEB">訂單編號</td>
    <td width="6%"   bgcolor="#EBEBEB">列印</td>
   	<td width="10%"  bgcolor="#EBEBEB">金額</td>
    <td width="12%"  bgcolor="#EBEBEB">會員ID</td>
    <td width="12%"  bgcolor="#EBEBEB">收貨人</td>
    <td width="18%"  bgcolor="#EBEBEB">下單時間</td>
    <td width="10%"  bgcolor="#EBEBEB">狀態</td>
    <td width="10%"  bgcolor="#EBEBEB">付款</td>
    <td width="5%"  bgcolor="#EBEBEB">點選</td>
  </tr>
<!---------------------------------------------------------------------------------------------------------------------------------->
<form action="" name="editord" method="POST" id="editord" enctype="multipart/form-data">
  <?php foreach ($row_showordRec as $key => $array1){ ?>
    <?php if ($totalRows_showordRec > 0) { // Show if recordset not empty ?>
	<tr>
        <td align="center"><a href="admineditord.php?OrderNum=<?php echo $array1['OrderNum']; ?>" target=_blank ><?php echo $array1['OrderNum']; ?></a></td>
        <td align="center"><a href="adminprintord.php?OrderNum=<?php echo $array1['OrderNum']; ?>" target=_blank ><?php echo "列印"; ?></a></td>
        <td align="right"><?php echo $array1['OrderSum']*($array1['thiskou']/10) + $array1['fei']; ?></td>
        <td align="right"><?php if($array1['UserId'] == "null") echo "遊客"; else echo $array1['UserId']; //*?></td>
        <td align="center"><?php echo $array1['RecName']; ?></td>
        <td align="center"><?php echo $array1['OrderTime']; //*?></td>
        <td align="right"><?php echo $array1['Status']; ?></td>
        <td align="right"><?php if($array1['PayStatus']==1) echo "<font color='#006600'>已付款</font>";else echo "<font color='#FF0000'>未付款</font>"; ?></td>
        <td align="center"><input name="select_good[]" type="checkbox"  value="<?php echo $array1['OrderNum'];?>"/></td>

	</tr>
    <?php } // Show if recordset not empty ?>
  <?php } ?>
<!---------------------------------------------------------------------------------------------------------------------------------->
  <tr>
  	<td width="100%" colspan="8" align="right"><input name="delete_btn" type="submit" value="刪除" /></td>
    <td align="center"><input type="checkbox" name="all" onclick="check_all(this,'select_good[]')" /></td>
  </tr>
</form>

<!--------------------------------------------------------------------------------------------------------------->

      	<tr>
            <td align="right" colspan="5" bgcolor="#cfcfcf">
            	<table width="100" border="0">
                    <tr>
                      <td  >
                        <?php if ($pageNum_showordRec > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_showordRec=%d%s", $currentPage, 0, $queryString_showordRec); ?>">
                          <img src="../../images/symbol/First.gif" class="img"/>
                        </a>
                        <?php } // Show if not first page ?>
                      </td>
                      <td>
                        <?php if ($pageNum_showordRec > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_showordRec=%d%s", $currentPage, max(0, $pageNum_showordRec - 1), $queryString_showordRec); ?>">
                          <img src="../../images/symbol/Previous.gif" class="img"/>
                        </a>
                        <?php } // Show if not first page ?>
                      </td>
                      <td>
                        <?php if ($pageNum_showordRec < $totalPages_showordRec) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_showordRec=%d%s", $currentPage, min($totalPages_showordRec, $pageNum_showordRec + 1), $queryString_showordRec); ?>">
                          <img src="../../images/symbol/Next.gif" class="img"/>
                        </a>
                        <?php } // Show if not last page ?>
                      </td>
                      <td>
                        <?php if ($pageNum_showordRec < $totalPages_showordRec) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_showordRec=%d%s", $currentPage, $totalPages_showordRec, $queryString_showordRec); ?>">
                          <img src="../../images/symbol/Last.gif" class="img"/>
                        </a>
                        <?php } // Show if not last page ?>
                      </td>
                    </tr>
                 </table>
			</td>
            <td colspan="4" bgcolor="#cfcfcf" >總:<?php echo $pageNum_showordRec+1 ?>/<?php echo $totalPages_showordRec_pages ?>頁　　總共:<?php echo $totalRows_showordRec ?>張訂單 [<?php echo $maxRows_showordRec ?>訂單/頁]</td>
      	</tr>
      </table>

<?php
//mysql_free_result($showordRec);
?>
