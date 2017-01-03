<?php //------------------修改訂單-----------------------------
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editord")) {
  $updateSQL = sprintf("UPDATE orderlist SET RecName=%s, RecMail=%s, RecPhone=%s, RecAddress=%s, Status=%s, Memo=%s, RecCity=%s, RecArea=%s WHERE OrderNum=%s",
                       GetSQLValueString($_POST['RecName'], "text"),
                       GetSQLValueString($_POST['RecMail'], "text"),
                       GetSQLValueString($_POST['RecPhone'], "text"),
                       GetSQLValueString($_POST['RecAddress'], "text"),
                       GetSQLValueString($_POST['Status'], "text"),
					   GetSQLValueString($_POST['memo'], "text"),
					   GetSQLValueString($_POST['city'], "text"),
					   GetSQLValueString($_POST['area'], "text"),
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

//------------------取得前一頁訂單內容OrderNum(orderlist+orderdetail)-----------------------------
$colname_ordmainRec = "-1";
if (isset($_GET['OrderNum'])) {
  $colname_ordmainRec = $_GET['OrderNum'];
}
mysql_select_db($database_webshop, $webshop);
$query_ordmainRec = sprintf("SELECT orderlist.*,usermain.UserId FROM orderlist LEFT JOIN usermain ON orderlist.UserId = usermain.UserId WHERE OrderNum = %s",
                             GetSQLValueString($colname_ordmainRec, "text"));
$ordmainRec = mysql_query($query_ordmainRec, $webshop) or die(mysql_error());
$row_ordmainRec = mysql_fetch_assoc($ordmainRec);
$totalRows_ordmainRec = mysql_num_rows($ordmainRec);

$colname_ordsubRec = "-1";
if (isset($_GET['OrderNum'])) {
  $colname_ordsubRec = $_GET['OrderNum'];
}
mysql_select_db($database_webshop, $webshop);
$query_ordsubRec = sprintf("SELECT * FROM orderdetail LEFT JOIN prodmain ON orderdetail.ProdId = prodmain.ProdId WHERE OrderNum = %s",
							 GetSQLValueString($colname_ordsubRec, "text"));
$ordsubRec = mysql_query($query_ordsubRec, $webshop) or die(mysql_error());
$row_ordsubRec = mysql_fetch_assoc($ordsubRec);
$totalRows_ordsubRec = mysql_num_rows($ordsubRec);
?>

  <!--------------------javascript更改order_status id變數------------------------------>
  <Script>
  function changeOrderStatus(){
    var Status;
    Status=document.adminRec.Status.value;
	location.href="admineditord.php?Status="+Status;
  }
</Script>
<h3 class=ttl01 >訂單資訊</h3>

<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">
<!------------------------訂單資訊------------------------------->
<form name="editord" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editord">

      <tr>
        <td colspan=2 >付款狀態:<?php if($row_ordmainRec['PayStatus']==1) echo "已付款";else echo "未付款"; ?></td>
      </tr>
      <tr>
        <td colspan=2 >訂單編號:<font color="#0000FF"><?php echo $row_ordmainRec['OrderNum']; ?></font></td>
      </tr>
      <tr>
        <td colspan=2 >訂單日期:<?php echo $row_ordmainRec['OrderTime']; ?></td>
      </tr>

  <!---------------------------------------------------------------------------------->
  <tr>
    <td>用戶ID:
		<?php if($row_ordmainRec['UserId'] != ""){
			echo $row_ordmainRec['UserId'];
		}else{
			echo "遊客";
		}?>
    </td>
    <td>收貨人姓名:
      <input name="RecName" type="text" id="RecName" class=sizeS value="<?php echo $row_ordmainRec['RecName']; ?>"/>
    </td>
  </tr>


  <tr>
    <td>配送方式:<?php if($row_ordmainRec['pei']==1) echo "貨到付款";if($row_ordmainRec['pei']==2) echo "匯款"; ?></td>
    <td>收貨人電話:
      <input name="RecPhone" type="text" id="RecPhone" class=sizeM value="<?php echo $row_ordmainRec['RecPhone']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>指定收貨時間:<?php echo $row_ordmainRec['Gettime']; ?></td>
    <td>收貨人信箱:
      <input name="RecMail" type="text" id="RecMail" class=sizeM value="<?php echo $row_ordmainRec['RecMail']; ?>"/>
    </td>
  </tr>
  <tr>
    <td>訂單狀態:<!--下拉式選單update MySQL(3)-->
      <select id="Status" name="Status" onchange="changeOrderStatus();" style="width:55%; height:80%; margin: 3px">
          <!--<option value="" selected>------<?php echo $row_ordmainRec['Status']; ?>------</option>-->
          <option value="新訂單" <?php if($row_ordmainRec['Status'] == "新訂單") echo "selected=\"selected\"";?>>新訂單</option>
 		  <option value="自行取消" <?php if($row_ordmainRec['Status'] == "自行取消") echo "selected=\"selected\"";?>>自行取消</option>
		  <option value="無效單，被取消" <?php if($row_ordmainRec['Status'] == "無效單，被取消") echo "selected=\"selected\"";?>>無效單，被取消</option>
          <option value="已確認，待結款" <?php if($row_ordmainRec['Status'] == "已確認，待結款") echo "selected=\"selected\"";?>>已確認，待結款</option>
		  <option value="已發貨，待收貨" <?php if($row_ordmainRec['Status'] == "已發貨，待收貨") echo "selected=\"selected\"";?>>已發貨，待收貨</option>
 		  <option value="訂單完成" <?php if($row_ordmainRec['Status'] == "訂單完成") echo "selected=\"selected\"";?>>訂單完成</option>
       </select>
    </td>
    <td>郵遞區號:
      <input name="RecAddress" type="text" id="RecAddress" class=sizeSss value="<?php echo $row_ordmainRec['ZipCode']; ?>"/>
    </td>
  </tr>

<!------------------------------------------------------------------------------- -->
<tr>
    <td colspan="2">收貨人地址:
  <input name="RecAddress" class="sizeM" type="text" id="RecAddress" value="<?php echo $row_ordmainRec['RecAddress']; ?>"/>
  </br>
    </td>
</tr>
</table>
→    <span name="toclip" id="toclip" style="margin-left:10px;"><?php echo $row_ordmainRec['RecAddress']; ?></span>  [<a href="#" id="copy-link-wrap">複製</a>]
<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <tr>
    <td>訂單總金額:$NT<?php echo $row_ordmainRec['OrderSum']*($row_ordmainRec['thiskou']/10)+$row_ordmainRec['fei']; ?></td>
  </tr>

  <tr>
    <td colspan="2">顧客說明：<br><textarea cols='50' rows='4' name='Notes'><?php echo $row_ordmainRec['Notes']; ?></textarea></td></tr>

  <tr>
    <td colspan="2">處理備忘：<br>
    <textarea cols='30' rows='4' name='memo' valign=abslutetop style="background-color: #FFFFCC; color: #222222;"><?php echo $row_ordmainRec['Memo']; ?></textarea> <br>訂單處理附加說明</td>
  </tr>


  <!------------------------新增按鈕------------------------------------------------->
  <tr>
    <td colspan="2">
      <input name="OrderNum" type="hidden" id="OrderNum" value="<?php echo $row_ordmainRec['OrderNum']; ?>" />
      <input name="add" type="submit" value="更新" style="font-size:16px;width:60px;height:30px"/>
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:60px;height:30px"/>
	</td>
  </tr>
  <input type="hidden" name="MM_update" value="editord" />
</form>
</table>



<!---------------------商品明細------------------------------------------------------>
<table width="650" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
  <tr>
    <td colspan="5" align="center" bgcolor="#999999"><font color="#FFFFFF"><p>商品明細</p></font></td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr align="center">
   	<td width="15%" >產品名稱</td>
   	<td width="25%" >圖片</td>
   	<td width="10%" >購買數量</td>
    <td width="10%" >單價</td>
    <td width="20%" >小計</td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <?php do { ?>
    <tr>
      <td align="center" height="20%"><?php echo $row_ordsubRec['ProdName']; ?></td>
      <td align="center" height="20%">
      <?php
	  mysql_select_db($database_webshop, $webshop);
      $query_img = "SELECT img_name FROM prod_img WHERE ProdId='".$row_ordsubRec['ProdId']."'";
      $result_img = mysql_query($query_img, $webshop) or die(mysql_error());
	  $rs_img = mysql_fetch_assoc($result_img);
	  ?>
	  <img src="../images/goodsimg/small/<?php echo $rs_img['img_name']; ?>" alt="" name="image"
       width="78px" height="65px" id="image" align="center" style="padding:5px;"/></td>
      <td align="right" height="20%"><?php echo $row_ordsubRec['ProdUnit']; ?></td>
      <td align="right" height="20%" ><?php echo $row_ordsubRec['BuyPrice']; ?></td>
      <td align="right" height="20%"><?php echo $row_ordsubRec['BuyPrice']*$row_ordsubRec['ProdUnit']; ?></td>
    </tr>
  <?php } while ($row_ordsubRec = mysql_fetch_assoc($ordsubRec)); ?>
  <!---------------------------------------------------------------------------------->
      <tr>
        <td colspan="5" align="left" valign="top">折前總價：<?php echo $row_ordmainRec['OrderSum']; ?>元</td>
      </tr>
      <<tr>
        <td colspan="5" align="left" valign="top">本次折扣： <?php echo $row_ordmainRec['thiskou']; ?>折</td>
      </tr>
      <tr>
        <td colspan="5" align="left" valign="top">折後總價： <?php echo $row_ordmainRec['OrderSum']*($row_ordmainRec['thiskou']/10); ?>元</td>
      </tr>
      <tr>
        <td colspan="5" align="left" valign="top">配送費用 ：<?php echo $row_ordmainRec['fei']; ?>元</td>
      </tr>
      <tr>
	    <td colspan="2" align="left" valign="top">總計費用：<?php echo ($row_ordmainRec['OrderSum']*($row_ordmainRec['thiskou']/10))+$row_ordmainRec['fei']; ?>元</td>
        <td colspan="3" align="right" valign="top">共訂購<?php echo $totalRows_ordsubRec; ?> 種商品</td>
      </tr>
</table>
<script>
	//----------------區處理------------------//
	function change()
	{
		var city = document.getElementById("city").value;

		$.ajax
		({
			url:"ajax.php", //接收頁
			type:"POST", //POST傳輸
			data:{city:city}, // key/value
			dataType:"text", //回傳形態
			success:function(i) //成功就....
			{
				document.getElementById("area").innerHTML=i;
			},
			error:function()//失敗就...
			{
				alert("ajax失敗");
			}
		});
	}
</script>
<?php
  mysql_free_result($ordmainRec);
  mysql_free_result($ordsubRec);
?>
