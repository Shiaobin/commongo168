<?php  //--------------------------修改分頁類別(大類)-----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_item"])) && ($_POST["update_item"] == "更新")) {

  $updateSQL = sprintf("UPDATE compclass SET LarSeq=%s, LarCode=%s, pnum=%s WHERE LarSeq=%s",
                       GetSQLValueString($_POST['upd_LarSeq'], "int"),
					   GetSQLValueString($_POST['LarCode'], "text"),					                 
					   GetSQLValueString($_POST['pnum'], "int"),
					   GetSQLValueString($_POST['LarSeq'], "int"));


  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  
 
  $updateGoTo = "adminwebitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>"; 
}
?>

<?php  //-----------------------------取得大類資訊------------------------------------//
$cloume_showitemLarRec = "-1";
if (isset($_GET['LarSeq'])) {
  $cloume_showitemLarRec = $_GET['LarSeq'];
}
mysql_select_db($database_webshop, $webshop);
$query_showitemLarRec = sprintf("SELECT * FROM compclass WHERE LarSeq=%s",
                               GetSQLValueString($cloume_showitemLarRec, "int"));
$showitemLarRec = mysql_query($query_showitemLarRec, $webshop) or die(mysql_error());
$row_showitemLarRec = mysql_fetch_assoc($showitemLarRec);
$totalRows_showitemLarRec = mysql_num_rows($showitemLarRec);
mysql_select_db($database_webshop, $webshop);
?>


<!---------------------新增類別--------------------------------->
<h3 class=ttl01 >編輯網頁大類</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <form action="<?php echo $editFormAction; ?>" name="additem" method="POST"
   enctype="multipart/form-data" id="additem">

  <tr align="left">
    <td width="100%">名稱:
      <input id="LarCode" name="LarCode" type="text" class=sizeM value="<?php echo $row_showitemLarRec['LarCode']; ?>"/>
    </td>
  </tr>
  
  <tr align="left">
    <td width="100%">排序:
   	  <input type="int" name="upd_LarSeq" id="upd_LarSeq" class=sizeSss value="<?php echo $row_showitemLarRec['LarSeq']; ?>"/>
   	  [不能與其它大類的排序號重複，否則會出錯]    
    </td>
  </tr>
  
  <tr align="left">
    <td width="100%">寫'0'值,則表示'前台選單'只顯示大類選項將不出現中類選項；寫'1'值,則反:
   	  <input type="int" name="pnum"  class=sizeSss value="<?php echo $row_showitemLarRec['pnum']; ?>"/>
      
    </td>
  </tr>
  
  <tr align="left">
    <td width="100%">
    <input name="LarSeq" type="hidden" value="<?php echo $row_showitemLarRec['LarSeq']; ?>" />
   	  <input type="submit" name="update_item" id="update_item" value="更新" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!-------------------------------------------------------------->
  </form>
</table>
