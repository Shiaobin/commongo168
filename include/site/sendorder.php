<?php  //-----------------------------取得會員資料------------------------------------//
if(isset($_SESSION['yuserid']) && isset($_SESSION['ypassword'])){
 $UserId=$_SESSION['yuserid'];
 $UserPassword=$_SESSION['ypassword'];
 $table_usermain		= SYS_DBNAME . ".usermain";
 $column = "*";
 $whereClause = "UserId='{$UserId}' && UserPassword='{$UserPassword}'";

 $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_usermain} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_usermain} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_usermain} WHERE {$whereClause}"
 );
 $row_memberRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_webRec = sprintf("SELECT * FROM prodmain
LEFT JOIN prod_img ON prod_img.ProdId = prodmain.ProdId
WHERE LarCode=%s && MidCode=%s && ProdNum=%s && Online='1'
order by img_no ASC",GetSQLValueString($LarCode, "text"),GetSQLValueString($MidCode, "text"),GetSQLValueString($ProdNum, "int"));
$webRec = mysql_query($query_webRec, $webshop) or die(mysql_error());
$row_webRec = mysql_fetch_assoc($webRec);
*/
 $UserId==$row_memberRec['UserId'];
 $UserName=$row_memberRec['UserName'];
 $Address=$row_memberRec['Address'];
 $CompPhone=$row_memberRec['CompPhone'];
 $UserMail=$row_memberRec['UserMail'];
 $ZipCode=$row_memberRec['ZipCode'];
}
else{
 $UserId="null";
}
?>
<?php
//$sysConnDebug = true;
$currentPage = $_SERVER["PHP_SELF"];


$maxRows_productRec = 6;
$pageNum_productRec = 0;
if (isset($_GET['pageNum_productRec'])) {
  $pageNum_productRec = $_GET['pageNum_productRec'];
}
$startRow_productRec = $pageNum_productRec * $maxRows_productRec;

$colname_productRec = "-1";/////////////////////////////////
if (isset($_GET['goods_id'])) {
  $colname_productRec = $_GET['goods_id'];//
}
/*
mysql_select_db($database_webshop, $webshop);
$query_productRec = sprintf("SELECT * FROM prodmain WHERE ProdId = %s", GetSQLValueString($colname_productRec, "text"));
$query_limit_productRec = sprintf("%s LIMIT %d, %d", $query_productRec, $startRow_productRec, $maxRows_productRec);
$productRec = mysql_query($query_limit_productRec, $webshop) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);

if (isset($_GET['totalRows_productRec'])) {
  $totalRows_productRec = $_GET['totalRows_productRec'];
} else {
  $all_productRec = mysql_query($query_productRec);
  $totalRows_productRec = mysql_num_rows($all_productRec);
}
$totalPages_productRec = ceil($totalRows_productRec/$maxRows_productRec)-1;

$colname_carRec = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_carRec = $_SESSION['MM_Username'];
  $query_carRec = sprintf("SELECT * FROM shop_car WHERE mem_no = %s", GetSQLValueString($colname_carRec, "text"));
}
else if (isset($_SESSION['tempord_id'])) {
  $colname_carRec = $_SESSION['tempord_id'];
  $query_carRec = sprintf("SELECT * FROM shop_car WHERE ord_id = %s", GetSQLValueString($colname_carRec, "text"));
}
mysql_select_db($database_webshop, $webshop);
$carRec = mysql_query($query_carRec, $webshop) or die(mysql_error());
$row_carRec = mysql_fetch_assoc($carRec);
$totalRows_carRec = mysql_num_rows($carRec);

$queryString_productRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_productRec") == false &&
        stristr($param, "totalRows_productRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_productRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_productRec = sprintf("&totalRows_productRec=%d%s", $totalRows_productRec, $queryString_productRec);
*/
?>
<?php  //------------------------------發送訂單----------------------------------//
if ((isset($_POST["buy"])) && ($_POST["buy"] == "確認進行訂購") && (isset($_POST['OrderSum']))) {

  echo "<script language=\"javascript\">";
  echo "window.alert(\"確定以上資料無誤，提交訂單！\");";
  echo "</script>";
  if(isset($_SESSION['MM_Username']) && $_SESSION['MM_Username'] != ""){
	$username = $_SESSION['MM_Username'];
	$cost=null;
	$column = "*";
	$table_usermain		= SYS_DBNAME . ".usermain";
	$whereClause = "UserId='{$username}'";

	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause}",
			'mssql'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause}",
			'oci8'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause}"
	);

	$row_username = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_showlistRec = sizeof($row_username);
	$thiskou=$row_username['UserKou'];

  }
  else $username="";


