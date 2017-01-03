<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="expires" content="0">
<?php

include("indexconfig.php");

?>


</head>
  <body>
    <div id="wrapper-box">
    <?php include("include/topmenu2.php"); ?>


<div id="header-box" class="row">
        <div class="jumbotron col-sm-10 col-sm-offset-1">
     <?php include("include/banner.php"); ?>

          <!--頁頭flash end.captioned-gallery-->
          <div class="jumbotron-box"><!-- 導覽列：會員登入前 -->
            <nav class="navbar navbar-default" role="navigation">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <!-- <a class="navbar-brand" href="#">57</a>-->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->

              </div><!-- /.container-fluid -->
            </nav>
          </div> <!-- end.jumbotron-box 導覽列：會員登入前-->

        </div>

        <!--頁頭flash end.jumbotron-->
          <ol class="breadcrumb col-sm-10 col-sm-offset-1" id="p_breadcrumb">
            <li class="font-small"><a href="index.php">首頁</a></li>
         <li class="font-small">會員專區</li>

          </ol>
        </div>

        <!-- end#header-box-->
        <div class="row" id="content-box">

          <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
           <?php
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){
echo "<table  class='table table-bordered table-striped'>
 <tr><th ><h4>
 會 員 中 心:&nbsp;&nbsp;";?>
<?php
include("Comm/m_menu.php");
 ?>
 </h4>
  </th></tr>


   <table style="font-size:15px"; class='table table-bordered table-striped'>
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
$query_orderlist=  "select B.OrderTime,B.OrderNum,B.pei,B.fei,B.Memo,B.thiskou,B.RecName,B.RecPhone,B.RecMail,B.RecAddress,B.ZipCode,B.PayType,B.Discount,B.Notes,B.OrderSum,B.PayStatus,D.UserKou,B.Status
		  from orderlist B,usermain D
		  where B.OrderNum='".$OrderNum."' and B.UserId=D.UserId";
$result_orderlist=mysql_query($query_orderlist, $webshop) or die("cannot connect to table" . mysql_error( ));
$num=mysql_num_rows($result_orderlist);
?>

<?php
if($num==0){
echo "<br><br><table><tr><td>對不起！您查詢的訂單<b> [".$OrderNum."] </b><br><br><B>不屬於您的登陸賬號，或者已經被管理員刪除</B>！<br>請您仔細檢查！<br><br>如果還有問題，請聯繫網站管理員</td></tr></table></td></tr>";
}
else{
while($rs_orderlist = mysql_fetch_array($result_orderlist)){

?>
<font size="4">訂單號為<?php echo $rs_orderlist['OrderNum']; ?>&nbsp;&nbsp;&nbsp;&nbsp;發生時間：<?php echo $rs_orderlist['OrderTime']; ?></font><br><br>
<?php if (strpos($rs_orderlist['Status'], '訂單完成') !== false): ?>
<fieldset class="rating">
    <legend>評價賣家</legend>
    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="超讚">5星</label>
    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="還不錯">4星</label>
    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="普普通通">3星</label>
    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="有點糟">2星</label>
    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="遜斃了">1星</label>
</fieldset>
<?php endif; ?>
<tr><td colspan="4">付款狀態：<?php if($rs_orderlist['PayStatus']==1) echo "已付款";else echo "未付款"; ?></td></tr>
<tr><td colspan="4">收貨人姓名：<?php echo $rs_orderlist['RecName']; ?></td></tr>
<tr><td colspan="4">收貨人電話：<?php echo $rs_orderlist['RecPhone']; ?></td></tr>
<tr><td colspan="4">收貨人郵箱：<?php echo $rs_orderlist['RecMail']; ?></td></tr>
<tr><td colspan="4">收貨地址：<?php echo $rs_orderlist['RecAddress']; ?></td></tr>
<tr><td colspan="4">配送方式：<?php if($rs_orderlist['pei']==1) echo "貨到付款"; if($rs_orderlist['pei']==2) echo "匯款";?></td></tr>
<tr><td colspan="4">配送費用：<?php echo $rs_orderlist['fei']; ?>元</td></tr>
<tr><td colspan="4">訂單備註：<?php echo $rs_orderlist['Notes']; ?></td></tr>
<tr><td colspan="4">客服處理情況：<?php echo $rs_orderlist['Memo']; ?></td></tr>

<tr><td width="45%">產品名稱</td><td width="5%">數量</td><td width="25%">單價</td><td width="25%"> 合 計</td></tr>

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
<td width="35%"><a href="prodshow.php?ProdId=<?php echo $rs_orderdetail['ProdId']; ?>&LarCode=<?php echo $rs_orderdetail['LarCode']; ?>&MidCode=<?php echo $rs_orderdetail['MidCode']; ?>&ProdNum=<?php echo $rs_orderdetail['ProdNum']; ?>" target="blank_"><?php echo $rs_orderdetail['ProdName']; ?></a>　</td>
<td width="20%"><?php echo $rs_orderdetail['ProdUnit']; ?></td>
<td width="20%"><?php echo $rs_orderdetail['BuyPrice']; ?></td>
<td width="25%"><?php echo $sum; ?></td>
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
	&nbsp;&nbsp;配送費用：<?php echo $rs_orderlist['fei']; ?> 元<br>
	&nbsp;&nbsp;總計費用：<?php echo ($rs_orderlist['OrderSum']*($rs_orderlist['thiskou']/10))+$rs_orderlist['fei']; ?> 元</font></td>
</TR>
<TR>
	<TD colspan="4">
<?php if($rs_orderlist['PayStatus']==0 && $rs_orderlist['pei']==2){ ?>
<input type="button" value="立即付款" border="0" name="button" onclick="location.href='allpay.php?OrderNum=<?php echo $rs_orderlist['OrderNum']; ?>'" style="width:100px;height:50px;font-size:20px;">
<?php } ?>
	</td>
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
include("usererror.php");
}
?>



          </div><!--內容 end#content-->


<div class="col-sm-2 col-sm-offset-1 col-sm-pull-8 col-xs-12" id="nav-box">
<?php include("include/leftmenu_prod.php"); ?>
          </div><!--導覽 end#nav-box-->
        </div><!--內容 end#content-box-->
     </div><!--頁尾以外 end#wrapper-box-->




<div id="footer-box">
      <div id="footer" class="row">
  <?php include("include/bottom.php"); ?>
      </div><!--頁尾 end#footer-->
    </div><!--頁尾 end#footer-box-->

 </body></html>
