<?php  //------------------------------顯示該分類列表--------------------------------//
$currentPage = $_SERVER["PHP_SELF"];

$index_item_id = "-1";
if (isset($_GET['index_item_id'])) {
  $index_item_id = $_GET['index_item_id'];
}

mysql_select_db($database_webshop, $webshop);
$query_pageRec = sprintf("SELECT * FROM index_pages WHERE index_pages.index_item_id=%s && set_open='1' ORDER BY pages_date ASC", GetSQLValueString($index_item_id, "text"));
$pageRec = mysql_query($query_pageRec, $webshop) or die(mysql_error());
$row_pageRec = mysql_fetch_assoc($pageRec);
$total_pageRec = mysql_num_rows($pageRec);
?>
<?php  //------------------------------取得網頁大項資訊------------------------------//
mysql_select_db($database_webshop, $webshop);
$query_showClassRec = sprintf("SELECT * FROM index_item WHERE index_item_id=%s",GetSQLValueString($index_item_id, "int"));
$showClassRec = mysql_query($query_showClassRec, $webshop) or die(mysql_error());
$row_showClassRec = mysql_fetch_assoc($showClassRec);
?>
<!--------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>依分類顯示商品列表</title>
<?php if($total_pageRec > 0)  {?>
<table width="94%" cellpadding="0" border="0">
  <tr>
    <td>目前位置:<a href="index.php">首頁</a>><?php echo $row_showClassRec["index_item_name"];?></td>
  </tr>
  <!-------------------------------------------------------------->
  <?php do { ?>
  <tr>
    <td height="50">
       <?php
	     $query_showinfoRec = sprintf("SELECT * FROM index_end_item WHERE index_end_item_id = %s", GetSQLValueString($row_pageRec['index_end_item_id'], "text"));
		 $showinfoRec = mysql_query($query_showinfoRec, $webshop) or die(mysql_error());
		 $row_showinfoRec = mysql_fetch_assoc($showinfoRec);?>
       <a href="indexpage.php?index_item_id=<?php echo $row_showinfoRec["index_item_id"]; ?>&index_end_item_id=<?php echo $row_showinfoRec["index_end_item_id"]; ?>">
	     <?php echo $row_showinfoRec["index_end_item_name"];?>
       </a>
    </td>
  </tr>
  <?php } while ($row_pageRec = mysql_fetch_assoc($pageRec)); ?>
  <!-------------------------------------------------------------->
</table>
<?php }else echo "暫無商品資料"; ?>
<?php
mysql_free_result($pageRec);
?>