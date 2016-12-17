<?php  //---------------------------更新類別資訊---------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "additem") && ($_POST['item_name'] != "")) {
  $insertSQL = sprintf("INSERT INTO album_item (item_name) VALUES (%s)",
                       GetSQLValueString($_POST['item_name'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());

  $insertGoTo = "adminalbumitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}

mysql_select_db($database_webshop, $webshop);
$query_showitemRec = "SELECT album_item.item_id,album_item.item_name,count(album_end_item.item_id) as num FROM album_item LEFT OUTER JOIN album_end_item ON album_item.item_id=album_end_item.item_id GROUP BY album_item.item_id";
$showitemRec = mysql_query($query_showitemRec, $webshop) or die(mysql_error());
$row_showitemRec = mysql_fetch_assoc($showitemRec);
$totalRows_showitemRec = mysql_num_rows($showitemRec);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>相簿分類管理頁面</title>

<!---------------------新增類別--------------------------------->
<table width="80%" border="0" class="admin_item_category_table">
  <form action="<?php echo $editFormAction; ?>" name="additem" method="POST" enctype="multipart/form-data" id="additem">
   <!-------------------------------------------------------------->
  <tr>
    <td width="100%" align="center">新增相簿分類</td>
  </tr>
  <!-------------------------------------------------------------->
  <tr align="center">
    <td width="100%">新增類別:
   	  <input type="text" name="item_name" id="item_name" style="width:70%; height:25px"/>
   	  <input type="submit" name="add" id="add" value="新增" style="height:25px"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
    <input type="hidden" name="MM_insert" value="additem" />
  </form>
</table>
<!---------------------相簿分類管理--------------------------------->
<table width="80%" height="50%" border="0" cellpadding="0" cellspacing="0" class="admin_item_edit">
  <!-------------------------------------------------------------->
  <tr>
    <td align="center" colspan="4"><p>相簿分類管理</p></td>
  </tr>
  <!-------------------------------------------------------------->
   <tr>
    <td align="right" colspan="4"><?php include("admin_albumlist.php"); ?></td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td align="right" colspan="4"><p>共<?php echo $totalRows_showitemRec ?> 種分類</p></td>
  </tr>
</table>
<!-------------------------------------------------------------->
<?php
mysql_free_result($showitemRec);
?>
