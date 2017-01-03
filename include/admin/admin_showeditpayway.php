<?php  //-----------------------------更新商品支付資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editpayway")) {
  $updateSQL = sprintf("UPDATE shop_payway SET payway_cost=%s, payway_limit=%s, warranty=%s, delievery_explain=%s, send_time=%s,
                        delievery_way=%s, set_open=%s WHERE payway_no=%s",
                       GetSQLValueString($_POST['payway_cost'], "text"),
					   GetSQLValueString($_POST['payway_limit'], "text"),
					   GetSQLValueString($_POST['warranty'], "text"),
                       GetSQLValueString($_POST['delievery_explain'], "text"),
                       GetSQLValueString($_POST['send_time'], "text"),
                       GetSQLValueString($_POST['delievery_way'], "text"),
					   GetSQLValueString($_POST['set_open'], "tinyint"),
					   GetSQLValueString($_POST['payway_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());

  $updateGoTo = "adminpayway.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得商品支付資訊------------------------------------//
$colname_paywaymainRec = "-1";
if (isset($_GET['payway_no'])) {
  $colname_paywaymainRec = $_GET['payway_no'];
}
mysql_select_db($database_webshop, $webshop);
$query_paywaymainRec = sprintf("SELECT * FROM shop_payway WHERE payway_no=%s", GetSQLValueString($colname_paywaymainRec, "text"));
$paywaymainRec = mysql_query($query_paywaymainRec, $webshop) or die(mysql_error());
$row_paywaymainRec = mysql_fetch_assoc($paywaymainRec);
$totalRows_paywaymainRec = mysql_num_rows($paywaymainRec);
?>
<!----------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>商品支付編輯</title>
  <!--------------------javascript更改order_status id變數------------------------------>
<Script>
  function changeDelieveryWayStatus(){
    var delievery_way;
    delievery_way=document.adminRec.delievery_way.value;
	location.href="admin_showeditpayway.php?delievery_way="+delievery_way;
  }
</Script>

<table width="97%" height="30%" border="1" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0">
<!------------------------修改商品支付配送資訊------------------------------->
<form name="editpayway" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editpayway">
  <!---------------------------------------------------------------------------------->
  <tr>
    <td colspan="4" align="center"><p>修改商品支付配送資訊</p></td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" align="center">送貨方式</td>
    <td width="40%" colspan="3" align="left">
      <input name="delievery_way" type="text" id="delievery_way" value="<?php echo $row_paywaymainRec["delievery_way"]?>" style="width:40%; height:70%; margin:3px"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" align="center">運費</td>
    <td width="40%" colspan="3" align="left">
      <input name="payway_cost" type="text" id="payway_cost" value="<?php echo $row_paywaymainRec["payway_cost"]?>" style="width:40%; height:70%; margin:3px"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" align="center">運費減免金額</td>
    <td width="40%" colspan="3" align="left">
      <input name="payway_limit" type="text" id="payway_limit" value="<?php echo $row_paywaymainRec["payway_limit"]?>" style="width:40%; height:70%; margin:3px"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" align="center">寄送時間</td>
    <td width="40%" colspan="3" align="left">
      <input name="send_time" type="text" id="send_time" value="<?php echo $row_paywaymainRec["send_time"]?>" style="width:40%; height:70%; margin:3px"/>

    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" height="100px" align="center">支付說明</td>
    <td width="40%" height="100px" colspan="3" align="left">
      <textarea id="delievery_explain" name="delievery_explain" style="width:70%; height:90%; margin:3px"><?php echo $row_paywaymainRec["delievery_explain"]?></textarea>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td width="10%" height="100px" align="center">運送及保固說明</td>
    <td width="40%" height="100px" colspan="3" align="left">
      <textarea id="warranty" name="warranty" style="width:70%; height:90%; margin:3px"><?php echo $row_paywaymainRec["warranty"]?></textarea>
    </td>
  </tr>
  <!----------------------------是否在線---------------------------->
  <tr>
    <td width="10%" height="10%" align="center">是否在線</td>
    <td width="40%" height="10%" align="left">
      <label>
        <input type="radio" name="set_open" value="0" id="set_open_0" <?php if ($row_paywaymainRec['set_open'] == '0'): ?>checked='checked'<?php endif; ?>/>否</label>
      <label>
        <input type="radio" name="set_open" value="1" id="set_open_1" <?php if ($row_paywaymainRec['set_open'] == '1'): ?>checked='checked'<?php endif; ?>/>是</label>
    </td>
  </tr>
  <!------------------------新增按鈕------------------------------------------------->
  <tr>
    <td width="10%" align="center"><input name="payway_no" type="hidden" id="payway_no" value="<?php echo $row_paywaymainRec['payway_no']; ?>" /></td>
    <td width="40%" colspan="3" align="left">
      <input name="add" type="submit" value="更新" style="width:8%; height:30px; margin:3px"/>
      <input type="reset" name="reset"  value="重設" style="width:8%; height:30px; margin-left:1px"/>
    </td>
  </tr>
  <input type="hidden" name="MM_update" value="editpayway" />
</form>
</table>
<!---------------------商品明細------------------------------------------------------>
<?php
  mysql_free_result($paywaymainRec);
?>
