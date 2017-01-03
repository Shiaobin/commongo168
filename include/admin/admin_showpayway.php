<?php  //---------------------------取出商品支付資訊---------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_showpaywayRec = 10;
$pageNum_showpaywayRec = 0;
if (isset($_GET['pageNum_showpaywayRec'])) {
  $pageNum_showpaywayRec = $_GET['pageNum_showpaywayRec'];
}
$startRow_showpaywayRec = $pageNum_showpaywayRec * $maxRows_showpaywayRec;
mysql_select_db($database_webshop, $webshop);
$query_showpaywayRec = "SELECT * FROM shop_payway";
$query_limit_showpaywayRec = sprintf("%s LIMIT %d, %d", $query_showpaywayRec, $startRow_showpaywayRec, $maxRows_showpaywayRec);
$showpaywayRec = mysql_query($query_limit_showpaywayRec, $webshop) or die(mysql_error());
$row_showpaywayRec = mysql_fetch_assoc($showpaywayRec);

if (isset($_GET['totalRows_showpaywayRec'])) {
  $totalRows_showpaywayRec = $_GET['totalRows_showpaywayRec'];
} else {
  $all_showpaywayRec = mysql_query($query_showpaywayRec);
  $totalRows_showpaywayRec = mysql_num_rows($all_showpaywayRec);
}
$totalpayway_showpaywayRec = ceil($totalRows_showpaywayRec/$maxRows_showpaywayRec)-1;

$queryString_showpaywayRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showpaywayRec") == false &&
        stristr($param, "totalRows_showpaywayRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showpaywayRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showpaywayRec = sprintf("&totalRows_showpaywayRec=%d%s", $totalRows_showpaywayRec, $queryString_showpaywayRec);
?>
<?php  //---------------------------上架功能---------------------------------//
if ((isset($_POST["open_btn"])) && ($_POST["open_btn"] == "上線")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."payway_no='".$_POST['select_page'][$i]."'";
      }

	  $updateSQL = "UPDATE shop_payway SET set_open='1' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());

	  $updateGoTo = "adminpayway.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------下架功能---------------------------------//
if ((isset($_POST["close_btn"])) && ($_POST["close_btn"] == "下線")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."payway_no='".$_POST['select_page'][$i]."'";
      }

	  $updateSQL = "UPDATE shop_payway SET set_open='0' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());

	  $updateGoTo = "adminpayway.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------刪除功能---------------------------------//
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."payway_no='".$_POST['select_page'][$i]."'";
      }

	  $deleteSQL = "DELETE FROM shop_payway WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());

	  $deleteGoTo = "adminpayway.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------加資料功能-------------------------------//
if ((isset($_POST["add_btn"])) && ($_POST["add_btn"] == "加資料")) {
	  $addGoTo = "adminaddpayway.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$addGoTo'";
      echo "</script>";
}
?>
<!--------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>商品支付管理</title>

<script>
function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
}
</script>

<table width="97%" height="60%" border="1" cellpadding="0" cellspacing="0">
<!-------------------------------------------------------------->
<tr>
  <td width="100%" height="10%" colspan="6" align="center"><p>商品支付管理</p></td>
</tr>
<!-------------------------------------------------------------->
<form action="" name="edit_web" method="POST" id="edit_web" enctype="multipart/form-data">
<tr>
  <td align="left" colspan="5"><font color="blue"></font></td>
  <td align="center"><input name="add_btn" type="submit" value="加資料" style="margin:5px"></td>
</tr>
<!-------------------------------------------------------------->
<tr align="center">
  <td width="5%"><p>選擇</p></td>
  <td width="10%">送貨方式</td>
  <td width="10%">運費</td>
  <td width="10%">運費減免金額</td>
  <td width="50%">支付說明</td>
  <td width="15%">狀態</td>
</tr>
<!-------------------------------------------------------------->
<?php do { ?>
  <?php if ($totalRows_showpaywayRec > 0) { // Show if recordset not empty ?>
  <tr align="center">
      <td><input name="select_page[]" type="checkbox" value="<?php echo $row_showpaywayRec['payway_no']; ?>" /></td>
      <td width="14%"><a href="admineditpayway.php?payway_no=<?php echo $row_showpaywayRec['payway_no']; ?>"><?php echo $row_showpaywayRec['delievery_way']; ?></a></td>
      <td><?php echo $row_showpaywayRec['payway_cost']; ?></td>
      <td><?php echo $row_showpaywayRec['payway_limit']; ?></td>
      <td align="left"><?php echo $row_showpaywayRec['delievery_explain']; ?></td>
      <td><?php if($row_showpaywayRec['set_open'] == 0) echo "離線"; else echo "上線";?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_showpaywayRec = mysql_fetch_assoc($showpaywayRec)); ?>
<!-------------------------------------------------------------->
<tr>
  <td height="10%" colspan="5" align="left">
    <input type="checkbox" name="all" onclick="check_all(this,'select_page[]')" />全選
    <input name="delete_btn" type="submit" value="刪除" />
    <input name="close_btn" type="submit" value="下線" />
    <input name="open_btn" type="submit" value="上線" />
  </td>
  <td align="center"><input name="add_btn" type="submit" value="加資料" style="margin:5px"></td>
</tr>
<!-----------------------------page control----------------------------->
<tr>
  <td colspan="6" align="right">
    <table border="0">
      <tr>
        <td>共<?php echo $totalRows_showpaywayRec ?> 筆資料</td>
      </tr>
      <tr>
        <td align="right">
		  <?php if ($pageNum_showpaywayRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showpaywayRec=%d%s", $currentPage, 0, $queryString_showpaywayRec); ?>"><img src="../../images/symbol/First.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showpaywayRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showpaywayRec=%d%s", $currentPage, max(0, $pageNum_showpaywayRec - 1), $queryString_showpaywayRec); ?>"><img src="../../images/symbol/Previous.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showpaywayRec < $totalpayway_showpaywayRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showpaywayRec=%d%s", $currentPage, min($totalpayway_showpaywayRec, $pageNum_showpaywayRec + 1), $queryString_showpaywayRec); ?>"><img src="../../images/symbol/Next.gif" class="img"/></a>
          <?php } // Show if not last page ?>
		  <?php if ($pageNum_showpaywayRec < $totalpayway_showpaywayRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showpaywayRec=%d%s", $currentPage, $totalpayway_showpaywayRec, $queryString_showpaywayRec); ?>"><img src="../../images/symbol/Last.gif" class="img"/></a>
          <?php } // Show if not last page ?>
        </td>
      </tr>
    </table>
  </td>
</tr>
</form>
<!-------------------------------------------------------------->
</table>
<?php
mysql_free_result($showpaywayRec);
?>