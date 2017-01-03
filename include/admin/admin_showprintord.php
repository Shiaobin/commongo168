<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editord")) {
  $updateSQL = sprintf("UPDATE orderlist SET RecName=%s, RecMail=%s, RecPhone=%s, RecAddress=%s, Status=%s WHERE OrderNum=%s",
                       GetSQLValueString($_POST['RecName'], "text"),
                       GetSQLValueString($_POST['RecMail'], "text"),
                       GetSQLValueString($_POST['RecPhone'], "text"),
                       GetSQLValueString($_POST['RecAddress'], "text"),
                       GetSQLValueString($_POST['Status'], "text"),
                       GetSQLValueString($_POST['OrderNum'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());

  $updateGoTo = "adminord.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}

$colname_ordmainRec = "-1";
if (isset($_GET['OrderNum'])) {
  $colname_ordmainRec = $_GET['OrderNum'];
}
mysql_select_db($database_webshop, $webshop);
$query_ordmainRec = sprintf("SELECT * FROM orderlist WHERE OrderNum = %s",
                             GetSQLValueString($colname_ordmainRec, "text"));
$ordmainRec = mysql_query($query_ordmainRec, $webshop) or die(mysql_error());
$row_ordmainRec = mysql_fetch_assoc($ordmainRec);
$totalRows_ordmainRec = mysql_num_rows($ordmainRec);

$colname_ordsubRec = "-1";
if (isset($_GET['OrderNum'])) {
  $colname_ordsubRec = $_GET['OrderNum'];
}
mysql_select_db($database_webshop, $webshop);
$query_ordsubRec = sprintf("SELECT * FROM orderdetail LEFT JOIN prodmain ON orderdetail.ProdId = prodmain.ProdId WHERE OrderNum = %s"
							, GetSQLValueString($colname_ordsubRec, "text"));
$ordsubRec = mysql_query($query_ordsubRec, $webshop) or die(mysql_error());
$row_ordsubRec = mysql_fetch_assoc($ordsubRec);
$totalRows_ordsubRec = mysql_num_rows($ordsubRec);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>後台編輯訂單</title>
  <!--------------------javascript更改order_status id變數------------------------------>
  <Script>
  function changeOrderStatus(){
    var Status;
    Status=document.adminRec.Status.value;
	location.href="admineditord.php?Status="+Status;
  }
  function printScreen(block){
    var value = block.innerHTML;
    var printPage = window.open("","printPage","");
    printPage.document.open();
    printPage.document.write("<HTML><head></head><BODY onload='window.print();window.close()'>");
    printPage.document.write("<PRE>");
    printPage.document.write(value);
    printPage.document.write("</PRE>");
    printPage.document.close("</BODY></HTML>");
 }
</Script>

<div id="print_block">
<table width="800" height="30" border="1" bordercolor="#003399" cellpadding="8" cellspacing="0">
<!-------------------------------------訂單資訊---------------------------------------->
  <tr>
    <td colspan="5" align="center"><p>訂單資訊</p></td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
  <td  colspan="5" align="center">
  <table width="100%" height="25%" border="0" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0">
   <!---------------------------------------------------------------------------------->
      <tr>
        <td width="50%" align="left">訂單編號:<font color="#0000FF"><?php echo $row_ordmainRec['OrderNum']; ?></font></td>
      </tr>
      <tr>
        <td width="50%" align="left">訂單日期:<?php echo $row_ordmainRec['OrderTime']; ?></td>
      </tr>
  </table>
  </td>
  </tr>
   <!----------------------------------------------------------------------->
  <tr>
    <td width="100%" colspan="5">
      <table width="100%" border="0" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0">
        <!---------------------------------------------------------------------------------->
        <tr>
          <td width="30%" align="right"><font size="+1">配送　　方式 : </font></td>
          <td width="70%" align="left"><font size="+1"><?php echo $row_ordmainRec['pei']; ?></font></td>
        </tr>
        <!---------------------------------------------------------------------------------->
        <tr>
          <td width="30%" align="right"><font size="+1">訂購人帳號ID: </font></td>
          <td width="70%" align="left"><font size="+1"><?php if($row_ordmainRec['UserId']=="") echo "遊客"; else echo $row_ordmainRec['UserId']; ?></font></td>
        </tr>
        <!---------------------------------------------------------------------------------->
        <tr>
          <td width="30%" align="right"><font size="+1">收貨人　姓名 : </font></td>
          <td width="70%" align="left"><font size="+1"><?php echo $row_ordmainRec['RecName']; ?></font></td>
        </tr>
        <!---------------------------------------------------------------------------------->
        <tr>
          <td width="30%" align="right"><font size="+1">收貨人　電話 : </font></td>
          <td width="70%" align="left"><font size="+1"><?php echo $row_ordmainRec['RecPhone']; ?></font></td>
        </tr>
        <!---------------------------------------------------------------------------------->
        <tr>
          <td width="30%" align="right"><font size="+1">收貨人　地址 : </font></td>
          <td width="70%" align="left"><font size="+1"><?php echo $row_ordmainRec['RecAddress']; ?></font></td>
        </tr>
        <!---------------------------------------------------------------------------------->
        <tr>
          <td width="30%" align="right"><font size="+1">收貨人　信箱 : </font></td>
          <td width="70%" align="left"><font size="+1"><?php echo $row_ordmainRec['RecMail']; ?></font></td>
        </tr>
        <!---------------------------------------------------------------------------------->
        <tr>
          <td width="30%" align="right"><font size="+1">指定收貨時間 : </font></td>
	　　　   <td width="70%" align="left"><font size="+1"><?php echo $row_ordmainRec['Gettime']; ?></font></td>
        </tr>
        <!---------------------------------------------------------------------------------->
        　　<td width="30%" align='right'><font size="+1">顧客　　說明 : </font></td>
    	　　<td width="70%" align="left"><font size="+1"><?php echo $row_ordmainRec['Notes']; ?></td></tr>
      </table>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr align="center">
   	<td width="32%">商品貨號及名號</td>
   	<td width="26%">商品圖片</td>
   	<td width="10%">數量</td>
    <td width="16%">單價</td>
    <td width="16%">小計</td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <?php do { ?>
    <tr align="center">
      <td><?php echo $row_ordsubRec['ProdId']; ?><br><?php echo $row_ordsubRec['ProdName']; ?></td>
      <td><?php echo $row_ordsubRec['ImgFull']; ?></td>
      <td><?php echo $row_ordsubRec['ProdUnit']; ?></td>
      <td><?php echo $row_ordsubRec['ProdPrice']; ?></td>
      <td><?php echo $row_ordsubRec['BuyPrice']; ?></td>
    </tr>
  <?php } while ($row_ordsubRec = mysql_fetch_assoc($ordsubRec)); ?>
  <!---------------------------------------------------------------------------------->
  <tr>
  <td colspan="5">
  <table width="100%" height="25%" border="0" BORDERCOLOR="#000000" class="content" cellpadding="0" cellspacing="0">
      <tr>
        <td width="40%" align="left" valign="top" height="20%">
        	折前總價：<?php echo $row_ordmainRec['OrderSum']; ?>元<br />
            本次折扣： <?php echo $row_ordmainRec['thiskou']; ?>折<br />
            折後總價： <?php echo $row_ordmainRec['OrderSum']*($row_ordmainRec['thiskou']/10); ?>元<br />
            配送費用 ：<?php echo $row_ordmainRec['fei']; ?>元<br />
            總計費用：<?php echo ($row_ordmainRec['OrderSum']*($row_ordmainRec['thiskou']/10))+$row_ordmainRec['fei']; ?>元<br />
        </td>
        <td width="60%" align="left" valign="top" height="20%">
        	<p><font size="+2">客戶簽收:</font></p>
            <p><font size="+2">業務簽收:</font></p>
        </td>
      </tr>
      <tr>
      	<td colspan="2" align="right" valign="top" height="20%"><p>共訂購 <?php echo $totalRows_ordsubRec; ?> 種商品</p></td>
      </tr>
  </table>
  </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  	  <tr>
    	<td width="100%" colspan="5" align="center"><input name="print" type="button" value="列印本頁" onclick="printScreen(print_block)" /></td>
  	  </tr>
</table>
</div>
<?php
  mysql_free_result($ordmainRec);
  mysql_free_result($ordsubRec);
?>
