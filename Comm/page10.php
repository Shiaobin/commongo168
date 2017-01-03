<?php
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){
echo "<table>
 <tr><th ><font size=4px>
 會 員 中 心:&nbsp;&nbsp;";?>
 <a href="my_info.php">個人資料</a> |&nbsp; <a href="my_order.php">個人訂單 |&nbsp; <a href="userlogout.php">登出</a></font>
 </th></tr>

  <tr>
    <td>
   </table>
   <table style="font-size:15px"; >
      <?php
$userid=$_SESSION['yuserid'];
$password=$_SESSION['ypassword'];
if(isset($_GET['OrderNum'])) $OrderNum=$_GET['OrderNum'];
/*
<%
sqlinfo = "select A.OrderNum,A.OrderTime,A.RecName,A.OrderSum,A.RecName,A.Status,B.StatusDefine"&_
          " from OrderList A,OrderStatustype B "&_
		  " where A.UserId='"&session("estore_userid")&"' and A.Status = B.Status order by A.OrderTime desc"
set rsorder=Server.Createobject("ADODB.RecordSet")
rsorder.Open sqlinfo,conn,1,1
%>*/
$query_orderlist=  "select B.OrderTime,B.OrderNum,B.pei,B.fei,B.Memo,B.thiskou,B.RecName,B.RecPhone,B.RecMail,B.RecAddress,B.ZipCode,B.PayType,B.Discount,B.Notes,B.OrderSum,D.UserKou
		  from orderlist B,usermain D
		  where B.OrderNum='".$OrderNum."' and B.UserId=D.UserId";
$result_orderlist=mysql_query($query_orderlist, $webshop) or die("cannot connect to table" . mysql_error( ));
$num=mysql_num_rows($result);
?>

<?php
if($num==0){
echo "<br><br><table><tr><td>對不起！您查詢的訂單<b> ["&OrderNum&"] </b><br><br><B>不屬於您的登陸賬號，或者已經被管理員刪除</B>！<br>請您仔細檢查！<br><br>如果還有問題，請聯繫網站管理員</td></tr></table></td></tr>";
}
else{
while($rs_orderlist = mysql_fetch_array($result_orderlist)){

?>

<font size="4">訂單號為<?php echo $rs_orderlist['OrderNum']; ?>&nbsp;&nbsp;&nbsp;&nbsp;發生時間：<?php echo $rs_orderlist['OrderTime']; ?></font><br><br>

<tr><td colspan="4">收貨人姓名：<?php echo $rs_orderlist['RecName']; ?></td></tr>
<tr><td colspan="4">收貨人電話：<?php echo $rs_orderlist['RecPhone']; ?></td></tr>
<tr><td colspan="4">收貨人郵箱：<?php echo $rs_orderlist['RecMail']; ?></td></tr>
<tr><td colspan="4">收貨地址：<?php echo $rs_orderlist['RecAddress']; ?></td></tr>
<tr><td colspan="4">郵政編碼：<?php echo $rs_orderlist['ZipCode']; ?></td></tr>
<tr><td colspan="4">配送方式：<?php echo $rs_orderlist['pei']; ?></td></tr>
<tr><td colspan="4">配送費用：<?php echo $rs_orderlist['fei']; ?>元</td></tr>
<tr><td colspan="4">訂單備註：<?php echo $rs_orderlist['Notes']; ?></td></tr>
<tr><td colspan="4">客服處理情況：<?php echo $rs_orderlist['Memo']; ?></td></tr>

<tr><td width="25%">產品名稱</td><td width="25%">購買數量</td><td width="25%">購買單價</td><td width="25%"> 合 計</td></tr>

<!--%
 Total = 0
 do while not rsorder.eof
 Sum = csng(rsorder("BuyPrice"))* rsorder("ProdUnit")
 Sum = FormatNumber(Sum,0)
 Total = Sum + Total '計算總金額
 Discount = rsorder("Discount")
%-->
<?php
$query_orderdetail=  "select A.UserId,A.OrderNum,A.ProdUnit,A.ProdPrice,A.BuyPrice,A.goods_spec_1,A.goods_spec_2,C.ProdName,C.ProdNum,C.LarCode,C.MidCode,C.ProdId
		  from orderdetail A,prodmain C
		  where A.OrderNum='".$OrderNum."' and A.ProdId=C.ProdId";
$result_orderdetail=mysql_query($query_orderdetail, $webshop) or die("cannot connect to table" . mysql_error( ));
while($rs_orderdetail = mysql_fetch_array($result_orderdetail)){
$sum = $rs_orderdetail['ProdUnit']*$rs_orderdetail['BuyPrice'];
?>
<tr>
<td width="50%"><a href="prodshow.php?ProdId=<?php echo $rs_orderdetail['ProdId']; ?>&LarCode=<?php echo $rs_orderdetail['LarCode']; ?>&MidCode=<?php echo $rs_orderdetail['MidCode']; ?>&ProdNum=<?php echo $rs_orderdetail['ProdNum']; ?>" target="blank_"><?php echo $rs_orderdetail['ProdName']; ?></a>　</td>
<td width="50%"><?php echo $rs_orderdetail['ProdUnit']; ?></td>
<td width="50%"><?php echo $rs_orderdetail['BuyPrice']; ?></td>
<td width="50%"><?php echo $sum; ?></td>
</tr>
<?php
}
?>
<!--%
rsorder.movenext
loop
end if
%-->


<TR>
	<TD colspan="4">
	&nbsp;&nbsp;折前總價：<?php echo $rs_orderlist['OrderSum']; ?> 元<br>
	&nbsp;&nbsp;本次折扣：<?php echo $rs_orderlist['UserKou']; ?>0折<br>
	&nbsp;&nbsp;折後總價：<?php echo $rs_orderlist['OrderSum']*$rs_orderlist['UserKou']; ?> 元<br>
	&nbsp;&nbsp;配送費用：<?php echo $rs_orderlist['fei']; ?> 元<br>
	&nbsp;&nbsp;總計費用：<?php echo ($rs_orderlist['OrderSum']*$rs_orderlist['UserKou'])+$rs_orderlist['fei']; ?> 元</font></td>
</TR>
<!--%
set rsorder=nothing
%-->

</TABLE>

<!--%
end sub

sub error_order()
 response.write "<br><br><table><tr><td>對不起！您查詢的訂單<b> ["&OrderNum&"] </b><br><br><B>不屬於您的登陸賬號，或者已經被管理員刪除</B>！<br>請您仔細檢查！<br><br>如果還有問題，請聯繫網站管理員</td></tr></table></td></tr>"
end sub
%-->
<?php
}
}
}else{
include("../usererror.php");
}
?>