//-----------------------------取得運費----------------------------------//
  if(isset($_POST['pei'])&& $_POST['pei'] != 0){
	$pei=$_POST['pei'];
	$total=$_POST['OrderSum'];
		if($total>=2000 && $pei==1)
		{
			$cost=0;
		}
		else if($total>=1500 && $total<2000 && $pei==1)
		{
			$cost=30;
		}
		else if($total<1500 && $pei==1)
		{
			$cost=110;
		}
		else if($total>=1500 && $pei==2)
		{
			$cost=0;
		}
		else if($total<1500 && $pei==2)
		{
			$cost=80;
		}
  }

	$table_orderlist		= SYS_DBNAME . ".orderlist";
	$record = array(
			'OrderNum' => $_POST['OrderNum'],
			'UserId' => $UserId,
			'RecName' => $_POST['RecName'],
			'RecMail' => $_POST['RecMail'],
			'RecPhone' => $_POST['RecPhone'],
			'RecAddress' => $_POST['RecAddress'],
			'OrderSum' => $_POST['OrderSum'],
			'fei' => $cost,
			'pei' => $pei,
			'thiskou' => $thiskou,
			//'ZipCode' => $_POST['ZipCode'],
			'Notes' => $_POST['Notes']
			//'Gettime' => $_POST['gettime'],
			);
	dbInsert($table_orderlist, $record);
	/*
  $insertSQL = sprintf("INSERT INTO orderlist (OrderNum, UserId, RecName, RecMail, RecPhone, RecAddress, OrderSum, fei, pei, ZipCode, Notes, Gettime)
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['OrderNum'], "text"),
					   GetSQLValueString($row_username['UserId'], "text"),
                       GetSQLValueString($_POST['RecName'], "text"),
                       GetSQLValueString($_POST['RecMail'], "text"),
                       GetSQLValueString($_POST['RecPhone'], "text"),
                       GetSQLValueString($_POST['RecAddress'], "text"),
                       GetSQLValueString($_POST['OrderSum'], "int"),
					   GetSQLValueString($cost, "int"),
					   GetSQLValueString($pei, "text"),
					   GetSQLValueString($_POST['ZipCode'], "text"),
					   GetSQLValueString($_POST['Notes'], "text"),
					   GetSQLValueString($_POST['gettime'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  */
  //Insert the data from shop_car table to OrderDetail table
  if(isset($_SESSION['MM_Username']) && $_SESSION['MM_Username'] != "") {
      //Update shop_car table
	  /*
	  $updateSQL = sprintf("UPDATE shop_car SET ord_id=%s WHERE mem_no=%s",
	                        GetSQLValueString($_POST['OrderNum'], "text"),
							GetSQLValueString($_SESSION['MM_Username'], "text"));
      $update = mysql_query($updateSQL, $webshop) or die(mysql_error());

      $insertSQL = sprintf("INSERT INTO orderdetail(OrderNum, UserId, ProdId, ProdName, ProdUnit, BuyPrice)
	  SELECT ord_id, mem_no, goods_id, goods_name, ord_num, goods_price FROM shop_car WHERE mem_no = %s",
	  GetSQLValueString($_SESSION['MM_Username'],"text"));
	  */
	  $table_orderdetail		= SYS_DBNAME . ".orderdetail";
	  foreach ($car_items as $key => $car_item )
	  {

		  $record = array(
				  'OrderNum' => $_POST['OrderNum'],
				  'UserId' => $car_item -> _MM_Username,
				  'ProdId' => $car_item -> _goods_id,
				  'ProdName' => $car_item -> _goods_name,
				  'ProdUnit' => $car_item -> _goods_quantity,
				  'BuyPrice' => $car_item -> _goods_price,
				  'goods_spec_1' => $car_item -> _goods_spec_1,
				  'goods_spec_2' => $car_item -> _goods_spec_2
				  );
		  dbInsert($table_orderdetail, $record);
	  }
  }
  else
  {
		$table_orderdetail		= SYS_DBNAME . ".orderdetail";
	  foreach ($car_items as $key => $car_item )
	  {

		  $record = array(
				  'OrderNum' => $_POST['OrderNum'],
				  'UserId' => $car_item -> _MM_Username,
				  'ProdId' => $car_item -> _goods_id,
				  'ProdName' => $car_item -> _goods_name,
				  'ProdUnit' => $car_item -> _goods_quantity,
				  'BuyPrice' => $car_item -> _goods_price,
				  'goods_spec_1' => $car_item -> _goods_spec_1,
				  'goods_spec_2' => $car_item -> _goods_spec_2
				  );
		  dbInsert($table_orderdetail, $record);
	  }
  }
  /*
      $insertSQL = sprintf("INSERT INTO orderdetail(OrderNum, UserId, ProdId, ProdName, ProdUnit, BuyPrice)
	  SELECT ord_id, mem_no, goods_id, goods_name, ord_num, goods_price FROM shop_car WHERE ord_id = %s",GetSQLValueString($_POST['OrderNum'],"text"));
  $Result2 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  */
  //Clear the data in shop_car table
  /*
  if(isset($_SESSION['MM_Username']) && $_SESSION['MM_Username'] != "")
      $DelSQL = sprintf("DELETE FROM shop_car WHERE mem_no = %s",GetSQLValueString($_SESSION['MM_Username'],"text"));
  else
      $DelSQL = sprintf("DELETE FROM shop_car WHERE ord_id = %s",GetSQLValueString($_POST['OrderNum'],"text"));
  mysql_select_db($database_webshop, $webshop);
  $Result3 = mysql_query($DelSQL, $webshop) or die(mysql_error());
  */
  //Clear session
  //session_unset();
  //$_SESSION['tempord_id'] = "";

  $insertGoTo = "my_order_detail.php?OrderNum=".$_POST['OrderNum'];
  $Cart -> clearCart();
  unset($_SESSION['tempord_id']);
  //Send information
  //$headers = "Content-Type:text/html; charset = UTF-8";
