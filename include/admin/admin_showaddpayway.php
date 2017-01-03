<?php  //-----------------------------新增商品支付資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增")) {
  $insertSQL = sprintf("INSERT INTO shop_payway (warranty, payway_cost, payway_limit, send_time, delievery_way, delievery_explain, set_open) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['warranty'], "text"),
                       GetSQLValueString($_POST['payway_cost'], "text"),
                       GetSQLValueString($_POST['payway_limit'], "text"),
                       GetSQLValueString($_POST['send_time'], "text"),
                       GetSQLValueString($_POST['delievery_way'], "text"),
                       GetSQLValueString($_POST['delievery_explain'], "text"),
                       GetSQLValueString($_POST['set_open'], "tinyint"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());

  $insertGoTo = "adminpayway.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------重設商品資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $endItemRec = "";
}
?>
<!--------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>商品支付新增</title>
<!-------------------------------------------------------------->
<table width="97%" height="60%" border="1" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0">
<form name="addpages" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="addpages">
  <!-------------------------------------------------------------->
  <tr>
    <td height="10%" colspan="4" align="center"><p>新增商品支付方式</p></td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" align="center">送貨方式</td>
    <td width="40%" colspan="3" align="left">
      <input name="delievery_way" type="text" id="delievery_way" style="width:40%; height:70%; margin:3px"/>

    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" align="center">運費</td>
    <td width="40%" colspan="3" align="left">
      <input name="payway_cost" type="text" id="payway_cost" style="width:40%; height:70%; margin:3px"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" align="center">運費減免金額</td>
    <td width="40%" colspan="3" align="left">
      <input name="payway_limit" type="text" id="payway_limit" style="width:40%; height:70%; margin:3px"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" align="center">寄送時間</td>
    <td width="40%" colspan="3" align="left">
      <input name="send_time" type="text" id="send_time" style="width:40%; height:70%; margin:3px"/>

    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" height="100px" align="center">支付說明</td>
    <td width="40%" height="100px" colspan="3" align="left">
      <textarea id="delievery_explain" name="delievery_explain" cols="" rows="" style="width:70%; height:90%; margin:3px"></textarea>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" height="100px" align="center">運送及保固說明</td>
    <td width="40%" height="100px" colspan="3" align="left">
      <textarea id="warranty" name="warranty" cols="" rows="" style="width:70%; height:90%; margin:3px"></textarea>
    </td>
  </tr>
  <!----------------------------是否在線---------------------------->
  <tr>
    <td width="10%" height="10%" align="center">是否在線</td>
    <td width="40%" height="10%" align="left">
      <label>
        <input type="radio" name="set_open" value="0" id="set_open_0" checked/>否</label>
      <label>
        <input type="radio" name="set_open" value="1" id="set_open_1" />是</label>
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" colspan="3" align="left">
      <input type="submit" name="MM_insert"  value="新增" style="width:10%; height:100%; margin: 3px"/>
      <input type="reset" name="MM_reset"  value="重設" style="width:10%; height:100%; margin: 3px"/>
    </td>
  </tr>
</form>
</table>
