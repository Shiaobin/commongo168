<?php //require_once('../Connections/webshop.php'); ?>
<?php //require('../include/system.php'); ?>
<?php  //-----------------------更新會員等級名稱----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_class"])) && ($_POST["update_class"] == "更新")) {
  $updateSQL = sprintf("UPDATE shop_member_class SET class_name=%s WHERE class_no=%s",
                       GetSQLValueString($_POST['class_name'], "text"),
                       GetSQLValueString($_POST['class_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());

  $updateGoTo = "adminclientlevel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------更新會員等級折扣----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_discount"])) && ($_POST["update_discount"] == "更新")) {
  echo $_POST['class_discount'];
  $updateSQL = sprintf("UPDATE shop_member_class SET class_discount=%s WHERE class_no=%s",
                       GetSQLValueString($_POST['class_discount'], "float"),
                       GetSQLValueString($_POST['class_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());

  $updateGoTo = "adminclientlevel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //---------------------------刪除會員等級----------------------------------//
if ((isset($_POST["del_class"])) && ($_POST["del_class"] == "刪除")) {
  $deleteSQL = sprintf("DELETE FROM shop_member_class WHERE class_no=%s",
                       GetSQLValueString($_POST['class_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($deleteSQL, $webshop) or die(mysql_error());

  $deleteGoTo = "adminclientlevel.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  echo "<script type='text/javascript'>";
  echo "window.location.href='$deleteGoTo'";
  echo "</script>";
}
?>
<?php  //--------------------------取出客戶層級資訊-------------------------------//
mysql_select_db($database_webshop, $webshop);
$query_showclassRec = "SELECT * FROM shop_member_class";
$showclassRec = mysql_query($query_showclassRec, $webshop) or die(mysql_error());
$row_showclassRec = mysql_fetch_assoc($showclassRec);
$totalRows_showclassRec = mysql_num_rows($showclassRec);
?>
<h3 class=ttl01 >會員資訊</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
    <tr>
      <?php if ($totalRows_showclassRec > 0) {?>
      <td width="25%" colspan="4" valign="top">
      <?php do { ?>
         <table id="class" width="100%" border="0">
         <form action="<?php echo $editFormAction; ?>" name="edit_class" method="POST" id="edit_class">
           <!-------------------------------------------------------------->
           <tr>
             <td width="20%" align="center">會員等級
               <input name="class_no" type="hidden" value="<?php echo $row_showclassRec['class_no']; ?>" />
             </td>
             <td width="50%" align="left">
               <input name="class_name" type="text" id="class_name" style="width:95%;font-size:20px" value="<?php echo $row_showclassRec['class_name']; ?>" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }"/>
             </td>
             <td width="30%" align="left">
               <input type="submit" name="update_class" value="更新">
               <?php if ($totalRows_showclassRec > 1) { ?>
               <!--<input type="submit" name="del_class" value="刪除">-->
               <?php } ?>
             </td>
           </tr>
           <!-------------------------------------------------------------->
            <tr>
              <td width="20%" align="center">會員折扣</td>
              <td width="50%" align="left">
                <input name="class_discount" type="text" style="width:95%;font-size:20px"
                 value="<?php echo $row_showclassRec['class_discount']; ?>">
              </td>
              <td width="30%" align="left" colspan="2">
                <input type="submit" name="update_discount" value="更新">
                 [取值0-1，數字越小優惠越大]
              </td>
            </tr>
            <!-------------------------------------------------------------->
            <tr>
              <td height="10%" colspan="3"></td>
            </tr>
         <!-------------------------------------------------------------->
         </form>
         </table>
      <?php } while ($row_showclassRec = mysql_fetch_assoc($showclassRec)); ?>
      </td>
      <?php }?>
    </tr>
</table>
<!-------------------------------------------------------------->