if(isset($_SESSION['yuserid']))
{
	include("sendordermail.php");

  echo "<script language=\"javascript\">";
  //echo "window.alert(\"您已完成訂購手續,我們將會儘快與您聯絡出貨事宜!!\");";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";

}


  //Show message window
}
?>
<?php  //------------------------------取消訂單----------------------------------//
if ((isset($_POST["cancel"])) && ($_POST["cancel"] == "取消本訂購單")) {
  $url = "index.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$url'";
  echo "</script>";
}
?>
<?php  //---------------------------取得綜合設置訂購方式---------------------------------//
	$column = "*";
	  $table_shopsetup		= SYS_DBNAME . ".shopsetup";
	  $whereClause = "1=1";

	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_shopsetup} WHERE {$whereClause}",
			  'mssql'	=> "SELECT {$column} FROM {$table_shopsetup} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_shopsetup} WHERE {$whereClause}"
	  );

	  $row_paywayRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	  /*
$query_paywayRec = "SELECT * FROM shopsetup";
$paywayRec = mysql_query($query_paywayRec, $webshop) or die(mysql_error());
$row_paywayRec = mysql_fetch_assoc($paywayRec);
*/
?>
<!----------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<title>填寫訂單內容</title>
<!--------------------javascript更改order_pei id變數------------------------------>
<Script>
  function changeOrderpei(){
    var pei;
    pei=document.adminRec.pei.value;
	location.href="order.php?pei="+pei;
  }
</Script>

