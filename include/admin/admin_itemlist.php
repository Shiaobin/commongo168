<?php  //-----------------------新增修改商品類別(大類)----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_item"])) && ($_POST["update_item"] == "更新")) {
  //更新大項內容
  $updateSQL = sprintf("UPDATE shop_item SET item_id=%s, item_name=%s WHERE item_id=%s",
                       GetSQLValueString($_POST['upd_item_id'], "int"),
                       GetSQLValueString($_POST['item_name'], "text"),
                       GetSQLValueString($_POST['item_id'], "int"));

  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());

  //更新中項內容
  $updateSQL = sprintf("UPDATE shop_end_item SET item_id=%s WHERE item_id=%s",
                       GetSQLValueString($_POST['upd_item_id'], "int"),
                       GetSQLValueString($_POST['item_id'], "int"));

  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());

  $updateGoTo = "adminitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}

//-----------------------------新增商品類別(大類)--------------------------------//
if ((isset($_POST["add_item"])) && ($_POST["add_item"] == "新增")) {
  $insertSQL = sprintf("INSERT INTO shop_end_item (item_id) VALUES (%s)",
                       GetSQLValueString($_POST['item_id'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());

  $insertGoTo = "adminitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}

//------------------------------刪除分頁類別(大類)--------------------------------//
if ((isset($_POST["del_item"])) && ($_POST["del_item"] == "刪除")) {
  $deleteSQL = sprintf("DELETE FROM shop_item WHERE item_id=%s",
                       GetSQLValueString($_POST['item_id'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($deleteSQL, $webshop) or die(mysql_error());

  $deleteGoTo = "adminitem.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  echo "<script type='text/javascript'>";
  echo "window.location.href='$deleteGoTo'";
  echo "</script>";
}
?>
<?php
//---------------------------新增修改商品類別(中類)---------------------------------//
if ((isset($_POST["update_end_item"])) && ($_POST["update_end_item"] == "更新")) {

  $updateSQL = sprintf("UPDATE shop_end_item SET end_item_id=%s, end_item_name=%s WHERE end_item_id=%s",
                       GetSQLValueString($_POST['upd_end_item_id'], "int"),
                       GetSQLValueString($_POST['end_item_name'], "text"),
                       GetSQLValueString($_POST['end_item_id'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());


  $updateGoTo = "adminitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}

if ((isset($_POST["del_end_item"])) && ($_POST["del_end_item"] == "刪除")) {
   $deleteSQL = sprintf("DELETE FROM shop_end_item WHERE end_item_id=%s",
                       GetSQLValueString($_POST['end_item_id'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($deleteSQL, $webshop) or die(mysql_error());

  $deleteGoTo = "adminitem.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  echo "<script type='text/javascript'>";
  echo "window.location.href='$deleteGoTo'";
  echo "</script>";
}
?>
<?php  //--------------------------取出商品類別資訊-------------------------------//
mysql_select_db($database_webshop, $webshop);
$query_showitemRec = "SELECT shop_item.item_id,shop_item.item_name,count(shop_end_item.item_id) as num FROM shop_item LEFT OUTER JOIN shop_end_item ON shop_item.item_id=shop_end_item.item_id GROUP BY shop_item.item_id";
$showitemRec = mysql_query($query_showitemRec, $webshop) or die(mysql_error());
$row_showitemRec = mysql_fetch_assoc($showitemRec);
$totalRows_showitemRec = mysql_num_rows($showitemRec);
?>
<!--------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>商品分類列表</title>
<!---------------------------商品分類-------------------------->
<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <?php if ($totalRows_showitemRec > 0) {?>
      <td width="25%" colspan="4" valign="top">
      <?php do { ?>
         <table id="item" width="100%" border="0">
           <!-------------------------------------------------------------->
           <tr>
           <form action="<?php echo $editFormAction; ?>" name="edit_item" method="POST" id="edit_item">
             <td width="5%" align="center"><input name="upd_item_id" type="text" id="upd_item_id" style="width:60%;font-size:20px" value="<?php echo $row_showitemRec['item_id']; ?>"/></td>
             <td width="80%" align="center">
               <input name="item_name" type="text" id="item_name" style="width:99%;font-size:20px" value="<?php echo $row_showitemRec['item_name']; ?>" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }"/><input name="item_id" type="hidden" value="<?php echo $row_showitemRec['item_id']; ?>" />
             </td>
             <td width="5%" align="center">
               <input type="submit" name="add_item" value="新增">
             </td>
             <td width="5%" align="center">
               <input type="submit" name="update_item" value="更新">
             </td>
             <td width="5%" align="center">
			   <?php if($row_showitemRec['num']<=0) {?>
               <input type="submit" name="del_item" value="刪除">
               <?php }?>
             </td>
           </form>
           </tr>
           <!-------------------------------------------------------------->
            <tr>
              <td colspan="5" align="left">
                 <table width="100%" border="0" cellpadding="0" cellspacing="0" id="goods">
                   <?php
				     mysql_select_db($database_webshop, $webshop);
				     $query_showgoodsRec = sprintf("SELECT * FROM shop_end_item WHERE item_id = %s",
						  						GetSQLValueString($row_showitemRec['item_id'], "text"));
				     $showgoodsRec = mysql_query($query_showgoodsRec, $webshop) or die(mysql_error());
				     $row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);
				     $totalRows_showgoodsRec = mysql_num_rows($showgoodsRec);
				     if ($totalRows_showgoodsRec > 0) {
					   do {?>
					     <tr>
                         <form action="<?php echo $editFormAction; ?>" name="edit_end_item" method="POST" id="edit_end_item">
    					   <td width="3%">
                             <img src="../../images/list/icon.png" width="8" height="8" hspace="8" align="middle"/>
                           </td>
                           <td width="5%" align="center"><input name="upd_end_item_id" type="text" id="upd_end_item_id" style="width:60%;font-size:20px" value="<?php echo $row_showgoodsRec['end_item_id']; ?>"/></td>
                           <td width="77%">
                             <input name="end_item_name" type="text" id="end_item_name" style="width:99%;font-size:20px" value="<?php echo $row_showgoodsRec['end_item_name']; ?>"/>
                             <input name="end_item_id" type="hidden" value="<?php echo $row_showgoodsRec['end_item_id']; ?>" />
                           </td>
                           <td width="5%" align="center">
                             <input type="submit" name="update_end_item" value="更新">
                           </td>
                           <td width="5%" align="center">
                             <input type="submit" name="del_end_item" value="刪除">
                           </td>
                           <td width="5%" align="center">
                           </td>
                         </form>
  					     </tr>
					   <?php }while($row_showgoodsRec = mysql_fetch_assoc($showgoodsRec));}?>
			     </table>
              </td>
            </tr>
            <!-------------------------------------------------------------->
            <tr>
              <td height="10%" colspan="3"></td>
            </tr>
         <!-------------------------------------------------------------->

         </table>
      <?php } while ($row_showitemRec = mysql_fetch_assoc($showitemRec)); ?>
      </td>
      <?php }?>
    </tr>
</table>
<!-------------------------------------------------------------->

