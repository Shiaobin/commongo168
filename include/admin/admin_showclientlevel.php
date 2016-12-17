<?php  //---------------------------取出客戶層級資訊---------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addclass") && ($_POST['class_name'] != "")) {
  $insertSQL = sprintf("INSERT INTO shop_member_class (class_name) VALUES (%s)",
                        GetSQLValueString($_POST['class_name'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());

  $insertGoTo = "adminclientlevel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>
<?php //---------------------------取出客戶層級資訊---------------------------------//
mysql_select_db($database_webshop, $webshop);
$query_showclassRec = "SELECT * FROM shop_member_class";
$showclassRec = mysql_query($query_showclassRec, $webshop) or die(mysql_error());
$row_showclassRec = mysql_fetch_assoc($showclassRec);
$totalRows_showclassRec = mysql_num_rows($showclassRec);
?>
<!------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>後台客戶層級管理</title>

<!---------------------新增類別--------------------------------->
<table width="97%" border="0" class="admin_class_category_table">
  <form action="<?php echo $editFormAction; ?>" name="addclass" method="POST"
   enctype="multipart/form-data" id="addclass">
   <!-------------------------------------------------------------->
  <tr>
    <td width="100%" align="center">新增客戶層級</td>
  </tr>
  <!-------------------------------------------------------------->
  <tr align="center">
    <td width="100%">新增層級:
   	  <input type="text" name="class_name" id="class_name" style="width:70%; height:25px"/>
   	  <input type="submit" name="add" id="add" value="新增" style="height:25px"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
    <input type="hidden" name="MM_insert" value="addclass" />
  </form>
</table>
<!---------------------客戶層級管理--------------------------------->
<table width="80%" height="40%" border="0" cellpadding="0" cellspacing="0" class="admin_class_edit">
  <!-------------------------------------------------------------->
  <tr>
    <td align="center" colspan="4"><p>客戶層級管理</p></td>
  </tr>
  <!-------------------------------------------------------------->
   <tr>
    <td align="right" colspan="4"><?php include("admin_clientitemlist.php"); ?></td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td align="right" colspan="4"><p>共<?php echo $totalRows_showclassRec ?> 種分類</p></td>
  </tr>
</table>
<!-------------------------------------------------------------->
<?php
mysql_free_result($showclassRec);
?>