<script type="text/javascript">
function checkform(form){

	var re1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/;



  var val=$('input:radio[name="pei"]:checked').val();

  if(document.sendOrder.RecName.value.length == 0)
    alert('請輸入收貨人\n');
  else if(document.sendOrder.RecPhone.value.length == 0)
    alert('請輸入手機\n');
  else if(document.sendOrder.RecMail.value.length == 0)
    alert('請輸入信箱\n');
  else if (re1.exec(document.sendOrder.RecMail.value) == null)
    alert('信箱格式錯誤\n');
  else if(val==null)
    alert('請選擇運送及付款方式\n');
  else if(document.sendOrder.RecAddress.value.length == 0)
    alert('請輸入地址\n');
  else if(document.sendOrder.city.value == 0)
    alert('請選擇縣市\n');
  else if(document.sendOrder.area.value == 0)
    alert('請選擇地區\n');
  else  {
	document.forms["buy"].submit();
  }
}
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
</script>
<?php if(is_array($car_items)){ ?>
<!-------------------------訂購明細------------------------------>
<h2>商品明細</h2>
<table width="100%" class="table table-bordered table-striped">
  <tr bgcolor="#DFDFDF">
      <td width="50%"  align="center">商品名稱</td>
        <td width="10%"  align="center">數量</td>
    	<td width="20%"  align="center">單價</td>
    	<td width="20%"  align="center">合計</td>
  </tr>
  <!-------------------------------------------------------------->
  <?php
	$total = 0;
	foreach ($car_items as $key => $car_item )
	{ ?>
      <tr>
        <td  align="center"><label for="ord_num"><?php echo $car_item->_goods_name; ?></label></td>
        <td  align="center"><?php echo $car_item->_goods_quantity; ?></td>
        <td  align="center">NT$<?php echo $car_item->_goods_price; ?></td>
        <td  align="center">NT$<?php echo $car_item->_goods_total; ?></td>
      </tr>
    <?php
	$ord_num=$car_item->_ord_id;
    $total=$total+$car_item->_goods_total;
	}?>
  <!-------------------------------------------------------------->
  <tr>
    <td  align="right" colspan="5">共訂購<?php echo sizeof($car_items) ?> 種商品</td>
  </tr>
  <!-------------------------------------------------------------->
</table><p><br></p>
<h4 class="ttl01">商品總價：<?php echo $total; ?> 元</h4>
<h4 class="ttl02">+運費：未勾選</h4>
<h4 class="ttl03">=總金額：待確認</h4>
<!-------------------------填寫訂購單------------------------------>
<table width="100%" border="0" cellspacing="5" cellpadding="0" class="formTable">
  <!-------------------------------------------------------------->
  <tr bgcolor="#DFDFDF">
     <td colspan="4" align="center" >訂購單（請認真填寫以下表格，<font color="#FF3333">帶 * 號的必須填寫</font>）</td>
  </tr>
  <!-------------------------------------------------------------->
  <form action="order.php" method="POST" name="sendOrder" id="sendOrder">
  <tr>
    <td align="center">訂單編號</td>
    <td align="left">

      <input type="hidden" name="OrderNum" id="OrderNum" value="<?php if(isset($_SESSION['MM_Username'])) {
		                                                             echo $ord_num;
	                                                              }
	                                                              else echo $_SESSION['tempord_id'];?>"/>
	  <?php if(isset($_SESSION['MM_Username'])) echo $ord_num;
	        else echo $_SESSION['tempord_id'];?>
    </td>
  </tr>
<tr>
 <td align="center">訂單日期</td>
    <td align="left" colspan="3">
    <?php echo date('Y-m-d');?>
    <input type="hidden" name="OrderSum" id="OrderSum" value="<?php echo $total;?>"/>
	</td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td align="center">運送方式</td>
    <td align="left" colspan="3">
      <!--<select id="pei" name="pei" onchange="this.form.submit()" style=" font-size:20px; width:50%; height:90%; margin: 2px">-->
      <!--select id="pei" name="pei" onChange="changeOrderpei();" style="font-size:20px; width:50%; height:90%; margin: 2px">
      <option value="0">------請選擇運送方式------</option>

      <?php if($row_paywayRec['pei1'] != ""){ ?>
      <option value="1">
		  <?php echo $row_paywayRec['pei1'];?></option>
	  <?php }?>

      <?php if($row_paywayRec['pei2'] != ""){ ?>
      <option value="2">
		  <?php echo $row_paywayRec['pei2'];?></option>
      <?php }?>

      <?php if($row_paywayRec['pei3'] != ""){ ?>
      <option value="3">
		  <?php echo $row_paywayRec['pei3'];?></option>
      <?php }?>

      <?php if($row_paywayRec['pei4'] != ""){ ?>
      <option value="4">
		  <?php echo $row_paywayRec['pei4'];?></option>
      <?php }?>
      </select--><font color="#FF3333"> *</font>
      <input type="radio" name="pei" value="1" onclick="op(1)">貨到付款 <input type="radio" name="pei" value="2" onclick="op(2)">匯款(轉帳/信用卡)
      <div id="pei_remark_1" class="pei_remark">
        <p>滿2000元+0元</p>
        <p>滿1500未滿2000元+30元</p>
        <p>未滿1500元+110元</p>
      </div>
      <div id="pei_remark_2" class="pei_remark">
        <p>滿1500元+0元</p>
        <p>未滿1500元+80元</p>
      </div>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td  align="center">收貨人</td>
    <td  align="left" colspan="3">
    <font color="#FF3333"> *</font>
       <input type="text" name="RecName" id="RecName" value="<?php if(isset($UserName)) echo $UserName; ?>" class="sizeS"/></td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td  align="center">手機</td>
    <td  align="left" colspan="3">
    <font color="#FF3333"> *</font>
      <input type="text" name="RecPhone" id="RecPhone" value="<?php if(isset($CompPhone)) echo $CompPhone; ?>" class="sizeS"/>
    </td>
  </tr>
  <tr>
     <td  align="center">信箱</td>
     <td  align="left" colspan="3">
     <font color="#FF3333"> *</font>
       <input type="text" name="RecMail" id="RecMail" value="<?php if(isset($UserMail)) echo $UserMail; ?>" class="sizeM"/></td>
  </tr>
  <!-------------------------------------------------------------->

  <tr>
     <td  align="center">地址</td>
     <td  align="left" colspan="3"><font color="#FF3333"> *</font>
            <input type="text" name="RecAddress" id="RecAddress" placeholder="收貨地址" value="<?php if(isset($Address)) echo $Address; ?>" class="sizeL" style="margin:5px 0 5px 12px;" />
        </td>

  </tr>
  <!-------------------------------------------------------------->

  	 <td align="center" >備&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;註</td>
     <td colspan="3">
     	<textarea name="Notes" cols="30" rows="10"></textarea><br><font color="#FF3333">您有什麼要求，請在備註中註明。</font>
     </td>
  </tr>
  <tr>
     <td  align="center" colspan="4">
     	<input type="button" name="Submit21" onClick="javascript:history.go(-1)" value="&lt;&lt; 返回修改" style="font-size:14px;width:120px;height:30px">&nbsp;&nbsp;&nbsp;
        <input name="buy" type="submit" id="buy" onClick="MM_callJS('checkform(this.form)'); return false;" value="確認進行訂購" style="font-size:14px;width:120px;height:30px"/>&nbsp;&nbsp;&nbsp;
       	<input type="submit" name="cancel" id="cancel" value="取消本訂購單" style="font-size:14px;width:120px;height:30px"/>
     </td>
  </tr>
  <!-------------------------------------------------------------->
  </form>
</table>
<?php }else{ header("location:car.php"); } ?>
<script>
	//----------------區處理------------------//
	function op(num)
	{
		var total= <?php echo $total; ?>;
		if(typeof index == "undefined")
		{
			$("#pei_remark_"+num).css('display','block');
			index=num;
		}else
		{
			$("#pei_remark_"+index).css('display','none');
			$("#pei_remark_"+num).css('display','block');
			index=num;
		}
		if(total>=2000 && num==1)
		{
			$(".ttl02").html('+運費：0 元');
			$(".ttl03").html('=<font color="#FF3333"><b>總金額：'+(total)+' 元</b></font>');
		}
		else if(total>=1500 && total<2000 && num==1)
		{
			$(".ttl02").html('+運費：30 元');
			$(".ttl03").html('=<font color="#FF3333"><b>總金額：'+(total+30)+' 元</b></font>');
		}
		else if(total<1500 && num==1)
		{
			$(".ttl02").html('+運費：110 元');
			$(".ttl03").html('=<font color="#FF3333"><b>總金額：'+(total+110)+' 元</b></font>');
		}
		else if(total>=1500 && num==2)
		{
			$(".ttl02").html('+運費：0 元');
			$(".ttl03").html('=<font color="#FF3333"><b>總金額：'+(total)+' 元</b></font>');
		}
		else if(total<1500 && num==2)
		{
			$(".ttl02").html('+運費：80 元');
			$(".ttl03").html('=<font color="#FF3333"><b>總金額：'+(total+80)+' 元</b></font>');
		}

	}
</script>
